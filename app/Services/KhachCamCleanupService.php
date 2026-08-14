<?php

namespace App\Services;

use App\Models\Customer;
use App\Models\Report;
use Illuminate\Support\Facades\DB;

class KhachCamCleanupService
{
    public function run(): array
    {
        $customerNameFixes = $this->customerNameFixes();
        $customerAddressFixes = $this->customerAddressFixes();
        $reportContentFixes = $this->reportContentFixes();

        $stats = [
            'customers' => 0,
            'reports' => 0,
        ];

        DB::transaction(function () use ($customerNameFixes, $customerAddressFixes, $reportContentFixes, &$stats): void {
            Customer::orderBy('id')->chunk(100, function ($customers) use ($customerNameFixes, $customerAddressFixes, &$stats): void {
                foreach ($customers as $customer) {
                    $updated = false;

                    if (array_key_exists($customer->id, $customerNameFixes) && $customer->name !== $customerNameFixes[$customer->id]) {
                        $customer->name = $customerNameFixes[$customer->id];
                        $updated = true;
                    }

                    if (array_key_exists($customer->id, $customerAddressFixes) && $customer->address !== $customerAddressFixes[$customer->id]) {
                        $customer->address = $customerAddressFixes[$customer->id];
                        $updated = true;
                    }

                    if ($updated) {
                        $customer->save();
                        $stats['customers']++;
                    }
                }
            });

            Report::where('reporter_name', 'Import PDF')->orderBy('id')->chunk(100, function ($reports) use ($reportContentFixes, &$stats): void {
                foreach ($reports as $report) {
                    $updated = false;

                    $category = $this->normalizeCategory($report->category);
                    if ($category !== $report->category) {
                        $report->category = $category;
                        $updated = true;
                    }

                    if (array_key_exists($report->id, $reportContentFixes) && $report->content !== $reportContentFixes[$report->id]) {
                        $report->content = $reportContentFixes[$report->id];
                        $updated = true;
                    }

                    if ($updated) {
                        $report->save();
                        $stats['reports']++;
                    }
                }
            });
        });

        return $stats;
    }

    private function normalizeCategory(?string $value): ?string
    {
        if ($value === null) {
            return null;
        }

        return match ($value) {
            'Cam xe' => 'Cấm xe',
            'Lam tray xe' => 'Làm trầy xe',
            'Quit tien thue xe' => 'Quịt tiền thuê xe',
            'Khong dong phat' => 'Không đóng phạt',
            'No xau' => 'Nợ xấu',
            default => $value,
        };
    }

    private function customerNameFixes(): array
    {
        return [
            10 => 'Nguyễn Thị Kim Trang',
            11 => 'Nguyễn Thu Hồng',
            13 => 'Nguyễn Tiến Thành',
            14 => 'Cao Đình Thanh',
            15 => 'Nguyễn Minh Nhật',
            16 => 'Huỳnh Thị Giao Châu',
            17 => 'Nguyễn Công Bôn',
            18 => 'Trần Minh Vũ',
            19 => 'Trần Thị Thanh Phương',
            20 => 'Trần Văn Công',
            21 => 'Đoàn Trí Nhân',
            22 => 'Lê Hữu Bình',
            23 => 'Nguyễn Thị Hằng',
            24 => 'Nguyễn Thị Kim Oanh',
            25 => 'Nguyễn Tiến Đạt',
            26 => 'Nguyễn Hữu Thịnh',
            27 => 'Nguyễn Tiến Hoài',
            28 => 'Hồ Văn Hậu',
            29 => 'Trần Tấn Tài',
            30 => 'Vũ Huy Phúc',
            31 => 'Nguyễn Phú Vinh',
            32 => 'Nguyễn Quốc Dũng',
            33 => 'Võ Hoàng Liêm',
            34 => 'Lý Hồng Phương',
            35 => 'Lê Thế Anh',
            36 => 'Phan Hoàng Duy',
            38 => 'Lê Trọng Trí',
            39 => 'Nguyễn Tuấn Sơn',
            40 => 'Nguyễn Hữu Phong',
            41 => 'Võ Hoàng Phong',
            42 => 'Lý Thanh Giang',
            43 => 'Trương Thanh Hải',
            44 => 'Đặng Thanh Việt',
            45 => 'Nguyễn Duy Kế',
            46 => 'Hồ Tấn Phát',
            48 => 'Hà Trí Hào',
            49 => 'Đàm Tố Hợp',
            50 => 'Phan Minh Tiến',
            51 => 'Vũ Thu Hiền',
            52 => 'Nguyễn Hữu Mạnh',
            53 => 'Phạm Thanh Tâm',
            54 => 'Lâm Phương Uyên',
            55 => 'Nguyễn Hoàng Nhân',
            56 => 'Lương Minh Ly',
            57 => 'Lương Gia Minh',
            58 => 'Lê Duy Truyền',
            59 => 'Nguyễn Ngọc Thanh',
            60 => 'Nguyễn Quốc Trung',
            61 => 'Hoàng Thanh Nhân',
            62 => 'Lê Hồng Đức',
            63 => 'Trần Quang Đạt',
            64 => 'Hoàng Anh Tuấn',
            65 => 'Bùi Hoàng Phong',
            66 => 'Trịnh Văn Quang',
        ];
    }

