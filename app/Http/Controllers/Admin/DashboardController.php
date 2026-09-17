<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Models\Visitor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Schema;

class DashboardController extends Controller
{
    private const DEFAULT_TELEGRAM_QUICK_TEMPLATE = "ĐƠN ĐẶT XE NHANH\n"
        . "Mã đơn: {ma_don}\n"
        . "Nguồn: {nguon_form}\n"
        . "Số điện thoại: {so_dien_thoai}\n"
        . "Loại thuê: {loai_thue}\n"
        . "Ngày thuê: {ngay_thue}\n"
        . "Khung giờ: {khung_gio}";

    private const DEFAULT_TELEGRAM_CAR_DETAIL_TEMPLATE = "ĐƠN ĐẶT XE CHI TIẾT\n"
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
            'site_owner_name' => Setting::get('site_owner_name', 'Thuê Xe Tự Lái Buôn Hồ'),
            'site_owner_avatar' => Setting::get('site_owner_avatar', ''),
            'site_facebook' => Setting::get('site_facebook', 'https://www.facebook.com/9999NDT/'),
            'site_keywords' => Setting::get('site_keywords', ''),
            'site_title' => Setting::get('site_title', 'Thuê Xe Buôn Hồ - Đưa Đón Khách'),
            'site_description' => Setting::get('site_description', 'Dịch vụ cho thuê xe tự lái, có tài xế tại Buôn Hồ, Đăk Lăk. Giá rẻ, uy tín, thủ tục nhanh gọn.'),
            'home_meta_description' => Setting::get('home_meta_description', 'Dịch vụ cho thuê xe tự lái, có tài xế tại Buôn Hồ, Đăk Lăk. Giá rẻ, uy tín, thủ tục nhanh gọn.'),
            'home_title' => Setting::get('home_title', 'Thuê Xe Buôn Hồ - Cho thuê xe tự lái'),
            'home_og_title' => Setting::get('home_og_title', 'Thuê Xe Buôn Hồ - Cho thuê xe tự lái'),
            'home_og_description' => Setting::get('home_og_description', 'Dịch vụ cho thuê xe tự lái, có tài xế tại Buôn Hồ, Đăk Lăk. Giá rẻ, uy tín, thủ tục nhanh gọn.'),
            'home_og_image' => Setting::get('home_og_image', ''),
            'marquee_enabled' => Setting::get('marquee_enabled', '1'),
            'marquee_text' => Setting::get('marquee_text', 'QUÝ KHÁCH THUÊ XE CÀNG LÂU - GIÁ CÀNG TỐT!'),
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
            'site_owner_name' => 'nullable|string|max:255',
            'site_owner_avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'site_facebook' => 'nullable|url|max:500',
            'site_keywords' => 'nullable|string|max:1000',
            'site_title' => 'nullable|string|max:200',
            'site_description' => 'nullable|string|max:500',
            'home_meta_description' => 'nullable|string|max:500',
            'home_title' => 'nullable|string|max:200',
            'home_og_title' => 'nullable|string|max:200',
            'home_og_description' => 'nullable|string|max:500',
            'home_og_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'marquee_enabled' => 'nullable|boolean',
            'marquee_text' => 'nullable|string|max:500',
        ], [
            'site_phone.max' => 'Số điện thoại không được vượt quá 30 ký tự.',
            'site_address.max' => 'Địa chỉ không được vượt quá 255 ký tự.',
            'site_url.url' => 'Link định vị phải là URL hợp lệ.',
            'site_url.max' => 'Link định vị không được vượt quá 1000 ký tự.',
            'google_tag_id.max' => 'Mã Google tag không được vượt quá 50 ký tự.',
            'google_tag_id.regex' => 'Mã Google tag phải có dạng G-XXXXXXX hoặc AW-XXXXXXX.',
            'site_owner_name.max' => 'Tên chủ cửa hàng không được vượt quá 255 ký tự.',
            'site_owner_avatar.image' => 'Avatar phải là file ảnh.',
            'site_owner_avatar.max' => 'Dung lượng avatar không được vượt quá 2MB.',
            'site_facebook.url' => 'Link Facebook phải là URL hợp lệ.',
            'site_facebook.max' => 'Link Facebook không được vượt quá 500 ký tự.',
            'site_description.max' => 'Meta description không được vượt quá 500 ký tự.',
            'site_title.max' => 'Title website không được vượt quá 200 ký tự.',
            'home_title.max' => 'Title trang chủ không được vượt quá 200 ký tự.',
            'home_meta_description.max' => 'Meta description trang chủ không được vượt quá 500 ký tự.',
            'home_og_title.max' => 'OG Title không được vượt quá 200 ký tự.',
            'home_og_description.max' => 'OG Description không được vượt quá 500 ký tự.',
            'home_og_image.image' => 'OG Image phải là file ảnh.',
            'home_og_image.max' => 'Dung lượng OG Image không được vượt quá 2MB.',
            'marquee_text.max' => 'Nội dung thông báo không được vượt quá 500 ký tự.',
        ]);

        Setting::set('site_phone', trim((string) ($validated['site_phone'] ?? '')));
        Setting::set('site_address', trim((string) ($validated['site_address'] ?? '')));
        Setting::set('site_map_url', trim((string) ($validated['site_map_url'] ?? '')));
        Setting::set('google_tag_id', strtoupper(trim((string) ($validated['google_tag_id'] ?? ''))));
        Setting::set('site_owner_name', trim((string) ($validated['site_owner_name'] ?? '')));
        Setting::set('site_facebook', trim((string) ($validated['site_facebook'] ?? '')));
        Setting::set('site_keywords', trim((string) ($validated['site_keywords'] ?? '')));
        Setting::set('site_title', trim((string) ($validated['site_title'] ?? '')));
        Setting::set('site_description', trim((string) ($validated['site_description'] ?? '')));
        Setting::set('home_meta_description', trim((string) ($validated['home_meta_description'] ?? '')));
        Setting::set('home_title', trim((string) ($validated['home_title'] ?? '')));
        Setting::set('home_og_title', trim((string) ($validated['home_og_title'] ?? '')));
        Setting::set('home_og_description', trim((string) ($validated['home_og_description'] ?? '')));
        Setting::set('marquee_enabled', $request->boolean('marquee_enabled') ? '1' : '0');
        Setting::set('marquee_text', trim((string) ($validated['marquee_text'] ?? '')));

        if ($request->hasFile('home_og_image')) {
            $oldOgImage = Setting::get('home_og_image', '');
            if ($oldOgImage && Storage::disk('public')->exists(str_replace('storage/', '', $oldOgImage))) {
                Storage::disk('public')->delete(str_replace('storage/', '', $oldOgImage));
            }
            $path = $request->file('home_og_image')->store('seo', 'public');
            Setting::set('home_og_image', 'storage/' . $path);
        }

        if ($request->hasFile('site_owner_avatar')) {
            $oldAvatar = Setting::get('site_owner_avatar', '');
            if ($oldAvatar && Storage::disk('public')->exists(str_replace('storage/', '', $oldAvatar))) {
                Storage::disk('public')->delete(str_replace('storage/', '', $oldAvatar));
            }
            $path = $request->file('site_owner_avatar')->store('owner', 'public');
            Setting::set('site_owner_avatar', 'storage/' . $path);
        }

        return back()->with('success', 'Đã cập nhật thông tin web.');
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
            'telegram_bot_token.max' => 'Bot token không được vượt quá 255 ký tự.',
            'telegram_chat_id.max' => 'Chat ID không được vượt quá 255 ký tự.',
        ]);

        $isEnabled = $request->boolean('telegram_bot_enabled');
        $botToken = trim((string) ($validated['telegram_bot_token'] ?? ''));
        $chatId = trim((string) ($validated['telegram_chat_id'] ?? ''));
        $quickMessageTemplate = trim((string) ($validated['telegram_quick_message_template'] ?? ''));
        $carDetailMessageTemplate = trim((string) ($validated['telegram_car_detail_message_template'] ?? ''));

        if ($isEnabled && ($botToken === '' || $chatId === '')) {
            return back()
                ->withErrors([
                    'telegram_bot_token' => 'Khi bật Telegram bot, bạn cần nhập đầy đủ bot token và chat ID.',
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

        return back()->with('success', 'Đã cập nhật cấu hình Telegram.');
    }

    public function users()
    {
        return view('admin.users');
    }
}
