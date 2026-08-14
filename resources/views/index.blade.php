@extends('layouts.app')

@section('title', 'Thuê Xe Buôn Hồ - Cho thuê xe tự lái')

{{--
================================================================
  TRANG CHỦ - INDEX (Desktop + Mobile)
  File: resources/views/index.blade.php
================================================================
  SECTION 1: #trang-chu       - HERO (Banner + Booking Card)
  SECTION 2: #danh-sach-xe   - Danh sách xe nổi bật
  SECTION 3: #dich-vu        - Dịch vụ nhận chạy (11 dịch vụ)
  SECTION 4: #bang-gia       - Bảng giá cho thuê xe (4 mức + ví dụ)
  SECTION 5: #huong-dan      - Hướng dẫn đặt xe (Zalo + Web)
  SECTION 6: #phat-sinh      - Phụ thu có thể phát sinh
  SECTION 7: #chung-toi      - Tại sao chọn chúng tôi? (12 ưu điểm)
================================================================
--}}

@section('meta')
@php
    $homeDesc = \App\Models\Setting::get('home_meta_description', 'Dịch vụ cho thuê xe tự lái, có tài xế tại Buôn Hồ, Đăk Lăk. Giá rẻ, uy tín, thủ tục nhanh gọn.');
    $homeOgTitle = \App\Models\Setting::get('home_og_title', 'Thuê Xe Buôn Hồ - Cho thuê xe tự lái');
    $homeOgDesc = \App\Models\Setting::get('home_og_description', $homeDesc);
    $homeOgImage = \App\Models\Setting::get('home_og_image', 'assets/image/bannerMXH.jpg');
@endphp
<meta name="description" content="{{ $homeDesc }}">
<meta property="og:title" content="{{ $homeOgTitle }}">
<meta property="og:description" content="{{ $homeOgDesc }}">
<meta property="og:image" content="{{ asset($homeOgImage) }}">
<meta name="twitter:image" content="{{ asset($homeOgImage) }}">
<meta property="og:image:width" content="1200">
<meta property="og:image:height" content="630">
<meta property="og:url" content="{{ url()->current() }}">
<meta property="og:type" content="website">
<meta property="og:site_name" content="Thuê Xe Buôn Hồ">
<meta property="og:locale" content="vi_VN">
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="{{ $homeOgTitle }}">
<meta name="twitter:description" content="{{ $homeOgDesc }}">
<meta name="twitter:image" content="{{ asset($homeOgImage) }}">
<meta property="og:image:type" content="image/jpeg">
<meta property="og:image:alt" content="{{ $homeOgTitle }}">
@endsection

