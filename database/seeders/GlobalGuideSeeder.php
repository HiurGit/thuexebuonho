<?php

namespace Database\Seeders;

use App\Models\GlobalGuide;
use Illuminate\Database\Seeder;

class GlobalGuideSeeder extends Seeder
{
    public function run(): void
    {
        GlobalGuide::insert([
            // ===== Quá trình sử dụng xe =====
            [
                'type' => 'usage',
                'section_title' => 'Sử dụng xe đúng lộ trình đã đăng ký',
                'content' => "• Người thuê chỉ được sử dụng xe theo khu vực và lộ trình đã thông báo với bên cho thuê.\n• Nếu có thay đổi về địa điểm hoặc lộ trình di chuyển, vui lòng thông báo trước để được xác nhận.",
                'sort_order' => 1,
            ],
            [
                'type' => 'usage',
                'section_title' => 'Chỉ người đăng ký mới được phép điều khiển xe',
                'content' => "• Chỉ người có tên trong hợp đồng thuê xe được phép điều khiển phương tiện.\n• Không giao xe cho người khác điều khiển hoặc cho mượn xe khi chưa có sự đồng ý của bên cho thuê.",
                'sort_order' => 2,
            ],
            [
                'type' => 'usage',
                'section_title' => 'Kiểm tra xe trước khi khởi hành',
                'content' => "• Kiểm tra ngoại thất, nội thất, mức nhiên liệu và các trang thiết bị trên xe.\n• Kiểm tra áp suất lốp, đèn chiếu sáng và các đèn cảnh báo.\n• Nếu phát hiện bất thường, vui lòng liên hệ ngay với bên cho thuê trước khi vận hành xe.",
                'sort_order' => 3,
            ],
            [
                'type' => 'usage',
                'section_title' => 'Điều khiển xe an toàn',
                'content' => "• Tuân thủ Luật Giao thông đường bộ.\n• Không lái xe khi đã sử dụng rượu bia, ma túy hoặc các chất kích thích.\n• Thắt dây an toàn cho tất cả người ngồi trên xe.\n• Không sử dụng điện thoại khi lái xe nếu không có thiết bị rảnh tay.",
                'sort_order' => 4,
            ],
            [
                'type' => 'usage',
                'section_title' => 'Sử dụng xe đúng mục đích',
                'content' => "• Không sử dụng xe để đua xe, chạy thử, tập lái, kéo xe khác hoặc thực hiện các hành vi vi phạm pháp luật.\n• Không chở quá số người hoặc quá tải trọng cho phép.\n• Không sử dụng xe để vận chuyển hàng cấm, hàng nguy hiểm hoặc phục vụ mục đích trái pháp luật.",
                'sort_order' => 5,
            ],
            [
                'type' => 'usage',
                'section_title' => 'Bảo quản xe',
                'content' => "• Giữ gìn vệ sinh nội thất và ngoại thất xe.\n• Không hút thuốc trong xe.\n• Không để vật sắc nhọn, hóa chất hoặc chất dễ cháy nổ trên xe.\n• Khi rời xe phải tắt máy, khóa cửa và bảo quản chìa khóa cẩn thận.",
                'sort_order' => 6,
            ],

            // ===== Xử lý tai nạn =====
            [
                'type' => 'accident',
                'section_title' => 'Đảm bảo an toàn',
                'content' => "• Bình tĩnh.\n• Bật đèn cảnh báo khẩn cấp.\n• Đặt biển cảnh báo nếu cần.\n• Kiểm tra tình trạng người trên xe.",
                'sort_order' => 1,
            ],
            [
                'type' => 'accident',
                'section_title' => 'Giữ nguyên hiện trường',
                'content' => "• Không tự ý di chuyển xe nếu không cần thiết.\n• Chỉ di chuyển khi gây nguy hiểm cho giao thông.",
                'sort_order' => 2,
            ],
            [
                'type' => 'accident',
                'section_title' => 'Ghi nhận hiện trường',
                'content' => "Chụp rõ:\n• Toàn cảnh hiện trường.\n• Vị trí các xe.\n• Biển số các xe.\n• Các vị trí hư hỏng.\n• Dấu vết phanh, biển báo, đèn tín hiệu.\n• Giấy tờ của các bên (nếu được phép).",
                'sort_order' => 3,
            ],
            [
                'type' => 'accident',
                'section_title' => 'Liên hệ',
                'content' => "Ưu tiên gọi theo thứ tự:\n1. Chủ xe/đơn vị cho thuê.\n2. Bảo hiểm.\n3. Cơ quan chức năng nếu có thương tích, tranh chấp hoặc thiệt hại lớn.",
                'sort_order' => 4,
            ],
            [
                'type' => 'accident',
                'section_title' => 'Chờ hướng dẫn',
                'content' => "• Không tự ý thỏa thuận bồi thường.\n• Không ký bất kỳ giấy tờ nào khi chưa trao đổi với chủ xe (trừ khi cơ quan chức năng yêu cầu).",
                'sort_order' => 5,
            ],

            // ===== Xử lý bảo hiểm =====
            [
                'type' => 'insurance',
                'section_title' => 'Khi nào cần gọi bảo hiểm?',
                'content' => "• Va chạm giao thông.\n• Hư hỏng xe.\n• Thiệt hại tài sản.\n• Có bên thứ ba liên quan.",
                'sort_order' => 1,
            ],
            [
                'type' => 'insurance',
                'section_title' => 'Chuẩn bị thông tin',
                'content' => "• Biển số xe.\n• Thời gian xảy ra sự việc.\n• Địa điểm.\n• Mô tả ngắn gọn diễn biến.",
                'sort_order' => 2,
            ],
            [
                'type' => 'insurance',
                'section_title' => 'Hình ảnh cần cung cấp',
                'content' => "• Toàn cảnh hiện trường.\n• Hư hỏng của xe.\n• Hư hỏng của các xe khác (nếu có).\n• Biển số các xe.\n• Hình ảnh khu vực xảy ra tai nạn.",
                'sort_order' => 3,
            ],
            [
                'type' => 'insurance',
                'section_title' => 'Trong thời gian chờ giám định',
                'content' => "• Không tự ý sửa chữa xe.\n• Không tháo rời các bộ phận bị hư hỏng.\n• Giữ nguyên hiện trạng theo hướng dẫn của bảo hiểm.",
                'sort_order' => 4,
            ],
            [
                'type' => 'insurance',
                'section_title' => 'Sau khi hoàn tất',
                'content' => "• Làm theo hướng dẫn của đơn vị bảo hiểm và đơn vị cho thuê xe.\n• Phối hợp cung cấp thông tin khi được yêu cầu.\n• Lưu lại toàn bộ hình ảnh và giấy tờ liên quan.",
                'sort_order' => 5,
            ],

            // ===== Quy tắc bảo hiểm =====
            [
                'type' => 'insurance_rules',
                'section_title' => 'Phạm vi bảo hiểm',
                'content' => "PVI chịu trách nhiệm bồi thường thiệt hại vật chất cho xe trong các trường hợp bất ngờ, không lường trước được sau đây:\n• Tai nạn: Đâm va, lật, đổ, chìm, rơi toàn bộ xe, bị vật thể khác rơi vào.\n• Cháy nổ: Hỏa hoạn, cháy, nổ.\n• Thiên tai: Những tai họa bất khả kháng do thiên tai gây ra.\n• Mất cắp: Mất toàn bộ xe do trộm, cướp.\n• Hành vi ác ý: Do người khác cố tình phá hoại (trừ người nhà, lái xe, hành khách trên xe).\n• Chi phí khác: Chi phí cứu hộ, kéo xe về nơi sửa chữa gần nhất.\n• Chi phí ngăn ngừa tổn thất thêm (có giới hạn).",
                'sort_order' => 1,
            ],
            [
                'type' => 'insurance_rules',
                'section_title' => 'Điểm loại trừ',
                'content' => "Bảo hiểm không chi trả nếu rơi vào các trường hợp sau (trừ khi có mua điều khoản bổ sung):\nĐiểm loại trừ về người lái:\n• Không có Giấy phép lái xe hợp lệ (hoặc đang bị tước bằng).\n• Có nồng độ cồn, ma túy hoặc chất cấm.\nĐiểm loại trừ về xe:\n• Xe hết hạn đăng kiểm.\n• Xe chở hàng trái phép, chất cháy nổ không có giấy phép.\n• Hư hỏng do hao mòn tự nhiên, hỏng hóc kỹ thuật/cơ khí/điện (không do tai nạn).\n• Mất cắp bộ phận (ví dụ: bị bẻ gương, mất logo).\n• Xe bị ngập nước làm hỏng động cơ (thủy kích) – trừ khi xe bị tai nạn rơi xuống nước.\nĐiểm loại trừ về vận hành:\n• Xe đi vào đường cấm, đường ngược chiều, vượt đèn đỏ.\n• Xe chở quá tải trọng hoặc quá số người quy định từ 50% trở lên.\n• Xe chạy quá tốc độ quy định trên 35 km/h.",
                'sort_order' => 2,
            ],
            [
                'type' => 'insurance_rules',
                'section_title' => 'Giảm trừ bồi thường',
                'content' => "Trong một số trường hợp dưới đây, PVI vẫn bồi thường nhưng sẽ giảm trừ từ 10% đến 100%, tùy mức độ vi phạm:\n• Không báo sự cố kịp thời, chậm làm hồ sơ.\n• Tự ý sửa xe hoặc thay đổi hiện trường trước khi giám định.\n• Chạy quá tốc độ, chở quá tải.\n• Không hợp tác, khai báo không trung thực.",
                'sort_order' => 3,
            ],

            // ===== Hướng dẫn đến nhận xe =====
            [
                'type' => 'pickup',
                'section_title' => 'Giấy tờ phải có',
                'content' => "• CCCD bản gốc còn hiệu lực.\n• Tài khoản VNeID mức 2 để đối chiếu thông tin.\n• Giấy phép lái xe còn hiệu lực, còn điểm theo quy định, chấp nhận bản cứng hoặc bản điện tử.",
                'sort_order' => 1,
            ],
            [
                'type' => 'pickup',
                'section_title' => 'Hình thức đặt cọc',
                'content' => "• Đặt cọc bằng tiền mặt hoặc chuyển khoản.\n• Số tiền đặt cọc tùy loại xe (thông báo trước khi nhận xe).",
                'sort_order' => 2,
            ],
            [
                'type' => 'pickup',
                'section_title' => 'Hoàn trả tiền cọc hoặc tài sản cọc',
                'content' => "• Kiểm tra xe tại chỗ khi trả.\n• Hoàn cọc ngay khi xe đạt điều kiện.",
                'sort_order' => 3,
            ],
            [
                'type' => 'pickup',
                'section_title' => 'Các trường hợp phát sinh',
                'content' => "• Xe có hư hỏng mới phát sinh sẽ được báo giá sửa chữa trước.\n• Phí phát sinh (vệ sinh, nhiên liệu, giờ phụ trội) sẽ được thông báo rõ ràng.",
                'sort_order' => 4,
            ],
        ]);
    }
}
