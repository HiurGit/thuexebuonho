<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Car;
use App\Models\CarImage;
use App\Models\CarGuide;
use App\Models\CarAmenity;
use App\Models\GlobalGuide;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Support\Str;

class SampleDataSeeder extends Seeder
{
    public function run(): void
    {
        // === ADMIN ===
        User::create([
            'name' => 'Admin',
            'email' => 'admin@thuexebuonho.com',
            'password' => bcrypt('admin123'),
            'role' => 'admin',
        ]);

        // === SETTINGS ===
        Setting::set('site_name', 'Thuê Xe Buôn Hồ');
        Setting::set('site_phone', '0964.918.047');
        Setting::set('site_address', '07 Chu Văn An, Buôn Hồ, Đăk Lăk');
        Setting::set('site_zalo', '0964918047');
        Setting::set('site_facebook', 'https://www.facebook.com/9999NDT/');
        Setting::set('delivery_fee_per_km', '10000');
        Setting::set('late_return_fee_per_hour', '100000');
        Setting::set('cleaning_fee', '250000');

        // === CARS ===
        $xpander = Car::create([
            'name' => 'Mitsubishi Xpander',
            'slug' => 'mitsubishi-xpander',
            'description' => 'Mitsubishi Xpander 2022 - Xe 7 chỗ gia đình, máy dầu tiết kiệm, hộp số tự động vận hành êm ái. Xe trang bị camera hành trình, cảm biến lùi, màn hình giải trí Android Auto/Apple CarPlay. Nội thất da sạch sẽ, máy lạnh mát lạnh.',
            'seats' => 7,
            'transmission' => 'Tự động',
            'fuel' => 'Máy dầu',
            'fuel_consumption' => '6l/100km',
            'year' => 2025,
            'price_per_day' => 650000,
            'price_per_session' => 350000,
            'price_multi_day' => 600000,
            'price_out_province' => 100000,
            'sort_order' => 1,
        ]);

        CarImage::create(['car_id' => $xpander->id, 'path' => 'assets/image/xpander.webp', 'is_main' => true, 'sort_order' => 0]);
        CarImage::create(['car_id' => $xpander->id, 'path' => 'assets/image/xpander.webp', 'is_main' => false, 'sort_order' => 1]);
        CarImage::create(['car_id' => $xpander->id, 'path' => 'assets/image/xpander.webp', 'is_main' => false, 'sort_order' => 2]);

        $guides = ['Hướng dẫn khởi động', 'Hướng dẫn chuyển số', 'Hướng dẫn điều hòa & tiện nghi', 'Hướng dẫn đổ xăng', 'Hướng dẫn đỗ xe & phanh', 'Hướng dẫn an toàn'];
        foreach ($guides as $i => $title) {
            CarGuide::create(['car_id' => $xpander->id, 'title' => $title, 'sort_order' => $i + 1]);
        }

        $amenities = ['Camera hành trình', 'Kết nối Bluetooth', 'Màn hình cảm ứng', 'Camera lùi', 'Định vị GPS', 'Điều hòa', 'Cổng sạc USB', 'Ghế trẻ em'];
        foreach ($amenities as $i => $name) {
            CarAmenity::create(['car_id' => $xpander->id, 'name' => $name, 'sort_order' => $i + 1]);
        }

        // === HONDA CITY ===
        $honda = Car::create([
            'name' => 'Honda City',
            'slug' => 'honda-city',
            'description' => 'Honda City - Xe 5 chỗ sedan, tiết kiệm xăng, phù hợp đi phố và công tác.',
            'seats' => 5,
            'transmission' => 'Tự động',
            'fuel' => 'Máy xăng',
            'fuel_consumption' => '5.5l/100km',
            'year' => 2022,
            'price_per_day' => 650000,
            'price_per_session' => 350000,
            'sort_order' => 2,
        ]);

        CarImage::create(['car_id' => $honda->id, 'path' => 'assets/image/hondaCity.jpg', 'is_main' => true, 'sort_order' => 0]);
        CarImage::create(['car_id' => $honda->id, 'path' => 'assets/image/hondaCity.jpg', 'is_main' => false, 'sort_order' => 1]);
        CarImage::create(['car_id' => $honda->id, 'path' => 'assets/image/hondaCity.jpg', 'is_main' => false, 'sort_order' => 2]);

        foreach ($guides as $i => $title) {
            CarGuide::create(['car_id' => $honda->id, 'title' => $title, 'sort_order' => $i + 1]);
        }
        foreach ($amenities as $i => $name) {
            CarAmenity::create(['car_id' => $honda->id, 'name' => $name, 'sort_order' => $i + 1]);
        }

        // === TOYOTA VELOZ ===
        $veloz = Car::create([
            'name' => 'Toyota Veloz',
            'slug' => 'toyota-veloz',
            'description' => 'Toyota Veloz - Xe 7 chỗ đa dụng, rộng rãi, phù hợp gia đình.',
            'seats' => 7,
            'transmission' => 'Tự động',
            'fuel' => 'Máy xăng',
            'fuel_consumption' => '6.2l/100km',
            'year' => 2023,
            'price_per_day' => 700000,
            'price_per_session' => 400000,
            'sort_order' => 3,
        ]);

        CarImage::create(['car_id' => $veloz->id, 'path' => 'assets/image/veloz.jpg', 'is_main' => true, 'sort_order' => 0]);
        CarImage::create(['car_id' => $veloz->id, 'path' => 'assets/image/veloz.jpg', 'is_main' => false, 'sort_order' => 1]);
        CarImage::create(['car_id' => $veloz->id, 'path' => 'assets/image/veloz.jpg', 'is_main' => false, 'sort_order' => 2]);

        foreach ($guides as $i => $title) {
            CarGuide::create(['car_id' => $veloz->id, 'title' => $title, 'sort_order' => $i + 1]);
        }
        foreach ($amenities as $i => $name) {
            CarAmenity::create(['car_id' => $veloz->id, 'name' => $name, 'sort_order' => $i + 1]);
        }

        // === GLOBAL GUIDES (Usage - Hướng dẫn sử dụng xe) ===
        $usageGuides = [
            ['Trước khi khởi hành', '<ul><li>Kiểm tra xung quanh xe.</li><li>Điều chỉnh ghế ngồi, vô lăng và gương.</li><li>Thắt dây an toàn.</li><li>Kiểm tra mức nhiên liệu.</li><li>Đảm bảo tất cả cửa đã đóng kín.</li></ul>'],
            ['Khởi động xe', '<ul><li>Đạp phanh.</li><li>Khởi động bằng nút bấm hoặc chìa khóa.</li><li>Chờ các đèn cảnh báo trên bảng đồng hồ tắt trước khi di chuyển.</li></ul>'],
            ['Chuyển số', '<ul><li><b>P</b>: Đỗ xe.</li><li><b>R</b>: Lùi xe.</li><li><b>N</b>: Mo.</li><li><b>D</b>: Tiến.</li><li>Chỉ chuyển số khi xe đã dừng hẳn.</li></ul>'],
            ['Sử dụng các chức năng', '<ul><li>Điều hòa.</li><li>Đèn chiếu sáng.</li><li>Gạt mưa.</li><li>Màn hình giải trí.</li><li>Camera lùi/cảm biến (nếu có).</li><li>Cruise Control (nếu có).</li><li>Auto Hold/Phanh tay điện tử (nếu có).</li></ul>'],
            ['Trong quá trình sử dụng', '<ul><li>Tuân thủ luật giao thông.</li><li>Không giao xe cho người không đăng ký thuê.</li><li>Không hút thuốc trong xe.</li><li>Không tự ý sửa chữa xe.</li><li>Không sử dụng sai loại nhiên liệu.</li></ul>'],
            ['Khi kết thúc hành trình', '<ul><li>Đưa cần số về P.</li><li>Kéo phanh tay (nếu cần).</li><li>Tắt động cơ.</li><li>Kiểm tra đồ dùng cá nhân trước khi rời xe.</li></ul>'],
        ];
        foreach ($usageGuides as $i => $g) {
            GlobalGuide::create(['type' => 'usage', 'section_title' => $g[0], 'content' => $g[1], 'sort_order' => $i + 1]);
        }

        // === GLOBAL GUIDES (Accident) ===
        $accidentGuides = [
            ['Đảm bảo an toàn', '<ul><li>Bình tĩnh.</li><li>Bật đèn cảnh báo khẩn cấp.</li><li>Đặt biển cảnh báo nếu cần.</li><li>Kiểm tra tình trạng người trên xe.</li></ul>'],
            ['Giữ nguyên hiện trường', '<ul><li>Không tự ý di chuyển xe nếu không cần thiết.</li><li>Chỉ di chuyển khi gây nguy hiểm cho giao thông.</li></ul>'],
            ['Ghi nhận hiện trường', '<p>Chụp rõ:</p><ul><li>Toàn cảnh hiện trường.</li><li>Vị trí các xe.</li><li>Biển số các xe.</li><li>Các vị trí hư hỏng.</li><li>Dấu vết phanh, biển báo, đèn tín hiệu.</li></ul>'],
            ['Liên hệ', '<p>Ưu tiên gọi theo thứ tự:</p><ul><li>Chủ xe/đơn vị cho thuê.</li><li>Bảo hiểm.</li><li>Cơ quan chức năng nếu có thương tích, tranh chấp hoặc thiệt hại lớn.</li></ul>'],
            ['Chờ hướng dẫn', '<ul><li>Không tự ý thỏa thuận bồi thường.</li><li>Không ký bất kỳ giấy tờ nào khi chưa trao đổi với chủ xe.</li></ul>'],
        ];
        foreach ($accidentGuides as $i => $g) {
            GlobalGuide::create(['type' => 'accident', 'section_title' => $g[0], 'content' => $g[1], 'sort_order' => $i + 1]);
        }

        // === GLOBAL GUIDES (Insurance) ===
        $insuranceGuides = [
            ['Khi nào cần gọi bảo hiểm?', '<ul><li>Va chạm giao thông.</li><li>Hư hỏng xe.</li><li>Thiệt hại tài sản.</li><li>Có bên thứ ba liên quan.</li></ul>'],
            ['Chuẩn bị thông tin', '<ul><li>Biển số xe.</li><li>Thời gian xảy ra sự việc.</li><li>Địa điểm.</li><li>Mô tả ngắn gọn diễn biến.</li></ul>'],
            ['Hình ảnh cần cung cấp', '<ul><li>Toàn cảnh hiện trường.</li><li>Hư hỏng của xe.</li><li>Hư hỏng của các xe khác (nếu có).</li><li>Biển số các xe.</li></ul>'],
            ['Trong thời gian chờ giám định', '<ul><li>Không tự ý sửa chữa xe.</li><li>Không tháo rời các bộ phận bị hư hỏng.</li><li>Giữ nguyên hiện trạng theo hướng dẫn của bảo hiểm.</li></ul>'],
            ['Sau khi hoàn tất', '<ul><li>Làm theo hướng dẫn của đơn vị bảo hiểm và đơn vị cho thuê xe.</li><li>Phối hợp cung cấp thông tin khi được yêu cầu.</li><li>Lưu lại toàn bộ hình ảnh và giấy tờ liên quan.</li></ul>'],
        ];
        foreach ($insuranceGuides as $i => $g) {
            GlobalGuide::create(['type' => 'insurance', 'section_title' => $g[0], 'content' => $g[1], 'sort_order' => $i + 1]);
        }
    }
}
