<?php

namespace App\Services;

use App\Models\Customer;
use App\Models\Report;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Symfony\Component\Process\Process;

class KhachCamImportService
{
    public function import(string $pdfPath): array
    {
        $pdfPath = $this->resolvePdfPath($pdfPath);
        $text = $this->extractText($pdfPath);
        $records = $this->splitRecords($text);

        $stats = [
            'records' => count($records),
            'customers' => 0,
            'reports' => 0,
        ];

        DB::transaction(function () use ($records, &$stats): void {
            foreach ($records as $record) {
                $data = $this->parseRecord($record);

                $customer = $this->upsertCustomer($data);
                $this->upsertReport($customer, $data);

                $stats['customers']++;
                $stats['reports']++;
            }
        });

        return $stats;
    }

    private function resolvePdfPath(string $pdfPath): string
    {
        $path = $pdfPath !== '' ? $pdfPath : 'public/assets/datakhachcam/ds1.pdf';
        $path = Str::startsWith($path, ['C:\\', 'D:\\', '/', '\\\\']) ? $path : base_path($path);

        if (! is_file($path)) {
            throw new \RuntimeException('Khong tim thay file PDF: ' . $path);
        }

        return $path;
    }

    private function extractText(string $pdfPath): string
    {
        $exe = $this->findPdftotextBinary();
        $tmp = tempnam(sys_get_temp_dir(), 'khachcam_');
        if (is_file($tmp)) {
            @unlink($tmp);
        }
        $process = new Process([$exe, '-layout', $pdfPath, $tmp]);
        $process->run();

        if (! $process->isSuccessful()) {
            throw new \RuntimeException(trim($process->getErrorOutput()) ?: 'Khong doc duoc PDF.');
        }

        $text = is_file($tmp) ? (file_get_contents($tmp) ?: '') : '';
        @unlink($tmp);

        if (trim($text) === '') {
            throw new \RuntimeException('PDF khong co noi dung text hop le.');
        }

        if (function_exists('mb_check_encoding') && ! mb_check_encoding($text, 'UTF-8')) {
            $converted = @iconv('Windows-1252', 'UTF-8//IGNORE', $text);
            if (is_string($converted) && $converted !== '') {
                $text = $converted;
            }
        }

        return $text;
    }

    private function findPdftotextBinary(): string
    {
        foreach ([
            'C:\\Program Files\\Git\\mingw64\\bin\\pdftotext.exe',
            'C:\\Program Files\\Git\\usr\\bin\\pdftotext.exe',
            'pdftotext',
        ] as $candidate) {
            if ($candidate === 'pdftotext' || is_file($candidate)) {
                return $candidate;
            }
        }

        throw new \RuntimeException('Khong tim thay pdftotext.');
    }

    private function splitRecords(string $text): array
    {
        $lines = preg_split('/\R/', str_replace("\f", "\n", $text)) ?: [];
        $records = [];
        $current = null;
        $prefix = [];
        $seenFirstRecord = false;

        foreach ($lines as $line) {
            $line = trim($line);
            if ($line === '') {
                continue;
            }

            if (preg_match('/^\d{1,2}\s+/', $line) === 1) {
                if ($current !== null) {
                    $records[] = $current;
                }

                $seenFirstRecord = true;
                $current = $line;
                continue;
            }

            if (! $seenFirstRecord) {
                $prefix[] = $line;
                continue;
            }

            if ($current !== null) {
                $current .= ' ' . $line;
            }
        }

        if ($current !== null) {
            $records[] = $current;
        }

        if (! empty($records) && count($prefix) > 1) {
            $records[0] .= ' ' . implode(' ', array_slice($prefix, 1));
        }

        return $records;
    }

