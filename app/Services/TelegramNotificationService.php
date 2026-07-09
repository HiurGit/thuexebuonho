<?php

namespace App\Services;

use App\Models\Booking;
use App\Models\Setting;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TelegramNotificationService
{
    private const DEFAULT_QUICK_TEMPLATE = "DON DAT XE NHANH\n"
        . "Ma don: {ma_don}\n"
        . "Nguon: {nguon_form}\n"
        . "So dien thoai: {so_dien_thoai}\n"
        . "Loai thue: {loai_thue}\n"
        . "Ngay thue: {ngay_thue}\n"
        . "Khung gio: {khung_gio}";

    private const DEFAULT_CAR_DETAIL_TEMPLATE = "DON DAT XE CHI TIET\n"
        . "Ma don: {ma_don}\n"
        . "Nguon: {nguon_form}\n"
        . "Xe: {ten_xe}\n"
        . "Khach: {ten_khach}\n"
        . "So dien thoai: {so_dien_thoai}\n"
        . "Loai thue: {loai_thue}\n"
        . "Ngay thue: {ngay_thue}\n"
        . "Khung gio: {khung_gio}\n"
        . "Ke hoach: {ke_hoach_chuyen_di}\n"
        . "Nhan xe: {hinh_thuc_nhan_xe}\n"
        . "So ngay: {so_ngay}\n"
        . "Tong tien: {tong_tien}\n"
        . "Ghi chu: {ghi_chu}";

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
            ?? 'Khach chua chon xe';

        $rentalTypeLabel = match ($booking->rental_type) {
            'multi-day' => 'Thue nhieu ngay',
            'hourly' => 'Thue theo ca',
            default => 'Thue 1 ngay',
        };

        $dateLabel = $booking->start_date
            ? $booking->start_date->format('d/m/Y')
            : 'Chua ro';

        if ($booking->rental_type === 'multi-day' && $booking->end_date) {
            $dateLabel .= ' - ' . $booking->end_date->format('d/m/Y');
        }

        $timeLabel = $booking->booking_time_label ?? '06:00 - 22:00';
        $pickupLabel = $booking->pickup_type === 'delivery' ? 'Giao xe tan noi' : 'Nhan xe tai cua hang';
        $tripPlanLabel = $booking->trip_plan === 'out-province' ? 'Di chuyen ngoai tinh' : 'Di chuyen trong tinh';

        return [
            '{ma_don}' => e('#' . $booking->id),
            '{nguon_form}' => e($formSource === 'car-detail' ? 'Chi tiet xe' : 'Thue xe nhanh'),
            '{ten_khach}' => e($booking->customer_name ?: 'Khach le'),
            '{so_dien_thoai}' => e($booking->customer_phone ?: 'Khong co'),
            '{ten_xe}' => e($carName),
            '{loai_thue}' => e($rentalTypeLabel),
            '{ngay_thue}' => e($dateLabel),
            '{khung_gio}' => e($timeLabel),
            '{ke_hoach_chuyen_di}' => e($tripPlanLabel),
            '{hinh_thuc_nhan_xe}' => e($pickupLabel),
            '{so_ngay}' => e((string) max(1, (int) $booking->days)),
            '{tong_tien}' => e(number_format((int) $booking->total_price) . 'd'),
            '{ghi_chu}' => e($booking->notes ?: 'Khong co'),
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

        $prefix = 'Xe khach chon: ';

        if (str_starts_with($notes, $prefix)) {
            return trim(substr($notes, strlen($prefix)));
        }

        return null;
    }

    private function ensureCarDetailTemplateFields(string $template): string
    {
        if (! str_contains($template, '{hinh_thuc_nhan_xe}')) {
            $template .= "\nNhan xe: {hinh_thuc_nhan_xe}";
        }

        return $template;
    }

    private function ensureTripPlanField(string $template): string
    {
        if (! str_contains($template, '{ke_hoach_chuyen_di}')) {
            if (str_contains($template, '{hinh_thuc_nhan_xe}')) {
                $template = str_replace(
                    "Nhan xe: {hinh_thuc_nhan_xe}",
                    "Ke hoach: {ke_hoach_chuyen_di}\nNhan xe: {hinh_thuc_nhan_xe}",
                    $template
                );
            } elseif (str_contains($template, '{khung_gio}')) {
                $template = str_replace(
                    "Khung gio: {khung_gio}",
                    "Khung gio: {khung_gio}\nKe hoach: {ke_hoach_chuyen_di}",
                    $template
                );
            } else {
                $template .= "\nKe hoach: {ke_hoach_chuyen_di}";
            }
        }

        return $template;
    }
}
