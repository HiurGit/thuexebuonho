<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CheckKhachThueController extends Controller
{
    private const VN_DIACRITIC_MAP = [
        'a' => ['à', 'á', 'ả', 'ã', 'ạ', 'ă', 'ằ', 'ắ', 'ẳ', 'ẵ', 'ặ', 'â', 'ầ', 'ấ', 'ẩ', 'ẫ', 'ậ'],
        'e' => ['è', 'é', 'ẻ', 'ẽ', 'ẹ', 'ê', 'ề', 'ế', 'ể', 'ễ', 'ệ'],
        'i' => ['ì', 'í', 'ỉ', 'ĩ', 'ị'],
        'o' => ['ò', 'ó', 'ỏ', 'õ', 'ọ', 'ô', 'ồ', 'ố', 'ổ', 'ỗ', 'ộ', 'ơ', 'ờ', 'ớ', 'ở', 'ỡ', 'ợ'],
        'u' => ['ù', 'ú', 'ủ', 'ũ', 'ụ', 'ư', 'ừ', 'ứ', 'ử', 'ữ', 'ự'],
        'y' => ['ỳ', 'ý', 'ỷ', 'ỹ', 'ỵ'],
    ];

    public function index()
    {
        $reports = Report::with(['customer', 'images'])
            ->where('status', 'approved')
            ->orderBy('created_at', 'desc')
            ->get();

        $items = $reports->map(fn (Report $r) => [
            'id' => $r->id,
            'customer_id' => $r->customer_id,
            'name' => $r->customer?->name ?? '',
            'phone' => $r->customer?->phone,
            'cccd' => $r->customer?->cccd,
            'license' => $r->customer?->license,
            'reason' => $r->content ?? '',
            'date' => $r->date,
            'views' => $r->views,
            'verified' => $r->status === 'approved',
            'images' => $r->images->pluck('path')->map(fn ($p) => asset($p))->all(),
        ])->values()->all();

        $customerIdsWithReport = $reports->pluck('customer_id')->unique();
        $customersNoReport = Customer::whereNull('deleted_at')
            ->whereNotIn('id', $customerIdsWithReport)
            ->get();

        $noReportItems = $customersNoReport->map(fn (Customer $c) => [
            'id' => null,
            'customer_id' => $c->id,
            'name' => $c->name ?? '',
            'phone' => $c->phone,
            'cccd' => $c->cccd,
            'license' => $c->license,
            'reason' => '',
            'date' => '',
            'views' => 0,
            'verified' => false,
            'images' => [],
        ])->values()->all();

        $items = array_merge($items, $noReportItems);

        $stats = [
            'total' => $reports->count(),
            'users' => Customer::count(),
            'verified' => $reports->count(),
        ];

        return view('check-khach-thue', compact('items', 'stats'));
    }

    public function report(Request $request)
    {
        $request->session()->put('report_started_at', time());

        return view('check-khach-thue-baocao');
    }

    public function ocrGemini(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,webp|max:5120',
        ]);

        $apiKey = trim((string) config('services.gemini.api_key', ''));
        if ($apiKey === '') {
            return response()->json([
                'success' => false,
                'message' => 'Chua duoc cau hinh API key, vui long nhap tay.',
            ], 503);
        }

        try {
            $file = $request->file('image');
            $mime = $file->getMimeType() ?: 'image/jpeg';
            $base64 = base64_encode((string) file_get_contents($file->getRealPath()));

            $maxRetries = (int) config('services.gemini.max_retries', 2);
            $retryDelay = (int) config('services.gemini.retry_delay', 2500);
            $last = null;

            foreach ($this->geminiModelCandidates() as $model) {
                for ($attempt = 0; $attempt <= $maxRetries; $attempt++) {
                    $result = $this->callGemini($apiKey, $model, $mime, $base64);
                    $last = $result;

                    if (! empty($result['ok'])) {
                        return response()->json([
                            'success' => true,
                            'fields' => $result['fields'],
                        ]);
                    }

                    if (! empty($result['retryable']) && $attempt < $maxRetries) {
                        usleep($retryDelay * 1000);
                        continue;
                    }

                    break;
                }
            }

            Log::warning('Gemini OCR failed.', [
                'message' => $last['error'] ?? 'no details',
                'status' => $last['status'] ?? null,
                'model' => $last['model'] ?? null,
            ]);

            return response()->json([
                'success' => false,
                'message' => $this->geminiErrorMessage($last),
            ], 502);
        } catch (\Throwable $e) {
            Log::warning('Gemini OCR failed.', ['message' => $e->getMessage()]);

            return response()->json([
                'success' => false,
                'message' => 'Khong ket noi duoc voi Gemini, vui long thu lai sau.',
            ], 502);
        }
    }

    private function geminiModelCandidates(): array
    {
        $primary = trim((string) config('services.gemini.model', 'gemini-flash-latest'));

        $candidates = [$primary];
        foreach (['gemini-flash-lite-latest', 'gemini-3.5-flash'] as $fallback) {
            if (! in_array($fallback, $candidates, true)) {
                $candidates[] = $fallback;
            }
        }

        return $candidates;
    }

    private function callGemini(string $apiKey, string $model, string $mime, string $base64): array
    {
        try {
            $response = Http::timeout((int) config('services.gemini.timeout', 60))
                ->post("https://generativelanguage.googleapis.com/v1beta/models/{$model}:generateContent?key={$apiKey}", [
                    'contents' => [
                        [
                            'role' => 'user',
                            'parts' => [
                                ['inline_data' => ['mime_type' => $mime, 'data' => $base64]],
                                ['text' => $this->geminiPrompt()],
                            ],
                        ],
                    ],
                    'generationConfig' => [
                        'responseMimeType' => 'application/json',
                        'responseSchema' => [
                            'type' => 'OBJECT',
                            'properties' => [
                                'full_name' => ['type' => 'STRING', 'nullable' => true],
                                'id_number' => ['type' => 'STRING', 'nullable' => true],
                                'license_number' => ['type' => 'STRING', 'nullable' => true],
                                'date_of_birth' => ['type' => 'STRING', 'nullable' => true],
                                'gender' => ['type' => 'STRING', 'nullable' => true],
                                'permanent_address' => ['type' => 'STRING', 'nullable' => true],
                                'date_of_issue' => ['type' => 'STRING', 'nullable' => true],
                            ],
                        ],
                    ],
                ]);

            $status = $response->status();

            if ($status !== 200) {
                $body = $response->json();

                return [
                    'ok' => false,
                    'status' => $status,
                    'retryable' => in_array($status, [429, 500, 502, 503], true),
                    'error' => $body['error']['message'] ?? 'HTTP ' . $status,
                    'model' => $model,
                ];
            }

            $text = '';
            foreach ($response->json()['candidates'][0]['content']['parts'] ?? [] as $part) {
                if (! empty($part['text'])) {
                    $text = (string) $part['text'];
                    break;
                }
            }

            if ($text === '') {
                return [
                    'ok' => false,
                    'status' => 502,
                    'retryable' => false,
                    'error' => 'Gemini khong tra ve ket qua.',
                    'model' => $model,
                ];
            }

            $fields = json_decode($text, true);
            if (! is_array($fields)) {
                $fields = $this->extractJsonFromText($text);
            }

            $fields = $this->normalizeGeminiFields($fields);

            if (empty($fields['name']) && empty($fields['cccd'])) {
                return [
                    'ok' => false,
                    'status' => 422,
                    'retryable' => false,
                    'error' => 'Khong doc duoc thong tin tren anh.',
                    'model' => $model,
                ];
            }

            return ['ok' => true, 'fields' => $fields, 'model' => $model];
        } catch (\Throwable $e) {
            return [
                'ok' => false,
                'status' => 0,
                'retryable' => true,
                'error' => $e->getMessage(),
                'model' => $model,
            ];
        }
    }

    private function geminiErrorMessage(array $last): string
    {
        $status = (int) ($last['status'] ?? 0);

        if ($status === 404) {
            return 'Model Gemini đang không khả dụng, vui lòng thử lại sau.';
        }

        if (in_array($status, [429, 500, 502, 503], true)) {
            return 'Gemini đang quá tải hoặc hết hạn mức (free tier), vui lòng thử lại sau 1 phút.';
        }

        return 'Khong ket noi duoc voi Gemini, vui long thu lai sau.';
    }

    private function geminiPrompt(): string
    {
        return 'Ban la cong cu doc thong tin tu anh giay to tuy than cua nguoi Viet Nam '
            . '(CCCD/Ca cuoc cong dan hoac Giay phep lai xe). '
            . 'Hay doc chinh xac cac truong sau tu anh, tra ve JSON dung schema: '
            . 'full_name (ho va ten), id_number (so CCCD/Can cuoc, chi giu so), '
            . 'license_number (so giay phep lai xe neu co), '
            . 'date_of_birth (ngay sinh dang dd/mm/yyyy), gender (Nam hoac Nu), '
            . 'permanent_address (noi thuong tru hoac dia chi day du), '
            . 'date_of_issue (ngay cap dang dd/mm/yyyy). '
            . 'Neu truong nao khong nhin thay hoac khong ro thi de null. '
            . 'Chi tra ve JSON, khong them giai thich.';
    }

    private function extractJsonFromText(string $text): array
    {
        if (preg_match('/\{.*\}/s', $text, $match)) {
            $decoded = json_decode($match[0], true);
            if (is_array($decoded)) {
                return $decoded;
            }
        }

        return [];
    }

    private function normalizeGeminiFields(array $fields): array
    {
        $cccd = preg_replace('/\D/', '', (string) ($fields['id_number'] ?? ''));
        $cccdLen = strlen($cccd);

        return [
            'name' => trim((string) ($fields['full_name'] ?? '')),
            'cccd' => $cccdLen >= 9 && $cccdLen <= 12 ? $cccd : '',
            'license' => trim((string) ($fields['license_number'] ?? '')),
            'dob' => $this->normalizeDate($fields['date_of_birth'] ?? null),
            'gender' => $this->normalizeGender($fields['gender'] ?? null),
            'address' => trim((string) ($fields['permanent_address'] ?? '')),
            'issue_date' => $this->normalizeDate($fields['date_of_issue'] ?? null),
        ];
    }

    private function normalizeDate($value): string
    {
        $value = trim((string) ($value ?? ''));
        if ($value === '') {
            return '';
        }

        if (preg_match('/^(\d{1,2})[\/\-\.](\d{1,2})[\/\-\.](\d{4})$/', $value, $m)) {
            return sprintf('%02d/%02d/%04d', (int) $m[1], (int) $m[2], (int) $m[3]);
        }

        if (preg_match('/^(\d{4})-(\d{1,2})-(\d{1,2})$/', $value, $m)) {
            return sprintf('%02d/%02d/%04d', (int) $m[3], (int) $m[2], (int) $m[1]);
        }

        return $value;
    }

    private function normalizeGender($value): string
    {
        $value = trim((string) ($value ?? ''));
        $lower = mb_strtolower($value, 'UTF-8');
        if ($lower === 'nam' || preg_match('/^n[àáảãạăắằẳẵặâấầẩẫậ]?m$/iu', $value) || $lower === 'male') {
            return 'Nam';
        }
        if ($lower === 'nu' || $lower === 'nữ' || $lower === 'nư' || $lower === 'female') {
            return 'Nữ';
        }

        return '';
    }

    public function ocrOpenAI(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,webp|max:5120',
        ]);

        $apiKey = trim((string) config('services.openai.api_key', ''));
        if ($apiKey === '') {
            return response()->json([
                'success' => false,
                'message' => 'Chua duoc cau hinh OpenAI API key, vui long nhap tay.',
            ], 503);
        }

        try {
            $file = $request->file('image');
            $mime = $file->getMimeType() ?: 'image/jpeg';
            $base64 = base64_encode((string) file_get_contents($file->getRealPath()));

            $maxRetries = (int) config('services.openai.max_retries', 2);
            $retryDelay = (int) config('services.openai.retry_delay', 2500);
            $last = null;

            foreach ($this->openaiModelCandidates() as $model) {
                for ($attempt = 0; $attempt <= $maxRetries; $attempt++) {
                    $result = $this->callOpenAI($apiKey, $model, $mime, $base64);
                    $last = $result;

                    if (! empty($result['ok'])) {
                        return response()->json([
                            'success' => true,
                            'fields' => $result['fields'],
                        ]);
                    }

                    if (! empty($result['retryable']) && $attempt < $maxRetries) {
                        usleep($retryDelay * 1000);
                        continue;
                    }

                    break;
                }
            }

            Log::warning('OpenAI OCR failed.', [
                'message' => $last['error'] ?? 'no details',
                'status' => $last['status'] ?? null,
                'model' => $last['model'] ?? null,
            ]);

            return response()->json([
                'success' => false,
                'message' => $this->openaiErrorMessage($last),
            ], 502);
        } catch (\Throwable $e) {
            Log::warning('OpenAI OCR failed.', ['message' => $e->getMessage()]);

            return response()->json([
                'success' => false,
                'message' => 'Khong ket noi duoc voi OpenAI, vui long thu lai sau.',
            ], 502);
        }
    }

    private function openaiModelCandidates(): array
    {
        $primary = trim((string) config('services.openai.model', 'gpt-4o-mini'));

        $candidates = [$primary];
        foreach (['gpt-4.1-mini', 'gpt-4.1-nano'] as $fallback) {
            if (! in_array($fallback, $candidates, true)) {
                $candidates[] = $fallback;
            }
        }

        return $candidates;
    }

    private function callOpenAI(string $apiKey, string $model, string $mime, string $base64): array
    {
        try {
            $response = Http::timeout((int) config('services.openai.timeout', 60))
                ->withToken($apiKey)
                ->post('https://api.openai.com/v1/chat/completions', [
                    'model' => $model,
                    'messages' => [
                        [
                            'role' => 'user',
                            'content' => [
                                [
                                    'type' => 'text',
                                    'text' => $this->openaiPrompt(),
                                ],
                                [
                                    'type' => 'image_url',
                                    'image_url' => [
                                        'url' => "data:{$mime};base64,{$base64}",
                                    ],
                                ],
                            ],
                        ],
                    ],
                    'response_format' => ['type' => 'json_object'],
                ]);

            $status = $response->status();

            if ($status !== 200) {
                $body = $response->json();

                return [
                    'ok' => false,
                    'status' => $status,
                    'retryable' => in_array($status, [429, 500, 502, 503], true),
                    'error' => $body['error']['message'] ?? 'HTTP ' . $status,
                    'model' => $model,
                ];
            }

            $text = trim((string) ($response->json()['choices'][0]['message']['content'] ?? ''));

            if ($text === '') {
                return [
                    'ok' => false,
                    'status' => 502,
                    'retryable' => false,
                    'error' => 'OpenAI khong tra ve ket qua.',
                    'model' => $model,
                ];
            }

            $fields = json_decode($text, true);
            if (! is_array($fields)) {
                $fields = $this->extractJsonFromText($text);
            }

            $fields = $this->normalizeOpenAIFields($fields);

            if (empty($fields['name']) && empty($fields['cccd'])) {
                return [
                    'ok' => false,
                    'status' => 422,
                    'retryable' => false,
                    'error' => 'Khong doc duoc thong tin tren anh.',
                    'model' => $model,
                ];
            }

            return ['ok' => true, 'fields' => $fields, 'model' => $model];
        } catch (\Throwable $e) {
            return [
                'ok' => false,
                'status' => 0,
                'retryable' => true,
                'error' => $e->getMessage(),
                'model' => $model,
            ];
        }
    }

    private function openaiErrorMessage(array $last): string
    {
        $status = (int) ($last['status'] ?? 0);

        if ($status === 404 || $status === 400) {
            return 'Model OpenAI đang không khả dụng, vui lòng thử lại sau.';
        }

        if (in_array($status, [401, 403], true)) {
            return 'OpenAI API key không hợp lệ hoặc hết hạn mức.';
        }

        if (in_array($status, [429, 500, 502, 503], true)) {
            return 'OpenAI đang quá tải, vui lòng thử lại sau 1 phút.';
        }

        return 'Khong ket noi duoc voi OpenAI, vui long thu lai sau.';
    }

    private function openaiPrompt(): string
    {
        return $this->geminiPrompt();
    }

    private function normalizeOpenAIFields(array $fields): array
    {
        $cccd = preg_replace('/\D/', '', (string) ($fields['id_number'] ?? ''));
        $cccdLen = strlen($cccd);

        return [
            'name' => trim((string) ($fields['full_name'] ?? '')),
            'cccd' => $cccdLen >= 9 && $cccdLen <= 12 ? $cccd : '',
            'license' => trim((string) ($fields['license_number'] ?? '')),
            'dob' => $this->normalizeDate($fields['date_of_birth'] ?? null),
            'gender' => $this->normalizeGender($fields['gender'] ?? null),
            'address' => trim((string) ($fields['permanent_address'] ?? '')),
            'issue_date' => $this->normalizeDate($fields['date_of_issue'] ?? null),
        ];
    }

    public function storeReport(Request $request)
    {
        if ($request->filled('website') || $request->filled('email')) {
            return response()->json(['success' => true]);
        }

        if (trim((string) $request->userAgent()) === '') {
            return response()->json([
                'success' => false,
                'message' => 'Yeu cau khong hop le.',
            ], 422);
        }

        $startedAt = (int) $request->session()->get('report_started_at', 0);
        if ($startedAt <= 0 || (time() - $startedAt) < 4) {
            return response()->json([
                'success' => false,
                'message' => 'Yeu cau khong hop le, vui long thu lai.',
            ], 422);
        }

        $validated = $request->validate([
            'name' => 'required|string|min:2|max:255',
            'cccd' => 'nullable|string|max:20',
            'license' => 'nullable|string|max:30',
            'phone' => 'nullable|string|regex:/^[0-9+\s()\-]{9,15}$/',
            'dob' => 'nullable|string|max:20',
            'gender' => 'nullable|string|max:10',
            'address' => 'nullable|string|max:255',
            'issue_date' => 'nullable|string|max:20',
            'detail' => 'nullable|string|max:5000',
            'images' => 'nullable|array|max:5',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:5120',
        ]);

        $cccd = trim((string) ($validated['cccd'] ?? ''));
        $cccd = $cccd !== '' ? preg_replace('/\D/', '', $cccd) : '';
        if ($cccd !== '' && (mb_strlen($cccd) < 9 || mb_strlen($cccd) > 12)) {
            return response()->json([
                'success' => false,
                'message' => 'So CCCD khong hop le.',
            ], 422);
        }

        $phoneDigits = preg_replace('/\D/', '', (string) ($validated['phone'] ?? ''));
        $licenseDigits = preg_replace('/\D/', '', (string) ($validated['license'] ?? ''));

        $hasIdentifier = $cccd !== '' || $phoneDigits !== '' || $licenseDigits !== '';

        if ($hasIdentifier) {
            $existingCustomer = Customer::withTrashed()
                ->where(function ($q) use ($cccd, $phoneDigits, $licenseDigits) {
                    if ($cccd !== '') {
                        $q->where('cccd', $cccd);
                    }
                    if ($phoneDigits !== '') {
                        $q->orWhereRaw('REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(phone, " ", ""), "-", ""), "(", ""), ")", ""), "+", "") = ?', [$phoneDigits]);
                    }
                    if ($licenseDigits !== '') {
                        $q->orWhereRaw('REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(license, " ", ""), "-", ""), "(", ""), ")", ""), "+", "") = ?', [$licenseDigits]);
                    }
                })
                ->first();

            if ($existingCustomer) {
                $hasApprovedReport = Report::where('customer_id', $existingCustomer->id)
                    ->where('status', 'approved')
                    ->exists();

                if ($hasApprovedReport) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Khách hàng này đã có báo cáo xác minh trong hệ thống.',
                    ], 422);
                }
            }
        }

        $content = trim($validated['detail'] ?? '');
        if ($content !== '' && $this->containsSpam($content)) {
            return response()->json([
                'success' => false,
                'message' => 'Noi dung khong hop le.',
            ], 422);
        }

        $ip = (string) $request->ip();
        $cutoff = now()->subHours(24);

        $ipCount = DB::table('report_submissions')
            ->where('ip', $ip)
            ->where('created_at', '>=', $cutoff)
            ->count();

        if ($ipCount >= 50) {
            return response()->json([
                'success' => false,
                'message' => 'Da gui qua nhieu bao cao tu thiet bi nay, vui long thu lai sau.',
            ], 422);
        }

        if ($cccd !== '') {
            $distinctCccd = DB::table('report_submissions')
                ->where('ip', $ip)
                ->where('created_at', '>=', $cutoff)
                ->whereNotNull('cccd')
                ->distinct('cccd')
                ->count('cccd');

            if ($distinctCccd >= 20) {
                return response()->json([
                    'success' => false,
                    'message' => 'Da gui qua nhieu bao cao, vui long thu lai sau.',
                ], 422);
            }
        }

        DB::table('report_submissions')->insert([
            'ip' => $ip,
            'user_agent' => mb_substr((string) $request->userAgent(), 0, 500),
            'cccd' => $cccd !== '' ? $cccd : null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $recentCutoff = now()->subHours(24);

        if ($cccd !== '' && $content !== '') {
            $duplicate = Report::where('content', $content)
                ->where('created_at', '>=', $recentCutoff)
                ->whereHas('customer', fn ($q) => $q->where('cccd', $cccd))
                ->exists();

            if ($duplicate) {
                return response()->json([
                    'success' => false,
                    'message' => 'Bao cao nay da duoc gui truoc do, vui long kiem tra lai.',
                ], 422);
            }
        }

        if ($cccd !== '') {
            $recentCount = Report::where('created_at', '>=', $recentCutoff)
                ->whereHas('customer', fn ($q) => $q->where('cccd', $cccd))
                ->count();

            if ($recentCount >= 10) {
                return response()->json([
                    'success' => false,
                    'message' => 'Da co bao cao cho khach hang nay trong 24h qua, vui long thu lai sau.',
                ], 422);
            }
        }

        $customer = null;
        if ($cccd !== '') {
            $customer = Customer::withTrashed()->where('cccd', $cccd)->first();
        }
        if (! $customer && $phoneDigits !== '') {
            $customer = Customer::withTrashed()
                ->whereRaw('REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(phone, " ", ""), "-", ""), "(", ""), ")", ""), "+", "") = ?', [$phoneDigits])
                ->first();
        }
        if (! $customer && $licenseDigits !== '') {
            $customer = Customer::withTrashed()
                ->whereRaw('REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(license, " ", ""), "-", ""), "(", ""), ")", ""), "+", "") = ?', [$licenseDigits])
                ->first();
        }

        if (! $customer) {
            $customer = Customer::create([
                'name' => $validated['name'],
                'cccd' => $cccd !== '' ? $cccd : null,
                'phone' => $validated['phone'] ?? null,
                'license' => $validated['license'] ?? null,
                'dob' => $validated['dob'] ?? null,
                'gender' => $validated['gender'] ?? null,
                'address' => $validated['address'] ?? null,
                'cccd_issue_date' => $validated['issue_date'] ?? null,
                'status' => 'active',
            ]);
        } else {
            $update = [];
            foreach (['phone', 'license', 'dob', 'gender', 'address'] as $field) {
                if (empty($customer->{$field}) && ! empty($validated[$field])) {
                    $update[$field] = $validated[$field];
                }
            }
            if (empty($customer->cccd_issue_date) && ! empty($validated['issue_date'])) {
                $update['cccd_issue_date'] = $validated['issue_date'];
            }
            if ($update) {
                $customer->update($update);
            }
        }

        $report = Report::create([
            'customer_id' => $customer->id,
            'reporter_name' => $validated['name'],
            'reporter_phone' => null,
            'content' => $validated['detail'] ?? null,
            'status' => 'pending',
        ]);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $path = $file->store('report_images', 'public');
                $report->images()->create(['path' => 'storage/' . $path]);
            }
        }

        return response()->json(['success' => true]);
    }

    public function showCustomer(Request $request, Customer $customer)
    {
        $customer->load(['reports' => fn ($q) => $q->where('status', 'approved')]);

        $latest = $customer->reports->first();
        if ($latest && ! $this->isBot($request)) {
            $latest->increment('views');
            $latest->refresh();
        }

        $qRaw = trim((string) $request->query('q', ''));
        $qDigits = preg_replace('/\D/', '', $qRaw);
        $qText = $this->normalizeSearchText($qRaw);

        $reveal = ($qDigits !== '' && (
            $qDigits === preg_replace('/\D/', '', (string) $customer->cccd)
            || $qDigits === preg_replace('/\D/', '', (string) $customer->phone)
            || $qDigits === preg_replace('/\D/', '', (string) $customer->license)
        )) || ($qText !== '' && $qText === $this->normalizeSearchText((string) $customer->name));

        $masked = [
            'name' => $this->maskName($customer->name),
            'cccd' => $this->maskNumber($customer->cccd),
            'phone' => $this->maskNumber($customer->phone),
            'license' => $this->maskNumber($customer->license),
            'address' => $this->maskAddress($customer->address),
        ];

        return view('check-khach-thue-chitiet', compact('customer', 'reveal', 'masked'));
    }

    private function maskName($value): string
    {
        $words = preg_split('/\s+/u', trim((string) $value), -1, PREG_SPLIT_NO_EMPTY);
        if (! $words) {
            return '';
        }

        if (count($words) === 1) {
            return mb_substr($words[0], 0, 1, 'UTF-8');
        }

        foreach ($words as $i => $word) {
            if ($i === 0) {
                continue;
            }

            $words[$i] = mb_substr($word, 0, 1, 'UTF-8');
        }

        return implode(' ', $words);
    }

    private function normalizeSearchText(string $value): string
    {
        $value = mb_strtolower(trim($value), 'UTF-8');
        $value = str_replace('đ', 'd', $value);

        if (function_exists('normalizer_normalize')) {
            $value = normalizer_normalize($value, \Normalizer::FORM_D);
        }

        $value = preg_replace('/[\x{0300}-\x{036f}]/u', '', $value) ?? $value;

        foreach (self::VN_DIACRITIC_MAP as $base => $chars) {
            $value = str_replace($chars, $base, $value);
        }

        return preg_replace('/\s+/', ' ', trim($value)) ?? '';
    }

    private function maskNumber($value): string
    {
        $digits = preg_replace('/\D/', '', (string) $value);
        if ($digits === '') {
            return '';
        }
        if (mb_strlen($digits) <= 4) {
            return 'xxxx';
        }

        return substr($digits, 0, -4) . 'xxxx';
    }

    private function maskAddress($value): string
    {
        $address = trim((string) $value);
        if ($address === '') {
            return '';
        }

        $parts = array_values(array_filter(array_map('trim', preg_split('/[,;]+/', $address)), fn ($p) => $p !== ''));

        if (count($parts) > 2) {
            return implode(', ', array_slice($parts, -2));
        }

        if (count($parts) === 2) {
            return implode(', ', $parts);
        }

        $words = preg_split('/\s+/', $parts[0] ?? $address);

        return implode(' ', array_slice($words, -2));
    }

    private function containsSpam(string $content): bool
    {
        $keywords = [
            'viagra', 'crypto', 'bitcoin', 'casino', 'nha cai',
            'lua dao', 'ban can', 'truc tiep', 'giam gia',
        ];

        foreach ($keywords as $keyword) {
            if (mb_stripos($content, $keyword) !== false) {
                return true;
            }
        }

        return preg_match('/https?:\/\/|www\.|\.com\b/i', $content) === 1;
    }

    private function isBot(Request $request): bool
    {
        $ua = strtolower($request->userAgent() ?? '');

        return preg_match('/(bot|crawl|spider|slurp|bingpreview|facebookexternalhit|whatsapp|telegrambot|preview)/', $ua) === 1;
    }
}
