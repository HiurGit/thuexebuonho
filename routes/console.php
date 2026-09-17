<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use App\Services\BlackListCsvImportService;
use App\Services\Ds2CsvImportService;
use App\Services\KhachCamCleanupService;
use App\Services\KhachCamImportService;
use App\Services\DataFileImportService;
use App\Services\KhachCamJsonImportService;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('khachcam:import {pdf?}', function () {
    $importer = app(KhachCamImportService::class);
    $pdf = (string) ($this->argument('pdf') ?? 'public/assets/datakhachcam/ds1.pdf');
    $stats = $importer->import($pdf);

    $this->info("Imported {$stats['records']} records.");
    $this->info("Customers: {$stats['customers']}, reports: {$stats['reports']}.");
})->purpose('Import khach cam data from PDF');

Artisan::command('khachcam:cleanup', function () {
    $cleanup = app(KhachCamCleanupService::class);
    $stats = $cleanup->run();

    $this->info("Updated {$stats['customers']} customers.");
    $this->info("Updated {$stats['reports']} reports.");
})->purpose('Clean OCR noise in imported khach cam data');

Artisan::command('khachcam:import-csv {csv?}', function () {
    $importer = app(BlackListCsvImportService::class);
    $csv = (string) ($this->argument('csv') ?? 'public/assets/datakhachcam/Black List - Thuê Xe.csv');
    $stats = $importer->import($csv);

    $this->info("Imported {$stats['imported']} rows.");
    $this->info("Skipped {$stats['skipped']} rows.");

    if (! empty($stats['log_path'])) {
        $this->info("Skip log: {$stats['log_path']}");
    }
})->purpose('Import blacklist CSV into customers and reports');

Artisan::command('khachcam:import-ds2 {csv?}', function () {
    $importer = app(Ds2CsvImportService::class);
    $csv = (string) ($this->argument('csv') ?? 'public/assets/datakhachcam/ds2.csv');
    $stats = $importer->import($csv);

    $this->info("Inserted customers: {$stats['inserted_customers']}");
    $this->info("Merged customers: {$stats['merged_customers']}");
    $this->info("Reports created: {$stats['reports']}");
    $this->info("Skipped rows: {$stats['skipped']}");

    if (! empty($stats['log_path'])) {
        $this->info("Skip log: {$stats['log_path']}");
    }
})->purpose('Import ds2 CSV and merge missing customer fields by CCCD');

Artisan::command('khachcam:import-data {files?*}', function () {
    $importer = app(DataFileImportService::class);
    $files = $this->argument('files');

    if ($files === []) {
        $files = array_values(array_filter([
            'public/assets/datakhachcam/data.txt',
            'public/assets/datakhachcam/data1.txt',
        ], 'is_file'));
    }

    $stats = $importer->import($files);

    $this->info("Customers inserted: {$stats['customers']}");
    $this->info("Reports created: {$stats['reports']}");
    $this->info("Skipped groups: {$stats['skipped']}");
})->purpose('Import danh sách đen từ file dữ liệu (bảng markdown + hồ sơ căn cước)');

Artisan::command('khachcam:import-json', function () {
    $importer = app(KhachCamJsonImportService::class);
    $stats = $importer->import();

    $this->info("Customers imported: {$stats['imported']}");
    $this->info("Skipped: {$stats['skipped']}");
    $this->info("Reports created: {$stats['reports']}");
    $this->info("Images copied: {$stats['images']}");
})->purpose('Import khach cam data from summary.json + images');
