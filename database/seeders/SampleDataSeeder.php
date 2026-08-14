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

        // === GLOBAL GUIDES (Usage - Quá trình sử dụng xe) ===
        $usageGuides = [
            ['Sử dụng xe đúng lộ trình đã đăng ký', '<ul><li>Người thuê chỉ được sử dụng xe theo khu vực và lộ trình đã thông báo với bên cho thuê.</li><li>Nếu có thay đổi về địa điểm hoặc lộ trình di chuyển, vui lòng thông báo trước để được xác nhận.</li></ul>'],
            ['Chỉ người đăng ký mới được phép điều khiển xe', '<ul><li>Chỉ người có tên trong hợp đồng thuê xe được phép điều khiển phương tiện.</li><li>Không giao xe cho người khác điều khiển hoặc cho mượn xe khi chưa có sự đồng ý của bên cho thuê.</li></ul>'],
            ['Kiểm tra xe trước khi khởi hành', '<ul><li>Kiểm tra ngoại thất, nội thất, mức nhiên liệu và các trang thiết bị trên xe.</li><li>Kiểm tra áp suất lốp, đèn chiếu sáng và các đèn cảnh báo.</li><li>Nếu phát hiện bất thường, vui lòng liên hệ ngay với bên cho thuê trước khi vận hành xe.</li></ul>'],
            ['Điều khiển xe an toàn', '<ul><li>Tuân thủ Luật Giao thông đường bộ.</li><li>Không lái xe khi đã sử dụng rượu bia, ma túy hoặc các chất kích thích.</li><li>Thắt dây an toàn cho tất cả người ngồi trên xe.</li><li>Không sử dụng điện thoại khi lái xe nếu không có thiết bị rảnh tay.</li></ul>'],
            ['Sử dụng xe đúng mục đích', '<ul><li>Không sử dụng xe để đua xe, chạy thử, tập lái, kéo xe khác hoặc thực hiện các hành vi vi phạm pháp luật.</li><li>Không chở quá số người hoặc quá tải trọng cho phép.</li><li>Không sử dụng xe để vận chuyển hàng cấm, hàng nguy hiểm hoặc phục vụ mục đích trái pháp luật.</li></ul>'],
            ['Bảo quản xe', '<ul><li>Giữ gìn vệ sinh nội thất và ngoại thất xe.</li><li>Không hút thuốc trong xe.</li><li>Không để vật sắc nhọn, hóa chất hoặc chất dễ cháy nổ trên xe.</li><li>Khi rời xe phải tắt máy, khóa cửa và bảo quản chìa khóa cẩn thận.</li></ul>'],
        ];
        foreach ($usageGuides as $i => $g) {
            GlobalGuide::create(['type' => 'usage', 'section_title' => $g[0], 'content' => $g[1], 'sort_order' => $i + 1]);
        }

        // === GLOBAL GUIDES (Accident) ===
        $accidentGuides = [
            ['Đảm bảo an toàn', "• Bình tĩnh.\n• Bật đèn cảnh báo khẩn cấp.\n• Đặt biển cảnh báo nếu cần.\n• Kiểm tra tình trạng người trên xe."],
            ['Giữ nguyên hiện trường', "• Không tự ý di chuyển xe nếu không cần thiết.\n• Chỉ di chuyển khi gây nguy hiểm cho giao thông."],
            ['Ghi nhận hiện trường', "Chụp rõ:\n• Toàn cảnh hiện trường.\n• Vị trí các xe.\n• Biển số các xe.\n• Các vị trí hư hỏng.\n• Dấu vết phanh, biển báo, đèn tín hiệu.\n• Giấy tờ của các bên (nếu được phép)."],
            ['Liên hệ', "Ưu tiên gọi theo thứ tự:\n1. Chủ xe/đơn vị cho thuê.\n2. Bảo hiểm.\n3. Cơ quan chức năng nếu có thương tích, tranh chấp hoặc thiệt hại lớn."],
            ['Chờ hướng dẫn', "• Không tự ý thỏa thuận bồi thường.\n• Không ký bất kỳ giấy tờ nào khi chưa trao đổi với chủ xe (trừ khi cơ quan chức năng yêu cầu)."],
        ];
        foreach ($accidentGuides as $i => $g) {
            GlobalGuide::create(['type' => 'accident', 'section_title' => $g[0], 'content' => $g[1], 'sort_order' => $i + 1]);
        }

        // === GLOBAL GUIDES (Insurance) ===
        $insuranceGuides = [
            ['Khi nào cần gọi bảo hiểm?', "• Va chạm giao thông.\n• Hư hỏng xe.\n• Thiệt hại tài sản.\n• Có bên thứ ba liên quan."],
            ['Chuẩn bị thông tin', "• Biển số xe.\n• Thời gian xảy ra sự việc.\n• Địa điểm.\n• Mô tả ngắn gọn diễn biến."],
            ['Hình ảnh cần cung cấp', "• Toàn cảnh hiện trường.\n• Hư hỏng của xe.\n• Hư hỏng của các xe khác (nếu có).\n• Biển số các xe.\n• Hình ảnh khu vực xảy ra tai nạn."],
            ['Trong thời gian chờ giám định', "• Không tự ý sửa chữa xe.\n• Không tháo rời các bộ phận bị hư hỏng.\n• Giữ nguyên hiện trạng theo hướng dẫn của bảo hiểm."],
            ['Sau khi hoàn tất', "• Làm theo hướng dẫn của đơn vị bảo hiểm và đơn vị cho thuê xe.\n• Phối hợp cung cấp thông tin khi được yêu cầu.\n• Lưu lại toàn bộ hình ảnh và giấy tờ liên quan."],
        ];
        foreach ($insuranceGuides as $i => $g) {
            GlobalGuide::create(['type' => 'insurance', 'section_title' => $g[0], 'content' => $g[1], 'sort_order' => $i + 1]);
        }

        // === GLOBAL GUIDES (Pickup) ===
        $pickupGuides = [
            ['Giấy tờ phải có', "• CCCD bản gốc còn hiệu lực.\n• Tài khoản VNeID mức 2 để đối chiếu thông tin.\n• Giấy phép lái xe còn hiệu lực, còn điểm theo quy định, chấp nhận bản cứng hoặc bản điện tử."],
            ['Hình thức đặt cọc', "• Đặt cọc bằng tiền mặt hoặc chuyển khoản.\n• Số tiền đặt cọc tùy loại xe (thông báo trước khi nhận xe)."],
            ['Hoàn trả tiền cọc hoặc tài sản cọc', "• Kiểm tra xe tại chỗ khi trả.\n• Hoàn cọc ngay khi xe đạt điều kiện."],
            ['Các trường hợp phát sinh', "• Xe có hư hỏng mới phát sinh sẽ được báo giá sửa chữa trước.\n• Phí phát sinh (vệ sinh, nhiên liệu, giờ phụ trội) sẽ được thông báo rõ ràng."],
        ];
        foreach ($pickupGuides as $i => $g) {
            GlobalGuide::create(['type' => 'pickup', 'section_title' => $g[0], 'content' => $g[1], 'sort_order' => $i + 1]);
        }

        // === GLOBAL GUIDES (Insurance rules - Quy tắc bảo hiểm) ===
        $insuranceRulesGuides = [
            ['Phạm vi bảo hiểm', "PVI chịu trách nhiệm bồi thường thiệt hại vật chất cho xe trong các trường hợp bất ngờ, không lường trước được sau đây:\n• Tai nạn: Đâm va, lật, đổ, chìm, rơi toàn bộ xe, bị vật thể khác rơi vào.\n• Cháy nổ: Hỏa hoạn, cháy, nổ.\n• Thiên tai: Những tai họa bất khả kháng do thiên tai gây ra.\n• Mất cắp: Mất toàn bộ xe do trộm, cướp.\n• Hành vi ác ý: Do người khác cố tình phá hoại (trừ người nhà, lái xe, hành khách trên xe).\n• Chi phí khác: Chi phí cứu hộ, kéo xe về nơi sửa chữa gần nhất.\n• Chi phí ngăn ngừa tổn thất thêm (có giới hạn)."],
            ['Điểm loại trừ', "Bảo hiểm không chi trả nếu rơi vào các trường hợp sau (trừ khi có mua điều khoản bổ sung):\nĐiểm loại trừ về người lái:\n• Không có Giấy phép lái xe hợp lệ (hoặc đang bị tước bằng).\n• Có nồng độ cồn, ma túy hoặc chất cấm.\nĐiểm loại trừ về xe:\n• Xe hết hạn đăng kiểm.\n• Xe chở hàng trái phép, chất cháy nổ không có giấy phép.\n• Hư hỏng do hao mòn tự nhiên, hỏng hóc kỹ thuật/cơ khí/điện (không do tai nạn).\n• Mất cắp bộ phận (ví dụ: bị bẻ gương, mất logo).\n• Xe bị ngập nước làm hỏng động cơ (thủy kích) – trừ khi xe bị tai nạn rơi xuống nước.\nĐiểm loại trừ về vận hành:\n• Xe đi vào đường cấm, đường ngược chiều, vượt đèn đỏ.\n• Xe chở quá tải trọng hoặc quá số người quy định từ 50% trở lên.\n• Xe chạy quá tốc độ quy định trên 35 km/h."],
            ['Giảm trừ bồi thường', "Trong một số trường hợp dưới đây, PVI vẫn bồi thường nhưng sẽ giảm trừ từ 10% đến 100%, tùy mức độ vi phạm:\n• Không báo sự cố kịp thời, chậm làm hồ sơ.\n• Tự ý sửa xe hoặc thay đổi hiện trường trước khi giám định.\n• Chạy quá tốc độ, chở quá tải.\n• Không hợp tác, khai báo không trung thực."],
        ];
        foreach ($insuranceRulesGuides as $i => $g) {
            GlobalGuide::create(['type' => 'insurance_rules', 'section_title' => $g[0], 'content' => $g[1], 'sort_order' => $i + 1]);
        }
    }
}
