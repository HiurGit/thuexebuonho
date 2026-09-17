<?php

namespace App\Console\Commands;

use App\Models\Customer;
use App\Models\Report;
use Illuminate\Console\Command;

class CreateCautionReports extends Command
{
    protected $signature = 'reports:create-caution';

    protected $description = 'Tạo report "Cảnh giác" cho khách hàng chưa có report nào';

    public function handle(): int
    {
        $customersWithoutReports = Customer::whereNull('deleted_at')
            ->whereDoesntHave('reports')
            ->get();

        if ($customersWithoutReports->isEmpty()) {
            $this->info('Tất cả khách hàng đều đã có report. Không có report nào được tạo.');
            return self::SUCCESS;
        }

        $bar = $this->output->createProgressBar($customersWithoutReports->count());
        $bar->start();

        $created = 0;
        foreach ($customersWithoutReports as $customer) {
            Report::create([
                'customer_id' => $customer->id,
                'reporter_name' => 'Hệ thống',
                'category' => 'Cảnh giác',
                'content' => 'Khách hàng cần cảnh giác khi giao dịch.',
                'status' => 'approved',
            ]);
            $created++;
            $bar->advance();
        }

        $bar->finish();
        $this->newLine();
        $this->info("Đã tạo {$created} report cảnh giác.");

        return self::SUCCESS;
    }
}
