<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<meta name="theme-color" content="#5fcf86">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>Tra Cứu Hợp Đồng Thuê Xe Ô Tô - Thuê Xe Buôn Hồ</title>
<meta name="description" content="Tra cứu hợp đồng thuê xe bằng mã hợp đồng và số điện thoại.">
<meta name="robots" content="noindex, nofollow">
<meta property="og:title" content="Tra Cứu Hợp Đồng Thuê Xe Ô Tô">
<meta property="og:description" content="Tra cứu hợp đồng thuê xe bằng mã hợp đồng và số điện thoại.">
<meta property="og:image" content="{{ asset('assets/icon-tracuuhopdong/tracuuhopdong.png') }}">
<meta property="og:image:width" content="1200">
<meta property="og:image:height" content="630">
<meta property="og:url" content="{{ url()->current() }}">
<meta property="og:type" content="website">
<meta property="og:site_name" content="Thuê Xe Buôn Hồ">
<meta property="og:locale" content="vi_VN">
<meta property="og:image:type" content="image/png">
<meta property="og:image:alt" content="Tra Cứu Hợp Đồng Thuê Xe Ô Tô">
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="Tra Cứu Hợp Đồng Thuê Xe Ô Tô">
<meta name="twitter:description" content="Tra cứu hợp đồng thuê xe bằng mã hợp đồng và số điện thoại.">
<meta name="twitter:image" content="{{ asset('assets/icon-tracuuhopdong/tracuuhopdong.png') }}">
<link rel="icon" type="image/png" sizes="32x32" href="{{ asset('assets/favicon-32.png') }}">
<link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/favicon-16.png') }}">
@vite(['resources/css/app.css', 'resources/js/app.js'])
<link href="{{ asset('assets/vendor/remixicon/remixicon.css') }}" rel="stylesheet">
<link href="{{ asset('assets/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">
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
  @media print {
    .no-print, .no-print * { display: none !important; }
    body { background: #fff !important; }
    .print-block { box-shadow: none !important; border-color: #e7e5e4 !important; }
  }
</style>
</head>
<body class="min-h-screen bg-white font-sans text-app-ink antialiased">

<div class="mx-auto max-w-3xl px-4 py-6 sm:py-10">

  {{-- Quay lại --}}
  <div class="mb-6 no-print">
    <a href="{{ route('index') }}" class="inline-flex items-center gap-1.5 text-[#0b296c] font-extrabold text-sm hover:underline">
      <i class="ri-arrow-left-line"></i>
      Về trang chủ
    </a>
  </div>

  {{-- Header --}}
  <div class="flex items-center justify-center gap-3 sm:gap-5 mb-6">
    <a href="{{ route('index') }}" title="Về trang chủ" class="flex-none">
      <img
        src="{{ asset('assets/icon-tracuuhopdong/icon-logotracuu.png') }}"
        alt="Tra cứu hợp đồng thuê xe"
        class="h-16 w-16 sm:h-24 sm:w-24 flex-none object-contain"
        width="112" height="112"
      >
    </a>
    <h1 class="text-[clamp(1.25rem,6vw,2.75rem)] font-extrabold uppercase leading-tight tracking-tight text-[#052c61]">
      Tra Cứu Hợp Đồng<br>
      Thuê Xe Ô Tô
    </h1>
  </div>

  @unless(isset($contract))
  {{-- Form --}}
  <div class="bg-white rounded-md border border-app-line shadow-card p-4 sm:p-6 no-print">
    @php $prefillCode = $prefillCode ?? null; @endphp

    @if ($errors->has('lookup'))
      <div class="mb-4 rounded-md border border-[#e02923] bg-red-50 text-[#e02923] text-[13px] font-bold px-3.5 py-2.5">
        {{ $errors->first('lookup') }}
      </div>
    @endif

    @if ($prefillCode)
      <div class="mb-4 rounded-md border border-app-line bg-[#FAFBFF] text-app-ink text-[12.5px] font-semibold px-3.5 py-2.5">
        Mã hợp đồng đã được điền sẵn từ liên kết bạn nhận được. Vui lòng nhập số điện thoại để xem hợp đồng.
      </div>
    @endif

    <form method="POST" action="{{ route('contract.lookup.check') }}">
      @csrf
      <div class="mb-3">
        <label class="block text-[12.5px] font-bold text-app-ink mb-1.5" for="contract_code">Mã hợp đồng <span class="text-[#e02923]">*</span></label>
        <input id="contract_code" type="text" name="contract_code" value="{{ old('contract_code', $prefillCode ?? '') }}" placeholder="VD: HD-20260918-001" autocomplete="off" @readonly($prefillCode) class="w-full px-3.5 py-2.5 rounded-md border-[1.5px] border-app-line text-[13.5px] text-app-ink outline-none placeholder:text-app-muted/60 focus:border-app-accent focus:ring-2 focus:ring-app-accentSoft transition {{ $prefillCode ? 'bg-stone-100 text-app-muted cursor-not-allowed' : 'bg-[#FAFBFF]' }}">
        @error('contract_code') <p class="mt-1.5 text-[12px] font-bold text-[#e02923]">{{ $message }}</p> @enderror
      </div>
      <div class="mb-4">
        <label class="block text-[12.5px] font-bold text-app-ink mb-1.5" for="phone">Số điện thoại <span class="text-[#e02923]">*</span></label>
        <input id="phone" type="text" name="phone" value="{{ old('phone') }}" placeholder="VD: 0964918047" autocomplete="off" inputmode="tel" class="w-full px-3.5 py-2.5 rounded-md border-[1.5px] border-app-line bg-[#FAFBFF] text-[13.5px] text-app-ink outline-none placeholder:text-app-muted/60 focus:border-app-accent focus:ring-2 focus:ring-app-accentSoft transition">
        @error('phone') <p class="mt-1.5 text-[12px] font-bold text-[#e02923]">{{ $message }}</p> @enderror
      </div>
      <button type="submit" class="flex w-full items-center justify-center gap-2 py-3 rounded-md font-extrabold text-[15px] text-white bg-[#195cc2] hover:bg-[#164fa6] active:scale-[0.97] transition">
        <i class="ri-search-line text-base"></i>
        Tra cứu hợp đồng
      </button>
      <p class="mt-3 text-center text-[11.5px] font-semibold text-app-muted">Nhập đúng mã hợp đồng và số điện thoại đã dùng khi thuê xe.</p>
    </form>
  </div>
  @endunless

  @isset($contract)
    <div class="mt-6">
      <div class="mb-3">
        <h2 class="text-[15px] font-extrabold text-[#052c61]">Kết quả tra cứu</h2>
      </div>
      @include('partials.contract-lookup-detail')
    </div>
  @endisset

  <div class="mt-4 no-print">
    <a href="{{ route('index') }}" class="flex w-full items-center justify-center gap-2 px-4 py-2.5 rounded-md text-[14px] font-bold text-[#0b296c] bg-white border-[1.5px] border-[#0b296c] hover:bg-[#0b296c] hover:text-white active:scale-[0.97] transition">
      <i class="ri-home-4-line"></i>
      Về trang chủ
    </a>
  </div>

</div>

@include('partials.contract-lookup-lightbox')

</body>
</html>
