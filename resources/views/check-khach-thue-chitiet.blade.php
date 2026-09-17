<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<meta name="theme-color" content="#5fcf86">
<title>Chi tiết khách - Check khách thuê</title>
<meta name="description" content="Chi tiết hồ sơ khách hàng trong danh sách đen của cộng đồng chủ cho thuê xe. Thông tin nhận dạng, báo cáo và bằng chứng.">
<meta name="robots" content="noindex, nofollow">
<meta name="keywords" content="check khách thuê, danh sách đen, báo cáo khách thuê, thuê xe, cho thuê xe">
<meta property="og:title" content="Chi tiết khách - Check khách thuê">
<meta property="og:description" content="Chi tiết hồ sơ khách hàng trong danh sách đen của cộng đồng chủ cho thuê xe.">
<meta property="og:image" content="{{ asset('assets/icon-checkkhach/banner-checkkhach.png') }}">
<meta property="og:image:width" content="1200">
<meta property="og:image:height" content="630">
<meta property="og:url" content="{{ url()->current() }}">
<meta property="og:type" content="website">
<meta property="og:site_name" content="Cộng đồng chủ cho thuê xe">
<meta property="og:locale" content="vi_VN">
<meta property="og:image:type" content="image/png">
<meta property="og:image:alt" content="Check khách thuê - Cộng đồng chủ cho thuê xe">
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="Chi tiết khách - Check khách thuê">
<meta name="twitter:description" content="Chi tiết hồ sơ khách hàng trong danh sách đen của cộng đồng chủ cho thuê xe.">
<meta name="twitter:image" content="{{ asset('assets/icon-checkkhach/banner-checkkhach.png') }}">
<link rel="icon" type="image/png" sizes="32x32" href="{{ asset('assets/favicon-32.png') }}">
<link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/favicon-16.png') }}">
@vite(['resources/css/app.css', 'resources/js/app.js', 'resources/js/check-khach-detail.js'])
<link href="{{ asset('assets/vendor/remixicon/remixicon.css') }}" rel="stylesheet">
<link rel="preload" href="{{ asset('assets/fonts/nunito/nunito-vietnamese.woff2') }}" as="font" type="font/woff2" crossorigin>
<link rel="preload" href="{{ asset('assets/fonts/nunito/nunito-latin.woff2') }}" as="font" type="font/woff2" crossorigin>
<style>
  @font-face {
    font-family: 'Nunito';
    font-style: normal;
    font-weight: 100 900;
    font-display: swap;
    src: url('{{ asset("assets/fonts/nunito/nunito-vietnamese.woff2") }}') format('woff2');
    unicode-range: U+0102-0103, U+0110-0111, U+0128-0129, U+0168-0169, U+01A0-01A1, U+01AF-01B0, U+0300-0301, U+0303-0304, U+0308-0309, U+0323, U+0329, U+1EA0-1EF9, U+20AB;
  }
  @font-face {
    font-family: 'Nunito';
    font-style: normal;
    font-weight: 100 900;
    font-display: swap;
    src: url('{{ asset("assets/fonts/nunito/nunito-latin.woff2") }}') format('woff2');
    unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+0304, U+0308, U+0329, U+2000-206F, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
  }
  html, body { margin: 0; padding: 0; }
  [x-cloak] { display: none !important; }
  @media (max-width: 767px) {
    input, select, textarea { font-size: 16px !important; }
  }
  #lightbox-pagination .swiper-pagination-bullet {
    background: rgba(255, 255, 255, 0.5);
    opacity: 1;
  }
  #lightbox-pagination .swiper-pagination-bullet-active {
    background: #ffffff;
  }
</style>
</head>
<body class="min-h-screen bg-white font-sans text-app-ink antialiased">

