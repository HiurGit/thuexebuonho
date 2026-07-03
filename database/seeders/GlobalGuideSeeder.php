<?php

namespace Database\Seeders;

use App\Models\GlobalGuide;
use Illuminate\Database\Seeder;

class GlobalGuideSeeder extends Seeder
{
    public function run(): void
    {
        GlobalGuide::insert([
            // ===== Hướng dẫn sử dụng xe =====
            [
                'type' => 'usage',
                'section_title' => 'Trước khi khởi hành',
                'content' => "• Kiểm tra xung quanh xe.\n• Điều chỉnh ghế ngồi, vô lăng và gương.\n• Thắt dây an toàn.\n• Kiểm tra mức nhiên liệu.\n• Đảm bảo tất cả cửa đã đóng kín.",
                'sort_order' => 1,
            ],
            [
                'type' => 'usage',
                'section_title' => 'Khởi động xe',
                'content' => "• Đạp phanh.\n• Khởi động bằng nút bấm hoặc chìa khóa.\n• Chờ các đèn cảnh báo trên bảng đồng hồ tắt trước khi di chuyển.",
                'sort_order' => 2,
            ],
            [
                'type' => 'usage',
                'section_title' => 'Chuyển số',
                'content' => "Số tự động:\n• P: Đỗ xe\n• R: Lùi xe\n• N: Mo\n• D: Tiến\n\nChỉ chuyển số khi xe đã dừng hẳn.",
                'sort_order' => 3,
            ],
            [
                'type' => 'usage',
                'section_title' => 'Sử dụng các chức năng',
                'content' => "• Điều hòa\n• Đèn chiếu sáng\n• Gạt mưa\n• Màn hình giải trí\n• Camera lùi/cảm biến (nếu có)\n• Cruise Control (nếu có)\n• Auto Hold/Phanh tay điện tử (nếu có)",
                'sort_order' => 4,
            ],
            [
                'type' => 'usage',
                'section_title' => 'Trong quá trình sử dụng',
                'content' => "• Tuân thủ luật giao thông.\n• Không giao xe cho người không đăng ký thuê.\n• Không hút thuốc trong xe.\n• Không tự ý sửa chữa xe.\n• Không sử dụng sai loại nhiên liệu.",
                'sort_order' => 5,
            ],
            [
                'type' => 'usage',
                'section_title' => 'Khi kết thúc hành trình',
                'content' => "• Đưa cần số về P.\n• Kéo phanh tay (nếu cần).\n• Tắt động cơ.\n• Kiểm tra đồ dùng cá nhân trước khi rời xe.",
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
        ]);
    }
}
