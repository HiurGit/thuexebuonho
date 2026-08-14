<?php

namespace App\Services;

use App\Models\Customer;
use App\Models\Report;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DataFileImportService
{
    private const READER_LABELS = [
        'Số định danh cá nhân' => 'cccd',
        'Nơi đăng ký khai sinh' => 'birth_registration',
        'Ngày cấp CCCD gần nhất' => 'cccd_issue_date',
        'Cập nhật lần cuối' => 'updated_at_text',
        'Đặc điểm nhận dạng' => 'features',
        'Nơi thường trú' => 'address',
        'Nơi ở hiện tại' => 'current_address',
        'Nơi tạm trú' => 'temporary_address',
        'Họ và tên' => 'name',
        'Ngày sinh' => 'dob',
        'Giới tính' => 'gender',
        'Quốc tịch' => 'nationality',
        'Nơi sinh' => 'birth_place',
        'Quê quán' => 'hometown',
        'Dân tộc' => 'ethnicity',
        'Tôn giáo' => 'religion',
    ];

    private const CAM_LABELS = [
        'Số định danh cá nhân',
        'Nơi thường trú & Nơi ở hiện tại',
        'Nơi đăng ký khai sinh',
        'Ngày cấp CCCD gần nhất',
        'Hạng xe được điều khiển',
        'Đặc điểm nhận dạng',
        'Cập nhật lần cuối',
        'Nơi thường trú',
        'Nơi ở hiện tại',
        'Nơi tạm trú',
        'Nơi cư trú',
        'Ngày trúng tuyển',
        'Có giá trị đến',
        'Cơ quan cấp',
        'Ngày hết hạn',
        'Ngày cấp',
        'Ngày sinh',
        'Giới tính',
        'Quốc tịch',
        'Quê quán',
        'Dân tộc',
        'Tôn giáo',
        'Hạng',
        'Địa chỉ',
        'Mã số',
        'Họ và tên',
        'Họ tên',
        'Số CCCD',
        'Số GPLX',
    ];

    public function import(array $files): array
    {
        $records = [];

        foreach ($files as $file) {
            $path = $this->resolvePath((string) $file);
            $records = array_merge($records, $this->parseFile($path));
        }

        return $this->storeRecords($records);
    }

    private function parseFile(string $path): array
    {
        $lines = file($path, FILE_IGNORE_NEW_LINES);
        if ($lines === false) {
            return [];
        }

        $firstLine = '';
        foreach ($lines as $line) {
            if (trim($line) !== '') {
                $firstLine = trim($line);
                break;
            }
        }

        if (mb_strpos($firstLine, '|') === 0) {
            return $this->parseTable($path);
        }

        if (preg_match('/^Hình\s+\d+\s*:/u', $firstLine) === 1 || mb_strpos($firstLine, ' – ') !== false) {
            return $this->parseCamFile($path);
        }

        return $this->parseReader($path);
    }

    private function parseTable(string $path): array
    {
        $lines = file($path, FILE_IGNORE_NEW_LINES);
        if ($lines === false) {
            return [];
        }

        $records = [];
        $map = null;

        foreach ($lines as $line) {
            if (trim($line) === '' || mb_strpos($line, '|') === false) {
                continue;
            }

            $cells = $this->splitTableRow($line);
            if ($cells === null || $this->isSeparatorRow($cells)) {
                continue;
            }

            $headers = array_map(fn ($cell) => $this->normalizeHeader($cell), $cells);
            if (in_array('STT', $headers, true)) {
                $map = $this->buildTableMap($headers);
                continue;
            }

            if ($map === null) {
                continue;
            }

            $record = $this->extractTableRecord($cells, $map);
            if ($record === null) {
                continue;
            }

            $records[] = $record;
        }

        return $records;
    }

    private function splitTableRow(string $line): ?array
    {
        $cells = explode('|', $line);

        if (trim($cells[0]) === '') {
            array_shift($cells);
        }

        if ($cells !== [] && trim($cells[count($cells) - 1]) === '') {
            array_pop($cells);
        }

        if ($cells === []) {
            return null;
        }

        return array_map(fn ($cell) => trim($cell), $cells);
    }

    private function isSeparatorRow(array $cells): bool
    {
        foreach ($cells as $cell) {
            if (preg_match('/^:?-+:?$/', trim($cell)) !== 1) {
                return false;
            }
        }

        return $cells !== [];
    }

    private function buildTableMap(array $headers): array
    {
        $map = [];

        foreach ($headers as $index => $header) {
            $key = $this->tableHeaderKey($header);
            if ($key !== null && ! isset($map[$key])) {
                $map[$key] = $index;
            }
        }

        return $map;
    }

    private function tableHeaderKey(string $header): ?string
    {
        return match ($header) {
            'STT' => 'stt',
            'HỌ VÀ TÊN', 'HỌ & TÊN', 'TÊN' => 'name',
            'LOẠI GIẤY TỜ' => 'doc_type',
            'NGÀY SINH' => 'dob',
            'GIỚI TÍNH' => 'gender',
            'QUỐC TỊCH' => 'nationality',
            'QUÊ QUÁN' => 'hometown',
            'ĐỊA CHỈ THƯỜNG TRÚ / CƯ TRÚ', 'ĐỊA CHỈ THƯỜNG TRÚ', 'ĐỊA CHỈ' => 'address',
            'THỜI HẠN / NGÀY CẤP' => 'validity',
            'GHI CHÚ' => 'note',
            'SỐ ĐỊNH DANH/CCCD', 'SỐ ĐỊNH DANH / CCCD', 'CCCD' => 'cccd',
            'GIẤY PHÉP LÁI XE', 'GPLX' => 'license',
            default => null,
        };
    }

    private function extractTableRecord(array $cells, array $map): ?array
    {
        $get = function (string $key) use ($cells, $map) {
            $index = $map[$key] ?? null;

            return $index !== null && isset($cells[$index]) ? $cells[$index] : null;
        };

        $name = $this->requiredText($get('name'));
        if ($name === null) {
            return null;
        }

        $cccdRaw = $this->requiredText($get('cccd'));
        $licenseRaw = $this->requiredText($get('license'));

        return [
            'doc_type' => $this->requiredText($get('doc_type')),
            'name' => $name,
            'dob' => $this->normalizeDate($get('dob')),
            'gender' => $this->normalizeGender($get('gender')),
            'nationality' => $this->requiredText($get('nationality')),
            'hometown' => $this->requiredText($get('hometown')),
            'address' => $this->requiredText($get('address')),
            'validity' => $this->requiredText($get('validity')),
            'note' => $this->requiredText($get('note')),
            'cccd' => $this->normalizeId($cccdRaw),
            'cccd_raw' => $cccdRaw,
            'license' => $this->normalizeId($licenseRaw),
            'license_raw' => $licenseRaw,
            'cccd_issue_date' => null,
            'features' => null,
            'birth_registration' => null,
        ];
    }

    private function parseReader(string $path): array
    {
        $lines = file($path, FILE_IGNORE_NEW_LINES);
        if ($lines === false) {
            return [];
        }

        $records = [];
        $raw = null;

        foreach ($lines as $line) {
            $line = trim($line);
            if ($line === '') {
                continue;
            }

            if (preg_match('/^(\d+)\.\s*(.*)$/u', $line, $match) === 1) {
                if ($raw !== null) {
                    $records[] = $this->readerToRecord($raw);
                }

                $raw = ['doc_type' => $match[2]];
                continue;
            }

            if ($raw === null) {
                continue;
            }

            $this->applyReaderLine($raw, $line);
        }

        if ($raw !== null) {
            $records[] = $this->readerToRecord($raw);
        }

        return $records;
    }

    private function applyReaderLine(array &$raw, string $line): void
    {
        foreach (self::READER_LABELS as $label => $key) {
            $labelValue = $label . ' ';
            if ($line === $label || mb_strpos($line, $labelValue) === 0) {
                $raw[$key] = trim(mb_substr($line, mb_strlen($label)));

                return;
            }
        }
    }

    private function readerToRecord(array $raw): array
    {
        $cccdRaw = $this->requiredText($raw['cccd'] ?? null);
        $cccd = $this->normalizeId($cccdRaw);

        return [
            'doc_type' => $this->requiredText($raw['doc_type'] ?? null),
            'name' => $this->requiredText($raw['name'] ?? null),
            'dob' => $this->normalizeDate($raw['dob'] ?? null),
            'gender' => $this->normalizeGender($raw['gender'] ?? null),
            'nationality' => $this->requiredText($raw['nationality'] ?? null),
            'hometown' => $this->requiredText($raw['hometown'] ?? null),
            'address' => $this->requiredText($raw['address'] ?? $raw['current_address'] ?? null),
            'validity' => null,
            'note' => null,
            'cccd' => $cccd,
            'cccd_raw' => $cccdRaw,
            'license' => null,
            'license_raw' => null,
            'cccd_issue_date' => $this->normalizeDate($raw['cccd_issue_date'] ?? null),
            'features' => $this->requiredText($raw['features'] ?? null),
            'birth_registration' => $this->requiredText($raw['birth_registration'] ?? null),
            'note_lines' => [],
        ];
    }

    private function parseCamFile(string $path): array
    {
        $lines = file($path, FILE_IGNORE_NEW_LINES);
        if ($lines === false) {
            return [];
        }

        $records = [];
        $current = null;
        $blockName = null;
        $blockDob = null;
        $pending = null;
        $note = [];

        foreach ($lines as $line) {
            $line = trim($line);
            if ($line === '') {
                continue;
            }

            $title = null;
            if ($this->isCamBlockStart($line, $title)) {
                $this->flushCamRecord($records, $current, $blockName, $blockDob, $note);
                [$blockName, $docType] = $this->parseCamBlockTitle($title);
                $blockDob = null;
                $current = ['doc_type' => $docType];
                $pending = null;
                continue;
            }

            if ($current === null) {
                $current = [];
            }

            if ($this->isCamSectionStart($line)) {
                $section = trim(rtrim($line, ':'));

                if ($this->camRecordIsEmpty($current)) {
                    $current['doc_type'] = $section;
                } else {
                    $this->flushCamRecord($records, $current, $blockName, $blockDob, $note);
                    $current = ['doc_type' => $section];
                }

                $pending = null;
                continue;
            }

            foreach (explode(' | ', $line) as $segment) {
                $segment = trim($segment);
                $matched = $this->matchCamLabel($segment);

                if ($matched !== null) {
                    [$label, $value] = $matched;
                    if ($value === '') {
                        $pending = $label;
                    } else {
                        $this->setCamField($current, $label, $value, $blockName, $blockDob);
                        $pending = null;
                    }
                    continue;
                }

                if ($pending !== null) {
                    $this->setCamField($current, $pending, $segment, $blockName, $blockDob);
                    $pending = null;
                    continue;
                }

                $note[] = $segment;
            }
        }

        $this->flushCamRecord($records, $current, $blockName, $blockDob, $note);

        return $records;
    }

    private function isCamBlockStart(string $line, ?string &$title): bool
    {
        if (preg_match('/^Hình\s+\d+\s*:\s*(.+)$/u', $line, $match) === 1) {
            $title = $match[1];

            return true;
        }

        if (preg_match('/^\d+\.\s*(.+)$/u', $line, $match) === 1) {
            $title = $match[1];

            return true;
        }

        if (mb_strpos($line, ' – ') !== false) {
            $title = $line;

            return true;
        }

        return false;
    }

    private function parseCamBlockTitle(string $title): array
    {
        $title = trim($title);

        if (mb_strpos($title, ' – ') !== false) {
            $parts = explode(' – ', $title);

            return [trim(implode(' – ', array_slice($parts, 1))), trim($parts[0])];
        }

        if (preg_match('/^(.*?)\s*\(([^()]*)\)\s*$/u', $title, $match)) {
            return [trim($match[1]), trim($match[2])];
        }

        return [$title, null];
    }

    private function isCamSectionStart(string $line): bool
    {
        if (! str_ends_with($line, ':')) {
            return false;
        }

        if ($this->matchCamLabel($line) !== null) {
            return false;
        }

        return mb_strlen($line) <= 60;
    }

    private function matchCamLabel(string $line): ?array
    {
        foreach (self::CAM_LABELS as $label) {
            if (preg_match('/^' . preg_quote($label, '/') . '\s*:\s*(.*)$/u', $line, $match) === 1) {
                return [$label, trim($match[1])];
            }
        }

        return null;
    }

    private function setCamField(array &$current, string $label, string $value, ?string &$blockName, ?string &$blockDob): void
    {
        $text = $this->requiredText($value);

        switch ($label) {
            case 'Số định danh cá nhân':
            case 'Số CCCD':
                $current['cccd_raw'] = $text;
                $current['cccd'] = $this->normalizeId($value);
                break;

            case 'Số GPLX':
                $current['license_raw'] = $text;
                $current['license'] = $this->normalizeId($value);
                break;

            case 'Họ và tên':
            case 'Họ tên':
                if ($text !== null) {
                    $current['name'] = $text;
                    $blockName ??= $text;
                }
                break;

            case 'Ngày sinh':
                $dob = $this->normalizeDate($value);
                if ($dob !== null) {
                    $current['dob'] = $dob;
                    $blockDob ??= $dob;
                }
                break;

            case 'Giới tính':
                $current['gender'] = $this->normalizeGender($value);
                break;

            case 'Quốc tịch':
                $current['nationality'] = $text;
                break;

            case 'Quê quán':
                $current['hometown'] = $text;
                break;

            case 'Nơi thường trú':
                $current['address'] = $text;
                break;

            case 'Nơi thường trú & Nơi ở hiện tại':
                $current['address'] = $text;
                $current['current_address'] = $text;
                break;

            case 'Nơi cư trú':
                $current['residence'] = $text;
                break;

            case 'Địa chỉ':
                $current['addr_line'] = $text;
                break;

            case 'Nơi ở hiện tại':
                $current['current_address'] = $text;
                break;

            case 'Nơi tạm trú':
                $current['temporary_address'] = $text;
                break;

            case 'Nơi đăng ký khai sinh':
                $current['birth_registration'] = $text;
                break;

            case 'Nơi sinh':
                $current['birth_place'] = $text;
                break;

            case 'Dân tộc':
                $current['ethnicity'] = $text;
                break;

            case 'Tôn giáo':
                $current['religion'] = $text;
                break;

            case 'Đặc điểm nhận dạng':
                $current['features'] = $text;
                break;

            case 'Ngày cấp CCCD gần nhất':
                $current['cccd_issue_date'] = $this->normalizeDate($value);
                break;

            case 'Có giá trị đến':
            case 'Ngày hết hạn':
                $current['valid_until'] = $text;
                break;

            case 'Ngày cấp':
                $current['issued_date'] = $text;
                break;

            case 'Cơ quan cấp':
                $current['issuing_authority'] = $text;
                break;

            case 'Hạng':
                $current['license_class'] = $text;
                break;

            case 'Mã số':
                $current['cert_code'] = $text;
                break;

            case 'Ngày trúng tuyển':
                $current['exam_date'] = $text;
                break;

            case 'Hạng xe được điều khiển':
                $current['vehicle_class'] = $text;
                break;

            case 'Cập nhật lần cuối':
                $current['updated_at_text'] = $text;
                break;
        }
    }

    private function camRecordIsEmpty(array $record): bool
    {
        $dataKeys = [
            'cccd', 'cccd_raw', 'license', 'license_raw', 'dob', 'gender', 'nationality',
            'hometown', 'address', 'residence', 'addr_line', 'current_address',
            'temporary_address', 'birth_registration', 'birth_place', 'ethnicity',
            'religion', 'features', 'cccd_issue_date', 'valid_until', 'issued_date',
            'issuing_authority', 'license_class', 'cert_code', 'exam_date',
            'vehicle_class', 'updated_at_text',
        ];

        foreach ($dataKeys as $key) {
            $value = $record[$key] ?? null;
            if ($value !== null && $value !== '') {
                return false;
            }
        }

        if (! empty($record['note_lines'] ?? [])) {
            return false;
        }

        return true;
    }

    private function flushCamRecord(array &$records, ?array &$current, ?string $blockName, ?string $blockDob, array &$note): void
    {
        if ($current === null) {
            return;
        }

        if ($this->camRecordIsEmpty($current)) {
            $current = null;
            $note = [];

            return;
        }

        if (($current['name'] ?? null) === null) {
            $current['name'] = $blockName;
        }

        if (($current['dob'] ?? null) === null) {
            $current['dob'] = $blockDob;
        }

        if ($note !== []) {
            $current['note_lines'] = array_merge($current['note_lines'] ?? [], $note);
        }

        $records[] = $this->finalizeCamRecord($current);
        $current = null;
        $note = [];
    }

    private function finalizeCamRecord(array $record): array
    {
        $record['doc_type'] = $this->requiredText($record['doc_type'] ?? null);
        $record['name'] = $this->requiredText($record['name'] ?? null);
        $record['dob'] = $record['dob'] ?? null;
        $record['gender'] = $record['gender'] ?? null;
        $record['nationality'] = $record['nationality'] ?? null;
        $record['hometown'] = $record['hometown'] ?? null;
        $record['address'] = $record['address'] ?? null;
        $record['validity'] = null;
        $record['note'] = null;
        $record['cccd'] = $record['cccd'] ?? null;
        $record['cccd_raw'] = $record['cccd_raw'] ?? null;
        $record['license'] = $record['license'] ?? null;
        $record['license_raw'] = $record['license_raw'] ?? null;
        $record['cccd_issue_date'] = $record['cccd_issue_date'] ?? null;
        $record['features'] = $record['features'] ?? null;
        $record['birth_registration'] = $record['birth_registration'] ?? null;
        $record['note_lines'] = $record['note_lines'] ?? [];

        return $record;
    }

    private function groupRecords(array $records): array
    {
        $groups = [];

        foreach ($records as $record) {
            $name = $this->normalizeName($record['name'] ?? null);
            if ($name === '') {
                continue;
            }

            $key = ! empty($record['cccd'])
                ? 'c:' . $record['cccd']
                : 'n:' . $name . '|' . ($record['dob'] ?? '');

            $groups[$key][] = $record;
        }

        return $groups;
    }

    private function storeRecords(array $records): array
    {
        $groups = $this->groupRecords($records);
        $summary = ['customers' => 0, 'reports' => 0, 'skipped' => 0];

        uksort($groups, fn ($a, $b) => ((str_starts_with($b, 'c:') ? 1 : 0) <=> (str_starts_with($a, 'c:') ? 1 : 0)));

        DB::transaction(function () use ($groups, &$summary): void {
            $byCustomer = [];

            foreach ($groups as $group) {
                $group = $this->sortGroup($group);
                $created = false;
                $customer = $this->findOrCreateCustomer($group, $created);

                if ($created) {
                    $summary['customers']++;
                }

                $byCustomer[$customer->id]['records'][] = $group;
            }

            foreach ($byCustomer as $customerId => $item) {
                $all = array_merge(...$item['records']);
                $all = $this->sortGroup($all);
                $content = $this->buildContent($all);

                if ($content === '') {
                    $summary['skipped']++;
                    continue;
                }

                $exists = Report::where('customer_id', $customerId)
                    ->where('content', $content)
                    ->where('status', 'approved')
                    ->exists();

                if ($exists) {
                    $summary['skipped']++;
                    continue;
                }

                Report::create([
                    'customer_id' => $customerId,
                    'reporter_name' => 'Import danh sách đen',
                    'category' => 'Danh sách đen',
                    'content' => $content,
                    'views' => 0,
                    'status' => 'approved',
                ]);

                $summary['reports']++;
            }
        });

        return $summary;
    }

    private function sortGroup(array $group): array
    {
        usort($group, fn ($a, $b) => $this->cccdPriority($b) <=> $this->cccdPriority($a));

        return $group;
    }

    private function cccdPriority(array $record): int
    {
        $type = mb_strtolower($record['doc_type'] ?? '', 'UTF-8');

        if ($type === 'giấy phép lái xe') {
            return 0;
        }

        return mb_strpos($type, 'căn cước') !== false ? 2 : 1;
    }

    private function findOrCreateCustomer(array $group, bool &$created): Customer
    {
        $first = $group[0];
        $name = $this->requiredText($first['name'] ?? null);
        $dob = $first['dob'] ?? null;
        $normalizedName = $this->normalizeName($name);

        if (! empty($first['cccd'])) {
            $customer = Customer::withTrashed()->where('cccd', $first['cccd'])->first();
            if ($customer) {
                $this->fillCustomer($customer, $group);
                $customer->save();
                $created = false;

                return $customer;
            }
        }

        $query = Customer::withTrashed();
        if ($dob !== null && $dob !== '') {
            $query->where('dob', $dob);
        }

        foreach ($query->get() as $candidate) {
            if ($this->normalizeName($candidate->name) === $normalizedName) {
                $this->fillCustomer($candidate, $group);
                $candidate->save();
                $created = false;

                return $candidate;
            }
        }

        $customer = new Customer();
        $this->fillCustomer($customer, $group);
        $customer->status = $customer->status ?: 'active';
        $customer->save();
        $created = true;

        return $customer;
    }

    private function fillCustomer(Customer $customer, array $group): void
    {
        foreach ($group as $record) {
            $address = $this->requiredText($record['address'] ?? null)
                ?? $this->requiredText($record['residence'] ?? null)
                ?? $this->requiredText($record['addr_line'] ?? null)
                ?? $this->requiredText($record['current_address'] ?? null);

            $fields = [
                'name' => $this->requiredText($record['name'] ?? null),
                'dob' => $record['dob'] ?? null,
                'gender' => $record['gender'] ?? null,
                'address' => $address,
                'cccd' => $record['cccd'] ?? null,
                'license' => $record['license'] ?? null,
                'cccd_issue_date' => $record['cccd_issue_date'] ?? null,
            ];

            foreach ($fields as $field => $value) {
                if ($value === null || $value === '') {
                    continue;
                }

                if ($this->isBlank($customer->{$field} ?? null)) {
                    $customer->{$field} = $value;
                }
            }
        }

        if ($customer->trashed()) {
            $customer->restore();
        }

        $customer->status = $customer->status ?: 'active';
    }

    private function buildContent(array $group): string
    {
        $chunks = [];

        foreach ($group as $record) {
            $parts = [];

            if ($record['doc_type']) {
                $parts[] = $record['doc_type'];
            }

            if ($record['cccd']) {
                $parts[] = 'CCCD: ' . $record['cccd'];
            } elseif ($record['cccd_raw']) {
                $parts[] = 'Số định danh: ' . $record['cccd_raw'];
            }

            if ($record['dob']) {
                $parts[] = 'Ngày sinh: ' . $record['dob'];
            }

            if ($record['gender']) {
                $parts[] = 'Giới tính: ' . $record['gender'];
            }

            if ($record['nationality']) {
                $parts[] = 'Quốc tịch: ' . $record['nationality'];
            }

            if ($record['hometown']) {
                $parts[] = 'Quê quán: ' . $record['hometown'];
            }

            if ($record['birth_registration']) {
                $parts[] = 'Nơi ĐKKS: ' . $record['birth_registration'];
            }

            if ($record['birth_place'] ?? null) {
                $parts[] = 'Nơi sinh: ' . $record['birth_place'];
            }

            if ($record['ethnicity'] ?? null) {
                $parts[] = 'Dân tộc: ' . $record['ethnicity'];
            }

            if ($record['religion'] ?? null) {
                $parts[] = 'Tôn giáo: ' . $record['religion'];
            }

            if ($record['address']) {
                $parts[] = 'HKTT: ' . $record['address'];
            }

            $residence = $record['residence'] ?? null;
            if ($residence && $residence !== ($record['address'] ?? null)) {
                $parts[] = 'Nơi cư trú: ' . $residence;
            }

            if ($record['temporary_address'] ?? null) {
                $parts[] = 'Nơi tạm trú: ' . $record['temporary_address'];
            }

            if ($record['current_address'] ?? null) {
                $parts[] = 'Nơi ở hiện tại: ' . $record['current_address'];
            }

            if ($record['cccd_issue_date']) {
                $parts[] = 'Ngày cấp CCCD: ' . $record['cccd_issue_date'];
            }

            if ($record['valid_until'] ?? null) {
                $parts[] = 'Có giá trị đến: ' . $record['valid_until'];
            }

            if ($record['issued_date'] ?? null) {
                $parts[] = 'Ngày cấp: ' . $record['issued_date'];
            }

            if ($record['issuing_authority'] ?? null) {
                $parts[] = 'Cơ quan cấp: ' . $record['issuing_authority'];
            }

            if ($record['license_raw']) {
                $parts[] = 'GPLX: ' . $record['license_raw'];
            } elseif ($record['license']) {
                $parts[] = 'GPLX: ' . $record['license'];
            }

            if ($record['license_class'] ?? null) {
                $parts[] = 'Hạng: ' . $record['license_class'];
            }

            if ($record['cert_code'] ?? null) {
                $parts[] = 'Mã số: ' . $record['cert_code'];
            }

            if ($record['exam_date'] ?? null) {
                $parts[] = 'Ngày trúng tuyển: ' . $record['exam_date'];
            }

            if ($record['vehicle_class'] ?? null) {
                $parts[] = 'Hạng xe: ' . $record['vehicle_class'];
            }

            if ($record['features']) {
                $parts[] = 'Nhận dạng: ' . $record['features'];
            }

            if ($record['validity']) {
                $parts[] = $record['validity'];
            }

            if ($record['updated_at_text'] ?? null) {
                $parts[] = 'Cập nhật lần cuối: ' . $record['updated_at_text'];
            }

            if ($record['note']) {
                $parts[] = $record['note'];
            }

            foreach ($record['note_lines'] ?? [] as $noteLine) {
                if ($noteLine !== null && $noteLine !== '') {
                    $parts[] = $noteLine;
                }
            }

            if ($parts !== []) {
                $chunks[] = implode(' | ', $parts);
            }
        }

        return implode(' — ', $chunks);
    }

    private function resolvePath(string $path): string
    {
        $path = Str::startsWith($path, ['C:\\', 'D:\\', '/', '\\\\']) ? $path : base_path($path);

        if (! is_file($path)) {
            throw new \RuntimeException('Khong tim thay file: ' . $path);
        }

        return $path;
    }

    private function cleanCell($value): ?string
    {
        if ($value === null) {
            return null;
        }

        $value = trim((string) $value);
        $value = preg_replace('/^\xEF\xBB\xBF/', '', $value) ?: $value;
        $value = str_replace('**', '', $value);
        $value = trim($value);

        if ($value === '') {
            return null;
        }

        if (in_array(mb_strtolower($value, 'UTF-8'), ['-', '—', '---', 'không hiển thị', 'n/a', 'na'], true)) {
            return null;
        }

        return $value;
    }

    private function requiredText($value): ?string
    {
        $value = $this->cleanCell($value);
        if ($value === null) {
            return null;
        }

        $value = preg_replace('/\s+/', ' ', $value) ?: $value;

        return $value === '' ? null : trim($value, " \t\n\r\0\x0B\"");
    }

    private function normalizeHeader(string $value): string
    {
        $value = $this->cleanCell($value) ?? '';
        $value = mb_strtoupper($value, 'UTF-8');
        $value = preg_replace('/\s+/', ' ', $value) ?: $value;

        return trim($value);
    }

    private function normalizeGender($value): ?string
    {
        $value = $this->requiredText($value);
        if ($value === null) {
            return null;
        }

        return match (mb_strtolower($value, 'UTF-8')) {
            'nam' => 'Nam',
            'nữ', 'nu' => 'Nữ',
            default => $value,
        };
    }

    private function normalizeDate($value): ?string
    {
        $value = $this->requiredText($value);
        if ($value === null) {
            return null;
        }

        if (preg_match('/^(\d{4})-(\d{2})-(\d{2})$/', $value, $match)) {
            return $match[3] . '/' . $match[2] . '/' . $match[1];
        }

        if (preg_match('/^(\d{1,2})\/(\d{1,2})\/(\d{4})$/', $value, $match)) {
            return sprintf('%02d/%02d/%s', $match[1], $match[2], $match[3]);
        }

        if (preg_match('/^(\d{2})(\d{2})(\d{4})$/', $value, $match)) {
            return $match[1] . '/' . $match[2] . '/' . $match[3];
        }

        return $value;
    }

    private function normalizeId($value): ?string
    {
        $value = $this->cleanCell($value);
        if ($value === null) {
            return null;
        }

        if (preg_match('/^\d+\.\d+E\+\d+$/i', $value) === 1) {
            $value = sprintf('%.0f', (float) $value);
        }

        if (preg_match('/\d{9,}/', $value, $match) !== 1) {
            return null;
        }

        return $match[0];
    }

    private function normalizeName($value): string
    {
        $name = $this->requiredText($value) ?? '';
        $name = mb_strtoupper($name, 'UTF-8');
        $name = str_replace('Đ', 'D', $name);

        if (function_exists('normalizer_normalize')) {
            $name = normalizer_normalize($name, \Normalizer::FORM_D);
            $name = preg_replace('/[\x{0300}-\x{036f}]/u', '', $name) ?? $name;
        }

        $name = preg_replace('/\s+/', ' ', trim($name)) ?? '';

        return $name;
    }

    private function isBlank($value): bool
    {
        $value = $this->cleanCell($value);
        if ($value === null) {
            return true;
        }

        return in_array(mb_strtolower($value, 'UTF-8'), ['x', 'n/a', 'na', '-'], true);
    }
}