<div class="mx-auto max-w-3xl px-4 py-6 sm:py-10">

  @php
    $reports = $customer->reports;
    $report = $reports->first();
  @endphp

  {{-- Back --}}
  <div class="mb-6">
    <a href="{{ route('check') }}" class="inline-flex items-center gap-1.5 text-[#0b296c] font-extrabold text-sm hover:underline">
      <i class="ri-arrow-left-line"></i>
      Quay lại tra cứu
    </a>
  </div>

  {{-- Header --}}
  <div class="flex items-center justify-center gap-3 sm:gap-5 mb-6">
    <img
      src="{{ asset('assets/icon-checkkhach/icon-logo-check.png') }}"
      alt="Hệ thống báo cáo khách thuê ô tô"
      class="h-16 w-16 sm:h-24 sm:w-24 flex-none object-contain"
      width="112" height="112"
    >
    <h1 class="text-[clamp(1.25rem,6vw,2.75rem)] font-extrabold uppercase leading-tight tracking-tight text-[#052c61]">
      Chi Tiết<br>
      Khách Hàng
    </h1>
  </div>

  {{-- Card: Thông tin chính --}}
  <div class="bg-white rounded-md border border-app-line shadow-card p-4 sm:p-6 mb-4">
    <div class="flex items-center gap-2.5 mb-4">
      <i class="ri-user-line text-[#0b296c] text-xl"></i>
      <h2 class="text-[clamp(0.9375rem,4vw,1.0625rem)] font-extrabold text-[#0b296c]">THÔNG TIN CHÍNH</h2>
    </div>
    <div class="divide-y divide-app-line">
      <div class="flex items-center justify-between gap-3 py-2.5">
        <span class="text-[12.5px] font-bold text-app-muted">Họ tên</span>
        <span class="text-[clamp(0.8125rem,3.6vw,0.875rem)] font-extrabold text-black text-right">{{ $customer->name ? ($reveal ? $customer->name : $masked['name']) : 'Không rõ' }}</span>
      </div>
      <div class="flex items-center justify-between gap-3 py-2.5">
        <span class="text-[12.5px] font-bold text-app-muted">Ngày sinh</span>
        <span class="text-[clamp(0.8125rem,3.6vw,0.875rem)] font-extrabold text-black text-right">{{ $customer->dob ?? 'Không rõ' }}</span>
      </div>
      <div class="flex items-center justify-between gap-3 py-2.5">
        <span class="text-[12.5px] font-bold text-app-muted">Giới tính</span>
        <span class="text-[clamp(0.8125rem,3.6vw,0.875rem)] font-extrabold text-black text-right">{{ $customer->gender ?? 'Không rõ' }}</span>
      </div>
      <div class="flex items-center justify-between gap-3 py-2.5">
        <span class="text-[12.5px] font-bold text-app-muted">Địa chỉ</span>
        <span class="text-[clamp(0.8125rem,3.6vw,0.875rem)] font-extrabold text-black text-right">{{ $customer->address ? ($reveal ? $customer->address : $masked['address']) : 'Không rõ' }}</span>
      </div>
      <div class="flex items-center justify-between gap-3 py-2.5">
        <span class="text-[12.5px] font-bold text-app-muted">Ngày cấp CCCD</span>
        <span class="text-[clamp(0.8125rem,3.6vw,0.875rem)] font-extrabold text-black text-right">{{ $customer->cccd_issue_date ?? 'Không rõ' }}</span>
      </div>
      <div class="flex items-center justify-between gap-3 py-2.5">
        <span class="text-[12.5px] font-bold text-app-muted">CCCD</span>
        <span class="text-[clamp(0.8125rem,3.6vw,0.875rem)] font-extrabold text-black text-right tracking-wide">{{ $customer->cccd ? ($reveal ? $customer->cccd : $masked['cccd']) : 'Không rõ' }}</span>
      </div>
      <div class="flex items-center justify-between gap-3 py-2.5">
        <span class="text-[12.5px] font-bold text-app-muted">SĐT</span>
        <span class="text-[clamp(0.8125rem,3.6vw,0.875rem)] font-extrabold text-black text-right tracking-wide">{{ $customer->phone ? ($reveal ? $customer->phone : $masked['phone']) : 'Không rõ' }}</span>
      </div>
      <div class="flex items-center justify-between gap-3 py-2.5">
        <span class="text-[12.5px] font-bold text-app-muted">Bằng lái</span>
        <span class="text-[clamp(0.8125rem,3.6vw,0.875rem)] font-extrabold text-black text-right tracking-wide">{{ $customer->license ? ($reveal ? $customer->license : $masked['license']) : 'Không rõ' }}</span>
      </div>
    </div>
  </div>

  {{-- Card: Thông tin báo cáo --}}
  <div class="bg-white rounded-md border border-app-line shadow-card p-4 sm:p-6 mb-4">
    <div class="flex items-center gap-2.5 mb-4">
      <i class="ri-file-warning-line text-[#0b296c] text-xl"></i>
      <h2 class="text-[clamp(0.9375rem,4vw,1.0625rem)] font-extrabold text-[#0b296c]">THÔNG TIN BÁO CÁO</h2>
    </div>
    @if ($report)
    <div class="mb-4">
      <p class="text-[12.5px] font-bold text-app-muted mb-1.5">Nội dung</p>
      <p class="text-[clamp(0.8125rem,3.6vw,0.875rem)] font-bold text-[#e02923] leading-relaxed mb-1.5">{{ collect([$report->category, $report->content])->filter()->implode(', ') ?: 'Không rõ' }}</p>
    </div>
    <div class="grid grid-cols-2 gap-2.5 sm:gap-3">
      <div class="rounded-md border border-app-line bg-[#FAFBFF] px-3 py-2.5 text-center">
        <p class="text-[11px] font-bold text-app-muted mb-1">Ngày tạo</p>
        <p class="text-[clamp(0.72rem,3.2vw,0.8125rem)] font-extrabold text-[#0b296c] whitespace-nowrap">{{ $report->date }}</p>
      </div>
      <div class="rounded-md border border-app-line bg-[#FAFBFF] px-3 py-2.5 text-center">
        <p class="text-[11px] font-bold text-app-muted mb-1">Lượt xem</p>
        <p class="text-[clamp(0.72rem,3.2vw,0.8125rem)] font-extrabold text-[#0b296c] whitespace-nowrap">{{ $report->views }} check</p>
      </div>
    </div>
    @else
    <p class="text-sm text-app-muted">Chưa có báo cáo cho khách hàng này.</p>
    @endif
  </div>

  {{-- Card: Lịch sử báo cáo --}}
  <div class="bg-white rounded-md border border-app-line shadow-card p-4 sm:p-6 mb-4">
    <div class="flex items-center gap-2.5 mb-4">
      <i class="ri-history-line text-[#0b296c] text-xl"></i>
      <h2 class="text-[clamp(0.9375rem,4vw,1.0625rem)] font-extrabold text-[#0b296c]">LỊCH SỬ BÁO CÁO</h2>
    </div>
    <div class="overflow-x-auto -mx-1 px-1">
      <table class="w-full text-left border-collapse">
        <thead>
          <tr class="border-b-2 border-app-line">
            <th class="py-2 pr-2 text-[11px] uppercase tracking-wide font-extrabold text-app-muted">STT</th>
            <th class="py-2 pr-2 text-[11px] uppercase tracking-wide font-extrabold text-app-muted">Nội dung</th>
            <th class="py-2 pr-2 text-[11px] uppercase tracking-wide font-extrabold text-app-muted">Ngày</th>
            <th class="py-2 text-[11px] uppercase tracking-wide font-extrabold text-app-muted text-right">Lượt xem</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-app-line">
          @forelse ($reports as $rep)
            @if ($loop->index < 3)
            <tr>
              <td class="py-2.5 pr-2 text-[clamp(0.75rem,3.3vw,0.8125rem)] font-extrabold text-black">{{ $loop->iteration }}</td>
              <td class="py-2.5 pr-2 text-[clamp(0.75rem,3.3vw,0.8125rem)] font-bold text-[#e02923] min-w-[120px]">{{ $rep->content }}</td>
              <td class="py-2.5 pr-2 text-[clamp(0.75rem,3.3vw,0.8125rem)] font-bold text-app-ink whitespace-nowrap">{{ $rep->date }}</td>
              <td class="py-2.5 text-[clamp(0.75rem,3.3vw,0.8125rem)] font-bold text-[#0b296c] text-right whitespace-nowrap">{{ $rep->views }}</td>
            </tr>
            @endif
          @empty
            <tr>
              <td colspan="4" class="py-4 text-center text-sm text-app-muted">Chưa có lịch sử báo cáo.</td>
            </tr>
          @endforelse
        </tbody>
        <tbody id="history-more" class="hidden">
          @foreach ($reports as $rep)
            @if ($loop->index >= 3)
            <tr>
              <td class="py-2.5 pr-2 text-[clamp(0.75rem,3.3vw,0.8125rem)] font-extrabold text-black">{{ $loop->iteration }}</td>
              <td class="py-2.5 pr-2 text-[clamp(0.75rem,3.3vw,0.8125rem)] font-bold text-[#e02923] min-w-[120px]">{{ $rep->content }}</td>
              <td class="py-2.5 pr-2 text-[clamp(0.75rem,3.3vw,0.8125rem)] font-bold text-app-ink whitespace-nowrap">{{ $rep->date }}</td>
              <td class="py-2.5 text-[clamp(0.75rem,3.3vw,0.8125rem)] font-bold text-[#0b296c] text-right whitespace-nowrap">{{ $rep->views }}</td>
            </tr>
            @endif
          @endforeach
        </tbody>
      </table>
    </div>
    @if ($reports->count() > 3)
    <button type="button" id="history-toggle" class="mt-3 w-full border-[1.5px] border-[#0b296c] text-[#0b296c] bg-white font-extrabold text-[clamp(0.8125rem,3.6vw,0.875rem)] px-4 py-2.5 rounded-md hover:bg-[#0b296c] hover:text-white transition">
      Xem thêm
    </button>
    @endif
  </div>

  {{-- Card: Hình ảnh / bằng chứng --}}
  <div class="bg-white rounded-md border border-app-line shadow-card p-4 sm:p-6 mb-6">
    <div class="flex items-center gap-2.5 mb-4">
      <i class="ri-image-line text-[#0b296c] text-xl"></i>
      <h2 class="text-[clamp(0.9375rem,4vw,1.0625rem)] font-extrabold text-[#0b296c]">HÌNH ẢNH / BẰNG CHỨNG</h2>
    </div>
    <div class="flex flex-col items-center justify-center gap-2 rounded-md border border-dashed border-app-line bg-[#FAFBFF] py-8 text-center px-4">
      <i class="ri-shield-check-line text-2xl text-app-muted"></i>
      <p class="text-[clamp(0.8125rem,3.6vw,0.875rem)] font-bold text-app-muted">Vì lý do bảo mật thông tin cá nhân, phần hình ảnh / bằng chứng không được hiển thị công khai.</p>
    </div>
  </div>

  {{-- Actions --}}
  <div class="grid grid-cols-2 gap-2.5 sm:gap-3">
    <a href="{{ route('check') }}" class="flex items-center justify-center gap-2 py-3 rounded-md font-extrabold text-[clamp(0.8125rem,3.6vw,0.875rem)] text-center bg-[#F1F2F8] text-app-muted hover:bg-[#E7E9F2] active:scale-[0.97] transition">
      <i class="ri-arrow-left-line text-base"></i>
      Quay lại
    </a>
    <a href="{{ route('check.report') }}" class="flex items-center justify-center gap-2 py-3 rounded-md font-extrabold text-[clamp(0.8125rem,3.6vw,0.875rem)] text-center text-white bg-[#e02923] shadow-[0_10px_20px_-10px_rgba(224,41,35,0.55)] hover:bg-[#c7241e] active:scale-[0.97] transition">
      <i class="ri-add-line text-base"></i>
      Báo cáo mới
    </a>
  </div>

</div>

<script>
(function() {
  var toggle = document.getElementById('history-toggle');
  var more = document.getElementById('history-more');
  if (toggle && more) {
    toggle.addEventListener('click', function() {
      var isHidden = more.classList.contains('hidden');
      more.classList.toggle('hidden', !isHidden);
      toggle.innerHTML = isHidden
        ? '<i class="ri-arrow-up-line"></i> Thu gọn'
        : '<i class="ri-arrow-down-line"></i> Xem thêm';
    });
  }
})();
</script>
</body>
</html>
