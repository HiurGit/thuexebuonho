<meta charset="UTF-8">
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<meta name="theme-color" content="#5fcf86">
@php
$googleTagId = trim((string) \App\Models\Setting::get('google_tag_id', ''));
$sitePhone = trim((string) \App\Models\Setting::get('site_phone', '0964918047'));
$siteAddress = trim((string) \App\Models\Setting::get('site_address', '07 Chu Van An, Buon Ho, Dak Lak'));
$siteMapUrl = trim((string) \App\Models\Setting::get('site_map_url', 'https://maps.app.goo.gl/Qr6kWexgKnYdRdpq7'));
$canonicalUrl = url()->current();
@endphp

@hasSection('meta')
  @yield('meta')
@else
  <meta name="description" content="Dịch vụ cho thuê xe tự lái, có tài xế tại Buôn Hồ, Đăk Lăk. Giá rẻ, uy tín, thủ tục nhanh gọn.">
  <meta property="og:title" content="Thuê Xe Buôn Hồ - Đưa Đón Khách">
  <meta property="og:description" content="Dịch vụ cho thuê xe tự lái, có tài xế tại Buôn Hồ, Đăk Lăk. Giá rẻ, uy tín, thủ tục nhanh gọn.">
  <meta property="og:image" content="{{ asset('assets/image/bannerMXH.jpg') }}">
  <meta property="og:image:width" content="1200">
  <meta property="og:image:height" content="630">
  <meta property="og:url" content="{{ url()->current() }}">
  <meta property="og:type" content="website">
  <meta property="og:site_name" content="Thuê Xe Buôn Hồ">
  <meta property="og:locale" content="vi_VN">
  <meta property="og:image:type" content="image/jpeg">
  <meta property="og:image:alt" content="Thuê Xe Buôn Hồ - Dịch vụ cho thuê xe">
  <meta name="twitter:card" content="summary_large_image">
  <meta name="twitter:title" content="Thuê Xe Buôn Hồ - Đưa Đón Khách">
  <meta name="twitter:description" content="Dịch vụ cho thuê xe tự lái, có tài xế tại Buôn Hồ, Đăk Lăk. Giá rẻ, uy tín, thủ tục nhanh gọn.">
  <meta name="twitter:image" content="{{ asset('assets/image/bannerMXH.jpg') }}">
@endif

<link rel="icon" type="image/png" sizes="32x32" href="{{ asset('assets/favicon-32.png') }}">
<link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/favicon-16.png') }}">
<link rel="apple-touch-icon" href="{{ asset('assets/icon-192.png') }}">
<title>@yield('title', 'Thuê Xe Buôn Hồ - Đưa Đón Khách')</title>

<link rel="canonical" href="{{ $canonicalUrl }}">

