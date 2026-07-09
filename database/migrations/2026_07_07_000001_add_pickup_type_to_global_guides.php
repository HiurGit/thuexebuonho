<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("ALTER TABLE global_guides MODIFY COLUMN type ENUM('usage', 'accident', 'insurance', 'pickup') NOT NULL");

        $now = now();

        $items = [
            [
                'type' => 'pickup',
                'section_title' => 'Giấy tờ phải có',
                'content' => <<<HTML
<p>CCCD bản gốc còn hiệu lực.</p>
<p>Tài khoản VNeID mức 2 để đối chiếu thông tin.</p>
<p>Giấy phép lái xe còn hiệu lực, còn điểm theo quy định, chấp nhận bản cứng hoặc bản điện tử.</p>
HTML,
                'sort_order' => 1,
            ],
            [
                'type' => 'pickup',
                'section_title' => 'Hình thức đặt cọc',
                'content' => <<<HTML
<p>Để bảo đảm thực hiện hợp đồng thuê xe, Quý khách vui lòng lựa chọn 1 trong 2 hình thức đặt cọc:</p>
<p>Đặt cọc bằng tiền: từ 10.000.000 đồng đến 15.000.000 đồng (tùy theo từng dòng xe).</p>
<p>Hoặc đặt cọc bằng xe máy chính chủ: xe có giá trị từ 15.000.000 đồng trở lên, kèm Giấy đăng ký xe (cà vẹt) chính chủ.</p>
<p>Khoản tiền hoặc tài sản đặt cọc chỉ nhằm mục đích bảo đảm thực hiện hợp đồng thuê xe.</p>
HTML,
                'sort_order' => 2,
            ],
            [
                'type' => 'pickup',
                'section_title' => 'Hoàn trả tiền cọc hoặc tài sản cọc',
                'content' => <<<HTML
<p>Khi Quý khách trả xe ô tô đúng thời hạn, đúng tình trạng theo hợp đồng và đã hoàn thành đầy đủ các nghĩa vụ thanh toán, bên cho thuê sẽ:</p>
<p>Hoàn trả 100% tiền đặt cọc.</p>
<p>Hoặc bàn giao lại xe máy và Giấy đăng ký xe đã nhận làm tài sản đặt cọc.</p>
HTML,
                'sort_order' => 3,
            ],
            [
                'type' => 'pickup',
                'section_title' => 'Các trường hợp phát sinh',
                'content' => <<<HTML
<p>Nếu phát sinh các chi phí như hư hỏng xe, vi phạm giao thông, trả xe quá thời hạn hoặc các khoản bồi thường khác theo hợp đồng, hai bên sẽ thực hiện theo các điều khoản đã thỏa thuận.</p>
<p>Các khoản phát sinh (nếu có) sẽ được đối trừ trước khi hoàn trả tiền cọc hoặc tài sản đặt cọc.</p>
HTML,
                'sort_order' => 4,
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
        DB::table('global_guides')->where('type', 'pickup')->delete();
        DB::statement("ALTER TABLE global_guides MODIFY COLUMN type ENUM('usage', 'accident', 'insurance') NOT NULL");
    }
};