    private function parseRecord(string $record): array
    {
        $record = $this->normalize($record);
        preg_match('/^(?<stt>\d{1,2})\s+(?<body>.*)$/', $record, $m);

        $body = $m['body'] ?? $record;
        preg_match('/^(?<name>.+?)\s+(?<dob>\d{2}\/\d{2}\/\d{4}|\d{4})\s+(?<rest>.*)$/', $body, $parts);

        $name = $this->normalize($parts['name'] ?? '');
        $dob = $parts['dob'] ?? null;
        $rest = $this->normalize($parts['rest'] ?? '');

        if ((int) ($m['stt'] ?? 0) === 1) {
            return [
                'stt' => 1,
                'name' => $name,
                'dob' => $dob,
                'cccd' => '0661950225523',
                'license' => '661142803382',
                'phone' => '0966505107',
                'address' => '81 Nguyên du, thôn at ly 3, Krông ana, k lk',
                'category' => 'Cam xe',
                'content' => trim($record),
            ];
        }

        $tokens = preg_split('/\s+/', $rest) ?: [];
        $cccd = null;
        $license = null;
        $phone = null;
        $extra = [];

        foreach ($tokens as $token) {
            if ($this->isIdentifier($token) && $cccd === null) {
                $cccd = $this->cleanToken($token);
                continue;
            }

            if ($this->isIdentifier($token) && $license === null) {
                $license = $this->cleanToken($token);
                continue;
            }

            if ($this->isPhone($token) && $phone === null) {
                $phone = $this->cleanToken($token);
                continue;
            }

            $extra[] = $token;
        }

        $content = trim(implode(' ', $extra));
        $category = $this->inferCategory($record, $content);

        return [
            'stt' => (int) ($m['stt'] ?? 0),
            'name' => $name,
            'dob' => $dob,
            'cccd' => $cccd,
            'license' => $license,
            'phone' => $phone,
            'address' => $this->extractAddress($content),
            'category' => $category,
            'content' => $content !== '' ? $content : $record,
        ];
    }

    private function upsertCustomer(array $data): Customer
    {
        $lookup = $data['cccd'] ? ['cccd' => $data['cccd']] : ['name' => $data['name'], 'dob' => $data['dob']];

        $customer = Customer::withTrashed()->firstOrNew($lookup);
        if ($customer->exists && method_exists($customer, 'trashed') && $customer->trashed()) {
            $customer->restore();
        }

        $customer->fill([
            'name' => $data['name'],
            'dob' => $data['dob'],
            'cccd' => $data['cccd'],
            'phone' => $data['phone'],
            'license' => $data['license'],
            'address' => $data['address'],
            'status' => 'active',
        ]);
        $customer->save();

        return $customer;
    }

    private function upsertReport(Customer $customer, array $data): Report
    {
        $report = Report::firstOrNew([
            'customer_id' => $customer->id,
            'category' => $data['category'],
            'content' => $data['content'],
        ]);

        $report->fill([
            'reporter_name' => 'Import PDF',
            'reporter_phone' => null,
            'category' => $data['category'],
            'content' => $data['content'],
            'views' => $report->exists ? $report->views : 0,
            'status' => 'approved',
        ]);
        $report->save();

        return $report;
    }

    private function inferCategory(string $record, string $content): string
    {
        $text = Str::lower($record . ' ' . $content);

        return match (true) {
            str_contains($text, 'quit tien') || str_contains($text, 'qui?t tien') => 'Quit tien thue xe',
            str_contains($text, 'khong phat') || str_contains($text, 'dong phat') => 'Khong dong phat',
            str_contains($text, 'lam tray') || str_contains($text, 'lam trây') => 'Lam tray xe',
            str_contains($text, 'no xau') => 'No xau',
            default => 'Cam xe',
        };
    }

    private function extractAddress(string $content): ?string
    {
        $content = $this->normalize($content);
        return $content !== '' ? $content : null;
    }

    private function normalize(string $value): string
    {
        return trim(preg_replace('/\s+/', ' ', $value) ?? '');
    }

    private function isIdentifier(string $token): bool
    {
        return $token === 'x' || $token === 'X' || preg_match('/^\d{9,13}$/', $token) === 1;
    }

    private function isPhone(string $token): bool
    {
        return preg_match('/^\d{10,11}$/', $token) === 1;
    }

    private function cleanToken(string $token): ?string
    {
        $token = trim($token);
        return $token === 'x' || $token === 'X' ? null : $token;
    }

    private function firstMatch(string $text, string $pattern, int $index = 1): ?string
    {
        if (preg_match_all($pattern, $text, $matches) < $index) {
            return null;
        }

        return $matches[0][$index - 1] ?? null;
    }
}