    private function customerAddressFixes(): array
    {
        return [
            10 => '81 Nguyễn Du, thôn A Tly 3, Krông Ana, Đắk Lắk',
            11 => '12 Ngô Yên Thế, Văn Miếu, Quốc Tử Giám, Đống Đa, Hà Nội, Cấm xe',
            12 => '0813, Khối C, Hiệp Thành, TP. TDM, Bình Dương, Cấm xe',
            13 => 'Kiên Tường, Long An, Cấm xe',
            14 => null,
            15 => null,
            16 => 'Kiên Tường, Long An, Cấm xe',
            17 => 'Lao động, Cấm xe',
            18 => 'Thống Nhất, Đồng Nai, Cấm xe',
            19 => null,
            20 => null,
            21 => null,
            22 => 'Hải Lăng, Quảng Trị, Cấm xe',
            23 => 'Cấm xe',
            24 => 'Sóc Sơn, Hà Nội',
            25 => null,
            26 => null,
            27 => null,
            28 => 'Làm trầy xe, không trả tiền',
            29 => null,
            30 => null,
            31 => 'Cao Lãnh, Đồng Tháp; Phường 12, Gò Vấp, Cấm xe',
            32 => 'Châu Thanh, Đồng Tháp; Phụng Hiệp, Hậu Giang, Cấm xe',
            33 => 'Cấm xe',
            34 => 'Phạt nguội, không đóng, cấm xe',
            35 => 'Hóc Môn và Quận 4, Hồ Chí Minh; Ninh Kiều, Cần Thơ, Cấm xe',
            36 => 'Ô Môn, Cần Thơ, Cấm xe',
            37 => 'Nhà Bè, Hồ Chí Minh, Cấm xe',
            38 => 'Quang Trung, Gò Vấp, Cấm xe',
            39 => 'Cấm xe',
            40 => 'Phường 5, Quận 6, HCM',
            41 => null,
            42 => null,
            43 => null,
            44 => null,
            45 => null,
            46 => null,
            47 => null,
            48 => null,
            49 => null,
            50 => null,
            51 => null,
            52 => null,
            53 => 'Bến Lức, Long An; không đóng phạt nguội, cấm xe',
            54 => null,
            55 => null,
            56 => 'Cấm xe',
            57 => '347/28C, Bùi Đình Túy, Bình Thạnh, TP. Hồ Chí Minh',
            58 => 'Thôn Trung Sơn, Tam Lãnh, Phú Ninh, Quảng Nam; không đóng phạt nguội',
            59 => '0/06 Chung cư số 1109 Phan Văn Trị, Phường 10, Gò Vấp; cấp 05/12/2023',
            60 => '127/14D/9 Mậu Thân, An Hòa, Ninh Kiều, Cần Thơ, Cấm xe',
            61 => 'Tổ 48, Hòa Phát, Cẩm Lệ, Đà Nẵng, Cấm xe',
            62 => 'Tổ 1, Ấp 4B, Bình Mỹ, Củ Chi, TP. Hồ Chí Minh; nợ xấu',
            63 => '463/11 Kha Vạn Cân, Linh Đông, Thủ Đức, HCM, Cấm xe',
            64 => 'Tổ 52, Cụm 8, Phú Thượng, Hà Nội, Cấm xe',
            65 => '12 đường N10, KP2, Phú Hữu, TP. Thủ Đức, Cấm xe',
            66 => 'Tổ 2, Khu phố Phú Thịnh, Đồng Xoài, Bình Phước; liên quan Đồng Nai, cấm xe',
        ];
    }

