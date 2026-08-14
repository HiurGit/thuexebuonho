<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("ALTER TABLE global_guides MODIFY COLUMN type ENUM('usage', 'accident', 'insurance', 'pickup', 'insurance_rules') NOT NULL");

        $now = now();

        $items = [
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
        ];

        foreach ($items as $item) {
            $exists = DB::table('global_guides')
                ->where('type', $item['type'])
                ->where('section_title', $item['section_title'])
                ->exists();

            if (!$exists) {
                DB::table('global_guides')->insert([
                    ...$item,
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);
            }
        }
    }

    public function down(): void
    {
        DB::table('global_guides')->where('type', 'insurance_rules')->delete();
        DB::statement("ALTER TABLE global_guides MODIFY COLUMN type ENUM('usage', 'accident', 'insurance', 'pickup') NOT NULL");
    }
};