@push('schemas')
<script type="application/ld+json">
{!! json_encode([
    '@context' => 'https://schema.org',
    '@type' => 'FAQPage',
    'mainEntity' => [
        [
            '@type' => 'Question',
            'name' => 'Có mấy cách để thuê xe tại Thuê Xe Buôn Hồ?',
            'acceptedAnswer' => [
                '@type' => 'Answer',
                'text' => 'Có 2 cách: (1) Nhắn tin Zalo trực tiếp, phản hồi nhanh trong 5 phút. (2) Thuê xe qua Web, thao tác ngay trên website không cần cài đặt thêm.',
            ],
        ],
        [
            '@type' => 'Question',
            'name' => 'Các bước thuê xe qua Zalo như thế nào?',
            'acceptedAnswer' => [
                '@type' => 'Answer',
                'text' => 'Bước 1: Mở Zalo và nhắn tin với Shop. Bước 2: Gửi thông tin cần thuê (loại xe, ngày giờ, khu vực và SĐT). Bước 3: Xác nhận và nhận xe - bộ phận tư vấn sẽ gọi lại xác nhận, hẹn lịch giao xe.',
            ],
        ],
        [
            '@type' => 'Question',
            'name' => 'Các bước thuê xe qua Web như thế nào?',
            'acceptedAnswer' => [
                '@type' => 'Answer',
                'text' => 'Bước 1: Chọn hình thức thuê xe (thuê 1 ngày, nhiều ngày hoặc theo buổi). Bước 2: Chọn ngày giờ và nhập số điện thoại. Bước 3: Bấm "Thuê xe nhanh" và chờ xác nhận - nhân viên sẽ gọi lại trong 5-10 phút.',
            ],
        ],
        [
            '@type' => 'Question',
            'name' => 'Xe có bảo hiểm không?',
            'acceptedAnswer' => [
                '@type' => 'Answer',
                'text' => 'Có, xe được trang bị bảo hiểm dân sự bắt buộc và bảo hiểm thân vỏ đầy đủ, an tâm tuyệt đối khi thuê xe.',
            ],
        ],
        [
            '@type' => 'Question',
            'name' => 'Có thể trả xe trễ không? Phí phạt thế nào?',
            'acceptedAnswer' => [
                '@type' => 'Answer',
                'text' => 'Nếu trả xe trễ hơn giờ đã thỏa thuận, phí phạt là 100.000đ/giờ.',
            ],
        ],
        [
            '@type' => 'Question',
            'name' => 'Cần chuẩn bị giấy tờ gì khi thuê xe?',
            'acceptedAnswer' => [
                '@type' => 'Answer',
                'text' => 'Chỉ cần CCCD (bản cứng hoặc VNeID mức 2) và Giấy phép lái xe (GPLX) còn điểm trên VNeTraffic. Nhận xe trong 5 phút.',
            ],
        ],
    ],
], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}
</script>
@endpush

@section('content-desktop')

  <!-- ============================================================
       DESKTOP - SECTION 1: HERO SECTION (Banner + Booking Card)
       ID: #trang-chu
       ============================================================ -->
  <section id="trang-chu" class="overflow-hidden bg-gradient-to-b from-white to-[#fafaf9]">
    <div class="mx-auto w-full overflow-hidden bg-[#e5e5e3] shadow-sm">
      <h1 class="sr-only">Thuê Xe Buôn Hồ - Dịch vụ cho thuê xe tự lái và có tài xế tại Buôn Hồ, Đăk Lăk</h1>
      @if($heroBanner)
      <img src="{{ asset($heroBanner->image) }}" alt="{{ $heroBanner->title }}" loading="eager" fetchpriority="high" class="h-auto w-full object-cover max-h-[660px]">
      @else
      <img src="{{ asset('assets/image/banner-main.png') }}" alt="Thuê xe tự lái cho mọi hành trình" loading="eager" fetchpriority="high" class="h-auto w-full object-cover max-h-[660px]">
      @endif
    </div>

    <div id="booking-card" class="relative -mt-64 mx-auto max-w-2xl rounded-xl border border-app-line bg-white p-1.5 shadow-lg">
      <div id="tab-container" class="grid grid-cols-3 gap-0 overflow-hidden rounded-t-[10px] bg-[#f4f4f3] text-center text-base font-extrabold">
        <button data-tab="one-day" class="banner-tab whitespace-nowrap rounded-none bg-app-accent px-1 py-2 text-white">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="mx-auto mb-0.5 h-5 w-5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
          </svg>
          Thuê 1 ngày
        </button>
        <button data-tab="multi-day" class="banner-tab whitespace-nowrap rounded-none border-x border-[#e5e5e3] bg-white px-1 py-2 text-app-muted">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="mx-auto mb-0.5 h-5 w-5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5m-9-6h.008v.008H12v-.008ZM12 15h.008v.008H12V15Zm0 2.25h.008v.008H12v-.008ZM9.75 15h.008v.008H9.75V15Zm0 2.25h.008v.008H9.75v-.008ZM7.5 15h.008v.008H7.5V15Zm0 2.25h.008v.008H7.5v-.008Zm6.75-4.5h.008v.008h-.008v-.008Zm0 2.25h.008v.008h-.008V15Zm0 2.25h.008v.008h-.008v-.008Zm2.25-4.5h.008v.008H16.5v-.008Zm0 2.25h.008v.008H16.5V15Z" />
          </svg>
          Thuê nhiều ngày
        </button>
        <button data-tab="hourly" class="banner-tab whitespace-nowrap rounded-none bg-white px-1 py-2 text-app-muted">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="mx-auto mb-0.5 h-5 w-5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
          </svg>
          Thuê theo buổi
        </button>
      </div>

      <div class="border-app-line bg-app-panel p-5 shadow-[inset_0_1px_0_rgba(255,255,255,0.7)]">
        <div class="mt-1 space-y-3">
          <div id="panel-one-day" class="booking-panel space-y-3">
            <label data-phone-field class="block w-full rounded-xl border border-[#d9e1e7] bg-white px-4 py-3 text-left">
              <p class="text-xs font-bold text-[#a1a1aa]">Số điện thoại</p>
              <div class="mt-1 flex items-center gap-1.5">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-4 w-4 shrink-0 text-app-accent">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 1.5H8.25A2.25 2.25 0 0 0 6 3.75v16.5a2.25 2.25 0 0 0 2.25 2.25h7.5A2.25 2.25 0 0 0 18 20.25V3.75a2.25 2.25 0 0 0-2.25-2.25H13.5m-3 0V3h3V1.5m-3 0h3m-3 18.75h3" />
                </svg>
                <input data-phone-input type="tel" inputmode="numeric" maxlength="10" autocomplete="tel-national" pattern="0[0-9]{9}" placeholder="Nhập số điện thoại của bạn" class="w-full border-0 bg-transparent p-0 text-sm font-semibold text-slate-700 outline-none placeholder:font-medium placeholder:text-slate-400">
              </div>
              <p data-phone-error class="mt-1 hidden text-xs font-semibold text-red-500" aria-live="polite"></p>
            </label>
            <button type="button" data-open-date="one-day" class="w-full rounded-xl border border-[#d9e1e7] bg-white px-5 py-3.5 text-left">
              <p class="text-xs font-bold text-[#a1a1aa]">Thời gian thuê</p>
              <div class="mt-1 flex items-center gap-1.5">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-4 w-4 shrink-0 text-app-accent">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5m-9-6h.008v.008H12v-.008ZM12 15h.008v.008H12V15Zm0 2.25h.008v.008H12v-.008ZM9.75 15h.008v.008H9.75V15Zm0 2.25h.008v.008H9.75v-.008ZM7.5 15h.008v.008H7.5V15Zm0 2.25h.008v.008H7.5v-.008Zm6.75-4.5h.008v.008h-.008v-.008Zm0 2.25h.008v.008h-.008V15Zm0 2.25h.008v.008h-.008v-.008Zm2.25-4.5h.008v.008H16.5v-.008Zm0 2.25h.008v.008H16.5V15Z" />
                </svg>
                <p id="one-day-date-title" data-date-text data-selected="1" class="text-sm font-semibold leading-5 text-slate-700">Từ 06:00, {{ now()->addDay()->format("d/m/Y") }}<br>Đến 22:00, {{ now()->addDay()->format("d/m/Y") }}</p>
              </div>
            </button>
            <p class="text-xs font-semibold leading-relaxed text-app-muted">Bạn cần điền SĐT và chọn ngày muốn thuê hoặc nhắn Zalo. Chúng tôi sẽ liên hệ tư vấn xe và giá cho bạn.</p>
            <button onclick="openThueXePopup(this)" class="w-full rounded-xl bg-app-accent px-5 py-3.5 text-base font-extrabold uppercase tracking-wide text-white transition-all hover:bg-app-green">
              Thuê xe nhanh
            </button>
          </div>

          <div id="panel-multi-day" class="booking-panel hidden space-y-3">
            <label data-phone-field class="block w-full rounded-xl border border-[#d9e1e7] bg-white px-4 py-3 text-left">
              <p class="text-xs font-bold text-[#a1a1aa]">Số điện thoại</p>
              <div class="mt-1 flex items-center gap-1.5">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-4 w-4 shrink-0 text-app-accent">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 1.5H8.25A2.25 2.25 0 0 0 6 3.75v16.5a2.25 2.25 0 0 0 2.25 2.25h7.5A2.25 2.25 0 0 0 18 20.25V3.75a2.25 2.25 0 0 0-2.25-2.25H13.5m-3 0V3h3V1.5m-3 0h3m-3 18.75h3" />
                </svg>
                <input data-phone-input type="tel" inputmode="numeric" maxlength="10" autocomplete="tel-national" pattern="0[0-9]{9}" placeholder="Nhập số điện thoại của bạn" class="w-full border-0 bg-transparent p-0 text-sm font-semibold text-slate-700 outline-none placeholder:font-medium placeholder:text-slate-400">
              </div>
              <p data-phone-error class="mt-1 hidden text-xs font-semibold text-red-500" aria-live="polite"></p>
            </label>
            <button type="button" data-open-date="multi-range" class="w-full rounded-xl border border-[#d9e1e7] bg-white px-5 py-3.5 text-left">
              <p class="text-xs font-bold text-[#a1a1aa]">Thời gian thuê</p>
              <div class="mt-1 flex items-center gap-1.5">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-4 w-4 shrink-0 text-app-accent">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5m-9-6h.008v.008H12v-.008ZM12 15h.008v.008H12V15Zm0 2.25h.008v.008H12v-.008ZM9.75 15h.008v.008H9.75V15Zm0 2.25h.008v.008H9.75v-.008ZM7.5 15h.008v.008H7.5V15Zm0 2.25h.008v.008H7.5v-.008Zm6.75-4.5h.008v.008h-.008v-.008Zm0 2.25h.008v.008h-.008V15Zm0 2.25h.008v.008h-.008v-.008Zm2.25-4.5h.008v.008H16.5v-.008Zm0 2.25h.008v.008H16.5V15Z" />
                </svg>
                <p id="multi-range-title" data-date-text data-selected="1" class="text-sm font-semibold leading-5 text-slate-700">Từ 06:00, {{ now()->addDay()->format("d/m/Y") }}<br>Đến 22:00, {{ now()->addDays(3)->format("d/m/Y") }}</p>
              </div>
            </button>
            <p class="text-xs font-semibold leading-relaxed text-app-muted">Bạn cần điền SĐT và chọn ngày muốn thuê hoặc nhắn Zalo. Chúng tôi sẽ liên hệ tư vấn xe và giá cho bạn.</p>
            <button onclick="openThueXePopup(this)" class="w-full rounded-xl bg-app-accent px-5 py-3.5 text-base font-extrabold uppercase tracking-wide text-white transition-all hover:bg-app-green">
              Thuê xe nhanh
            </button>
          </div>

          <div id="panel-hourly" class="booking-panel hidden space-y-3">
            <label data-phone-field class="block w-full rounded-xl border border-[#d9e1e7] bg-white px-4 py-3 text-left">
              <p class="text-xs font-bold text-[#a1a1aa]">Số điện thoại</p>
              <div class="mt-1 flex items-center gap-1.5">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-4 w-4 shrink-0 text-app-accent">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 1.5H8.25A2.25 2.25 0 0 0 6 3.75v16.5a2.25 2.25 0 0 0 2.25 2.25h7.5A2.25 2.25 0 0 0 18 20.25V3.75a2.25 2.25 0 0 0-2.25-2.25H13.5m-3 0V3h3V1.5m-3 0h3m-3 18.75h3" />
                </svg>
                <input data-phone-input type="tel" inputmode="numeric" maxlength="10" autocomplete="tel-national" pattern="0[0-9]{9}" placeholder="Nhập số điện thoại của bạn" class="w-full border-0 bg-transparent p-0 text-sm font-semibold text-slate-700 outline-none placeholder:font-medium placeholder:text-slate-400">
              </div>
              <p data-phone-error class="mt-1 hidden text-xs font-semibold text-red-500" aria-live="polite"></p>
            </label>
            <button type="button" data-open-date="hourly" class="w-full rounded-xl border border-[#d9e1e7] bg-white px-5 py-3.5 text-left">
              <p class="text-xs font-bold text-[#a1a1aa]">Thời gian thuê</p>
              <div class="mt-1 flex items-center gap-1.5">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-4 w-4 shrink-0 text-app-accent">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5m-9-6h.008v.008H12v-.008ZM12 15h.008v.008H12V15Zm0 2.25h.008v.008H12v-.008ZM9.75 15h.008v.008H9.75V15Zm0 2.25h.008v.008H9.75v-.008ZM7.5 15h.008v.008H7.5V15Zm0 2.25h.008v.008H7.5v-.008Zm6.75-4.5h.008v.008h-.008v-.008Zm0 2.25h.008v.008h-.008V15Zm0 2.25h.008v.008h-.008v-.008Zm2.25-4.5h.008v.008H16.5v-.008Zm0 2.25h.008v.008H16.5V15Z" />
                </svg>
                <p id="hourly-date-title" data-date-text data-selected="1" class="text-sm font-semibold leading-5 text-slate-700">Sáng (6h-12h), {{ now()->format("d/m/Y") }}</p>
              </div>
            </button>
            <p class="text-xs font-semibold leading-relaxed text-app-muted">Bạn cần điền SĐT và chọn ngày muốn thuê hoặc nhắn Zalo. Chúng tôi sẽ liên hệ tư vấn xe và giá cho bạn.</p>
            <button onclick="openThueXePopup(this)" class="w-full rounded-xl bg-app-accent px-5 py-3.5 text-base font-extrabold uppercase tracking-wide text-white transition-all hover:bg-app-green">
              Thuê xe nhanh
            </button>
          </div>
        </div>
      </div>
    </div>

  </section>
  <!-- END SECTION 1: HERO -->

  <!-- ============================================================
       DESKTOP - SECTION 2: DANH SÁCH XE NỔI BẬT
       ID: #danh-sach-xe
       ============================================================ -->
  <section id="danh-sach-xe" class="border-b border-app-line">
    <div class="mx-auto max-w-7xl rounded-b-2xl bg-[#f5f5f4] px-6 pb-10">
      <div class="text-center">
        <h2 class="inline-block rounded-b-xl bg-[#5fcf86] px-8 py-3 text-3xl font-extrabold text-white">Danh sách xe nổi bật</h2>
        <p class="mt-3 text-sm font-semibold text-app-muted"></p>
      </div>
      <div class="mt-6 overflow-hidden rounded-2xl">
        <div class="swiper banner-price-swiper">
          <div class="swiper-wrapper">
            @forelse($priceBanners as $pb)
            <div class="swiper-slide">
              <img src="{{ asset($pb->image) }}" alt="{{ $pb->title }}" loading="eager" fetchpriority="high" class="h-auto w-full object-cover">
            </div>
            @empty
            <div class="swiper-slide">
              <img src="{{ asset('assets/banner-price/banner-gia1.png') }}" alt="Banner giá" class="h-auto w-full object-cover">
            </div>
            @endforelse
          </div>
          <div class="swiper-pagination banner-price-pagination"></div>
        </div>
      </div>
      @if($cars->count() > 0)
      <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
        @foreach($cars as $car)
        <article onclick="location.href='{{ route('car-detail', $car->slug) }}'" class="cursor-pointer rounded-2xl border border-app-line bg-white p-4 shadow-sm transition-all hover:-translate-y-1 hover:shadow-card">
          <div class="card-car-swiper-wrap cursor-pointer" style="aspect-ratio: 280/210;">
            @if($car->images->count())
            <div class="swiper card-car-swiper">
              <div class="swiper-wrapper">
                @foreach($car->images as $img)
                <div class="swiper-slide">
                  <img src="{{ asset($img->path) }}" alt="{{ $car->name }}" class="h-full w-full object-cover">
                </div>
                @endforeach
              </div>
              <div class="swiper-pagination"></div>
            </div>
            @elseif($car->mainImage)
            <img src="{{ asset($car->mainImage->path) }}" alt="{{ $car->name }}" class="h-full w-full object-cover">
            @else
            <div class="flex h-full w-full items-center justify-center text-sm font-bold text-app-muted">{{ $car->name }}</div>
            @endif
          </div>
          <div class="mt-4">
            <div class="flex items-start justify-between">
              <h3 class="text-lg font-extrabold">{{ $car->name }}</h3>
            </div>
            <div class="mt-3 flex flex-wrap gap-3">
              <div class="flex items-center gap-1.5">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0 text-app-muted"><path d="M15.214 18.373L15.214 18.373C15.4789 18.5536 15.8056 18.4392 15.9384 18.2034L15.9385 18.2033L16.8394 16.6021L18.327 17.2521L16.3093 21.5005L7.45754 21.5005L5.65568 17.2645L7.20867 16.6026L8.05607 18.193C8.05607 18.193 8.05608 18.193 8.05608 18.193C8.1829 18.431 8.51278 18.5592 8.78602 18.373L8.50445 17.9598L8.78602 18.373C8.83279 18.3411 10.0881 17.5005 12 17.5005C13.9124 17.5005 15.1679 18.3416 15.214 18.373ZM8.93862 17.7228L8.93862 17.7228C8.93862 17.7228 8.93862 17.7228 8.93862 17.7228Z" stroke="#666666"></path><path d="M9.5 4C9.5 3.17157 10.1716 2.5 11 2.5H13C13.8284 2.5 14.5 3.17157 14.5 4V5C14.5 5.27614 14.2761 5.5 14 5.5H10C9.72386 5.5 9.5 5.27614 9.5 5V4Z" stroke="#666666"></path><path d="M7 17L7.40499 8.90013C7.45821 7.83571 8.33675 7 9.4025 7H14.5975C15.6633 7 16.5418 7.83571 16.595 8.90012L17 17" stroke="#666666"></path><path d="M11 5.51855V7.41751" stroke="#666666"></path><path d="M13 5.51855V7.41751" stroke="#666666"></path></svg>
                <span class="text-xs font-extrabold text-app-muted">{{ $car->seats }} chỗ</span>
              </div>
              <div class="flex items-center gap-1.5">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0 text-app-muted"><circle cx="18" cy="6" r="1.5" stroke="#78716c"></circle><circle cx="18" cy="18" r="1.5" stroke="#78716c"></circle><circle cx="12" cy="6" r="1.5" stroke="#78716c"></circle><circle cx="12" cy="18" r="1.5" stroke="#78716c"></circle><circle cx="6" cy="6" r="1.5" stroke="#78716c"></circle><path d="M7.57715 20V16H5.99902C5.69694 16 5.43913 16.054 5.22559 16.1621C5.01074 16.2689 4.84733 16.4206 4.73535 16.6172C4.62207 16.8125 4.56543 17.0423 4.56543 17.3066C4.56543 17.5723 4.62272 17.8008 4.7373 17.9922C4.85189 18.1823 5.0179 18.3281 5.23535 18.4297C5.4515 18.5312 5.71322 18.582 6.02051 18.582H7.07715V17.9023H6.15723C5.99577 17.9023 5.86165 17.8802 5.75488 17.8359C5.64811 17.7917 5.56868 17.7253 5.5166 17.6367C5.46322 17.5482 5.43652 17.4382 5.43652 17.3066C5.43652 17.1738 5.46322 17.0618 5.5166 16.9707C5.56868 16.8796 5.64876 16.8105 5.75684 16.7637C5.86361 16.7155 5.99837 16.6914 6.16113 16.6914H6.73145V20H7.57715ZM5.41699 18.1797L4.42285 20H5.35645L6.3291 18.1797H5.41699Z" fill="#78716c"></path><path d="M18 8V12M18 16V12M12 8V16M6 8V11.5C6 11.7761 6.22386 12 6.5 12H18" stroke="#78716c" stroke-linecap="round"></path></svg>
                <span class="text-xs font-extrabold text-app-muted">{{ $car->transmission }}</span>
              </div>
              <div class="flex items-center gap-1.5">
                <svg width="20" height="20" viewBox="0 0 512 512" fill="#78716c" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0">
                    <path d="M502.467,186.733h-34.133c-3.413,0-6.827,2.56-7.68,5.973l-23.893,70.827h-23.04l-23.04-38.4 c-1.707-2.56-4.267-4.267-7.68-4.267h-34.133v-25.6c0-5.12-3.413-8.533-8.533-8.533H280.6V152.6h25.6 c5.12,0,8.533-3.413,8.533-8.533v-51.2c0-5.12-3.413-8.533-8.533-8.533H152.6c-5.12,0-8.533,3.413-8.533,8.533v51.2 c0,5.12,3.413,8.533,8.533,8.533h25.6v34.133h-68.267c-2.56,0-4.267,0.853-5.973,2.56s-2.56,3.413-2.56,5.973v25.6H41.667 c-5.12,0-8.533,3.413-8.533,8.533v51.2H16.067V255c0-5.12-3.413-8.533-8.533-8.533S-1,249.88-1,255v68.267 c0,5.12,3.413,8.533,8.533,8.533s8.533-3.413,8.533-8.533v-25.6h17.067v68.267c0,5.12,3.413,8.533,8.533,8.533h64l31.573,47.787 c1.707,1.707,4.267,3.413,6.827,3.413H383c3.413,0,5.973-1.707,7.68-5.12l23.04-46.08h23.893l23.04,46.08 c1.707,3.413,4.267,5.12,7.68,5.12h34.133c5.12,0,8.533-3.413,8.533-8.533V195.267C511,190.147,507.587,186.733,502.467,186.733z M161.133,101.4h136.533v34.133h-25.6h-85.333h-25.6V101.4z M195.267,152.6h68.267v34.133h-68.267V152.6z M50.2,357.4V237.933 h51.2V357.4H50.2z M377.027,408.6H148.333l-29.867-45.204V229.4v-25.6h68.267h85.333H331.8v25.6c0,5.12,3.413,8.533,8.533,8.533 h37.547l22.187,36.978v87.609L377.027,408.6z M417.133,357.4v-76.8H434.2v76.8H417.133z M493.933,408.6h-20.48l-22.187-42.789 v-93.714l23.04-68.297h19.627V408.6z"/>
                  </svg>
                <span class="text-xs font-extrabold text-app-muted">{{ $car->fuel }}</span>
              </div>
            </div>
            <div class="mt-2 flex items-center gap-1.5">
              <svg class="h-5 w-5 shrink-0 text-app-muted" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z"/></svg>
              <span class="text-xs font-extrabold text-app-muted">{{ $car->address }}</span>
            </div>
            <div class="mt-3 grid grid-cols-2 gap-2">
              <div class="rounded-lg bg-stone-50 px-3 py-2 text-center">
                <p class="text-xs font-bold text-app-muted">Theo buổi</p>
                <p class="text-sm font-extrabold">{{ number_format($car->price_per_session) }}đ</p>
              </div>
              <div class="rounded-lg bg-stone-50 px-3 py-2 text-center">
                <p class="text-xs font-bold text-app-muted">1 ngày</p>
                <p class="text-sm font-extrabold">{{ number_format($car->price_per_day) }}đ</p>
              </div>
            </div>
            <button class="mt-3 w-full rounded-xl bg-app-accent px-4 py-2.5 text-sm font-extrabold text-white transition-all hover:bg-app-green">Thuê xe</button>
          </div>
        </article>
        @endforeach
      </div>
      @endif
    </div>
  </section>
  <!-- END SECTION 2: DANH SÁCH XE -->

  <!-- ============================================================
       DESKTOP - SECTION 3: DỊCH VỤ NHẬN CHẠY (11 dịch vụ)
       ID: #dich-vu
       ============================================================ -->
  <section id="dich-vu" class="border-b border-app-line bg-white py-10">
    <div class="mx-auto max-w-7xl px-6">
      <div class="overflow-hidden rounded-2xl border border-app-line bg-[#f5f5f4]">
        <img src="{{ asset('assets/image/banner-thuexe.png') }}" alt="Banner thuê xe" class="h-auto w-full object-cover">
      </div>
      <div class="mb-6 mt-6 text-center">
        <h2 class="text-2xl font-extrabold text-app-ink">Dịch vụ nhận chạy</h2>
        <p class="mt-2 text-sm font-semibold text-app-muted">Đa dạng dịch vụ đáp ứng mọi nhu cầu di chuyển của bạn</p>
      </div>
      <div class="grid gap-4 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5">
        <article class="flex flex-col items-center rounded-2xl border border-app-line bg-white p-5 text-center shadow-sm transition-all hover:-translate-y-1 hover:shadow-card">
          <div class="flex h-20 w-20 items-center justify-center">
            <img src="{{ asset('assets/icon-dichvu/dv-tulai.png') }}" alt="Thuê Xe tự lái" class="h-20 w-20 object-contain">
          </div>
          <h3 class="mt-3 text-sm font-extrabold">Thuê Xe tự lái</h3>
          <p class="mt-1 text-xs leading-4 text-app-muted">Tự do chủ động lịch trình, nhận xe nhanh trong ngày.</p>
        </article>
        <article class="flex flex-col items-center rounded-2xl border border-app-line bg-white p-5 text-center shadow-sm transition-all hover:-translate-y-1 hover:shadow-card">
          <div class="flex h-20 w-20 items-center justify-center">
            <img src="{{ asset('assets/icon-dichvu/dv-sanbay.png') }}" alt="Đưa đón sân bay" class="h-20 w-20 object-contain">
          </div>
          <h3 class="mt-3 text-sm font-extrabold">Đưa đón sân bay</h3>
          <p class="mt-1 text-xs leading-4 text-app-muted">Đón tiễn đúng giờ, phù hợp đi công tác hoặc du lịch.</p>
        </article>
        <article class="flex flex-col items-center rounded-2xl border border-app-line bg-white p-5 text-center shadow-sm transition-all hover:-translate-y-1 hover:shadow-card">
          <div class="flex h-20 w-20 items-center justify-center">
            <img src="{{ asset('assets/icon-dichvu/dv-nhau.png') }}" alt="Đưa đón đi nhậu" class="h-20 w-20 object-contain">
          </div>
          <h3 class="mt-3 text-sm font-extrabold">Đưa đón đi nhậu</h3>
          <p class="mt-1 text-xs leading-4 text-app-muted">Tận hưởng cuộc vui trọn vẹn, có tài xế đưa đón tận nơi.</p>
        </article>
        <article class="flex flex-col items-center rounded-2xl border border-app-line bg-white p-5 text-center shadow-sm transition-all hover:-translate-y-1 hover:shadow-card">
          <div class="flex h-20 w-20 items-center justify-center">
            <img src="{{ asset('assets/icon-dichvu/dv-dulich.png') }}" alt="Đưa đón du lịch" class="h-20 w-20 object-contain">
          </div>
          <h3 class="mt-3 text-sm font-extrabold">Đưa đón du lịch</h3>
          <p class="mt-1 text-xs leading-4 text-app-muted">Linh hoạt hành trình tham quan, đi tỉnh và cuối tuần.</p>
        </article>
        <article class="flex flex-col items-center rounded-2xl border border-app-line bg-white p-5 text-center shadow-sm transition-all hover:-translate-y-1 hover:shadow-card">
          <div class="flex h-20 w-20 items-center justify-center">
            <img src="{{ asset('assets/icon-dichvu/dv-ngaydem.png') }}" alt="Đưa đón ngày đêm" class="h-20 w-20 object-contain">
          </div>
          <h3 class="mt-3 text-sm font-extrabold">Đưa đón ngày đêm</h3>
          <p class="mt-1 text-xs leading-4 text-app-muted">Phục vụ linh hoạt mọi khung giờ, kể cả đêm khuya.</p>
        </article>
        <article class="flex flex-col items-center rounded-2xl border border-app-line bg-white p-5 text-center shadow-sm transition-all hover:-translate-y-1 hover:shadow-card">
          <div class="flex h-20 w-20 items-center justify-center">
            <img src="{{ asset('assets/icon-dichvu/dv-benhvien.png') }}" alt="Đưa đón bệnh viện" class="h-20 w-20 object-contain">
          </div>
          <h3 class="mt-3 text-sm font-extrabold">Đưa đón bệnh viện</h3>
          <p class="mt-1 text-xs leading-4 text-app-muted">Ưu tiên sự an tâm, hỗ trợ di chuyển nhẹ nhàng.</p>
        </article>
        <article class="flex flex-col items-center rounded-2xl border border-app-line bg-white p-5 text-center shadow-sm transition-all hover:-translate-y-1 hover:shadow-card">
          <div class="flex h-20 w-20 items-center justify-center">
            <img src="{{ asset('assets/icon-dichvu/dv-congtac.png') }}" alt="Đưa đón công tác" class="h-20 w-20 object-contain">
          </div>
          <h3 class="mt-3 text-sm font-extrabold">Đưa đón công tác</h3>
          <p class="mt-1 text-xs leading-4 text-app-muted">Chỉnh chu, đúng hẹn, phù hợp lịch làm việc doanh nghiệp.</p>
        </article>
        <article class="flex flex-col items-center rounded-2xl border border-app-line bg-white p-5 text-center shadow-sm transition-all hover:-translate-y-1 hover:shadow-card">
          <div class="flex h-20 w-20 items-center justify-center">
            <img src="{{ asset('assets/icon-dichvu/dv-dihoc.png') }}" alt="Đưa đón đi học" class="h-20 w-20 object-contain">
          </div>
          <h3 class="mt-3 text-sm font-extrabold">Đưa đón đi học</h3>
          <p class="mt-1 text-xs leading-4 text-app-muted">An toàn và ổn định cho lịch học hằng ngày của bé.</p>
        </article>
        <article class="flex flex-col items-center rounded-2xl border border-app-line bg-white p-5 text-center shadow-sm transition-all hover:-translate-y-1 hover:shadow-card">
          <div class="flex h-20 w-20 items-center justify-center">
            <img src="{{ asset('assets/icon-dichvu/dv-dilam.png') }}" alt="Đưa đón đi làm" class="h-20 w-20 object-contain">
          </div>
          <h3 class="mt-3 text-sm font-extrabold">Đưa đón đi làm</h3>
          <p class="mt-1 text-xs leading-4 text-app-muted">Đi làm đúng giờ, riêng tư và thoải mái mỗi ngày.</p>
        </article>
        <article class="flex flex-col items-center rounded-2xl border border-app-line bg-white p-5 text-center shadow-sm transition-all hover:-translate-y-1 hover:shadow-card">
          <div class="flex h-20 w-20 items-center justify-center">
            <img src="{{ asset('assets/icon-dichvu/dv-yeucau.png') }}" alt="Xe theo yêu cầu" class="h-20 w-20 object-contain">
          </div>
          <h3 class="mt-3 text-sm font-extrabold">Xe theo yêu cầu</h3>
          <p class="mt-1 text-xs leading-4 text-app-muted">Thiết kế lịch trình linh hoạt theo nhu cầu riêng của bạn.</p>
        </article>
        <article class="flex flex-col items-center rounded-2xl border border-app-line bg-white p-5 text-center shadow-sm transition-all hover:-translate-y-1 hover:shadow-card">
          <div class="flex h-20 w-20 items-center justify-center">
            <img src="{{ asset('assets/icon-dichvu/dv-24tren7.png') }}" alt="Phục vụ 24/7" class="h-20 w-20 object-contain">
          </div>
          <h3 class="mt-3 text-sm font-extrabold">Phục vụ 24/7</h3>
          <p class="mt-1 text-xs leading-4 text-app-muted">Hỗ trợ nhiệt tình mọi lúc, kể cả đêm khuya và cuối tuần.</p>
        </article>
      </div>
      <div class="mt-6 text-center">
        <a href="{{ route('services') }}" class="inline-flex items-center gap-2 rounded-xl bg-app-accent px-6 py-3 text-sm font-extrabold text-white transition-all hover:bg-app-green">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-4 w-4">
            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
          </svg>
          Xem tất cả dịch vụ
        </a>
      </div>
    </div>
  </section>
  <!-- END SECTION 3: DỊCH VỤ -->

  <!-- ============================================================
       DESKTOP - SECTION 4: BẢNG GIÁ CHO THUÊ XE (4 mức giá + ví dụ)
       ID: #bang-gia
       ============================================================ -->
  <section id="bang-gia" class="border-b border-app-line bg-white py-10">
    <div class="mx-auto max-w-7xl px-6">
      <div class="overflow-hidden rounded-2xl border border-app-line bg-[#f5f5f4] shadow-sm">
        <img src="{{ asset('assets/image/banner-banggia.png') }}" alt="Bảng giá thuê xe" class="h-auto w-full object-cover">
      </div>
      <div class="mb-8 mt-6 text-center">
        <h2 class="text-2xl font-extrabold text-app-ink">Bảng giá cho thuê xe</h2>
        <p class="mt-2 text-sm font-semibold text-app-muted">Giá minh bạch, cạnh tranh nhất thị trường</p>
      </div>
      <div class="mt-6 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
        <div class="rounded-2xl border border-app-line bg-white p-5 shadow-sm transition-all hover:-translate-y-1 hover:shadow-card">
          <div class="flex items-center gap-3">
            <img src="{{ asset('assets/icon-thuexe/thue-1gio.png') }}" alt="Thuê theo buổi" class="h-14 w-14 shrink-0 rounded-xl object-contain">
            <div>
              <p class="text-base font-extrabold">Theo buổi</p>
              <p class="text-xs text-app-muted">Sáng / Chiều / Tối</p>
            </div>
          </div>
          <p class="mt-3 text-2xl font-extrabold text-app-accent">{{ number_format($defaultCar->price_per_session) }}đ <span class="text-sm font-semibold text-app-muted">/ buổi</span></p>
        </div>
        <div class="rounded-2xl border-2 border-app-accent bg-white p-5 shadow-sm transition-all hover:-translate-y-1 hover:shadow-card">
          <div class="flex items-center gap-3">
            <img src="{{ asset('assets/icon-thuexe/thue-1ngay.png') }}" alt="Thuê 1 ngày" class="h-14 w-14 shrink-0 rounded-xl object-contain">
            <div>
              <p class="text-base font-extrabold">1 ngày</p>
              <p class="text-xs text-app-muted">Nội tỉnh Đăk Lăk</p>
            </div>
          </div>
          <p class="mt-3 text-2xl font-extrabold text-app-accent">{{ number_format($defaultCar->price_per_day) }}đ <span class="text-sm font-semibold text-app-muted">/ ngày</span></p>
          <div class="mt-2 inline-block rounded-full bg-app-accentSoft px-3 py-1 text-xs font-extrabold text-app-accent">Phổ biến nhất</div>
        </div>
        <div class="rounded-2xl border border-app-line bg-white p-5 shadow-sm transition-all hover:-translate-y-1 hover:shadow-card">
          <div class="flex items-center gap-3">
            <img src="{{ asset('assets/icon-thuexe/thue-nhieungay.png') }}" alt="Thuê nhiều ngày" class="h-14 w-14 shrink-0 rounded-xl object-contain">
            <div>
              <p class="text-base font-extrabold">3 ngày trở lên</p>
              <p class="text-xs text-app-muted">Giảm {{ number_format($defaultCar->price_per_day - $defaultCar->price_multi_day) }}đ/ngày</p>
            </div>
          </div>
          <p class="mt-3 text-2xl font-extrabold text-app-accent">{{ number_format($defaultCar->price_multi_day) }}đ <span class="text-sm font-semibold text-app-muted">/ ngày</span></p>
        </div>
        <div class="rounded-2xl border border-dashed border-app-line bg-white p-5 shadow-sm transition-all hover:-translate-y-1 hover:shadow-card">
          <div class="flex items-center gap-3">
            <img src="{{ asset('assets/icon-thuexe/thue-ngoaitinh.png') }}" alt="Phụ phí ra tỉnh" class="h-14 w-14 shrink-0 rounded-xl object-contain">
            <div>
              <p class="text-base font-extrabold">Phụ phí ra tỉnh</p>
              <p class="text-xs text-app-muted">Áp dụng khi đi liên tỉnh</p>
            </div>
          </div>
          <p class="mt-3 text-2xl font-extrabold text-app-accent">+{{ number_format($defaultCar->price_out_province) }}đ <span class="text-sm font-semibold text-app-muted">/ ngày</span></p>
        </div>
      </div>
      <div class="mt-6 rounded-2xl border border-app-line bg-white p-5 shadow-sm">
        <div class="flex items-center gap-2">
          <svg class="h-[18px] w-[18px] text-app-muted" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                  </svg>
          <p class="text-sm font-extrabold uppercase tracking-wider text-app-muted">Ví dụ cách tính giá</p>
        </div>
        <div class="mt-4 grid gap-3 sm:grid-cols-2 lg:grid-cols-4">
          <div class="rounded-xl border border-app-line bg-stone-50 px-4 py-3 text-center">
            <p class="text-xs font-semibold text-app-muted">Trong tỉnh - 1 ngày</p>
            <p class="mt-1 text-lg font-extrabold text-slate-900">{{ number_format($defaultCar->price_per_day) }}đ</p>
          </div>
          <div class="rounded-xl border border-app-line bg-stone-50 px-4 py-3 text-center">
            <p class="text-xs font-semibold text-app-muted">Đi tỉnh khác - 1 ngày</p>
            <p class="mt-1 text-lg font-extrabold text-slate-900">{{ number_format($defaultCar->price_per_day + $defaultCar->price_out_province) }}đ</p>
          </div>
          <div class="rounded-xl border border-app-line bg-stone-50 px-4 py-3 text-center">
            <p class="text-xs font-semibold text-app-muted">Trong tỉnh - 3 ngày</p>
            <p class="mt-1 text-lg font-extrabold text-slate-900">{{ number_format($defaultCar->price_multi_day) }}đ/ngày</p>
          </div>
          <div class="rounded-xl border-2 border-app-accent bg-app-accentSoft px-4 py-3 text-center">
            <p class="text-xs font-semibold text-app-accent">Đi tỉnh khác - 3 ngày</p>
            <p class="mt-1 text-lg font-extrabold text-slate-900">{{ number_format($defaultCar->price_multi_day + $defaultCar->price_out_province) }}đ/ngày</p>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- END SECTION 4: BẢNG GIÁ -->

  <!-- ============================================================
       DESKTOP - SECTION 5: HƯỚNG DẪN ĐẶT XE (Zalo + Web)
       ID: #huong-dan
       ============================================================ -->
  <section id="huong-dan" class="border-b border-app-line bg-white py-10">
    <div class="mx-auto max-w-7xl px-6">
      <div class="overflow-hidden rounded-2xl border border-app-line bg-[#f5f5f4] shadow-sm">
        <img src="{{ asset('assets/image/banner-huongdan.png') }}" alt="Hướng dẫn đặt xe" class="h-auto w-full object-cover">
      </div>
      <div class="mb-8 mt-6 text-center">
        <h2 class="text-2xl font-extrabold text-app-ink">Hướng dẫn đặt xe</h2>
        <p class="mt-2 text-sm font-semibold text-app-muted">Chỉ 3 bước đơn giản để thuê xe</p>
      </div>
      <div class="mt-6 grid gap-6 lg:grid-cols-2">
        <div class="overflow-hidden rounded-2xl border border-app-line bg-white shadow-sm">
          <div class="flex items-center gap-3 bg-[#0068ff] px-6 py-4">
            <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-white/20 text-white">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M8.625 9.75a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H8.25m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H12m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0h-.375m-13.5 3.01c0 1.6 1.123 2.994 2.707 3.227 1.087.16 2.185.283 3.293.369V21l4.184-4.183a1.14 1.14 0 0 1 .778-.332 48.294 48.294 0 0 0 5.83-.498c1.585-.233 2.708-1.626 2.708-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0 0 12 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018Z" />
              </svg>
            </div>
            <div>
              <p class="text-base font-extrabold text-white">Cách 1: Thuê xe qua Zalo</p>
              <p class="text-xs font-semibold text-white/70">Nhắn tin trực tiếp, phản hồi nhanh trong 5 phút</p>
            </div>
          </div>
          <div class="px-6 py-5">
            <div class="space-y-4">
              <div class="flex items-start gap-3">
                <div class="flex h-7 w-7 shrink-0 items-center justify-center rounded-full bg-[#e8f0fe] text-xs font-extrabold text-[#0068ff]">1</div>
                <div>
                  <p class="text-sm font-bold text-slate-800">Mở Zalo và nhắn tin với Shop</p>
                  <p class="mt-1 text-xs leading-5 text-app-muted">Click nút nhắn tin ngay để liên hệ</p>
                </div>
              </div>
              <div class="flex items-start gap-3">
                <div class="flex h-7 w-7 shrink-0 items-center justify-center rounded-full bg-[#e8f0fe] text-xs font-extrabold text-[#0068ff]">2</div>
                <div>
                  <p class="text-sm font-bold text-slate-800">Gửi thông tin cần thuê</p>
                  <p class="mt-1 text-xs leading-5 text-app-muted">Loại xe, ngày giờ, khu vực và SĐT</p>
                </div>
              </div>
              <div class="flex items-start gap-3">
                <div class="flex h-7 w-7 shrink-0 items-center justify-center rounded-full bg-[#e8f0fe] text-xs font-extrabold text-[#0068ff]">3</div>
                <div>
                  <p class="text-sm font-bold text-slate-800">Xác nhận và nhận xe</p>
                  <p class="mt-1 text-xs leading-5 text-app-muted">Bộ phận tư vấn sẽ gọi lại xác nhận, hẹn lịch giao xe</p>
                </div>
              </div>
            </div>
            <a href="{{ 'https://zalo.me/' . preg_replace('/\D+/', '', \App\Models\Setting::get('site_phone', '0964918047')) }}" target="_blank" rel="noopener" class="mt-5 flex w-full items-center justify-center gap-2 rounded-xl bg-[#0068ff] px-4 py-3 text-sm font-extrabold text-white transition-all hover:bg-[#0056d6]">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M8.625 9.75a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H8.25m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H12m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0h-.375m-13.5 3.01c0 1.6 1.123 2.994 2.707 3.227 1.087.16 2.185.283 3.293.369V21l4.184-4.183a1.14 1.14 0 0 1 .778-.332 48.294 48.294 0 0 0 5.83-.498c1.585-.233 2.708-1.626 2.708-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0 0 12 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018Z" />
              </svg>
              Nhắn tin Zalo ngay
            </a>
          </div>
        </div>

        <div class="overflow-hidden rounded-2xl border border-app-line bg-white shadow-sm">
          <div class="flex items-center gap-3 bg-app-accent px-6 py-4">
            <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-white/20 text-white">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9.004 9.004 0 0 0 8.716-6.747M12 21a9.004 9.004 0 0 1-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 0 1 7.843 4.582M12 3a8.997 8.997 0 0 0-7.843 4.582m15.686 0A11.953 11.953 0 0 1 12 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0 1 21 12c0 .778-.099 1.533-.284 2.253m0 0A17.919 17.919 0 0 1 12 16.5c-3.162 0-6.133-.815-8.716-2.247m0 0A9.015 9.015 0 0 1 3 12c0-1.605.42-3.113 1.157-4.418" />
              </svg>
            </div>
            <div>
              <p class="text-base font-extrabold text-white">Cách 2: Thuê xe qua Web</p>
              <p class="text-xs font-semibold text-white/70">Thao tác ngay trên website, không cần cài đặt thêm</p>
            </div>
          </div>
          <div class="px-6 py-5">
            <div class="space-y-4">
              <div class="flex items-start gap-3">
                <div class="flex h-7 w-7 shrink-0 items-center justify-center rounded-full bg-app-accentSoft text-xs font-extrabold text-app-accent">1</div>
                <div>
                  <p class="text-sm font-bold text-slate-800">Chọn hình thức thuê xe</p>
                  <p class="mt-1 text-xs leading-5 text-app-muted">Thuê 1 ngày, nhiều ngày hoặc theo buổi</p>
                </div>
              </div>
              <div class="flex items-start gap-3">
                <div class="flex h-7 w-7 shrink-0 items-center justify-center rounded-full bg-app-accentSoft text-xs font-extrabold text-app-accent">2</div>
                <div>
                  <p class="text-sm font-bold text-slate-800">Chọn ngày giờ và nhập SĐT</p>
                  <p class="mt-1 text-xs leading-5 text-app-muted">Điền thời gian và số điện thoại</p>
                </div>
              </div>
              <div class="flex items-start gap-3">
                <div class="flex h-7 w-7 shrink-0 items-center justify-center rounded-full bg-app-accentSoft text-xs font-extrabold text-app-accent">3</div>
                <div>
                  <p class="text-sm font-bold text-slate-800">Bấm "Thuê xe nhanh" và chờ xác nhận</p>
                  <p class="mt-1 text-xs leading-5 text-app-muted">Nhân viên sẽ gọi lại trong 5-10 phút</p>
                </div>
              </div>
            </div>
            <a href="#trang-chu" class="mt-5 flex w-full items-center justify-center gap-2 rounded-xl bg-app-accent px-4 py-3 text-sm font-extrabold text-white transition-all hover:bg-app-green">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5m-9-6h.008v.008H12v-.008ZM12 15h.008v.008H12V15Zm0 2.25h.008v.008H12v-.008ZM9.75 15h.008v.008H9.75V15Zm0 2.25h.008v.008H9.75v-.008ZM7.5 15h.008v.008H7.5V15Zm0 2.25h.008v.008H7.5v-.008Zm6.75-4.5h.008v.008h-.008v-.008Zm0 2.25h.008v.008h-.008V15Zm0 2.25h.008v.008h-.008v-.008Zm2.25-4.5h.008v.008H16.5v-.008Zm0 2.25h.008v.008H16.5V15Z" />
              </svg>
              Thuê xe ngay trên Web
            </a>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- END SECTION 5: HƯỚNG DẪN -->

  <!-- ============================================================
       DESKTOP - SECTION 6: PHỤ THU CÓ THỂ PHÁT SINH
       ID: #phat-sinh
       ============================================================ -->
  <section id="phat-sinh" class="border-b border-app-line bg-white py-10">
    <div class="mx-auto max-w-7xl px-6">
      <div class="overflow-hidden rounded-2xl border border-app-line bg-[#f5f5f4] shadow-sm">
        <img src="{{ asset('assets/image/banner-phiphuthu.png') }}" alt="Phụ thu có thể phát sinh" class="h-auto w-full object-cover">
      </div>
      <div class="mb-8 mt-6 text-center">
        <h2 class="text-2xl font-extrabold text-app-ink">Phụ thu có thể phát sinh</h2>
        <p class="mt-2 text-sm font-semibold text-app-muted">Minh bạch trong từng chi phí</p>
      </div>
      <div class="mt-6 grid gap-4 sm:grid-cols-2">
        <div class="flex items-center gap-4 rounded-2xl border border-app-line bg-white p-5 shadow-sm">
          <img src="{{ asset('assets/svg-phuthuphatsinh/phi-cauduong.png') }}" alt="Phí cầu đường" class="h-16 w-16 shrink-0 rounded-xl object-contain">
          <div>
            <p class="text-sm font-extrabold">Phí cầu đường</p>
            <p class="mt-1 text-xs leading-5 text-app-muted">Chủ xe có thể yêu cầu thanh toán các khoản lệ phí cầu đường phát sinh trên tài khoản VETC.</p>
          </div>
        </div>
        <div class="flex items-center gap-4 rounded-2xl border border-app-line bg-white p-5 shadow-sm">
          <img src="{{ asset('assets/svg-phuthuphatsinh/phi-nhienlieu.png') }}" alt="Phụ thu nhiên liệu" class="h-16 w-16 shrink-0 rounded-xl object-contain">
          <div>
            <p class="text-sm font-extrabold">Phụ thu nhiên liệu</p>
            <p class="mt-1 text-xs leading-5 text-app-muted">Chỉ thu khi vạch xăng thấp hơn lúc nhận xe. Trả đúng vạch xăng để không phải trả phí này.</p>
          </div>
        </div>
        <div class="flex items-center gap-4 rounded-2xl border border-app-line bg-white p-5 shadow-sm">
          <img src="{{ asset('assets/svg-phuthuphatsinh/phi-quagio.png') }}" alt="Phí trả trễ" class="h-16 w-16 shrink-0 rounded-xl object-contain">
          <div class="flex-1">
            <p class="text-sm font-extrabold">Phí trả trễ</p>
            <p class="mt-1 text-xs leading-5 text-app-muted">Áp dụng khi trả xe trễ hơn giờ đã thỏa thuận.</p>
          </div>
          <p class="shrink-0 text-lg font-extrabold text-app-accent">100.000đ <span class="text-sm font-semibold text-app-muted">/ giờ</span></p>
        </div>
        <div class="flex items-center gap-4 rounded-2xl border border-app-line bg-white p-5 shadow-sm">
          <img src="{{ asset('assets/svg-phuthuphatsinh/phi-vesinh.png') }}" alt="Phí nặng mùi hôi" class="h-16 w-16 shrink-0 rounded-xl object-contain">
          <div class="flex-1">
            <p class="text-sm font-extrabold">Phí nặng mùi hôi - thuốc lá</p>
            <p class="mt-1 text-xs leading-5 text-app-muted">Dựa vào tình trạng vệ sinh xe lúc trả xe để thu phí.</p>
          </div>
          <p class="shrink-0 text-lg font-extrabold text-app-accent">250.000đ</p>
        </div>
      </div>
    </div>
  </section>
  <!-- END SECTION 6: PHỤ THU -->

  <!-- ============================================================
       DESKTOP - SECTION 7: TẠI SAO CHỌN CHÚNG TÔI? (12 ưu điểm)
       ID: #chung-toi
       ============================================================ -->
  <section id="chung-toi" class="border-b border-app-line bg-white py-10">
    <div class="mx-auto max-w-7xl px-6">
      <div class="overflow-hidden rounded-2xl border border-app-line bg-[#f5f5f4]">
        <img src="{{ asset('assets/image/banner-chungtoicogi.png') }}" alt="Tại sao chọn chúng tôi" class="h-auto w-full object-cover">
      </div>
      <div class="mb-6 mt-6 text-center">
        <h2 class="text-2xl font-extrabold text-app-ink">Tại sao chọn chúng tôi?</h2>
        <p class="mt-2 text-sm font-semibold text-app-muted">Cam kết mang đến trải nghiệm tốt nhất cho bạn</p>
      </div>
      <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
        <article class="flex items-start gap-4 rounded-2xl border border-app-line bg-white p-5 shadow-sm transition-all hover:-translate-y-1 hover:shadow-card">
          <img src="{{ asset('assets/icon-chungtoi/icon-thutuc.png') }}" alt="Thủ tục đơn giản" class="h-16 w-16 shrink-0 rounded-xl object-contain">
          <div>
            <p class="text-sm font-extrabold">Thủ tục đơn giản</p>
            <p class="mt-1 text-xs leading-5 text-app-muted">Chỉ cần CCCD và GPLX. Nhận xe trong 5 phút.</p>
          </div>
        </article>
        <article class="flex items-start gap-4 rounded-2xl border border-app-line bg-white p-5 shadow-sm transition-all hover:-translate-y-1 hover:shadow-card">
          <img src="{{ asset('assets/icon-chungtoi/icon-giamenhbach.png') }}" alt="Giá minh bạch" class="h-16 w-16 shrink-0 rounded-xl object-contain">
          <div>
            <p class="text-sm font-extrabold">Giá minh bạch</p>
            <p class="mt-1 text-xs leading-5 text-app-muted">Báo giá rõ ràng, cạnh tranh nhất thị trường.</p>
          </div>
        </article>
        <article class="flex items-start gap-4 rounded-2xl border border-app-line bg-white p-5 shadow-sm transition-all hover:-translate-y-1 hover:shadow-card">
          <img src="{{ asset('assets/icon-chungtoi/icon-baohiem.png') }}" alt="Có bảo hiểm" class="h-16 w-16 shrink-0 rounded-xl object-contain">
          <div>
            <p class="text-sm font-extrabold">Bảo hiểm đầy đủ</p>
            <p class="mt-1 text-xs leading-5 text-app-muted">Bảo hiểm dân sự + thân vỏ, an tâm tuyệt đối.</p>
          </div>
        </article>
        <article class="flex items-start gap-4 rounded-2xl border border-app-line bg-white p-5 shadow-sm transition-all hover:-translate-y-1 hover:shadow-card">
          <img src="{{ asset('assets/icon-chungtoi/icon-baoduongdinhky.png') }}" alt="Bảo dưỡng định kỳ" class="h-16 w-16 shrink-0 rounded-xl object-contain">
          <div>
            <p class="text-sm font-extrabold">Bảo dưỡng định kỳ</p>
            <p class="mt-1 text-xs leading-5 text-app-muted">Xe được kiểm tra thường xuyên, vận hành an toàn.</p>
          </div>
        </article>
        <article class="flex items-start gap-4 rounded-2xl border border-app-line bg-white p-5 shadow-sm transition-all hover:-translate-y-1 hover:shadow-card">
          <img src="{{ asset('assets/icon-chungtoi/icon-vietmap.png') }}" alt="Vietmap Live Pro" class="h-16 w-16 shrink-0 rounded-xl object-contain">
          <div>
            <p class="text-sm font-extrabold">Vietmap Live Pro</p>
            <p class="mt-1 text-xs leading-5 text-app-muted">Cảnh báo tốc độ, biển báo giao thông đầy đủ.</p>
          </div>
        </article>
        <article class="flex items-start gap-4 rounded-2xl border border-app-line bg-white p-5 shadow-sm transition-all hover:-translate-y-1 hover:shadow-card">
          <img src="{{ asset('assets/icon-chungtoi/icon-camera.png') }}" alt="Camera hành trình" class="h-16 w-16 shrink-0 rounded-xl object-contain">
          <div>
            <p class="text-sm font-extrabold">Camera hành trình</p>
            <p class="mt-1 text-xs leading-5 text-app-muted">Đảm bảo an toàn và minh bạch trên mọi hành trình.</p>
          </div>
        </article>
        <article class="flex items-start gap-4 rounded-2xl border border-app-line bg-white p-5 shadow-sm transition-all hover:-translate-y-1 hover:shadow-card">
          <img src="{{ asset('assets/icon-chungtoi/icon-hotro24h.png') }}" alt="Hỗ trợ 24/7" class="h-16 w-16 shrink-0 rounded-xl object-contain">
          <div>
            <p class="text-sm font-extrabold">Hỗ trợ 24/7</p>
            <p class="mt-1 text-xs leading-5 text-app-muted">Sẵn sàng giải đáp và xử lý mọi vấn đề 24/7.</p>
          </div>
        </article>
        <article class="flex items-start gap-4 rounded-2xl border border-app-line bg-white p-5 shadow-sm transition-all hover:-translate-y-1 hover:shadow-card">
          <img src="{{ asset('assets/icon-chungtoi/icon-xemoi.png') }}" alt="Xe đời mới" class="h-16 w-16 shrink-0 rounded-xl object-contain">
          <div>
            <p class="text-sm font-extrabold">Xe đời mới, sạch sẽ</p>
            <p class="mt-1 text-xs leading-5 text-app-muted">Vệ sinh kỹ lưỡng, khử khuẩn trước khi giao xe.</p>
          </div>
        </article>
        <article class="flex items-start gap-4 rounded-2xl border border-app-line bg-white p-5 shadow-sm transition-all hover:-translate-y-1 hover:shadow-card">
          <img src="{{ asset('assets/icon-chungtoi/icon-giaoxetannoi.png') }}" alt="Giao nhận tận nơi" class="h-16 w-16 shrink-0 rounded-xl object-contain">
          <div>
            <p class="text-sm font-extrabold">Giao nhận tận nơi</p>
            <p class="mt-1 text-xs leading-5 text-app-muted">Miễn phí trong nội thành, linh hoạt theo yêu cầu.</p>
          </div>
        </article>
        <article class="flex items-start gap-4 rounded-2xl border border-app-line bg-white p-5 shadow-sm transition-all hover:-translate-y-1 hover:shadow-card">
          <img src="{{ asset('assets/icon-chungtoi/icon-giaoxenhanh.png') }}" alt="Nhận xe nhanh" class="h-16 w-16 shrink-0 rounded-xl object-contain">
          <div>
            <p class="text-sm font-extrabold">Nhận xe nhanh</p>
            <p class="mt-1 text-xs leading-5 text-app-muted">Chỉ 5-10 phút thủ tục là nhận xe ngay.</p>
          </div>
        </article>
        <article class="flex items-start gap-4 rounded-2xl border border-app-line bg-white p-5 shadow-sm transition-all hover:-translate-y-1 hover:shadow-card">
          <img src="{{ asset('assets/icon-chungtoi/icon-thanhtoan.png') }}" alt="Thanh toán linh hoạt" class="h-16 w-16 shrink-0 rounded-xl object-contain">
          <div>
            <p class="text-sm font-extrabold">Thanh toán linh hoạt</p>
            <p class="mt-1 text-xs leading-5 text-app-muted">Tiền mặt, chuyển khoản, thẻ ngân hàng.</p>
          </div>
        </article>
        <article class="flex items-start gap-4 rounded-2xl border border-app-line bg-white p-5 shadow-sm transition-all hover:-translate-y-1 hover:shadow-card">
          <img src="{{ asset('assets/icon-chungtoi/icon-phanthuong.png') }}" alt="Ưu đãi thuê dài ngày" class="h-16 w-16 shrink-0 rounded-xl object-contain">
          <div>
            <p class="text-sm font-extrabold">Ưu đãi thuê dài ngày</p>
            <p class="mt-1 text-xs leading-5 text-app-muted">Giảm giá cho khách thuê 3 ngày trở lên.</p>
          </div>
        </article>
      </div>
    </div>
  </section>
  <!-- END SECTION 7: TẠI SAO CHỌN CHÚNG TÔI -->

  <!-- ============================================================
       DESKTOP - SECTION 8: BẢN ĐỒ VỊ TRÍ CỬA HÀNG
       ID: #ban-do
       ============================================================ -->
  <section id="ban-do" class="bg-white py-10">
    <div class="mx-auto max-w-7xl px-6">
      <div class="mb-6 text-center">
        <h2 class="text-2xl font-extrabold text-app-ink">Vị trí cửa hàng</h2>
        <p class="mt-2 text-sm font-semibold text-app-muted">07 Chu Văn An, Buôn Hồ, Đắk Lắk</p>
      </div>
      <div class="overflow-hidden rounded-2xl border border-app-line shadow-sm">
        <iframe
          src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d243.05795650418517!2d108.26486600298888!3d12.91239379451464!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x316e1d45da2bce3f%3A0x392028fcc9b8fca!2zVGh1w6ogWGUgQnXDtG4gSOG7kw!5e0!3m2!1svi!2s!4v1783877732052!5m2!1svi!2s"
          width="100%" height="450" style="border:0;"
          allowfullscreen loading="lazy"
          referrerpolicy="strict-origin-when-cross-origin"
          title="Vị trí cửa hàng Thuê Xe Buôn Hồ">
        </iframe>
      </div>
    </div>
  </section>
  <!-- END SECTION 8: BẢN ĐỒ -->

  <!-- END DESKTOP CONTENT -->

  @endsection

@section('content-mobile')

  <!-- ============================================================
       MOBILE - SECTION 1: HERO SECTION (Banner + Booking Card)
       ID: #trang-chu (mobile)
       ============================================================ -->

    <main class="flex-1 overflow-y-auto" style="scroll-behavior: smooth">
      <section id="trang-chu" class="relative border-b border-app-line bg-white pb-4 pt-0 text-app-ink">
        <div class="relative">
          <div class="px-0">
            <h1 class="sr-only">Thuê Xe Buôn Hồ - Dịch vụ cho thuê xe tự lái và có tài xế tại Buôn Hồ, Đăk Lăk</h1>
            @if($heroBanner)
            <img src="{{ asset($heroBanner->image) }}" alt="{{ $heroBanner->title }}" class="h-auto w-full object-cover rounded-b-[10px]">
            @else
            <img src="{{ asset('assets/image/banner-main.png') }}" alt="Thuê xe tự lái cho mọi hành trình" class="h-auto w-full object-cover rounded-b-[10px]">
            @endif
          </div>
        </div>

        <div id="booking-card-mobile" class="relative -mt-3 mx-4 rounded-[10px] border border-app-line bg-white p-1 shadow-lg">
          <div id="tab-container-mobile" class="grid grid-cols-3 gap-0 overflow-hidden rounded-t-[10px] bg-[#f4f4f3] text-center text-[11px] font-extrabold">
            <button data-tab="one-day" class="banner-tab rounded-none bg-app-accent px-0 py-1.5 leading-tight text-white">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="mx-auto mb-0.5 h-4 w-4">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
              </svg>
              Thuê 1 ngày
            </button>
            <button data-tab="multi-day" class="banner-tab rounded-none border-x border-[#e5e5e3] bg-white px-0 py-1.5 leading-tight text-app-muted">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="mx-auto mb-0.5 h-4 w-4">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5m-9-6h.008v.008H12v-.008ZM12 15h.008v.008H12V15Zm0 2.25h.008v.008H12v-.008ZM9.75 15h.008v.008H9.75V15Zm0 2.25h.008v.008H9.75v-.008ZM7.5 15h.008v.008H7.5V15Zm0 2.25h.008v.008H7.5v-.008Zm6.75-4.5h.008v.008h-.008v-.008Zm0 2.25h.008v.008h-.008V15Zm0 2.25h.008v.008h-.008v-.008Zm2.25-4.5h.008v.008H16.5v-.008Zm0 2.25h.008v.008H16.5V15Z" />
              </svg>
              Nhiều ngày
            </button>
            <button data-tab="hourly" class="banner-tab rounded-none bg-white px-0 py-1.5 leading-tight text-app-muted">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="mx-auto mb-0.5 h-4 w-4">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
              </svg>
              Theo buổi
            </button>
          </div>

          <div class=" border-app-line bg-app-panel p-3 shadow-[inset_0_1px_0_rgba(255,255,255,0.7)]">
            <div class="mt-1">
              <div id="panel-one-day-mobile" class="booking-panel space-y-2">
                <label data-phone-field class="block w-full rounded-[10px] border border-[#d9e1e7] bg-white px-3 py-2.5 text-left">
                  <p class="text-xs font-bold text-[#a1a1aa]">Số điện thoại</p>
                  <div class="mt-1 flex items-center gap-1.5">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-4 w-4 shrink-0 text-app-accent">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 1.5H8.25A2.25 2.25 0 0 0 6 3.75v16.5a2.25 2.25 0 0 0 2.25 2.25h7.5A2.25 2.25 0 0 0 18 20.25V3.75a2.25 2.25 0 0 0-2.25-2.25H13.5m-3 0V3h3V1.5m-3 0h3m-3 18.75h3" />
                    </svg>
                    <input data-phone-input type="tel" inputmode="numeric" maxlength="10" autocomplete="tel-national" pattern="0[0-9]{9}" placeholder="Nhập số điện thoại của bạn" class="w-full border-0 bg-transparent p-0 text-[14px] font-semibold text-slate-700 outline-none placeholder:font-medium placeholder:text-slate-400">
                  </div>
                  <p data-phone-error class="mt-1 hidden text-xs font-semibold text-red-500" aria-live="polite"></p>
                </label>
                <button type="button" data-open-date="one-day" class="w-full rounded-[10px] border border-[#d9e1e7] bg-white px-3 py-2.5 text-left">
                  <p class="text-xs font-bold text-[#a1a1aa]">Thời gian thuê</p>
                  <div class="mt-1 flex items-center gap-1.5">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-4 w-4 shrink-0 text-app-accent">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5m-9-6h.008v.008H12v-.008ZM12 15h.008v.008H12V15Zm0 2.25h.008v.008H12v-.008ZM9.75 15h.008v.008H9.75V15Zm0 2.25h.008v.008H9.75v-.008ZM7.5 15h.008v.008H7.5V15Zm0 2.25h.008v.008H7.5v-.008Zm6.75-4.5h.008v.008h-.008v-.008Zm0 2.25h.008v.008h-.008V15Zm0 2.25h.008v.008h-.008v-.008Zm2.25-4.5h.008v.008H16.5v-.008Zm0 2.25h.008v.008H16.5V15Z" />
                    </svg>
                    <p id="one-day-date-title-mobile" data-date-text data-selected="1" class="text-[14px] font-semibold leading-5 text-slate-700">Từ 06:00, {{ now()->addDay()->format("d/m/Y") }}<br>Đến 22:00, {{ now()->addDay()->format("d/m/Y") }}</p>
                  </div>
                </button>
                <p class="text-[12px] font-semibold leading-relaxed text-app-muted">Bạn cần điền SĐT và chọn ngày muốn thuê hoặc nhắn Zalo. Chúng tôi sẽ liên hệ tư vấn xe và giá cho bạn.</p>
                <button onclick="openThueXePopup(this)" class="w-full rounded-[10px] bg-app-accent px-3 py-2.5 text-base font-extrabold uppercase tracking-wide text-white">
                  Thuê xe nhanh
                </button>
              </div>

              <div id="panel-multi-day-mobile" class="booking-panel hidden space-y-2">
                <label data-phone-field class="block w-full rounded-[10px] border border-[#d9e1e7] bg-white px-3 py-2.5 text-left">
                  <p class="text-xs font-bold text-[#a1a1aa]">Số điện thoại</p>
                  <div class="mt-1 flex items-center gap-1.5">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-4 w-4 shrink-0 text-app-accent">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 1.5H8.25A2.25 2.25 0 0 0 6 3.75v16.5a2.25 2.25 0 0 0 2.25 2.25h7.5A2.25 2.25 0 0 0 18 20.25V3.75a2.25 2.25 0 0 0-2.25-2.25H13.5m-3 0V3h3V1.5m-3 0h3m-3 18.75h3" />
                    </svg>
                    <input data-phone-input type="tel" inputmode="numeric" maxlength="10" autocomplete="tel-national" pattern="0[0-9]{9}" placeholder="Nhập số điện thoại của bạn" class="w-full border-0 bg-transparent p-0 text-[14px] font-semibold text-slate-700 outline-none placeholder:font-medium placeholder:text-slate-400">
                  </div>
                  <p data-phone-error class="mt-1 hidden text-xs font-semibold text-red-500" aria-live="polite"></p>
                </label>
                <button type="button" data-open-date="multi-range" class="w-full rounded-[10px] border border-[#d9e1e7] bg-white px-3 py-2.5 text-left">
                  <p class="text-xs font-bold text-[#a1a1aa]">Thời gian thuê</p>
                  <div class="mt-1 flex items-center gap-1.5">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-4 w-4 shrink-0 text-app-accent">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5m-9-6h.008v.008H12v-.008ZM12 15h.008v.008H12V15Zm0 2.25h.008v.008H12v-.008ZM9.75 15h.008v.008H9.75V15Zm0 2.25h.008v.008H9.75v-.008ZM7.5 15h.008v.008H7.5V15Zm0 2.25h.008v.008H7.5v-.008Zm6.75-4.5h.008v.008h-.008v-.008Zm0 2.25h.008v.008h-.008V15Zm0 2.25h.008v.008h-.008v-.008Zm2.25-4.5h.008v.008H16.5v-.008Zm0 2.25h.008v.008H16.5V15Z" />
                    </svg>
                    <p id="multi-range-title-mobile" data-date-text data-selected="1" class="text-[14px] font-semibold leading-5 text-slate-700">Từ 06:00, {{ now()->addDay()->format("d/m/Y") }}<br>Đến 22:00, {{ now()->addDays(3)->format("d/m/Y") }}</p>
                  </div>
                </button>
                <p class="text-[12px] font-semibold leading-relaxed text-app-muted">Bạn cần điền SĐT và chọn ngày muốn thuê hoặc nhắn Zalo. Chúng tôi sẽ liên hệ tư vấn xe và giá cho bạn.</p>
                <button onclick="openThueXePopup(this)" class="w-full rounded-[10px] bg-app-accent px-3 py-2.5 text-base font-extrabold uppercase tracking-wide text-white">
                  Thuê xe nhanh
                </button>
              </div>

              <div id="panel-hourly-mobile" class="booking-panel hidden space-y-2">
                <label data-phone-field class="block w-full rounded-[10px] border border-[#d9e1e7] bg-white px-3 py-2.5 text-left">
                  <p class="text-xs font-bold text-[#a1a1aa]">Số điện thoại</p>
                  <div class="mt-1 flex items-center gap-1.5">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-4 w-4 shrink-0 text-app-accent">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 1.5H8.25A2.25 2.25 0 0 0 6 3.75v16.5a2.25 2.25 0 0 0 2.25 2.25h7.5A2.25 2.25 0 0 0 18 20.25V3.75a2.25 2.25 0 0 0-2.25-2.25H13.5m-3 0V3h3V1.5m-3 0h3m-3 18.75h3" />
                    </svg>
                    <input data-phone-input type="tel" inputmode="numeric" maxlength="10" autocomplete="tel-national" pattern="0[0-9]{9}" placeholder="Nhập số điện thoại của bạn" class="w-full border-0 bg-transparent p-0 text-[14px] font-semibold text-slate-700 outline-none placeholder:font-medium placeholder:text-slate-400">
                  </div>
                  <p data-phone-error class="mt-1 hidden text-xs font-semibold text-red-500" aria-live="polite"></p>
                </label>
                <button type="button" data-open-date="hourly" class="w-full rounded-[10px] border border-[#d9e1e7] bg-white px-3 py-2.5 text-left">
                  <p class="text-xs font-bold text-[#a1a1aa]">Thời gian thuê</p>
                  <div class="mt-1 flex items-center gap-1.5">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-4 w-4 shrink-0 text-app-accent">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5m-9-6h.008v.008H12v-.008ZM12 15h.008v.008H12V15Zm0 2.25h.008v.008H12v-.008ZM9.75 15h.008v.008H9.75V15Zm0 2.25h.008v.008H9.75v-.008ZM7.5 15h.008v.008H7.5V15Zm0 2.25h.008v.008H7.5v-.008Zm6.75-4.5h.008v.008h-.008v-.008Zm0 2.25h.008v.008h-.008V15Zm0 2.25h.008v.008h-.008v-.008Zm2.25-4.5h.008v.008H16.5v-.008Zm0 2.25h.008v.008H16.5V15Z" />
                    </svg>
                    <p id="hourly-date-title-mobile" data-date-text data-selected="1" class="text-[14px] font-semibold leading-5 text-slate-700">Sáng (6h-12h), {{ now()->format("d/m/Y") }}</p>
                  </div>
                </button>
                <p class="text-[12px] font-semibold leading-relaxed text-app-muted">Bạn cần điền SĐT và chọn ngày muốn thuê hoặc nhắn Zalo. Chúng tôi sẽ liên hệ tư vấn xe và giá cho bạn.</p>
                <button onclick="openThueXePopup(this)" class="w-full rounded-[10px] bg-app-accent px-3 py-2.5 text-base font-extrabold uppercase tracking-wide text-white">
                  Thuê xe nhanh
                </button>
              </div>
            </div>
          </div>
        </div>
      </section>
      <!-- END MOBILE SECTION 1: HERO -->
      
      <!-- ============================================================
           MOBILE - SECTION 2: DANH SÁCH XE NỔI BẬT
           ID: #danh-sach-xe (mobile)
           ============================================================ -->
<section id="danh-sach-xe" class="border-b border-app-line bg-white px-4 py-5">
    

      <div class="mt-2 overflow-hidden rounded-[10px]">
        <div class="swiper banner-price-swiper-mobile">
          <div class="swiper-wrapper">
            @forelse($priceBanners as $pb)
            <div class="swiper-slide">
              <img src="{{ asset($pb->image) }}" alt="{{ $pb->title }}" loading="eager" fetchpriority="high" class="h-auto w-full object-cover">
            </div>
            @empty
            <div class="swiper-slide">
              <img src="{{ asset('assets/banner-price/banner-gia1.png') }}" alt="Banner giá" class="h-auto w-full object-cover">
            </div>
            @endforelse
          </div>
          <div class="swiper-pagination banner-price-pagination-mobile"></div>
        </div>
      </div>

        <div class="mt-3 space-y-3">
          @forelse($cars as $car)
           <article onclick="location.href='{{ route('car-detail', $car->slug) }}'" class="cursor-pointer rounded-[10px] border border-app-line bg-white p-3">
            <div class="card-car-swiper-wrap-mobile cursor-pointer" style="aspect-ratio: 280/210;">
              @if($car->images->count())
              <div class="swiper card-car-swiper-mobile">
                <div class="swiper-wrapper">
                  @foreach($car->images as $img)
                  <div class="swiper-slide">
                    <img src="{{ asset($img->path) }}" alt="{{ $car->name }}" class="h-full w-full object-cover">
                  </div>
                  @endforeach
                </div>
                <div class="swiper-pagination"></div>
              </div>
              @elseif($car->mainImage)
              <img src="{{ asset($car->mainImage->path) }}" alt="{{ $car->name }}" class="h-full w-full object-cover">
              @else
              <div class="flex h-full w-full items-center justify-center text-sm font-bold text-app-muted">{{ $car->name }}</div>
              @endif
            </div>
            <div class="mt-3">
              <div class="flex items-start justify-between">
                <div>
                  <h3 class="text-lg font-extrabold">{{ $car->name }}</h3>
                </div>
              </div>
              <div class="mt-3 flex items-center justify-between">
                <div class="flex items-center gap-1.5">
                  <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0 text-app-muted"><path d="M15.214 18.373L15.214 18.373C15.4789 18.5536 15.8056 18.4392 15.9384 18.2034L15.9385 18.2033L16.8394 16.6021L18.327 17.2521L16.3093 21.5005L7.45754 21.5005L5.65568 17.2645L7.20867 16.6026L8.05607 18.193C8.05607 18.193 8.05608 18.193 8.05608 18.193C8.1829 18.431 8.51278 18.5592 8.78602 18.373L8.50445 17.9598L8.78602 18.373C8.83279 18.3411 10.0881 17.5005 12 17.5005C13.9124 17.5005 15.1679 18.3416 15.214 18.373ZM8.93862 17.7228L8.93862 17.7228C8.93862 17.7228 8.93862 17.7228 8.93862 17.7228Z" stroke="#666666"></path><path d="M9.5 4C9.5 3.17157 10.1716 2.5 11 2.5H13C13.8284 2.5 14.5 3.17157 14.5 4V5C14.5 5.27614 14.2761 5.5 14 5.5H10C9.72386 5.5 9.5 5.27614 9.5 5V4Z" stroke="#666666"></path><path d="M7 17L7.40499 8.90013C7.45821 7.83571 8.33675 7 9.4025 7H14.5975C15.6633 7 16.5418 7.83571 16.595 8.90012L17 17" stroke="#666666"></path><path d="M11 5.51855V7.41751" stroke="#666666"></path><path d="M13 5.51855V7.41751" stroke="#666666"></path></svg>
                  <span class="text-[13px] font-extrabold text-app-muted">{{ $car->seats }} chỗ</span>
                </div>
                <div class="flex items-center gap-1.5">
                  <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0 text-app-muted"><circle cx="18" cy="6" r="1.5" stroke="#78716c"></circle><circle cx="18" cy="18" r="1.5" stroke="#78716c"></circle><circle cx="12" cy="6" r="1.5" stroke="#78716c"></circle><circle cx="12" cy="18" r="1.5" stroke="#78716c"></circle><circle cx="6" cy="6" r="1.5" stroke="#78716c"></circle><path d="M7.57715 20V16H5.99902C5.69694 16 5.43913 16.054 5.22559 16.1621C5.01074 16.2689 4.84733 16.4206 4.73535 16.6172C4.62207 16.8125 4.56543 17.0423 4.56543 17.3066C4.56543 17.5723 4.62272 17.8008 4.7373 17.9922C4.85189 18.1823 5.0179 18.3281 5.23535 18.4297C5.4515 18.5312 5.71322 18.582 6.02051 18.582H7.07715V17.9023H6.15723C5.99577 17.9023 5.86165 17.8802 5.75488 17.8359C5.64811 17.7917 5.56868 17.7253 5.5166 17.6367C5.46322 17.5482 5.43652 17.4382 5.43652 17.3066C5.43652 17.1738 5.46322 17.0618 5.5166 16.9707C5.56868 16.8796 5.64876 16.8105 5.75684 16.7637C5.86361 16.7155 5.99837 16.6914 6.16113 16.6914H6.73145V20H7.57715ZM5.41699 18.1797L4.42285 20H5.35645L6.3291 18.1797H5.41699Z" fill="#78716c"></path><path d="M18 8V12M18 16V12M12 8V16M6 8V11.5C6 11.7761 6.22386 12 6.5 12H18" stroke="#78716c" stroke-linecap="round"></path></svg>
                  <span class="text-[13px] font-extrabold text-app-muted">{{ $car->transmission }}</span>
                </div>
                <div class="flex items-center gap-1.5">
                  <svg width="20" height="20" viewBox="0 0 512 512" fill="#78716c" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0">
                    <path d="M502.467,186.733h-34.133c-3.413,0-6.827,2.56-7.68,5.973l-23.893,70.827h-23.04l-23.04-38.4 c-1.707-2.56-4.267-4.267-7.68-4.267h-34.133v-25.6c0-5.12-3.413-8.533-8.533-8.533H280.6V152.6h25.6 c5.12,0,8.533-3.413,8.533-8.533v-51.2c0-5.12-3.413-8.533-8.533-8.533H152.6c-5.12,0-8.533,3.413-8.533,8.533v51.2 c0,5.12,3.413,8.533,8.533,8.533h25.6v34.133h-68.267c-2.56,0-4.267,0.853-5.973,2.56s-2.56,3.413-2.56,5.973v25.6H41.667 c-5.12,0-8.533,3.413-8.533,8.533v51.2H16.067V255c0-5.12-3.413-8.533-8.533-8.533S-1,249.88-1,255v68.267 c0,5.12,3.413,8.533,8.533,8.533s8.533-3.413,8.533-8.533v-25.6h17.067v68.267c0,5.12,3.413,8.533,8.533,8.533h64l31.573,47.787 c1.707,1.707,4.267,3.413,6.827,3.413H383c3.413,0,5.973-1.707,7.68-5.12l23.04-46.08h23.893l23.04,46.08 c1.707,3.413,4.267,5.12,7.68,5.12h34.133c5.12,0,8.533-3.413,8.533-8.533V195.267C511,190.147,507.587,186.733,502.467,186.733z M161.133,101.4h136.533v34.133h-25.6h-85.333h-25.6V101.4z M195.267,152.6h68.267v34.133h-68.267V152.6z M50.2,357.4V237.933 h51.2V357.4H50.2z M377.027,408.6H148.333l-29.867-45.204V229.4v-25.6h68.267h85.333H331.8v25.6c0,5.12,3.413,8.533,8.533,8.533 h37.547l22.187,36.978v87.609L377.027,408.6z M417.133,357.4v-76.8H434.2v76.8H417.133z M493.933,408.6h-20.48l-22.187-42.789 v-93.714l23.04-68.297h19.627V408.6z"/>
                  </svg>
                  <span class="text-[13px] font-extrabold text-app-muted">{{ $car->fuel }}</span>
                </div>

              </div>
              <div class="mt-3 flex items-center gap-1.5">
                <svg class="h-5 w-5 shrink-0 text-app-muted" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z"/></svg>
                <span class="text-[13px] font-extrabold text-app-muted">{{ $car->address }}</span>
              </div>
              <div class="mt-2 grid grid-cols-2 gap-1.5">
                <div class="rounded-[6px] bg-stone-50 px-2 py-1.5 text-center">
                  <p class="text-[12px] font-bold text-app-muted">Theo buổi</p>
                  <p class="text-sm font-extrabold">{{ number_format($car->price_per_session) }}đ</p>
                </div>
                <div class="rounded-[6px] bg-stone-50 px-2 py-1.5 text-center">
                  <p class="text-[12px] font-bold text-app-muted">1 ngày</p>
                  <p class="text-sm font-extrabold">{{ number_format($car->price_per_day) }}đ</p>
                </div>
              </div>
                <button class="mt-2 w-full rounded-[10px] bg-app-accent px-4 py-2.5 text-sm font-extrabold text-white">Thuê xe</button>
            </div>
          </article>
          @empty
          <p class="text-center text-sm text-app-muted py-6">Chưa có xe nào.</p>
          @endforelse
        </div>
      </section>
      <!-- END MOBILE SECTION 2: DANH SÁCH XE -->
      
      <!-- ============================================================
           MOBILE - SECTION 3: DỊCH VỤ NHẬN CHẠY (11 dịch vụ - Swiper)
           ID: #dich-vu (mobile)
           ============================================================ -->
      <section id="dich-vu" class="border-b border-app-line bg-white px-4 py-5">
       

        <div class="overflow-hidden rounded-[12px] border border-app-line bg-[#f5f5f4]">
          <img src="{{ asset('assets/image/banner-thuexe.png') }}" alt="Banner thuê xe" class="h-auto w-full object-cover">
        </div>

        <div class="mt-3 overflow-hidden">
           <div class="swiper services-swiper">
            <div class="swiper-wrapper py-1">
              <!-- 1. Thuê Xe tự lái -->
              <div class="swiper-slide">
                <article class="group flex h-full flex-col rounded-[12px] border border-app-line bg-white p-3 shadow-sm transition-all duration-200 hover:-translate-y-0.5 hover:shadow-card">
                  <div class="mx-auto flex h-20 w-20 items-center justify-center">
                    <img src="{{ asset('assets/icon-dichvu/dv-tulai.png') }}" alt="Thuê Xe tự lái" class="h-20 w-20 object-contain">
                  </div>
                  <h3 class="mt-2 text-center text-[14px] font-extrabold leading-4">Thuê Xe tự lái</h3>
                  <p class="mt-1 text-center text-[12px] leading-4 text-app-muted">Tự do chủ động lịch trình, nhận xe nhanh trong ngày.</p>
                </article>
              </div>

              <!-- 2. Đưa đón sân bay -->
              <div class="swiper-slide">
                <article class="group flex h-full flex-col rounded-[12px] border border-app-line bg-white p-3 shadow-sm transition-all duration-200 hover:-translate-y-0.5 hover:shadow-card">
                  <div class="mx-auto flex h-20 w-20 items-center justify-center">
                    <img src="{{ asset('assets/icon-dichvu/dv-sanbay.png') }}" alt="Đưa đón sân bay" class="h-20 w-20 object-contain">
                  </div>
                  <h3 class="mt-2 text-center text-[14px] font-extrabold leading-4">Đưa đón sân bay</h3>
                  <p class="mt-1 text-center text-[12px] leading-4 text-app-muted">Đón tiễn đúng giờ, phù hợp đi công tác hoặc du lịch.</p>
                </article>
              </div>

              <!-- 3. Đưa đón đi nhậu -->
              <div class="swiper-slide">
                <article class="group flex h-full flex-col rounded-[12px] border border-app-line bg-white p-3 shadow-sm transition-all duration-200 hover:-translate-y-0.5 hover:shadow-card">
                  <div class="mx-auto flex h-20 w-20 items-center justify-center">
                    <img src="{{ asset('assets/icon-dichvu/dv-nhau.png') }}" alt="Đưa đón đi nhậu" class="h-20 w-20 object-contain">
                  </div>
                  <h3 class="mt-2 text-center text-[14px] font-extrabold leading-4">Đưa đón đi nhậu</h3>
                  <p class="mt-1 text-center text-[12px] leading-4 text-app-muted">Tận hưởng cuộc vui trọn vẹn, có tài xế đưa đón tận nơi.</p>
                </article>
              </div>

              <!-- 4. Đưa đón du lịch -->
              <div class="swiper-slide">
                <article class="group flex h-full flex-col rounded-[12px] border border-app-line bg-white p-3 shadow-sm transition-all duration-200 hover:-translate-y-0.5 hover:shadow-card">
                  <div class="mx-auto flex h-20 w-20 items-center justify-center">
                    <img src="{{ asset('assets/icon-dichvu/dv-dulich.png') }}" alt="Đưa đón du lịch" class="h-20 w-20 object-contain">
                  </div>
                  <h3 class="mt-2 text-center text-[14px] font-extrabold leading-4">Đưa đón du lịch</h3>
                  <p class="mt-1 text-center text-[12px] leading-4 text-app-muted">Linh hoạt hành trình tham quan, đi tỉnh và cuối tuần.</p>
                </article>
              </div>

              <!-- 5. Đưa đón ngày đêm -->
              <div class="swiper-slide">
                <article class="group flex h-full flex-col rounded-[12px] border border-app-line bg-white p-3 shadow-sm transition-all duration-200 hover:-translate-y-0.5 hover:shadow-card">
                  <div class="mx-auto flex h-20 w-20 items-center justify-center">
                    <img src="{{ asset('assets/icon-dichvu/dv-ngaydem.png') }}" alt="Đưa đón ngày đêm" class="h-20 w-20 object-contain">
                  </div>
                  <h3 class="mt-2 text-center text-[14px] font-extrabold leading-4">Đưa đón ngày đêm</h3>
                  <p class="mt-1 text-center text-[12px] leading-4 text-app-muted">Phục vụ linh hoạt mọi khung giờ, kể cả đêm khuya.</p>
                </article>
              </div>

              <!-- 6. Đưa đón bệnh viện -->
              <div class="swiper-slide">
                <article class="group flex h-full flex-col rounded-[12px] border border-app-line bg-white p-3 shadow-sm transition-all duration-200 hover:-translate-y-0.5 hover:shadow-card">
                  <div class="mx-auto flex h-20 w-20 items-center justify-center">
                    <img src="{{ asset('assets/icon-dichvu/dv-benhvien.png') }}" alt="Đưa đón bệnh viện" class="h-20 w-20 object-contain">
                  </div>
                  <h3 class="mt-2 text-center text-[14px] font-extrabold leading-4">Đưa đón bệnh viện</h3>
                  <p class="mt-1 text-center text-[12px] leading-4 text-app-muted">Ưu tiên sự an tâm, hỗ trợ di chuyển nhẹ nhàng và kín đáo.</p>
                </article>
              </div>

              <!-- 7. Đưa đón công tác -->
              <div class="swiper-slide">
                <article class="group flex h-full flex-col rounded-[12px] border border-app-line bg-white p-3 shadow-sm transition-all duration-200 hover:-translate-y-0.5 hover:shadow-card">
                  <div class="mx-auto flex h-20 w-20 items-center justify-center">
                    <img src="{{ asset('assets/icon-dichvu/dv-congtac.png') }}" alt="Đưa đón công tác" class="h-20 w-20 object-contain">
                  </div>
                  <h3 class="mt-2 text-center text-[14px] font-extrabold leading-4">Đưa đón công tác</h3>
                  <p class="mt-1 text-center text-[12px] leading-4 text-app-muted">Chỉnh chu, đúng hẹn, phù hợp lịch làm việc doanh nghiệp.</p>
                </article>
              </div>

              <!-- 8. Đưa đón đi học -->
              <div class="swiper-slide">
                <article class="group flex h-full flex-col rounded-[12px] border border-app-line bg-white p-3 shadow-sm transition-all duration-200 hover:-translate-y-0.5 hover:shadow-card">
                  <div class="mx-auto flex h-20 w-20 items-center justify-center">
                    <img src="{{ asset('assets/icon-dichvu/dv-dihoc.png') }}" alt="Đưa đón đi học" class="h-20 w-20 object-contain">
                  </div>
                  <h3 class="mt-2 text-center text-[14px] font-extrabold leading-4">Đưa đón đi học</h3>
                  <p class="mt-1 text-center text-[12px] leading-4 text-app-muted">An toàn và ổn định cho lịch học hằng ngày của bé.</p>
                </article>
              </div>

              <!-- 9. Đưa đón đi làm -->
              <div class="swiper-slide">
                <article class="group flex h-full flex-col rounded-[12px] border border-app-line bg-white p-3 shadow-sm transition-all duration-200 hover:-translate-y-0.5 hover:shadow-card">
                  <div class="mx-auto flex h-20 w-20 items-center justify-center">
                    <img src="{{ asset('assets/icon-dichvu/dv-dilam.png') }}" alt="Đưa đón đi làm" class="h-20 w-20 object-contain">
                  </div>
                  <h3 class="mt-2 text-center text-[14px] font-extrabold leading-4">Đưa đón đi làm</h3>
                  <p class="mt-1 text-center text-[12px] leading-4 text-app-muted">Đi làm đúng giờ, riêng tư và thoải mái mỗi ngày.</p>
                </article>
              </div>

              <!-- 10. Xe theo yêu cầu -->
              <div class="swiper-slide">
                <article class="group flex h-full flex-col rounded-[12px] border border-app-line bg-white p-3 shadow-sm transition-all duration-200 hover:-translate-y-0.5 hover:shadow-card">
                  <div class="mx-auto flex h-20 w-20 items-center justify-center">
                    <img src="{{ asset('assets/icon-dichvu/dv-yeucau.png') }}" alt="Xe theo yêu cầu" class="h-20 w-20 object-contain">
                  </div>
                  <h3 class="mt-2 text-center text-[14px] font-extrabold leading-4">Xe theo yêu cầu</h3>
                  <p class="mt-1 text-center text-[12px] leading-4 text-app-muted">Thiết kế lịch trình linh hoạt theo nhu cầu riêng của bạn.</p>
                </article>
              </div>

              <!-- 11. Phục vụ 24/7 -->
              <div class="swiper-slide">
                <article class="group flex h-full flex-col rounded-[12px] border border-app-line bg-white p-3 shadow-sm transition-all duration-200 hover:-translate-y-0.5 hover:shadow-card">
                  <div class="mx-auto flex h-20 w-20 items-center justify-center">
                    <img src="{{ asset('assets/icon-dichvu/dv-24tren7.png') }}" alt="Phục vụ 24/7" class="h-20 w-20 object-contain">
                  </div>
                  <h3 class="mt-2 text-center text-[14px] font-extrabold leading-4">Phục vụ 24/7</h3>
                  <p class="mt-1 text-center text-[12px] leading-4 text-app-muted">Hỗ trợ nhiệt tình mọi lúc, kể cả đêm khuya và cuối tuần.</p>
                </article>
              </div>
            </div>
          </div>
        </div>

        <div class="mt-4 flex items-center justify-center gap-2 text-[13px] font-bold text-app-muted">
          <span class="block h-0.5 w-6 rounded-full bg-app-accent/30"></span>
          <span>Vuốt sang trái hoặc phải để xem thêm</span>
          <span class="block h-0.5 w-6 rounded-full bg-app-accent/30"></span>
        </div>
      </section>
      <!-- END MOBILE SECTION 3: DỊCH VỤ -->

      

      <!-- ============================================================
           MOBILE - SECTION 4: BẢNG GIÁ CHO THUÊ XE (4 mức giá + ví dụ)
           ID: #bang-gia (mobile)
           ============================================================ -->
      <section id="bang-gia" class="border-b border-app-line bg-white px-4 py-6">
        <div class="overflow-hidden rounded-[10px] border border-app-line bg-[#f5f5f4] shadow-sm">
          <img src="{{ asset('assets/image/banner-banggia.png') }}" alt="Bảng giá thuê xe" class="h-auto w-full object-cover">
        </div>

        <!-- Bảng giá dạng card (style giống Tại sao chọn chúng tôi) -->
        <div class="mt-3 space-y-2.5">
          <!-- Card 1: Theo buổi -->
          <div class="flex items-center justify-between rounded-[12px] border border-app-line bg-white px-4 py-3.5 shadow-sm">
            <div class="flex items-center gap-3">
              <img src="{{ asset('assets/icon-thuexe/thue-1gio.png') }}" alt="Thuê theo buổi" class="h-16 w-16 shrink-0 rounded-[10px] object-contain">
              <div>
                <p class="text-sm font-bold">Thuê theo buổi</p>
                <p class="mt-0.5 text-xs text-app-muted">Sáng 6h-12h<br>Chiều 12h-18h<br>Tối 18h-23h</p>
              </div>
            </div>
            <div class="shrink-0 text-right">
              <p class="text-sm font-extrabold text-app-accent">{{ number_format($defaultCar->price_per_session) }}đ <span class="text-[13px] font-semibold text-app-muted">/ 1 buổi</span></p>
            </div>
          </div>

          <!-- Card 2: 1 ngày nội thành -->
          <div class="flex items-center justify-between rounded-[12px] border-2 border-app-accent bg-white px-4 py-3.5 shadow-sm">
            <div class="flex items-center gap-3">
              <img src="{{ asset('assets/icon-thuexe/thue-1ngay.png') }}" alt="Thuê 1 ngày" class="h-16 w-16 shrink-0 rounded-[10px] object-contain">
              <div>
                <p class="text-sm font-bold">Thuê 1 ngày</p>
                <p class="mt-0.5 text-xs text-app-muted">Trong nội tỉnh Đăk Lăk</p>
              </div>
            </div>
            <div class="shrink-0 text-right">
              <p class="text-sm font-extrabold text-app-accent">{{ number_format($defaultCar->price_per_day) }}đ <span class="text-[13px] font-semibold text-app-muted">/ 1 ngày</span></p>
            </div>
          </div>

          <!-- Card 3: Nhiều ngày -->
          <div class="flex items-center justify-between rounded-[12px] border border-app-line bg-white px-4 py-3.5 shadow-sm">
            <div class="flex items-center gap-3">
              <img src="{{ asset('assets/icon-thuexe/thue-nhieungay.png') }}" alt="Thuê nhiều ngày" class="h-16 w-16 shrink-0 rounded-[10px] object-contain">
              <div>
                <p class="text-sm font-bold">Thuê 3 ngày trở lên</p>
                <p class="mt-0.5 text-xs text-app-muted">Giảm {{ number_format($defaultCar->price_per_day - $defaultCar->price_multi_day) }}đ / ngày <br>(giá niêm yết {{ number_format($defaultCar->price_per_day) }}đ)</p>
              </div>
            </div>
            <div class="shrink-0 text-right">
              <p class="text-sm font-extrabold text-app-accent">{{ number_format($defaultCar->price_multi_day) }}đ <span class="text-[13px] font-semibold text-app-muted">/ 1 ngày</span></p>
            </div>
          </div>

          <!-- Card 4: Phụ phí ra tỉnh -->
          <div class="flex items-center justify-between rounded-[12px] border border-dashed border-app-line bg-white px-4 py-3.5 shadow-sm">
            <div class="flex items-center gap-3">
              <img src="{{ asset('assets/icon-thuexe/thue-ngoaitinh.png') }}" alt="Phụ phí ra tỉnh" class="h-16 w-16 shrink-0 rounded-[10px] object-contain">
              <div>
                <p class="text-sm font-bold">Phụ phí ra tỉnh</p>
                <p class="mt-0.5 text-xs text-app-muted">Áp dụng khi đi liên tỉnh</p>
              </div>
            </div>
            <div class="shrink-0 text-right">
              <p class="text-sm font-extrabold text-app-accent">+{{ number_format($defaultCar->price_out_province) }}đ <span class="text-[13px] font-semibold text-app-muted">/ 1 ngày</span></p>
            </div>
          </div>
        </div>

        <!-- Ví dụ cách tính -->
        <div class="mt-3 rounded-[12px] border border-app-line bg-white px-3 py-2.5 shadow-sm">
          <div class="flex items-center gap-2">
            <svg class="h-[18px] w-[18px] text-app-muted" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
              <path stroke-linecap="round" stroke-linejoin="round" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
            </svg>
            <p class="text-xs font-extrabold uppercase tracking-wider text-app-muted">Ví dụ cách tính giá</p>
          </div>
          <div class="mt-2 grid grid-cols-2 gap-1.5">
            <div class="rounded-[8px] border border-app-line bg-stone-50 px-2.5 py-2 text-center">
              <p class="text-xs font-semibold text-app-muted">Trong tỉnh</p>
              <p class="text-xs font-bold text-slate-700">1 ngày</p>
              <p class="mt-0.5 text-sm font-extrabold text-slate-900">{{ number_format($defaultCar->price_per_day) }}đ</p>
            </div>
            <div class="rounded-[8px] border border-app-line bg-stone-50 px-2.5 py-2 text-center">
              <p class="text-xs font-semibold text-app-muted">Đi tỉnh khác</p>
              <p class="text-xs font-bold text-slate-700">1 ngày</p>
              <p class="mt-0.5 text-sm font-extrabold text-slate-900">{{ number_format($defaultCar->price_per_day + $defaultCar->price_out_province) }}đ</p>
            </div>
            <div class="rounded-[8px] border border-app-line bg-stone-50 px-2.5 py-2 text-center">
              <p class="text-xs font-semibold text-app-muted">Trong tỉnh</p>
              <p class="text-xs font-bold text-slate-700">3 ngày</p>
              <p class="mt-0.5 text-sm font-extrabold text-slate-900">{{ number_format($defaultCar->price_multi_day) }}đ/ngày</p>
            </div>
            <div class="rounded-[8px] border border-app-accent bg-app-accentSoft px-2.5 py-2 text-center">
              <p class="text-[11px] font-semibold text-app-accent">Đi tỉnh khác</p>
              <p class="text-xs font-bold text-slate-700">3 ngày</p>
              <p class="mt-0.5 text-sm font-extrabold text-slate-900">{{ number_format($defaultCar->price_multi_day + $defaultCar->price_out_province) }}đ/ngày</p>
            </div>
          </div>
       
        </div>
      </section>
      <!-- END MOBILE SECTION 4: BẢNG GIÁ -->

      <!-- ============================================================
           MOBILE - SECTION 5: HƯỚNG DẪN ĐẶT XE (Zalo + Web + Hotline)
           ID: #huong-dan (mobile)
           ============================================================ -->
      <section id="huong-dan" class="border-b border-app-line bg-white px-4 py-6">
        <div class="overflow-hidden rounded-[10px] border border-app-line bg-[#f5f5f4] shadow-sm">
          <img src="{{ asset('assets/image/banner-huongdan.png') }}" alt="Hướng dẫn đặt xe" class="h-auto w-full object-cover">
        </div>

        <div class="mt-3 space-y-4">
          <!-- Đặt qua Zalo -->
          <div class="overflow-hidden rounded-[14px] border border-app-line bg-white shadow-sm">
            <div class="flex items-center gap-3 bg-[#0068ff] px-4 py-3">
              <div class="flex h-10 w-10 items-center justify-center rounded-[10px] bg-white/20 text-white">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M8.625 9.75a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H8.25m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H12m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0h-.375m-13.5 3.01c0 1.6 1.123 2.994 2.707 3.227 1.087.16 2.185.283 3.293.369V21l4.184-4.183a1.14 1.14 0 0 1 .778-.332 48.294 48.294 0 0 0 5.83-.498c1.585-.233 2.708-1.626 2.708-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0 0 12 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018Z" />
                </svg>
              </div>
              <div>
                <p class="text-sm font-extrabold text-white">Cách 1: Thuê xe qua Zalo</p>
                <p class="text-xs font-semibold text-white/70">Nhắn tin trực tiếp, phản hồi nhanh trong 5 phút</p>
              </div>
            </div>
            <div class="px-4 py-4">
              <div class="space-y-3">
                <div class="flex items-start gap-3">
                  <div class="flex h-7 w-7 shrink-0 items-center justify-center rounded-full bg-[#e8f0fe] text-[13px] font-extrabold text-[#0068ff]">1</div>
                  <div>
                    <p class="text-sm font-bold text-slate-800">Mở Zalo và nhắn tin với Shop</p>
                    <p class="mt-0.5 text-xs leading-5 text-app-muted">Click nút nhắn tin ngay để liên hệ với Shop</p>
                  </div>
                </div>
                <div class="flex items-start gap-3">
                  <div class="flex h-7 w-7 shrink-0 items-center justify-center rounded-full bg-[#e8f0fe] text-[13px] font-extrabold text-[#0068ff]">2</div>
                  <div>
                    <p class="text-sm font-bold text-slate-800">Gửi thông tin cần thuê</p>
                    <p class="mt-0.5 text-xs leading-5 text-app-muted">Loại xe, ngày giờ nhận - trả, khu vực di chuyển và số điện thoại liên hệ</p>
                  </div>
                </div>
                <div class="flex items-start gap-3">
                  <div class="flex h-7 w-7 shrink-0 items-center justify-center rounded-full bg-[#e8f0fe] text-[13px] font-extrabold text-[#0068ff]">3</div>
                  <div>
                    <p class="text-sm font-bold text-slate-800">Xác nhận và nhận xe</p>
                    <p class="mt-0.5 text-xs leading-5 text-app-muted">Bộ phận tư vấn sẽ gọi lại xác nhận, hẹn lịch giao xe tận nơi hoặc đến điểm nhận</p>
                  </div>
                </div>
              </div>
              <a href="{{ 'https://zalo.me/' . preg_replace('/\D+/', '', \App\Models\Setting::get('site_phone', '0964918047')) }}" target="_blank" rel="noopener" class="mt-4 flex w-full items-center justify-center gap-2 rounded-[10px] bg-[#0068ff] px-4 py-3 text-sm font-extrabold text-white transition-all hover:bg-[#0056d6] active:scale-[0.98]">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M8.625 9.75a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H8.25m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H12m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0h-.375m-13.5 3.01c0 1.6 1.123 2.994 2.707 3.227 1.087.16 2.185.283 3.293.369V21l4.184-4.183a1.14 1.14 0 0 1 .778-.332 48.294 48.294 0 0 0 5.83-.498c1.585-.233 2.708-1.626 2.708-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0 0 12 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018Z" />
                </svg>
                Nhắn tin Zalo ngay
              </a>
            </div>
          </div>

          <!-- Đặt qua Web -->
          <div class="overflow-hidden rounded-[14px] border border-app-line bg-white shadow-sm">
            <div class="flex items-center gap-3 bg-app-accent px-4 py-3">
              <div class="flex h-10 w-10 items-center justify-center rounded-[10px] bg-white/20 text-white">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9.004 9.004 0 0 0 8.716-6.747M12 21a9.004 9.004 0 0 1-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 0 1 7.843 4.582M12 3a8.997 8.997 0 0 0-7.843 4.582m15.686 0A11.953 11.953 0 0 1 12 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0 1 21 12c0 .778-.099 1.533-.284 2.253m0 0A17.919 17.919 0 0 1 12 16.5c-3.162 0-6.133-.815-8.716-2.247m0 0A9.015 9.015 0 0 1 3 12c0-1.605.42-3.113 1.157-4.418" />
                </svg>
              </div>
              <div>
                <p class="text-sm font-extrabold text-white">Cách 2: Thuê xe qua Web</p>
                <p class="text-xs font-semibold text-white/70">Thao tác ngay trên website, không cần cài đặt thêm</p>
              </div>
            </div>
            <div class="px-4 py-4">
              <div class="space-y-3">
                <div class="flex items-start gap-3">
                  <div class="flex h-7 w-7 shrink-0 items-center justify-center rounded-full bg-app-accentSoft text-[13px] font-extrabold text-app-accent">1</div>
                  <div>
                    <p class="text-sm font-bold text-slate-800">Chọn hình thức thuê xe</p>
                    <p class="mt-0.5 text-xs leading-5 text-app-muted">Lựa chọn thuê 1 ngày, nhiều ngày hoặc theo buổi phù hợp nhu cầu của bạn</p>
                  </div>
                </div>
                <div class="flex items-start gap-3">
                  <div class="flex h-7 w-7 shrink-0 items-center justify-center rounded-full bg-app-accentSoft text-[13px] font-extrabold text-app-accent">2</div>
                  <div>
                    <p class="text-sm font-bold text-slate-800">Chọn ngày giờ và nhập số điện thoại</p>
                    <p class="mt-0.5 text-xs leading-5 text-app-muted">Điền thời gian nhận xe, trả xe và số điện thoại để chúng tôi liên hệ xác nhận</p>
                  </div>
                </div>
                <div class="flex items-start gap-3">
                  <div class="flex h-7 w-7 shrink-0 items-center justify-center rounded-full bg-app-accentSoft text-[13px] font-extrabold text-app-accent">3</div>
                  <div>
                    <p class="text-sm font-bold text-slate-800">Bấm "Thuê xe nhanh" và chờ xác nhận</p>
                    <p class="mt-0.5 text-xs leading-5 text-app-muted">Hệ thống sẽ gửi yêu cầu của bạn, nhân viên sẽ gọi lại trong vòng 5-10 phút để xác nhận đặt xe</p>
                  </div>
                </div>
              </div>
              <button id="btn-thue-web" onclick="startWebTour();" class="mt-4 flex w-full items-center justify-center gap-2 rounded-[10px] bg-app-accent px-4 py-3 text-sm font-extrabold text-white transition-all hover:bg-[#4ab572] active:scale-[0.98]">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5m-9-6h.008v.008H12v-.008ZM12 15h.008v.008H12V15Zm0 2.25h.008v.008H12v-.008ZM9.75 15h.008v.008H9.75V15Zm0 2.25h.008v.008H9.75v-.008ZM7.5 15h.008v.008H7.5V15Zm0 2.25h.008v.008H7.5v-.008Zm6.75-4.5h.008v.008h-.008v-.008Zm0 2.25h.008v.008h-.008V15Zm0 2.25h.008v.008h-.008v-.008Zm2.25-4.5h.008v.008H16.5v-.008Zm0 2.25h.008v.008H16.5V15Z" />
                </svg>
                Thuê xe ngay trên Web
              </button>
            </div>
          </div>

          <!-- Ghi chú hỗ trợ -->
          <div   class="flex items-start gap-3 rounded-[10px] bg-amber-50 px-4 py-3">
            <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-amber-100 text-amber-500">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 0 0 2.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 0 1-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 0 0-1.091-.852H4.5A2.25 2.25 0 0 0 2.25 4.5v2.25Z" />
              </svg>
            </div>
            <div>
              <p class="text-sm font-bold text-amber-800">Cần hỗ trợ thêm?</p>
              <p class="mt-0.5 text-xs leading-5 text-amber-700">Hotline / Zalo <span class="font-extrabold">0964.918.047</span> để được tư vấn miễn phí 24/7</p>
            </div>
          </div>
        </div>
      </section>
      <!-- END MOBILE SECTION 5: HƯỚNG DẪN -->

      <!-- ============================================================
           MOBILE - SECTION 6: PHỤ THU CÓ THỂ PHÁT SINH
           ID: #phat-sinh (mobile)
           ============================================================ -->
      <section id="phat-sinh" class="border-b border-app-line bg-white px-4 py-6">
        <div class="overflow-hidden rounded-[10px] border border-app-line bg-[#f5f5f4] shadow-sm">
          <img src="{{ asset('assets/image/banner-phiphuthu.png') }}" alt="Phụ thu có thể phát sinh" class="h-auto w-full object-cover">
        </div>

        <div class="mt-3 space-y-2.5">
          <!-- Phí cầu đường -->
          <div class="flex items-center justify-between rounded-[12px] border border-app-line bg-white px-4 py-3.5 shadow-sm">
            <div class="flex items-center gap-3">
              <img src="{{ asset('assets/svg-phuthuphatsinh/phi-cauduong.png') }}" alt="Phí cầu đường" class="h-16 w-16 shrink-0 rounded-[10px] object-contain">
              <div>
                <p class="text-sm font-bold">Phí cầu đường</p>
                <p class="mt-1 text-xs leading-5 text-app-muted">Chủ xe có thể yêu cầu thanh toán tất cả các khoản lệ phí cầu đường phát sinh trên tài khoản VETC trong thời gian thuê xe.</p>
              </div>
            </div>
          </div>

          <!-- Phụ thu nhiên liệu -->
          <div class="flex items-center justify-between rounded-[12px] border border-app-line bg-white px-4 py-3.5 shadow-sm">
            <div class="flex items-center gap-3">
              <img src="{{ asset('assets/svg-phuthuphatsinh/phi-nhienlieu.png') }}" alt="Phụ thu nhiên liệu" class="h-16 w-16 shrink-0 rounded-[10px] object-contain">
              <div>
                <p class="text-sm font-bold">Phụ thu nhiên liệu</p>
                <p class="mt-1 text-xs leading-5 text-app-muted">Chủ xe chỉ thu khi vạch xăng thấp hơn lúc nhận xe. Trả lại đúng vạch xăng như lúc nhận để không phải trả phí này.</p>
              </div>
            </div>
          </div>

          <!-- Phí trả trễ -->
          <div class="flex items-center justify-between rounded-[12px] border border-app-line bg-white px-4 py-3.5 shadow-sm">
            <div class="flex items-center gap-3">
              <img src="{{ asset('assets/svg-phuthuphatsinh/phi-quagio.png') }}" alt="Phí trả trễ" class="h-16 w-16 shrink-0 rounded-[10px] object-contain">
              <div>
                <p class="text-sm font-bold">Phí trả trễ</p>
                <p class="mt-1 text-xs leading-5 text-app-muted">Áp dụng khi trả xe trễ hơn giờ đã thỏa thuận.</p>
              </div>
            </div>
            <div class="shrink-0 text-right">
              <p class="text-sm font-extrabold text-app-accent">100.000đ <span class="text-[13px] font-semibold text-app-muted">/ giờ</span></p>
            </div>
          </div>

          <!-- Phí nặng mùi hôi - thuốc lá -->
          <div class="flex items-center justify-between rounded-[12px] border border-app-line bg-white px-4 py-3.5 shadow-sm">
            <div class="flex items-center gap-3">
              <img src="{{ asset('assets/svg-phuthuphatsinh/phi-vesinh.png') }}" alt="Phí nặng mùi hôi" class="h-16 w-16 shrink-0 rounded-[10px] object-contain">
              <div>
                <p class="text-sm font-bold">Phí nặng mùi hôi - thuốc lá</p>
                <p class="mt-1 text-xs leading-5 text-app-muted">Chủ xe sẽ dựa vào tình trạng vệ sinh xe lúc khách hàng trả xe để thu phí.</p>
              </div>
            </div>
            <div class="shrink-0 text-right">
              <p class="text-sm font-extrabold text-app-accent">250.000đ</p>
            </div>
          </div>
        </div>
      </section>
      <!-- END MOBILE SECTION 6: PHỤ THU -->

      <!-- ============================================================
           MOBILE - SECTION 7: TẠI SAO CHỌN CHÚNG TÔI? (12 ưu điểm)
           ID: #chung-toi (mobile)
           ============================================================ -->
      <section id="chung-toi" class="border-b border-app-line bg-white px-4 py-3 pb-4">
        <div class="text-center">
       
          <div class="overflow-hidden rounded-[12px] border border-app-line bg-[#f5f5f4] shadow-sm">
            <img src="{{ asset('assets/image/banner-chungtoicogi.png') }}" alt="Tại sao chọn chúng tôi" class="h-auto w-full object-cover">
          </div>
        
          
        </div>

        <div class="mt-3 space-y-2.5">
          <!-- 5 items hiển thị mặc định -->
          <article class="flex items-center gap-3 rounded-[12px] border border-app-line bg-white px-4 py-3.5 shadow-sm">
            <img src="{{ asset('assets/icon-chungtoi/icon-thutuc.png') }}" alt="Thủ tục đơn giản" class="h-16 w-16 shrink-0 rounded-[10px] object-contain">
            <div class="min-w-0 flex-1">
              <p class="text-sm font-bold">Thủ tục đơn giản</p>
              <p class="mt-1 text-xs leading-5 text-app-muted">Chỉ cần CCCD và GPLX Cứng hoặc Mềm đều được. <br>Hồ sơ nhanh chóng, nhận xe chỉ trong 5 phút.</p>
            </div>
          </article>

          <article class="flex items-center gap-3 rounded-[12px] border border-app-line bg-white px-4 py-3.5 shadow-sm">
            <img src="{{ asset('assets/icon-chungtoi/icon-giamenhbach.png') }}" alt="Giá minh bạch" class="h-16 w-16 shrink-0 rounded-[10px] object-contain">
            <div class="min-w-0 flex-1">
              <p class="text-sm font-bold">Giá minh bạch</p>
              <p class="mt-1 text-xs leading-5 text-app-muted">Báo giá rõ ràng, Giá cả cạnh tranh. Cam kết giá tốt nhất thị trường.</p>
            </div>
          </article>
 <article class="flex items-center gap-3 rounded-[12px] border border-app-line bg-white px-4 py-3.5 shadow-sm">
              <img src="{{ asset('assets/icon-chungtoi/icon-baohiem.png') }}" alt="Có bảo hiểm" class="h-16 w-16 shrink-0 rounded-[10px] object-contain">
              <div class="min-w-0 flex-1">
                <p class="text-sm font-bold">Có bảo hiểm dân sự bắt buộc <br>Có Bảo hiểm thân vỏ</p>
                <p class="mt-1 text-xs leading-5 text-app-muted">Trang bị đầy đủ bảo hiểm, mang đến sự an tâm tuyệt đối trong suốt hành trình.</p>
              </div>
            </article>

            <!-- 🔧 Bảo dưỡng định kỳ -->
            <article class="flex items-center gap-3 rounded-[12px] border border-app-line bg-white px-4 py-3.5 shadow-sm">
              <img src="{{ asset('assets/icon-chungtoi/icon-baoduongdinhky.png') }}" alt="Bảo dưỡng định kỳ" class="h-16 w-16 shrink-0 rounded-[10px] object-contain">
              <div class="min-w-0 flex-1">
                <p class="text-sm font-bold">Bảo dưỡng định kỳ</p>
                <p class="mt-1 text-xs leading-5 text-app-muted">Xe được kiểm tra và bảo dưỡng thường xuyên, đảm bảo vận hành an toàn và êm ái.</p>
              </div>
            </article>

          <article class="flex items-center gap-3 rounded-[12px] border border-app-line bg-white px-4 py-3.5 shadow-sm">
            <img src="{{ asset('assets/icon-chungtoi/icon-vietmap.png') }}" alt="Có Vietmap Live Pro" class="h-16 w-16 shrink-0 rounded-[10px] object-contain">
            <div class="min-w-0 flex-1">
              <p class="text-sm font-bold">Có Vietmap Live Pro</p>
              <p class="mt-1 text-xs leading-5 text-app-muted">Hỗ trợ cảnh báo tốc độ, biển báo giao thông<br>Full chức năng của Vietmap Live Pro.</p>
            </div>
          </article>

          <!-- 7 items còn lại được ẩn, bấm "Xem thêm" mới hiện -->
          <div id="extra-features" class="hidden space-y-2.5">
            <article class="flex items-center gap-3 rounded-[12px] border border-app-line bg-white px-4 py-3.5 shadow-sm">
              <img src="{{ asset('assets/icon-chungtoi/icon-camera.png') }}" alt="Có camera hành trình" class="h-16 w-16 shrink-0 rounded-[10px] object-contain">
              <div class="min-w-0 flex-1">
                <p class="text-sm font-bold">Có camera hành trình</p>
                <p class="mt-1 text-xs leading-5 text-app-muted">Tất cả xe đều được trang bị camera hành trình, đảm bảo an toàn và minh bạch.</p>
              </div>
            </article>

            <article class="flex items-center gap-3 rounded-[12px] border border-app-line bg-white px-4 py-3.5 shadow-sm">
              <img src="{{ asset('assets/icon-chungtoi/icon-hotro24h.png') }}" alt="Hỗ trợ 24/7" class="h-16 w-16 shrink-0 rounded-[10px] object-contain">
              <div class="min-w-0 flex-1">
                <p class="text-sm font-bold">Hỗ trợ 24/7</p>
                <p class="mt-1 text-xs leading-5 text-app-muted">Đội ngũ hỗ trợ chuyên nghiệp, sẵn sàng giải đáp và xử lý mọi vấn đề 24/7.</p>
              </div>
            </article>

            <article class="flex items-center gap-3 rounded-[12px] border border-app-line bg-white px-4 py-3.5 shadow-sm">
              <img src="{{ asset('assets/icon-chungtoi/icon-xemoi.png') }}" alt="Xe đời mới, sạch sẽ" class="h-16 w-16 shrink-0 rounded-[10px] object-contain">
              <div class="min-w-0 flex-1">
                <p class="text-sm font-bold">Xe đời mới, sạch sẽ</p>
                <p class="mt-1 text-xs leading-5 text-app-muted">Xe đời mới, được vệ sinh kỹ lưỡng, khử khuẩn sạch sẽ trước khi giao cho khách.</p>
              </div>
            </article>

            <!-- 🏠 Giao nhận tận nơi -->
            <article class="flex items-center gap-3 rounded-[12px] border border-app-line bg-white px-4 py-3.5 shadow-sm">
              <img src="{{ asset('assets/icon-chungtoi/icon-giaoxetannoi.png') }}" alt="Giao nhận tận nơi" class="h-16 w-16 shrink-0 rounded-[10px] object-contain">
              <div class="min-w-0 flex-1">
                <p class="text-sm font-bold">Giao nhận tận nơi</p>
                <p class="mt-1 text-xs leading-5 text-app-muted">Giao xe tận nơi miễn phí trong khu vực nội thành. Linh hoạt theo yêu cầu.</p>
              </div>
            </article>

            <!-- ⚡ Nhận xe nhanh -->
            <article class="flex items-center gap-3 rounded-[12px] border border-app-line bg-white px-4 py-3.5 shadow-sm">
              <img src="{{ asset('assets/icon-chungtoi/icon-giaoxenhanh.png') }}" alt="Nhận xe nhanh" class="h-16 w-16 shrink-0 rounded-[10px] object-contain">
              <div class="min-w-0 flex-1">
                <p class="text-sm font-bold">Nhận xe nhanh</p>
                <p class="mt-1 text-xs leading-5 text-app-muted">Chỉ cần 5-10 phút làm thủ tục là bạn đã có thể nhận xe và bắt đầu hành trình.</p>
              </div>
            </article>

            <!-- 💳 Thanh toán linh hoạt -->
            <article class="flex items-center gap-3 rounded-[12px] border border-app-line bg-white px-4 py-3.5 shadow-sm">
              <img src="{{ asset('assets/icon-chungtoi/icon-thanhtoan.png') }}" alt="Thanh toán linh hoạt" class="h-16 w-16 shrink-0 rounded-[10px] object-contain">
              <div class="min-w-0 flex-1">
                <p class="text-sm font-bold">Thanh toán linh hoạt</p>
                <p class="mt-1 text-xs leading-5 text-app-muted">Chấp nhận tiền mặt, chuyển khoản, thẻ ngân hàng. Linh hoạt theo nhu cầu của bạn.</p>
              </div>
            </article>

            <!-- 🎁 Ưu đãi thuê dài ngày -->
            <article class="flex items-center gap-3 rounded-[12px] border border-app-line bg-white px-4 py-3.5 shadow-sm">
              <img src="{{ asset('assets/icon-chungtoi/icon-phanthuong.png') }}" alt="Ưu đãi thuê dài ngày" class="h-16 w-16 shrink-0 rounded-[10px] object-contain">
              <div class="min-w-0 flex-1">
                <p class="text-sm font-bold">Ưu đãi thuê dài ngày</p>
                <p class="mt-1 text-xs leading-5 text-app-muted">Giảm giá đặc biệt cho khách hàng thuê 3 ngày trở lên. Tiết kiệm hơn khi thuê lâu dài.</p>
              </div>
            </article>
          </div>

          <!-- Nút Xem thêm / Thu gọn -->
          <button onclick="document.getElementById('extra-features').classList.toggle('hidden'); this.classList.toggle('hidden')" class="w-full rounded-[10px] border border-app-line bg-white px-4 py-3 text-sm font-bold text-app-accent shadow-sm transition-all hover:bg-app-accentSoft">
            <span class="flex items-center justify-center gap-1">
              <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
              Xem thêm
            </span>
          </button>
        </div>

      </section>
      <!-- END MOBILE SECTION 7: TẠI SAO CHỌN CHÚNG TÔI -->

      <!-- ============================================================
           MOBILE - SECTION 8: BẢN ĐỒ VỊ TRÍ CỬA HÀNG
           ID: #ban-do (mobile)
           ============================================================ -->
      <section id="ban-do" class="border-b border-app-line bg-white px-4 py-5 pb-20">
        <div class="mb-3 text-center">
          <h2 class="text-lg font-extrabold text-app-ink">Vị trí cửa hàng</h2>
          <p class="mt-1 text-xs font-semibold text-app-muted">07 Chu Văn An, Buôn Hồ, Đắk Lắk</p>
        </div>
        <div class="overflow-hidden rounded-[10px] border border-app-line shadow-sm">
          <iframe
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d243.05795650418517!2d108.26486600298888!3d12.91239379451464!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x316e1d45da2bce3f%3A0x392028fcc9b8fca!2zVGh1w6ogWGUgQnXDtG4gSOG7kw!5e0!3m2!1svi!2s!4v1783877732052!5m2!1svi!2s"
            width="100%" height="250" style="border:0;"
            allowfullscreen loading="lazy"
            referrerpolicy="strict-origin-when-cross-origin"
            title="Vị trí cửa hàng Thuê Xe Buôn Hồ">
          </iframe>
        </div>
      </section>
      <!-- END MOBILE SECTION 8: BẢN ĐỒ -->

    </main>
    <!-- END MOBILE CONTENT -->

    
@endsection