    private function reportContentFixes(): array
    {
        return [
            16 => '81 Nguyễn Du, thôn A Tly 3, Krông Ana, Đắk Lắk, Cấm xe',
            17 => '12 Ngô Yên Thế, Văn Miếu, Quốc Tử Giám, Đống Đa, Hà Nội, Cấm xe',
            18 => '0813, Khối C, Hiệp Thành, TP. TDM, Bình Dương, Cấm xe',
            19 => 'Kiên Tường, Long An, Cấm xe',
            20 => null,
            21 => null,
            22 => 'Kiên Tường, Long An, Cấm xe',
            23 => 'Lao động, Cấm xe',
            24 => 'Thống Nhất, Đồng Nai, Cấm xe',
            25 => null,
            26 => null,
            27 => null,
            28 => 'Hải Lăng, Quảng Trị, Cấm xe',
            29 => 'Cấm xe',
            30 => 'Sóc Sơn, Hà Nội',
            31 => null,
            32 => null,
            33 => null,
            34 => 'Làm trầy xe, không trả tiền',
            35 => null,
            36 => null,
            37 => 'Cao Lãnh, Đồng Tháp; Phường 12, Gò Vấp, Cấm xe',
            38 => 'Châu Thanh, Đồng Tháp; Phụng Hiệp, Hậu Giang, Cấm xe',
            39 => 'Cấm xe',
            40 => 'Phạt nguội, không đóng, cấm xe',
            41 => 'Hóc Môn và Quận 4, Hồ Chí Minh; Ninh Kiều, Cần Thơ, Cấm xe',
            42 => 'Ô Môn, Cần Thơ, Cấm xe',
            43 => 'Nhà Bè, Hồ Chí Minh, Cấm xe',
            44 => 'Quang Trung, Gò Vấp, Cấm xe',
            45 => 'Cấm xe',
            46 => 'Phường 5, Quận 6, HCM',
            47 => null,
            48 => null,
            49 => null,
            50 => null,
            51 => null,
            52 => null,
            53 => null,
            54 => null,
            55 => null,
            56 => null,
            57 => null,
            58 => null,
            59 => 'Bến Lức, Long An; không đóng phạt nguội, cấm xe',
            60 => null,
            61 => null,
            62 => 'Cấm xe',
            63 => '347/28C, Bùi Đình Túy, Bình Thạnh, TP. Hồ Chí Minh, quịt tiền thuê xe',
            64 => 'Thôn Trung Sơn, Tam Lãnh, Phú Ninh, Quảng Nam; không đóng phạt nguội',
            65 => '0/06 Chung cư số 1109 Phan Văn Trị, Phường 10, Gò Vấp; cấp 05/12/2023',
            66 => '127/14D/9 Mậu Thân, An Hòa, Ninh Kiều, Cần Thơ, Cấm xe',
            67 => 'Tổ 48, Hòa Phát, Cẩm Lệ, Đà Nẵng, Cấm xe',
            68 => 'Tổ 1, Ấp 4B, Bình Mỹ, Củ Chi, TP. Hồ Chí Minh; nợ xấu',
            69 => '463/11 Kha Vạn Cân, Linh Đông, Thủ Đức, HCM, Cấm xe',
            70 => 'Tổ 52, Cụm 8, Phú Thượng, Hà Nội, Cấm xe',
            71 => '12 đường N10, KP2, Phú Hữu, TP. Thủ Đức, Cấm xe',
            72 => 'Tổ 2, Khu phố Phú Thịnh, Đồng Xoài, Bình Phước; liên quan Đồng Nai, cấm xe',
        ];
    }
}
