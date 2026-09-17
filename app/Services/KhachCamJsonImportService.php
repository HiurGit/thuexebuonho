<?php

namespace App\Services;

use App\Models\Customer;
use App\Models\Report;
use App\Models\ReportImage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class KhachCamJsonImportService
{
    private string $dataDir;
    private int $imported = 0;
    private int $skipped = 0;
    private int $reports = 0;
    private int $images = 0;

    public function __construct()
    {
        $this->dataDir = public_path('assets/datakhachcam');
    }

    public function import(): array
    {
        $dirs = array_filter(
            is_dir($this->dataDir)
                ? glob($this->dataDir . '/*')
                : [],
            'is_dir'
        );

        DB::transaction(function () use ($dirs) {
            foreach ($dirs as $dir) {
                $uuid = basename($dir);
                $jsonFile = $dir . '/' . $uuid . '.summary.json';

                if (! is_file($jsonFile)) {
                    continue;
                }

                $data = json_decode(File::get($jsonFile), true);

                if (! is_array($data)) {
                    continue;
                }

                $this->processRecord($data, $dir, $uuid);
            }
        });

        return [
            'imported' => $this->imported,
            'skipped' => $this->skipped,
            'reports' => $this->reports,
            'images' => $this->images,
        ];
    }

    private function processRecord(array $data, string $dir, string $uuid): void
    {
        $name = trim($data['ten'] ?? '');
        $cccd = $this->normalizeCccd($data['cccd'] ?? '');
        $dob = trim($data['ngay_sinh'] ?? '');
        $phone = trim($data['sdt'] ?? '');
        $moTa = trim($data['mo_ta'] ?? '');

        if ($name === '') {
            $this->skipped++;
            return;
        }

        $existing = $this->findExistingCustomer($cccd, $name);

        if ($existing) {
            $this->skipped++;
            return;
        }

        $customer = Customer::create([
            'name' => $name,
            'dob' => $dob !== '' ? $dob : null,
            'cccd' => $cccd !== '' ? $cccd : null,
            'phone' => $phone !== '' ? $phone : null,
            'status' => 'active',
        ]);

        $this->imported++;

        if ($moTa !== '') {
            $this->createReport($customer, $moTa);
        }

        $this->copyImages($dir, $uuid, $customer);
    }

    private function findExistingCustomer(?string $cccd, string $name): ?Customer
    {
        if ($cccd !== '' && $cccd !== null) {
            $found = Customer::where('cccd', $cccd)->first();

            if ($found) {
                return $found;
            }
        }

        return Customer::where('name', $name)->first();
    }

    private function normalizeCccd(string $value): ?string
    {
        $value = preg_replace('/\s+/', '', $value);
        $value = preg_replace('/[^0-9]/', '', $value);

        return $value !== '' ? $value : null;
    }

    private function createReport(Customer $customer, string $moTa): void
    {
        $category = $this->inferCategory($moTa);

        $report = Report::create([
            'customer_id' => $customer->id,
            'reporter_name' => 'Hệ thống',
            'reporter_phone' => '',
            'category' => $category,
            'content' => $moTa,
            'views' => 0,
            'status' => 'approved',
        ]);

        $this->reports++;
    }

    private function inferCategory(string $text): string
    {
        $lower = mb_strtolower($text);

        if (str_contains($lower, 'cầm') || str_contains($lower, 'cắm') || str_contains($lower, 'định vị')) {
            return 'Cầm cố';
        }

        if (str_contains($lower, 'quỵt') || str_contains($lower, 'không thanh toán') || str_contains($lower, 'nợ') || str_contains($lower, 'bùng')) {
            return 'Không thanh toán';
        }

        if (str_contains($lower, 'lừa') || str_contains($lower, 'lừa đảo')) {
            return 'Lừa đảo';
        }

        if (str_contains($lower, 'trầy') || str_contains($lower, 'va quẹt') || str_contains($lower, 'hư hỏng')) {
            return 'Va quẹt';
        }

        if (str_contains($lower, 'trả xe trễ') || str_contains($lower, 'trễ')) {
            return 'Trả xe trễ';
        }

        if (str_contains($lower, 'bỏ trốn') || str_contains($lower, 'mất xe') || str_contains($lower, 'tháo')) {
            return 'Thuê xe bỏ trốn';
        }

        if (str_contains($lower, 'tai nạn')) {
            return 'Gây tai nạn';
        }

        if (str_contains($lower, 'đồng phạm')) {
            return 'Đồng phạm';
        }

        return 'Khác';
    }

    private function copyImages(string $dir, string $uuid, Customer $customer): void
    {
        $imagesDir = $dir . '/images';

        if (! is_dir($imagesDir)) {
            return;
        }

        $files = array_merge(
            glob($imagesDir . '/*.png'),
            glob($imagesDir . '/*.jpg'),
            glob($imagesDir . '/*.jpeg'),
            glob($imagesDir . '/*.gif'),
            glob($imagesDir . '/*.webp'),
        );

        if (empty($files)) {
            return;
        }

        $report = $customer->reports()->first();

        if (! $report) {
            $report = Report::create([
                'customer_id' => $customer->id,
                'reporter_name' => 'Hệ thống',
                'reporter_phone' => '',
                'category' => 'Khác',
                'content' => 'Ảnh minh chứng từ dữ liệu camera',
                'views' => 0,
                'status' => 'approved',
            ]);
        }

        foreach ($files as $file) {
            $filename = $uuid . '_' . basename($file);
            $destPath = 'report_images/' . $filename;

            if (! Storage::disk('public')->exists($destPath)) {
                Storage::disk('public')->put($destPath, File::get($file));
            }

            ReportImage::create([
                'report_id' => $report->id,
                'path' => 'storage/' . $destPath,
            ]);

            $this->images++;
        }
    }
}
