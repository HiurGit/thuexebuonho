<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Models\Visitor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

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
        $visitorSummary = [
            'today_views' => 0,
            'today_unique_visitors' => 0,
        ];

        if (Schema::hasTable('visitors')) {
            $today = now()->startOfDay();
            $visitorSummary = [
                'today_views' => Visitor::where('last_visited_at', '>=', $today)->count(),
                'today_unique_visitors' => Visitor::where('first_visited_at', '>=', $today)->count(),
            ];
        }

        return view('admin.dashboard', compact('visitorSummary'));
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
        $settings = [
            'enabled' => Setting::get('telegram_bot_enabled', '0') === '1',
            'bot_token' => Setting::get('telegram_bot_token', ''),
            'chat_id' => Setting::get('telegram_chat_id', ''),
            'quick_message_template' => Setting::get('telegram_quick_message_template', self::DEFAULT_TELEGRAM_QUICK_TEMPLATE),
            'car_detail_message_template' => Setting::get('telegram_car_detail_message_template', self::DEFAULT_TELEGRAM_CAR_DETAIL_TEMPLATE),
        ];

        return view('admin.settings', compact('settings'));
    }

    public function webInfo()
    {
        $settings = [
            'site_phone' => Setting::get('site_phone', '0964918047'),
            'site_address' => Setting::get('site_address', '07 Chu Van An, Buon Ho, Dak Lak'),
            'site_map_url' => Setting::get('site_map_url', 'https://maps.app.goo.gl/Qr6kWexgKnYdRdpq7'),
            'google_tag_id' => Setting::get('google_tag_id', ''),
        ];

        return view('admin.web-info', compact('settings'));
    }

    public function updateWebInfo(Request $request)
    {
        $validated = $request->validate([
            'site_phone' => 'nullable|string|max:30',
            'site_address' => 'nullable|string|max:255',
            'site_map_url' => 'nullable|url|max:1000',
            'google_tag_id' => ['nullable', 'string', 'max:50', 'regex:/^(G|AW)-[A-Z0-9]+$/i'],
        ], [
            'site_phone.max' => 'So dien thoai khong duoc vuot qua 30 ky tu.',
            'site_address.max' => 'Dia chi khong duoc vuot qua 255 ky tu.',
            'site_map_url.url' => 'Link dinh vi phai la URL hop le.',
            'site_map_url.max' => 'Link dinh vi khong duoc vuot qua 1000 ky tu.',
            'google_tag_id.max' => 'Ma Google tag khong duoc vuot qua 50 ky tu.',
            'google_tag_id.regex' => 'Ma Google tag phai co dang G-XXXXXXX hoac AW-XXXXXXX.',
        ]);

        Setting::set('site_phone', trim((string) ($validated['site_phone'] ?? '')));
        Setting::set('site_address', trim((string) ($validated['site_address'] ?? '')));
        Setting::set('site_map_url', trim((string) ($validated['site_map_url'] ?? '')));
        Setting::set('google_tag_id', strtoupper(trim((string) ($validated['google_tag_id'] ?? ''))));

        return back()->with('success', 'Da cap nhat thong tin web.');
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

        return back()->with('success', 'Da cap nhat cau hinh Telegram.');
    }

    public function users()
    {
        return view('admin.users');
    }
}
