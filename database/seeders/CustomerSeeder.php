<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Customer;
use App\Models\Report;
use App\Models\ReportImage;

class CustomerSeeder extends Seeder
{
    public function run(): void
    {
        $nguyenVanA = Customer::updateOrCreate(
            ['cccd' => '041203000123'],
            [
                'name' => 'Nguyễn Văn A',
                'dob' => '12/03/1995',
                'phone' => '0901234567',
                'license' => '790000123456',
                'status' => 'active',
            ]
        );

        $tranThiB = Customer::updateOrCreate(
            ['cccd' => '041204008765'],
            [
                'name' => 'Trần Thị B',
                'dob' => '25/11/1998',
                'phone' => '0919876543',
                'license' => '790000654321',
                'status' => 'active',
            ]
        );

        $reports = [
            [
                'customer' => $nguyenVanA,
                'reporter_name' => 'Chủ xe gửi báo cáo',
                'reporter_phone' => '0964918047',
                'category' => 'Lừa đảo chuyển khoản',
                'content' => 'Khách đặt cọc thuê xe qua chuyển khoản, sau đó báo "chuyển nhầm" và yêu cầu hoàn tiền vào một tài khoản khác, gây thiệt hại cho chủ xe.',
                'views' => 234,
                'status' => 'approved',
                'days_ago' => 0,
            ],
            [
                'customer' => $nguyenVanA,
                'reporter_name' => 'Chủ xe B',
                'reporter_phone' => '0964918047',
                'category' => 'Trả xe trễ',
                'content' => 'Trả xe trễ, không báo trước, giữ xe thêm nhiều giờ.',
                'views' => 97,
                'status' => 'approved',
                'days_ago' => 2,
            ],
            [
                'customer' => $nguyenVanA,
                'reporter_name' => 'Chủ xe C',
                'reporter_phone' => '0964918047',
                'category' => 'Xe hư hỏng',
                'content' => 'Xe bị hư hỏng nội thất khi trả, không báo cáo trước.',
                'views' => 61,
                'status' => 'approved',
                'days_ago' => 4,
            ],
            [
                'customer' => $nguyenVanA,
                'reporter_name' => 'Chủ xe D',
                'reporter_phone' => '0964918047',
                'category' => 'Vi phạm giao thông',
                'content' => 'Chạy quá tốc độ, nhiều lần vi phạm giao thông trong thời gian thuê.',
                'views' => 45,
                'status' => 'pending',
                'days_ago' => 7,
            ],
            [
                'customer' => $nguyenVanA,
                'reporter_name' => 'Chủ xe E',
                'reporter_phone' => '0964918047',
                'category' => 'Nợ tiền thuê xe',
                'content' => 'Nợ tiền thuê xe nhiều lần, chậm thanh toán.',
                'views' => 38,
                'status' => 'pending',
                'days_ago' => 9,
            ],
            [
                'customer' => $tranThiB,
                'reporter_name' => 'Chủ xe gửi báo cáo',
                'reporter_phone' => '0964918047',
                'category' => 'Trả xe trễ',
                'content' => 'Thuê xe 2 ngày nhưng giữ xe thêm 3 ngày không liên lạc được, chỉ trả lại sau khi chủ xe trình báo công an.',
                'views' => 97,
                'status' => 'approved',
                'days_ago' => 1,
            ],
            [
                'customer' => $tranThiB,
                'reporter_name' => 'Chủ xe F',
                'reporter_phone' => '0964918047',
                'category' => 'Không thanh toán',
                'content' => 'Không thanh toán phí phát sinh khi trả xe.',
                'views' => 52,
                'status' => 'approved',
                'days_ago' => 3,
            ],
        ];

        foreach ($reports as $data) {
            $customer = $data['customer'];
            unset($data['customer'], $data['days_ago']);

            $report = Report::create($data + ['customer_id' => $customer->id]);

            for ($i = 0; $i < 3; $i++) {
                ReportImage::create(['report_id' => $report->id, 'path' => 'assets/icon-checkkhach/icon-avt.png']);
            }
        }
    }
}
