<?php

namespace App\Services;

use App\Models\Customer;
use App\Models\Report;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class Ds2CsvImportService
{
    public function import(string $csvPath): array
    {
        $csvPath = $this->resolveCsvPath($csvPath);
        $handle = fopen($csvPath, 'r');

        if ($handle === false) {
            throw new \RuntimeException('Khong mo duoc file CSV: ' . $csvPath);
        }

        $header = fgetcsv($handle);
        if (! is_array($header)) {
            fclose($handle);
            throw new \RuntimeException('CSV khong co dong tieu de hop le.');
        }

        $header = array_map(fn ($value) => $this->normalizeCell($value), $header);
        $map = $this->headerMap($header);

        $summary = [
            'inserted_customers' => 0,
            'merged_customers' => 0,
            'reports' => 0,
            'skipped' => 0,
            'log_path' => null,
        ];
        $skippedRows = [];
        $seen = [];

        DB::transaction(function () use ($handle, $map, &$summary, &$skippedRows, &$seen): void {
            $rowNumber = 1;

            while (($row = fgetcsv($handle)) !== false) {
                $rowNumber++;

                if ($this->isEmptyRow($row)) {
                    continue;
                }

                $data = $this->extractRow($row, $map);
                $cccd = $this->normalizeId($data['cccd'] ?? null);

                if ($cccd === null) {
                    $summary['skipped']++;
                    $skippedRows[] = $this->skipRow($rowNumber, 'missing_cccd', $data);
                    continue;
                }

                $customer = Customer::withTrashed()->where('cccd', $cccd)->first();
                if (! $customer) {
                    $customer = new Customer();
                    $customer->cccd = $cccd;
                    $summary['inserted_customers']++;
                } else {
                    if ($customer->trashed()) {
                        $customer->restore();
                    }
                    $summary['merged_customers']++;
                }

                $before = $customer->getAttributes();
                $this->fillCustomerMissingFields($customer, $data);
                $customer->status = $customer->status ?: 'active';
                $customer->save();

                Report::create([
                    'customer_id' => $customer->id,
                    'reporter_name' => 'Import CSV DS2',
                    'reporter_phone' => $this->normalizePhone($data['phone'] ?? null),
                    'category' => $this->requiredText($data['reason'] ?? null),
                    'content' => $this->buildReportContent($data),
                    'views' => 0,
                    'status' => 'approved',
                ]);

                $summary['reports']++;
                $seen[$cccd] = true;
            }
        });

        fclose($handle);

        if ($skippedRows !== []) {
            $summary['log_path'] = $this->writeSkipLog($csvPath, $skippedRows);
        }

        return $summary;
    }

    private function resolveCsvPath(string $csvPath): string
    {
        $path = $csvPath !== '' ? $csvPath : 'public/assets/datakhachcam/ds2.csv';
        $path = Str::startsWith($path, ['C:\\', 'D:\\', '/', '\\\\']) ? $path : base_path($path);

        if (! is_file($path)) {
            throw new \RuntimeException('Khong tim thay file CSV: ' . $path);
        }

        return $path;
    }

    private function headerMap(array $header): array
    {
        $header = array_map(fn ($value) => $this->normalizeHeader((string) $value), $header);

        return [
            'stt' => $this->findHeader($header, ['STT']),
            'name' => $this->findHeader($header, ['HỌ & TÊN', 'HO & TEN', 'TEN']),
            'gender' => $this->findHeader($header, ['GIỚI TÍNH', 'GIOI TINH']),
            'cccd' => $this->findHeader($header, ['CCCD']),
            'license' => $this->findHeader($header, ['GPLX', 'GIẤY PHÉP LÁI XE', 'GIAY PHEP LAI XE']),
            'phone' => $this->findHeader($header, ['SĐT', 'SDT', 'SỐ ĐIỆN THOẠI', 'SO DIEN THOAI']),
            'dob' => $this->findHeader($header, ['NGÀY THÁNG NĂM SINH', 'NGAY THANG NAM SINH', 'NGÀY SINH', 'NGAY SINH']),
            'address' => $this->findHeader($header, ['ĐỊA CHỈ CCCD', 'DIA CHI CCCD', 'ĐỊA CHỈ HIỆN TẠI', 'DIA CHI HIEN TAI']),
            'province' => $this->findHeader($header, ['TỈNH THÀNH', 'TINH THANH']),
            'reason' => $this->findHeader($header, ['LÝ DO', 'LY DO']),
            'detail' => $this->findHeader($header, ['CHI TIẾT', 'CHI TIET']),
        ];
    }

    private function findHeader(array $header, array $candidates): ?int
    {
        foreach ($candidates as $candidate) {
            $index = array_search($this->normalizeHeader($candidate), $header, true);
            if ($index !== false) {
                return $index;
            }
        }

        return null;
    }

    private function extractRow(array $row, array $map): array
    {
        $get = function (string $key) use ($row, $map) {
            $index = $map[$key] ?? null;
            return $index !== null && array_key_exists($index, $row) ? $row[$index] : null;
        };

        return [
            'stt' => $get('stt'),
            'name' => $get('name'),
            'gender' => $get('gender'),
            'cccd' => $get('cccd'),
            'license' => $get('license'),
            'phone' => $get('phone'),
            'dob' => $get('dob'),
            'address' => $get('address'),
            'province' => $get('province'),
            'reason' => $get('reason'),
            'detail' => $get('detail'),
        ];
    }

    private function fillCustomerMissingFields(Customer $customer, array $data): void
    {
        $fields = [
            'name' => $this->requiredText($data['name'] ?? null),
            'gender' => $this->normalizeGender($data['gender'] ?? null),
            'dob' => $this->requiredText($data['dob'] ?? null),
            'phone' => $this->normalizePhone($data['phone'] ?? null),
            'license' => $this->normalizeId($data['license'] ?? null),
            'address' => $this->requiredText($data['address'] ?? null),
        ];

        foreach ($fields as $field => $incoming) {
            if ($incoming === null) {
                continue;
            }

            $current = $customer->{$field} ?? null;
            if ($this->isBlank($current)) {
                $customer->{$field} = $incoming;
            }
        }
    }

    private function buildReportContent(array $data): ?string
    {
        $parts = [];
        foreach (['province', 'detail'] as $key) {
            $value = $this->requiredText($data[$key] ?? null);
            if ($value !== null) {
                $parts[] = $value;
            }
        }

        return $parts !== [] ? implode(' | ', $parts) : null;
    }

    private function normalizeCell($value): ?string
    {
        if ($value === null) {
            return null;
        }

        if (is_float($value) || is_int($value)) {
            return (string) $value;
        }

        $value = (string) $value;
        $value = preg_replace('/^\xEF\xBB\xBF/', '', $value) ?: $value;
        $value = trim($value);

        return $value === '' ? null : $value;
    }

    private function normalizeHeader(string $value): string
    {
        $value = $this->normalizeCell($value) ?? '';
        $value = mb_strtoupper($value, 'UTF-8');
        $value = preg_replace('/\s+/', ' ', $value) ?: $value;

        return trim($value);
    }

    private function normalizeId($value): ?string
    {
        $value = $this->normalizeCell($value);
        if ($value === null) {
            return null;
        }

        if (preg_match('/^\d+\.\d+E\+\d+$/i', $value) === 1 || preg_match('/^\d+\.\d+e\+\d+$/i', $value) === 1) {
            $value = sprintf('%.0f', (float) $value);
        }

        $value = preg_replace('/[^\d]/', '', $value) ?: $value;

        return $value === '' ? null : $value;
    }

    private function normalizePhone($value): ?string
    {
        $value = $this->normalizeCell($value);
        if ($value === null) {
            return null;
        }

        if (preg_match('/^\d+\.\d+E\+\d+$/i', $value) === 1 || preg_match('/^\d+\.\d+e\+\d+$/i', $value) === 1) {
            $value = sprintf('%.0f', (float) $value);
        }

        $value = preg_replace('/[^\d]/', '', $value) ?: $value;

        return $value === '' ? null : $value;
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

    private function requiredText($value): ?string
    {
        $value = $this->normalizeCell($value);
        if ($value === null) {
            return null;
        }

        $value = trim($value, " \t\n\r\0\x0B\"");
        $value = preg_replace('/\s+/', ' ', $value) ?: $value;

        return $value === '' ? null : $value;
    }

    private function isBlank($value): bool
    {
        $value = $this->normalizeCell($value);
        return $value === null || in_array(mb_strtolower($value, 'UTF-8'), ['x', 'n/a', 'na', '-'], true);
    }

    private function isEmptyRow(array $row): bool
    {
        foreach ($row as $cell) {
            if ($this->normalizeCell($cell) !== null) {
                return false;
            }
        }

        return true;
    }

    private function skipRow(int $rowNumber, string $reason, array $data): array
    {
        return [
            'row' => $rowNumber,
            'reason' => $reason,
            'name' => $this->requiredText($data['name'] ?? null),
            'cccd' => $this->normalizeId($data['cccd'] ?? null),
            'phone' => $this->normalizePhone($data['phone'] ?? null),
            'dob' => $this->requiredText($data['dob'] ?? null),
            'gender' => $this->normalizeGender($data['gender'] ?? null),
            'license' => $this->normalizeId($data['license'] ?? null),
            'address' => $this->requiredText($data['address'] ?? null),
            'province' => $this->requiredText($data['province'] ?? null),
            'category' => $this->requiredText($data['reason'] ?? null),
            'detail' => $this->requiredText($data['detail'] ?? null),
        ];
    }

    private function writeSkipLog(string $csvPath, array $rows): string
    {
        $dir = storage_path('app/khachcam-imports');
        if (! is_dir($dir)) {
            mkdir($dir, 0777, true);
        }

        $name = 'ds2-skip-' . now()->format('Ymd_His') . '.json';
        $path = $dir . DIRECTORY_SEPARATOR . $name;
        file_put_contents($path, json_encode([
            'source' => $csvPath,
            'skipped' => $rows,
        ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

        return $path;
    }
}