<script type="application/ld+json">
{!! json_encode([
    '@context' => 'https://schema.org',
    '@type' => 'WebSite',
    'name' => 'Thuê Xe Buôn Hồ',
    'url' => url('/'),
    'inLanguage' => 'vi-VN',
], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}
</script>
<script type="application/ld+json">
{!! json_encode([
    '@context' => 'https://schema.org',
    '@type' => 'LocalBusiness',
    'name' => 'Thuê Xe Buôn Hồ',
    'url' => url('/'),
    'telephone' => $sitePhone,
    'address' => [
        '@type' => 'PostalAddress',
        'streetAddress' => $siteAddress,
        'addressCountry' => 'VN',
    ],
    'image' => asset('assets/image/bannerMXH.jpg'),
    'sameAs' => [
        $siteMapUrl,
        'https://www.facebook.com/9999NDT/',
    ],
], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}
</script>

@php
$breadcrumbItems = [];
$routeName = request()->route()?->getName();

if ($routeName === 'index') {
    $breadcrumbItems = [
        ['name' => 'Trang chủ', 'url' => route('index')],
    ];
} elseif ($routeName === 'services') {
    $breadcrumbItems = [
        ['name' => 'Trang chủ', 'url' => route('index')],
        ['name' => 'Dịch vụ', 'url' => route('services')],
    ];
} elseif ($routeName === 'huongdan') {
    $breadcrumbItems = [
        ['name' => 'Trang chủ', 'url' => route('index')],
        ['name' => 'Hướng dẫn', 'url' => route('huongdan')],
    ];
} elseif ($routeName === 'da-giao') {
    $breadcrumbItems = [
        ['name' => 'Trang chủ', 'url' => route('index')],
        ['name' => 'Đã giao', 'url' => route('da-giao')],
    ];
} elseif ($routeName === 'terms') {
    $breadcrumbItems = [
        ['name' => 'Trang chủ', 'url' => route('index')],
        ['name' => 'Điều khoản', 'url' => route('terms')],
    ];
} elseif ($routeName === 'privacy') {
    $breadcrumbItems = [
        ['name' => 'Trang chủ', 'url' => route('index')],
        ['name' => 'Chính sách bảo mật', 'url' => route('privacy')],
    ];
} elseif ($routeName === 'car-detail') {
    $breadcrumbItems = [
        ['name' => 'Trang chủ', 'url' => route('index')],
        ['name' => 'Danh sách xe', 'url' => route('index') . '#danh-sach-xe'],
    ];
    $carForBreadcrumb = $car ?? null;
    if ($carForBreadcrumb) {
        $breadcrumbItems[] = ['name' => $carForBreadcrumb->name, 'url' => route('car-detail', $carForBreadcrumb->slug)];
    }
}
@endphp

@if (!empty($breadcrumbItems))
@php
$breadcrumbList = [];
foreach ($breadcrumbItems as $i => $item) {
    $breadcrumbList[] = [
        '@type' => 'ListItem',
        'position' => $i + 1,
        'name' => $item['name'],
        'item' => $item['url'],
    ];
}
@endphp
<script type="application/ld+json">
{!! json_encode([
    '@context' => 'https://schema.org',
    '@type' => 'BreadcrumbList',
    'itemListElement' => $breadcrumbList,
], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}
</script>
@endif

@stack('schemas')

@if ($googleTagId !== '')
  <script async src="https://www.googletagmanager.com/gtag/js?id={{ urlencode($googleTagId) }}"></script>
  <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());
    gtag('config', @json($googleTagId));
  </script>
@endif

@vite(['resources/css/app.css', 'resources/js/app.js'])

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800;900&display=swap" rel="stylesheet">

<link href="{{ asset('assets/vendor/remixicon/remixicon.css') }}" rel="stylesheet">
<link href="{{ asset('assets/vendor/fontawesome/css/all.min.css') }}" rel="stylesheet">
<link href="{{ asset('assets/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">
<link href="{{ asset('assets/vendor/flatpickr/flatpickr.min.css') }}" rel="stylesheet">

<style>
  html, body { margin: 0; padding: 0; }
  #date-picker-holder .flatpickr-calendar, #date-picker-holder-mobile .flatpickr-calendar { width: 100%; max-width: none; border: 0; box-shadow: none; font-family: "Nunito", sans-serif; }
  #date-picker-holder .flatpickr-months, #date-picker-holder .flatpickr-weekdays, #date-picker-holder .flatpickr-days,
  #date-picker-holder-mobile .flatpickr-months, #date-picker-holder-mobile .flatpickr-weekdays, #date-picker-holder-mobile .flatpickr-days { width: 100%; }
  #date-picker-holder .dayContainer, #date-picker-holder .flatpickr-rContainer,
  #date-picker-holder-mobile .dayContainer, #date-picker-holder-mobile .flatpickr-rContainer { width: 100%; min-width: 100%; max-width: 100%; }
  #date-picker-holder .flatpickr-day, #date-picker-holder-mobile .flatpickr-day { max-width: none; height: 40px; line-height: 40px; font-weight: 700; border-radius: 10px; position: relative; }
  #date-picker-holder .flatpickr-current-month, #date-picker-holder-mobile .flatpickr-current-month { font-size: 18px; font-weight: 800; padding-top: 8px; }
  #date-picker-holder .flatpickr-weekday, #date-picker-holder-mobile .flatpickr-weekday { color: #78716c; font-weight: 700; }
  #date-picker-holder .flatpickr-day.inRange, #date-picker-holder-mobile .flatpickr-day.inRange { background: #e8f8ee; border-color: #e8f8ee; color: #166534; box-shadow: -6px 0 0 #e8f8ee, 6px 0 0 #e8f8ee; border-radius: 0; }
  #date-picker-holder .flatpickr-day.startRange, #date-picker-holder .flatpickr-day.endRange, #date-picker-holder .flatpickr-day.selected,
  #date-picker-holder-mobile .flatpickr-day.startRange, #date-picker-holder-mobile .flatpickr-day.endRange, #date-picker-holder-mobile .flatpickr-day.selected { background: #5fcf86; border-color: #5fcf86; color: #ffffff; border-radius: 12px; box-shadow: none; }
  #date-picker-holder .flatpickr-day.startRange, #date-picker-holder-mobile .flatpickr-day.startRange { box-shadow: 6px 0 0 #e8f8ee; border-top-right-radius: 0; border-bottom-right-radius: 0; }
  #date-picker-holder .flatpickr-day.endRange, #date-picker-holder-mobile .flatpickr-day.endRange { box-shadow: -6px 0 0 #e8f8ee; border-top-left-radius: 0; border-bottom-left-radius: 0; }
  #date-picker-holder .flatpickr-day.startRange.endRange, #date-picker-holder-mobile .flatpickr-day.startRange.endRange { box-shadow: none; }
  #date-picker-holder .flatpickr-day.today, #date-picker-holder-mobile .flatpickr-day.today { border-color: transparent; background: transparent; }
  #date-picker-holder .flatpickr-day.today.selected, #date-picker-holder .flatpickr-day.today.startRange, #date-picker-holder .flatpickr-day.today.endRange,
  #date-picker-holder-mobile .flatpickr-day.today.selected, #date-picker-holder-mobile .flatpickr-day.today.startRange, #date-picker-holder-mobile .flatpickr-day.today.endRange { background: #5fcf86; border-color: #5fcf86; color: #ffffff; }
  #date-picker-holder .flatpickr-day.disabled, #date-picker-holder .flatpickr-day.disabled.today,
  #date-picker-holder-mobile .flatpickr-day.disabled, #date-picker-holder-mobile .flatpickr-day.disabled.today { color: #d4d4d4 !important; background: transparent !important; border-color: transparent !important; cursor: not-allowed !important; opacity: 1 !important; }
  .nav-swiper .swiper-slide { width: auto !important; }
  .services-swiper { overflow: visible !important; }
  .services-swiper .swiper-wrapper { align-items: stretch; }
  .services-swiper .swiper-slide { height: auto; }
  .hide-scrollbar { scrollbar-width: none; -ms-overflow-style: none; }
  .hide-scrollbar::-webkit-scrollbar { display: none; }
  body { overscroll-behavior-y: contain; }
  .buoi-option.bg-\[\#5fcf86\] p { color: #ffffff !important; }
  .modal-overlay { transition: opacity 0.3s ease; }
  .modal-panel { transition: transform 0.3s ease, opacity 0.3s ease; }
  #drawer-overlay { transition: opacity 0.3s ease; }
  #drawer-panel { transition: transform 0.3s ease; }
  .proof-card { transition: transform 0.2s ease, box-shadow 0.2s ease; cursor: pointer; }
  .proof-card:hover { transform: translateY(-2px); box-shadow: 0 12px 30px rgba(18, 18, 18, 0.08); }
  .proof-card:active { transform: scale(0.97); }
  .section-title { display: flex; align-items: center; gap: 10px; }
  .section-title::before { content: ''; display: block; width: 4px; height: 18px; background: #5fcf86; border-radius: 2px; flex-shrink: 0; }
  .car-gallery-swiper { position: relative; overflow: hidden; height: auto !important; }
  .car-gallery-swiper .swiper-wrapper { display: flex; align-items: flex-start; height: auto !important; }
  .car-gallery-swiper .swiper-slide { width: 100% !important; flex-shrink: 0; height: auto !important; }
  .car-gallery-swiper img { display: block; width: 100%; }
  .car-gallery-swiper .swiper-pagination { position: absolute; bottom: 16px !important; left: 0 !important; right: 0 !important; width: 100% !important; display: flex !important; align-items: center; justify-content: center; gap: 6px; z-index: 10; }
  .car-gallery-swiper .swiper-pagination-bullet { width: 5px; height: 5px; border-radius: 50%; background: rgba(255,255,255,0.5); opacity: 1; transition: all 0.3s ease; }
  .car-gallery-swiper .swiper-pagination-bullet-active { width: 16px; height: 5px; border-radius: 2.5px; background: #fff; }
  #lightbox-swiper { width: 100%; }
  #lightbox-swiper .swiper-wrapper { align-items: center; }
  #lightbox-swiper .swiper-slide { display: flex; align-items: center; justify-content: center; min-height: 50vh; }
  #lightbox-swiper .swiper-slide img { display: block; margin: 0 auto; }
  #mobile-actions-toggle, #mobile-actions-menu button { -webkit-tap-highlight-color: transparent; }
  #mobile-actions-toggle:active, #mobile-actions-menu button:active {
    background-color: transparent !important;
    border-color: rgb(229 229 227) !important;
    color: inherit !important;
    opacity: 1 !important;
    transform: none !important;
  }
  html { scroll-behavior: smooth; }
  #htx-loading-bar { position: fixed; top: 0; left: 0; z-index: 9999; height: 3px; background: #5fcf86; width: 0; transition: width 0.3s ease; opacity: 0; }
  body.is-loading { cursor: wait; }
  body.is-loading * { pointer-events: none; }
</style>
