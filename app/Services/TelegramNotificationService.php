<?php

namespace App\Services;

use App\Models\Booking;
use App\Models\Setting;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TelegramNotificationService
{
    private const DEFAULT_QUICK_TEMPLATE = "ĐƠN ĐẶT XE NHANH\n"
        . "Mã đơn: {ma_don}\n"
        . "Nguồn: {nguon_form}\n"
        . "Số điện thoại: {so_dien_thoai}\n"
        . "Loại thuê: {loai_thue}\n"
        . "Ngày thuê: {ngay_thue}\n"
        . "Khung giờ: {khung_gio}";

    private const DEFAULT_CAR_DETAIL_TEMPLATE = "ĐƠN ĐẶT XE CHI TIẾT\n"
        . "Mã đơn: {ma_don}\n"
        . "Nguồn: {nguon_form}\n"
        . "Xe: {ten_xe}\n"
        . "Khách: {ten_khach}\n"
        . "Số điện thoại: {so_dien_thoai}\n"
        . "Loại thuê: {loai_thue}\n"
        . "Ngày thuê: {ngay_thue}\n"
        . "Khung giờ: {khung_gio}\n"
        . "Kế hoạch: {ke_hoach_chuyen_di}\n"
        . "Nhận xe: {hinh_thuc_nhan_xe}\n"
        . "Số ngày: {so_ngay}\n"
        . "Tổng tiền: {tong_tien}\n"
        . "Ghi chú: {ghi_chu}";

    public function sendNewBookingNotification(Booking $booking, string $formSource = 'quick-booking'): void
    {
        if (! $this->isEnabled()) {
            return;
        }

        $botToken = (string) Setting::get('telegram_bot_token', '');
        $chatId = (string) Setting::get('telegram_chat_id', '');

        if ($botToken === '' || $chatId === '') {
            return;
        }

        try {
            Http::asForm()
                ->timeout(10)
                ->post("https://api.telegram.org/bot{$botToken}/sendMessage", [
                    'chat_id' => $chatId,
                    'text' => $this->buildBookingMessage($booking, $formSource),
                    'parse_mode' => 'HTML',
                ])
                ->throw();
        } catch (\Throwable $e) {
            Log::warning('Telegram booking notification failed.', [
                'booking_id' => $booking->id,
                'message' => $e->getMessage(),
            ]);
        }
    }

    private function isEnabled(): bool
    {
        return Setting::get('telegram_bot_enabled', '0') === '1';
    }

    private function buildBookingMessage(Booking $booking, string $formSource): string
    {
        $template = trim((string) Setting::get(
            $formSource === 'car-detail' ? 'telegram_car_detail_message_template' : 'telegram_quick_message_template',
            $formSource === 'car-detail' ? self::DEFAULT_CAR_DETAIL_TEMPLATE : self::DEFAULT_QUICK_TEMPLATE
        ));

        if ($template === '') {
            $template = $formSource === 'car-detail' ? self::DEFAULT_CAR_DETAIL_TEMPLATE : self::DEFAULT_QUICK_TEMPLATE;
        }

        if ($formSource === 'car-detail') {
            $template = $this->ensureTripPlanField($template);
            $template = $this->ensureCarDetailTemplateFields($template);
        }

        return $this->formatTemplate($template, $this->buildBookingPlaceholders($booking, $formSource));
    }

    private function buildBookingPlaceholders(Booking $booking, string $formSource): array
    {
        $carName = $booking->car?->name
            ?? $this->extractCarNameFromNotes($booking->notes)
            ?? 'Khách chưa chọn xe';

        $rentalTypeLabel = match ($booking->rental_type) {
            'multi-day' => 'Thuê nhiều ngày',
            'hourly' => 'Thuê theo ca',
            default => 'Thuê 1 ngày',
        };

        $dateLabel = $booking->start_date
            ? $booking->start_date->format('d/m/Y')
            : 'Chưa rõ';

        if ($booking->rental_type === 'multi-day' && $booking->end_date) {
            $dateLabel .= ' - ' . $booking->end_date->format('d/m/Y');
        }

        $timeLabel = $booking->booking_time_label ?? '06:00 - 22:00';
        $pickupLabel = $booking->pickup_type === 'delivery' ? 'Giao xe tận nơi' : 'Nhận xe tại cửa hàng';
        $tripPlanLabel = $booking->trip_plan === 'out-province' ? 'Di chuyển ngoài tỉnh' : 'Di chuyển trong tỉnh';

        return [
            '{ma_don}' => e('#' . $booking->id),
            '{nguon_form}' => e($formSource === 'car-detail' ? 'Chi tiết xe' : 'Thuê xe nhanh'),
            '{ten_khach}' => e($booking->customer_name ?: 'Khách lẻ'),
            '{so_dien_thoai}' => e($booking->customer_phone ?: 'Không có'),
            '{ten_xe}' => e($carName),
            '{loai_thue}' => e($rentalTypeLabel),
            '{ngay_thue}' => e($dateLabel),
            '{khung_gio}' => e($timeLabel),
            '{ke_hoach_chuyen_di}' => e($tripPlanLabel),
            '{hinh_thuc_nhan_xe}' => e($pickupLabel),
            '{so_ngay}' => e((string) max(1, (int) $booking->days)),
            '{tong_tien}' => e(number_format((int) $booking->total_price) . 'đ'),
            '{ghi_chu}' => e($booking->notes ?: 'Không có'),
        ];
    }

    private function formatTemplate(string $template, array $placeholders): string
    {
        $pattern = '/(\{[a-z_]+\})/';
        $parts = preg_split($pattern, $template, -1, PREG_SPLIT_DELIM_CAPTURE);

        return collect($parts)->map(function ($part) use ($placeholders) {
            if ($part === '') {
                return '';
            }

            if (array_key_exists($part, $placeholders)) {
                return $placeholders[$part];
            }

            return '<b><i>' . e($part) . '</i></b>';
        })->implode('');
    }

    private function extractCarNameFromNotes(?string $notes): ?string
    {
        if (! $notes) {
            return null;
        }

        $prefix = 'Xe khách chọn: ';

        if (str_starts_with($notes, $prefix)) {
            return trim(substr($notes, strlen($prefix)));
        }

        return null;
    }

    private function ensureCarDetailTemplateFields(string $template): string
    {
        if (! str_contains($template, '{hinh_thuc_nhan_xe}')) {
            $template .= "\nNhận xe: {hinh_thuc_nhan_xe}";
        }

        return $template;
    }

    private function ensureTripPlanField(string $template): string
    {
        if (! str_contains($template, '{ke_hoach_chuyen_di}')) {
            if (str_contains($template, '{hinh_thuc_nhan_xe}')) {
                $template = str_replace(
                    "Nhận xe: {hinh_thuc_nhan_xe}",
                    "Kế hoạch: {ke_hoach_chuyen_di}\nNhận xe: {hinh_thuc_nhan_xe}",
                    $template
                );
            } elseif (str_contains($template, '{khung_gio}')) {
                $template = str_replace(
                    "Khung giờ: {khung_gio}",
                    "Khung giờ: {khung_gio}\nKế hoạch: {ke_hoach_chuyen_di}",
                    $template
                );
            } else {
                $template .= "\nKế hoạch: {ke_hoach_chuyen_di}";
            }
        }

        return $template;
    }
}
