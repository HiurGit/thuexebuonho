<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    private const DEFAULT_TELEGRAM_QUICK_TEMPLATE = "DON DAT XE NHANH\n"
        . "Ma don: {ma_don}\n"
        . "Nguon: {nguon_form}\n"
        . "So dien thoai: {so_dien_thoai}\n"
        . "Loai thue: {loai_thue}\n"
        . "Ngay thue: {ngay_thue}\n"
        . "Khung gio: {khung_gio}";

    private const DEFAULT_TELEGRAM_CAR_DETAIL_TEMPLATE = "DON DAT XE CHI TIET\n"
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

    public function index()
    {
        return view('admin.dashboard');
    }

    public function cars()
    {
        return view('admin.cars');
    }

    public function bookings()
    {
        return view('admin.bookings');
    }

    public function guides()
    {
        return view('admin.guides');
    }

    public function settings()
    {
        $telegramSettings = [
            'enabled' => Setting::get('telegram_bot_enabled', '0') === '1',
            'bot_token' => Setting::get('telegram_bot_token', ''),
            'chat_id' => Setting::get('telegram_chat_id', ''),
            'quick_message_template' => Setting::get('telegram_quick_message_template', self::DEFAULT_TELEGRAM_QUICK_TEMPLATE),
            'car_detail_message_template' => Setting::get('telegram_car_detail_message_template', self::DEFAULT_TELEGRAM_CAR_DETAIL_TEMPLATE),
        ];

        return view('admin.settings', compact('telegramSettings'));
    }

    public function updateSettings(Request $request)
    {
        $validated = $request->validate([
            'telegram_bot_enabled' => 'nullable|boolean',
            'telegram_bot_token' => 'nullable|string|max:255',
            'telegram_chat_id' => 'nullable|string|max:255',
            'telegram_quick_message_template' => 'nullable|string',
            'telegram_car_detail_message_template' => 'nullable|string',
        ], [
            'telegram_bot_token.max' => 'Bot token khong duoc vuot qua 255 ky tu.',
            'telegram_chat_id.max' => 'Chat ID khong duoc vuot qua 255 ky tu.',
        ]);

        $isEnabled = $request->boolean('telegram_bot_enabled');
        $botToken = trim((string) ($validated['telegram_bot_token'] ?? ''));
        $chatId = trim((string) ($validated['telegram_chat_id'] ?? ''));
        $quickMessageTemplate = trim((string) ($validated['telegram_quick_message_template'] ?? ''));
        $carDetailMessageTemplate = trim((string) ($validated['telegram_car_detail_message_template'] ?? ''));

        if ($isEnabled && ($botToken === '' || $chatId === '')) {
            return back()
                ->withErrors([
                    'telegram_bot_token' => 'Khi bat Telegram bot, ban can nhap day du bot token va chat ID.',
                ])
                ->withInput();
        }

        if ($quickMessageTemplate === '') {
            $quickMessageTemplate = self::DEFAULT_TELEGRAM_QUICK_TEMPLATE;
        }

        if ($carDetailMessageTemplate === '') {
            $carDetailMessageTemplate = self::DEFAULT_TELEGRAM_CAR_DETAIL_TEMPLATE;
        }

        Setting::set('telegram_bot_enabled', $isEnabled ? '1' : '0');
        Setting::set('telegram_bot_token', $botToken);
        Setting::set('telegram_chat_id', $chatId);
        Setting::set('telegram_quick_message_template', $quickMessageTemplate);
        Setting::set('telegram_car_detail_message_template', $carDetailMessageTemplate);

        return back()->with('success', 'Da cap nhat cau hinh Telegram bot.');
    }

    public function users()
    {
        return view('admin.users');
    }
}
