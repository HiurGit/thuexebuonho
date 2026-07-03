@extends('layouts.app')

@section('title', ($car->name ?? 'Chi tiết xe') . ' - Thuê Xe Buôn Hồ')

@php
$mainImage = $car->mainImage?->path ?? $car->images->first()?->path;
$allImages = $car->images;
@endphp

@section('meta')
<meta name="description" content="Thuê {{ $car->name }} tại Buôn Hồ, Đăk Lăk. Giá rẻ, uy tín, thủ tục nhanh gọn.">
<meta property="og:title" content="{{ $car->name }} - Thuê Xe Buôn Hồ">
<meta property="og:description" content="Thuê {{ $car->name }} tại Buôn Hồ, Đăk Lăk. Giá rẻ, uy tín, thủ tục nhanh gọn.">
<meta property="og:image" content="{{ asset($mainImage ?? 'assets/image/bannerMXH.jpg') }}">
<meta property="og:image:width" content="1200">
<meta property="og:image:height" content="630">
<meta property="og:url" content="{{ url()->current() }}">
<meta property="og:type" content="website">
<meta property="og:site_name" content="Thuê Xe Buôn Hồ">
<meta property="og:locale" content="vi_VN">
<meta property="og:image:type" content="image/jpeg">
<meta property="og:image:alt" content="{{ $car->name }} - Thuê Xe Buôn Hồ">
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="{{ $car->name }} - Thuê Xe Buôn Hồ">
<meta name="twitter:description" content="Thuê {{ $car->name }} tại Buôn Hồ, Đăk Lăk. Giá rẻ, uy tín, thủ tục nhanh gọn.">
<meta name="twitter:image" content="{{ asset($mainImage ?? 'assets/image/bannerMXH.jpg') }}">
@endsection

@section('content-desktop')
<main>
  <div class="w-full border-b border-app-line bg-app-accent">
    <a href="{{ route('index') }}#danh-sach-xe" class="mx-auto flex max-w-7xl items-center gap-2 px-6 py-3.5 text-base font-extrabold text-white transition-all hover:bg-app-green">
      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5 text-white">
        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
      </svg> Quay lại danh sách
    </a>
  </div>
  <div class="mx-auto max-w-7xl px-6 py-8">
    <div class="grid grid-cols-1 gap-8 lg:grid-cols-2">
      <div>
        <div class="mb-4 flex items-center justify-between">
          <h1 class="text-2xl font-extrabold">{{ $car->name }}</h1>
          <button class="flex h-10 w-10 items-center justify-center rounded-xl bg-stone-100 text-app-muted transition-all hover:bg-app-accentSoft hover:text-app-accent">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5">
              <path stroke-linecap="round" stroke-linejoin="round" d="M7.217 10.907a2.25 2.25 0 1 0 0 2.186m0-2.186c.18.324.283.696.283 1.093s-.103.77-.283 1.093m0-2.186 9.566-5.314m-9.566 7.5 9.566 5.314m0 0a2.25 2.25 0 1 0 3.935 2.186 2.25 2.25 0 0 0-3.935-2.186Zm0-12.814a2.25 2.25 0 1 0 3.933-2.185 2.25 2.25 0 0 0-3.933 2.185Z" />
            </svg>
          </button>
        </div>
        <div id="car-gallery-area">
          <div class="overflow-hidden rounded-2xl bg-white shadow-card">
            <img loading="lazy" src="{{ asset($mainImage) }}" alt="{{ $car->name }}" class="aspect-[8/5] w-full cursor-pointer object-cover">
          </div>
          @if($allImages->count() > 1)
          <div class="mt-2 grid grid-cols-3 gap-2">
            @foreach($allImages as $img)
            <img loading="lazy" src="{{ asset($img->path) }}" alt="{{ $car->name }}" class="aspect-[4/3] w-full cursor-pointer rounded-xl object-cover">
            @endforeach
          </div>
          @endif
        </div>
      </div>
      <div>
        <div class="sticky top-24 rounded-2xl border border-app-line bg-white p-4 shadow-card">
          <h2 class="text-base font-extrabold">Đặt lịch thuê xe</h2>
          <div class="mt-3">
            <div class="tab-container grid grid-cols-3 gap-1 overflow-hidden rounded-xl bg-[#f4f4f3] p-1 text-center text-[11px] font-extrabold">
              <button data-tab="one-day" class="banner-tab rounded-lg bg-app-accent px-1.5 py-2 text-white transition-all">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="mx-auto mb-0.5 h-4 w-4">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
                </svg> Thuê 1 ngày
              </button>
              <button data-tab="multi-day" class="banner-tab rounded-lg bg-white px-1.5 py-2 text-app-muted transition-all">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="mx-auto mb-0.5 h-4 w-4">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5m-9-6h.008v.008H12v-.008ZM12 15h.008v.008H12V15Zm0 2.25h.008v.008H12v-.008ZM9.75 15h.008v.008H9.75V15Zm0 2.25h.008v.008H9.75v-.008ZM7.5 15h.008v.008H7.5V15Zm0 2.25h.008v.008H7.5v-.008Zm6.75-4.5h.008v.008h-.008v-.008Zm0 2.25h.008v.008h-.008V15Zm0 2.25h.008v.008h-.008v-.008Zm2.25-4.5h.008v.008H16.5v-.008Zm0 2.25h.008v.008H16.5V15Z" />
                </svg> Nhiều ngày
              </button>
              <button data-tab="hourly" class="banner-tab rounded-lg bg-white px-1.5 py-2 text-app-muted transition-all">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="mx-auto mb-0.5 h-4 w-4">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                </svg> Theo buổi
              </button>
            </div>
            <div class="mt-3 space-y-2">
              <div id="panel-one-day" class="booking-panel space-y-2">
                <label data-phone-field class="block w-full rounded-xl border border-[#d9e1e7] bg-white px-3 py-2.5">
                  <p class="text-[11px] font-bold text-[#a1a1aa]">Số điện thoại</p>
                  <div class="mt-1 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-4 w-4 text-app-accent">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 1.5H8.25A2.25 2.25 0 0 0 6 3.75v16.5a2.25 2.25 0 0 0 2.25 2.25h7.5A2.25 2.25 0 0 0 18 20.25V3.75a2.25 2.25 0 0 0-2.25-2.25H13.5m-3 0V3h3V1.5m-3 0h3m-3 18.75h3" />
                    </svg>
                    <input data-phone-input type="tel" inputmode="numeric" maxlength="10" autocomplete="tel-national" pattern="0[0-9]{9}" placeholder="Nhập số điện thoại của bạn" class="w-full border-0 bg-transparent p-0 text-[13px] font-semibold text-slate-700 outline-none placeholder:font-medium placeholder:text-slate-400">
                  </div>
                  <p data-phone-error class="mt-1 hidden text-[11px] font-semibold text-red-500" aria-live="polite"></p>
                </label>
                <button type="button" data-open-date="one-day" class="w-full rounded-xl border border-[#d9e1e7] bg-white px-3 py-2.5 text-left">
                  <p class="text-[11px] font-bold text-[#a1a1aa]">Thời gian thuê</p>
                  <p id="one-day-date-title" data-date-text class="mt-1 text-[13px] font-semibold text-slate-700">Từ 06:00, 27/06/2026 <br> Đến 22:00, 27/06/2026</p>
                </button>
                <div class="space-y-1">
                  <p class="text-[11px] font-bold text-[#a1a1aa]">Hình thức nhận xe</p>
                  <div class="grid grid-cols-2 gap-2">
                    <button type="button" class="pickup-option pickup-shop rounded-xl border-2 border-app-accent bg-green-50 px-2 py-1.5 text-center transition-all">
                      <img loading="lazy" src="{{ asset('assets/image/nhantaishop.png') }}" class="mx-auto block h-12 w-12 rounded-lg object-contain">
                      <p class="mt-0.5 text-[11px] font-bold text-app-accent">Nhận tại shop</p>
                      <p class="text-[10px] text-slate-400">{{ $car->address }}</p>
                    </button>
                    <button type="button" class="pickup-option pickup-delivery rounded-xl border-2 border-[#d9e1e7] bg-white px-2 py-1.5 text-center transition-all">
                      <img loading="lazy" src="{{ asset('assets/image/giaotannoi.png') }}" class="mx-auto block h-12 w-12 rounded-lg object-contain">
                      <p class="mt-0.5 text-[11px] font-bold text-slate-500">Giao xe tận nơi</p>
                      <p class="text-[10px] text-slate-400">10k / km</p>
                    </button>
                  </div>
                </div>
                <p class="text-[11px] font-semibold leading-relaxed text-app-muted">Bạn cần điền SĐT và chọn ngày muốn thuê. Chúng tôi sẽ liên hệ tư vấn xe và giá cho bạn.</p>
              </div>
              <div id="panel-multi-day" class="booking-panel hidden space-y-2">
                <label data-phone-field class="block w-full rounded-xl border border-[#d9e1e7] bg-white px-3 py-2.5">
                  <p class="text-[11px] font-bold text-[#a1a1aa]">Số điện thoại</p>
                  <div class="mt-1 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-4 w-4 text-app-accent">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 1.5H8.25A2.25 2.25 0 0 0 6 3.75v16.5a2.25 2.25 0 0 0 2.25 2.25h7.5A2.25 2.25 0 0 0 18 20.25V3.75a2.25 2.25 0 0 0-2.25-2.25H13.5m-3 0V3h3V1.5m-3 0h3m-3 18.75h3" />
                    </svg>
                    <input data-phone-input type="tel" inputmode="numeric" maxlength="10" autocomplete="tel-national" pattern="0[0-9]{9}" placeholder="Nhập số điện thoại của bạn" class="w-full border-0 bg-transparent p-0 text-[13px] font-semibold text-slate-700 outline-none placeholder:font-medium placeholder:text-slate-400">
                  </div>
                  <p data-phone-error class="mt-1 hidden text-[11px] font-semibold text-red-500" aria-live="polite"></p>
                </label>
                <button type="button" data-open-date="multi-range" class="w-full rounded-xl border border-[#d9e1e7] bg-white px-3 py-2.5 text-left">
                  <p class="text-[11px] font-bold text-[#a1a1aa]">Thời gian thuê</p>
                  <p id="multi-range-title" data-date-text class="mt-1 text-[13px] font-semibold text-slate-700">Từ 06:00, 27/06/2026 <br> Đến 22:00, 29/06/2026</p>
                </button>
                <div class="space-y-1">
                  <p class="text-[11px] font-bold text-[#a1a1aa]">Hình thức nhận xe</p>
                  <div class="grid grid-cols-2 gap-2">
                    <button type="button" class="pickup-option pickup-shop rounded-xl border-2 border-app-accent bg-green-50 px-2 py-1.5 text-center transition-all">
                      <img loading="lazy" src="{{ asset('assets/image/nhantaishop.png') }}" class="mx-auto block h-12 w-12 rounded-lg object-contain">
                      <p class="mt-0.5 text-[11px] font-bold text-app-accent">Nhận tại shop</p>
                      <p class="text-[10px] text-slate-400">{{ $car->address }}</p>
                    </button>
                    <button type="button" class="pickup-option pickup-delivery rounded-xl border-2 border-[#d9e1e7] bg-white px-2 py-1.5 text-center transition-all">
                      <img loading="lazy" src="{{ asset('assets/image/giaotannoi.png') }}" class="mx-auto block h-12 w-12 rounded-lg object-contain">
                      <p class="mt-0.5 text-[11px] font-bold text-slate-500">Giao xe tận nơi</p>
                      <p class="text-[10px] text-slate-400">10k / km</p>
                    </button>
                  </div>
                </div>
                <p class="text-[11px] font-semibold leading-relaxed text-app-muted">Bạn cần điền SĐT và chọn ngày muốn thuê. Chúng tôi sẽ liên hệ tư vấn xe và giá cho bạn.</p>
              </div>
              <div id="panel-hourly" class="booking-panel hidden space-y-2">
                <label data-phone-field class="block w-full rounded-xl border border-[#d9e1e7] bg-white px-3 py-2.5">
                  <p class="text-[11px] font-bold text-[#a1a1aa]">Số điện thoại</p>
                  <div class="mt-1 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-4 w-4 text-app-accent">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 1.5H8.25A2.25 2.25 0 0 0 6 3.75v16.5a2.25 2.25 0 0 0 2.25 2.25h7.5A2.25 2.25 0 0 0 18 20.25V3.75a2.25 2.25 0 0 0-2.25-2.25H13.5m-3 0V3h3V1.5m-3 0h3m-3 18.75h3" />
                    </svg>
                    <input data-phone-input type="tel" inputmode="numeric" maxlength="10" autocomplete="tel-national" pattern="0[0-9]{9}" placeholder="Nhập số điện thoại của bạn" class="w-full border-0 bg-transparent p-0 text-[13px] font-semibold text-slate-700 outline-none placeholder:font-medium placeholder:text-slate-400">
                  </div>
                  <p data-phone-error class="mt-1 hidden text-[11px] font-semibold text-red-500" aria-live="polite"></p>
                </label>
                <button type="button" data-open-date="hourly" class="w-full rounded-xl border border-[#d9e1e7] bg-white px-3 py-2.5 text-left">
                  <p class="text-[11px] font-bold text-[#a1a1aa]">Thời gian thuê</p>
                  <p id="hourly-date-title" data-date-text class="mt-1 text-[13px] font-semibold text-slate-700">Sáng (6h-12h), 27/06/2026</p>
                </button>
                <div class="space-y-1">
                  <p class="text-[11px] font-bold text-[#a1a1aa]">Hình thức nhận xe</p>
                  <div class="grid grid-cols-2 gap-2">
                    <button type="button" class="pickup-option pickup-shop rounded-xl border-2 border-app-accent bg-green-50 px-2 py-1.5 text-center transition-all">
                      <img loading="lazy" src="{{ asset('assets/image/nhantaishop.png') }}" class="mx-auto block h-12 w-12 rounded-lg object-contain">
                      <p class="mt-0.5 text-[11px] font-bold text-app-accent">Nhận tại shop</p>
                      <p class="text-[10px] text-slate-400">{{ $car->address }}</p>
                    </button>
                    <button type="button" class="pickup-option pickup-delivery rounded-xl border-2 border-[#d9e1e7] bg-white px-2 py-1.5 text-center transition-all">
                      <img loading="lazy" src="{{ asset('assets/image/giaotannoi.png') }}" class="mx-auto block h-12 w-12 rounded-lg object-contain">
                      <p class="mt-0.5 text-[11px] font-bold text-slate-500">Giao xe tận nơi</p>
                      <p class="text-[10px] text-slate-400">10k / km</p>
                    </button>
                  </div>
                </div>
                <p class="text-[11px] font-semibold leading-relaxed text-app-muted">Bạn cần điền SĐT và chọn ngày muốn thuê. Chúng tôi sẽ liên hệ tư vấn xe và giá cho bạn.</p>
              </div>
            </div>
            <div class="mt-3 flex items-center justify-between rounded-xl bg-app-accentSoft px-3 py-2.5">
              <div>
                <p class="text-[11px] font-bold text-app-muted">Tổng giá thuê</p>
                <p id="form-duration" class="text-xs font-bold text-app-ink">1 ngày</p>
              </div>
              <p id="form-total" class="text-base font-extrabold text-app-accent">{{ number_format($car->price_per_day) }}đ</p>
            </div>
            <button id="btn-thue-ngay" data-car-price-day="{{ $car->price_per_day }}" data-car-price-session="{{ $car->price_per_session }}" data-car-price-multi-day="{{ $car->price_multi_day }}" onclick="openConfirmModal()" class="mt-2 w-full rounded-xl bg-app-accent px-4 py-2.5 text-xs font-extrabold uppercase tracking-wide text-white shadow-sm transition-all hover:bg-app-green">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="mr-1 inline-block h-4 w-4">
                <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 18.75a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 0 1-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124a17.902 17.902 0 0 0-3.213-9.193 2.056 2.056 0 0 0-1.58-.86H14.25M16.5 18.75h-2.25m0-11.177v-.958c0-.568-.422-1.048-.987-1.106a48.554 48.554 0 0 0-10.026 0 1.106 1.106 0 0 0-.987 1.106v7.635m12-6.677v6.677m0 4.5v-4.5m0 0h-12" />
              </svg> Thuê ngay
            </button>
            <div class="mt-2 flex items-center gap-2 rounded-xl bg-amber-50 px-3 py-2.5">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-4 w-4 text-amber-500">
                <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 8.511c.884.284 1.5 1.128 1.5 2.097v4.286c0 1.136-.847 2.1-1.98 2.193-.34.027-.68.052-1.02.072v3.091l-3-3c-1.354 0-2.694-.055-4.02-.163a2.115 2.115 0 0 1-.825-.242m9.345-8.334a2.126 2.126 0 0 0-.476-.095 48.64 48.64 0 0 0-8.048 0c-1.131.094-1.976 1.057-1.976 2.192v4.286c0 .837.46 1.58 1.155 1.951m9.345-8.334V6.637c0-1.621-1.152-3.026-2.76-3.235A48.455 48.455 0 0 0 11.25 3c-2.115 0-4.198.137-6.24.402-1.608.209-2.76 1.614-2.76 3.235v6.226c0 1.621 1.152 3.026 2.76 3.235.577.075 1.157.14 1.74.194V21l4.155-4.155" />
              </svg>
              <p class="text-[11px] font-semibold text-amber-700">Hotline / Zalo <span class="font-extrabold">0964.918.047</span> - Tư vấn miễn phí 24/7</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="mx-auto max-w-7xl space-y-8 px-6 pb-12">
    <section>
      <h2 class="section-title text-lg font-extrabold">Thông số kỹ thuật</h2>
      <div class="mt-4 grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
        <div class="flex items-center gap-4 rounded-2xl bg-white p-5 shadow-sm">
          <img loading="lazy" src="{{ asset('assets/icon-chungtoi/icon-baohiem.png') }}" class="h-14 w-14 shrink-0 rounded-xl object-contain">
          <div><p class="text-xs font-bold text-app-muted">Bảo hiểm</p><p class="mt-0.5 text-base font-extrabold">{{ $car->insurance }}</p></div>
        </div>
        <div class="flex items-center gap-4 rounded-2xl bg-white p-5 shadow-sm">
          <img loading="lazy" src="{{ asset('assets/icon-thongso/icon-namsanxuat.png') }}" class="h-14 w-14 shrink-0 rounded-xl object-contain">
          <div><p class="text-xs font-bold text-app-muted">Năm sản xuất</p><p class="mt-0.5 text-base font-extrabold">{{ $car->year }}</p></div>
        </div>
        <div class="flex items-center gap-4 rounded-2xl bg-white p-5 shadow-sm">
          <img loading="lazy" src="{{ asset('assets/icon-thongso/icon-chôngi.png') }}" class="h-14 w-14 shrink-0 rounded-xl object-contain">
          <div><p class="text-xs font-bold text-app-muted">Số chỗ</p><p class="mt-0.5 text-base font-extrabold">{{ $car->seats }} chỗ</p></div>
        </div>
        <div class="flex items-center gap-4 rounded-2xl bg-white p-5 shadow-sm">
          <img loading="lazy" src="{{ asset('assets/icon-thongso/icon-hopho.png') }}" class="h-14 w-14 shrink-0 rounded-xl object-contain">
          <div><p class="text-xs font-bold text-app-muted">Hộp số</p><p class="mt-0.5 text-base font-extrabold">{{ $car->transmission }}</p></div>
        </div>
        <div class="flex items-center gap-4 rounded-2xl bg-white p-5 shadow-sm">
          <img loading="lazy" src="{{ asset('assets/icon-thongso/icon-nhienlieu.png') }}" class="h-14 w-14 shrink-0 rounded-xl object-contain">
          <div><p class="text-xs font-bold text-app-muted">Nhiên liệu</p><p class="mt-0.5 text-base font-extrabold">{{ $car->fuel }}</p></div>
        </div>
        <div class="flex items-center gap-4 rounded-2xl bg-white p-5 shadow-sm">
          <img loading="lazy" src="{{ asset('assets/icon-thongso/icon-tieuhao.png') }}" class="h-14 w-14 shrink-0 rounded-xl object-contain">
          <div><p class="text-xs font-bold text-app-muted">Tiêu hao</p><p class="mt-0.5 text-base font-extrabold">{{ $car->fuel_consumption }}</p></div>
        </div>
      </div>
    </section>
    <section>
      <h2 class="section-title text-lg font-extrabold">Giấy tờ thuê xe</h2>
      <div class="mt-4 grid grid-cols-1 gap-3 sm:grid-cols-2">
        <div class="flex items-center gap-4 rounded-2xl border border-app-line bg-white px-5 py-4 shadow-sm">
          <img loading="lazy" src="{{ asset('assets/icon-giayto/icon-CCCD.png') }}" class="h-14 w-20 shrink-0 rounded-lg">
          <div><p class="text-sm font-bold">Căn cước công dân (CCCD)</p><p class="mt-0.5 text-xs text-app-muted">Bản cứng hoặc mềm VNeID mức 2 đều được</p></div>
        </div>
        <div class="flex items-center gap-4 rounded-2xl border border-app-line bg-white px-5 py-4 shadow-sm">
          <img loading="lazy" src="{{ asset('assets/icon-giayto/icon-GPLX.png') }}" class="h-14 w-20 shrink-0 rounded-lg">
          <div><p class="text-sm font-bold">Giấy phép lái xe (GPLX)</p><p class="mt-0.5 text-xs text-app-muted">Bản cứng hoặc mềm VNeID mức 2 đều được</p></div>
        </div>
        <div class="flex items-center gap-4 rounded-2xl border border-app-line bg-white px-5 py-4 shadow-sm sm:col-span-2">
          <img loading="lazy" src="{{ asset('assets/icon-giayto/icon-diemGPLX.png') }}" class="h-14 w-20 shrink-0 rounded-lg">
          <div><p class="text-sm font-bold">GPLX còn điểm trên VNeTraffic</p><p class="mt-0.5 text-xs text-app-muted">Yêu cầu GPLX còn hiệu lực và đủ điểm theo quy định</p></div>
        </div>
      </div>
    </section>
    <section>
      <h2 class="section-title text-lg font-extrabold">Địa chỉ cửa hàng</h2>
      <div class="mt-4 flex items-center gap-4 rounded-2xl bg-white p-5 shadow-sm">
        <img loading="lazy" src="{{ asset('assets/image/icon-thuexe.png') }}" class="h-20 w-24 shrink-0 rounded-xl object-contain">
        <div><p class="text-xs font-bold text-app-muted">Địa chỉ nhận xe</p><p class="mt-0.5 text-lg font-extrabold">{{ $car->address }}</p></div>
      </div>
    </section>
    <section>
      <h2 class="section-title text-lg font-extrabold">Cọc và thế chấp</h2>
      <div class="mt-4 space-y-3">
        <div class="flex items-center gap-4 rounded-2xl border border-app-line bg-white px-5 py-4 shadow-sm">
          <img loading="lazy" src="{{ asset('assets/icon-cocvathechap/icon-coctien.png') }}" class="h-16 w-16 shrink-0 rounded-xl">
          <div><p class="text-sm font-bold">Tiền cọc giữ slot xe</p><p class="mt-0.5 text-xs text-app-muted">{{ number_format($car->deposit_min) }}đ - {{ number_format($car->deposit_max) }}đ (tuỳ xe, tuỳ thời gian)</p></div>
        </div>
        <div class="flex items-center gap-4 rounded-2xl border border-app-line bg-white px-5 py-4 shadow-sm">
          <img loading="lazy" src="{{ asset('assets/icon-cocvathechap/icon-xethechap.png') }}" class="h-16 w-16 shrink-0 rounded-xl">
          <div><p class="text-sm font-bold">Thuê xe có thế chấp</p><p class="mt-0.5 text-xs text-app-muted">Người thuê cần chuẩn bị: Tiền {{ number_format($car->deposit_asset) }}đ hoặc Xe máy tương đương {{ number_format($car->deposit_asset) }}đ giấy tờ chính chủ</p></div>
        </div>
      </div>
    </section>
    <section>
      <h2 class="section-title text-lg font-extrabold">Mô tả</h2>
      <div class="mt-4 rounded-2xl border border-app-line bg-stone-50 p-6">
        <p class="text-sm leading-7 text-app-muted">{{ $car->description }}</p>
      </div>
    </section>
    <section>
      <h2 class="section-title text-lg font-extrabold">Bảng giá thuê</h2>
      <div class="mt-4 grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
        <div class="flex flex-col items-center gap-3 rounded-2xl border border-app-line bg-white p-5 text-center shadow-sm">
          <img loading="lazy" src="{{ asset('assets/icon-thuexe/thue-1gio.png') }}" class="h-16 w-16 shrink-0 rounded-xl object-contain">
          <p class="text-sm font-bold">Theo buổi</p>
          <p class="text-lg font-extrabold text-app-accent">{{ number_format($car->price_per_session) }}đ <span class="text-xs font-semibold text-app-muted">/ buổi</span></p>
        </div>
        <div class="flex flex-col items-center gap-3 rounded-2xl border-2 border-app-accent bg-white p-5 text-center shadow-sm">
          <img loading="lazy" src="{{ asset('assets/icon-thuexe/thue-1ngay.png') }}" class="h-16 w-16 shrink-0 rounded-xl object-contain">
          <p class="text-sm font-bold">1 ngày <span class="ml-1 inline-block rounded-full bg-app-accentSoft px-2 py-0.5 text-[10px] font-extrabold text-app-accent">Phổ biến</span></p>
          <p class="text-lg font-extrabold text-app-accent">{{ number_format($car->price_per_day) }}đ <span class="text-xs font-semibold text-app-muted">/ ngày</span></p>
          <p class="text-xs text-app-muted">Trong tỉnh Đăk Lăk</p>
        </div>
        <div class="flex flex-col items-center gap-3 rounded-2xl border border-app-line bg-white p-5 text-center shadow-sm">
          <img loading="lazy" src="{{ asset('assets/icon-thuexe/thue-nhieungay.png') }}" class="h-16 w-16 shrink-0 rounded-xl object-contain">
          <p class="text-sm font-bold">3 ngày trở lên</p>
          @php $multiDayDiscount = $car->price_per_day - $car->price_multi_day; @endphp
          <p class="text-lg font-extrabold">{{ number_format($car->price_multi_day) }}đ <span class="text-xs font-semibold text-app-muted">/ ngày</span></p>
          <p class="text-xs text-app-muted">Giảm {{ number_format($multiDayDiscount) }}đ/ngày</p>
        </div>
        <div class="flex flex-col items-center gap-3 rounded-2xl border border-dashed border-app-line bg-white p-5 text-center shadow-sm">
          <img loading="lazy" src="{{ asset('assets/icon-thuexe/thue-ngoaitinh.png') }}" class="h-16 w-16 shrink-0 rounded-xl object-contain">
          <p class="text-sm font-bold">Phụ phí ra tỉnh</p>
          <p class="text-lg font-extrabold">+{{ number_format($car->price_out_province) }}đ <span class="text-xs font-semibold text-app-muted">/ ngày</span></p>
          <p class="text-xs text-app-muted">Đi liên tỉnh</p>
        </div>
      </div>
    </section>
    <section>
      <h2 class="section-title text-lg font-extrabold">Tiện ích đi kèm</h2>
      <div class="mt-4 grid grid-cols-2 gap-3 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5">
        @forelse($car->amenities as $amenity)
        <div class="flex flex-col items-center gap-2 rounded-2xl bg-stone-50 px-3 py-4 text-center transition-all hover:shadow-sm">
          <div class="flex h-12 w-12 items-center justify-center rounded-full bg-app-accentSoft">
            @if($amenity->icon)
            <img loading="lazy" src="{{ asset(\Illuminate\Support\Str::startsWith($amenity->icon, 'storage/') ? $amenity->icon : 'assets/' . ltrim($amenity->icon, '/')) }}" alt="{{ $amenity->name }}" class="h-10 w-10 object-contain">
            @else
            <span class="text-base font-extrabold text-app-accent">{{ substr($amenity->name, 0, 1) }}</span>
            @endif
          </div>
          <span class="text-xs font-bold text-app-muted">{{ $amenity->name }}</span>
        </div>
        @empty
        <div class="col-span-full text-center text-sm font-bold text-app-muted">Chưa có tiện ích</div>
        @endforelse
      </div>
    </section>
    <section>
      <h2 class="section-title text-lg font-extrabold">Phụ phí có thể phát sinh</h2>
      <div class="mt-4 grid grid-cols-1 gap-4 sm:grid-cols-2">
        <div class="flex items-center gap-4 rounded-2xl border border-app-line bg-white p-5 shadow-sm">
          <img loading="lazy" src="{{ asset('assets/svg-phuthuphatsinh/phi-cauduong.png') }}" class="h-16 w-16 shrink-0 rounded-xl object-contain">
          <div><p class="text-sm font-bold">Phí cầu đường</p><p class="mt-1 text-xs leading-5 text-app-muted">Chủ xe có thể yêu cầu thanh toán các khoản lệ phí cầu đường phát sinh trên tài khoản VETC trong thời gian thuê xe.</p></div>
        </div>
        <div class="flex items-center gap-4 rounded-2xl border border-app-line bg-white p-5 shadow-sm">
          <img loading="lazy" src="{{ asset('assets/svg-phuthuphatsinh/phi-nhienlieu.png') }}" class="h-16 w-16 shrink-0 rounded-xl object-contain">
          <div><p class="text-sm font-bold">Phụ thu nhiên liệu</p><p class="mt-1 text-xs leading-5 text-app-muted">Chủ xe chỉ thu khi vạch xăng thấp hơn lúc nhận xe. Trả lại đúng vạch xăng như lúc nhận để không phải trả phí này.</p></div>
        </div>
        <div class="flex items-center gap-4 rounded-2xl border border-app-line bg-white p-5 shadow-sm">
          <img loading="lazy" src="{{ asset('assets/svg-phuthuphatsinh/phi-quagio.png') }}" class="h-16 w-16 shrink-0 rounded-xl object-contain">
          <div class="flex-1"><p class="text-sm font-bold">Phí trả trễ</p><p class="mt-1 text-xs leading-5 text-app-muted">Áp dụng khi trả xe trễ hơn giờ đã thỏa thuận.</p></div>
          <p class="shrink-0 text-lg font-extrabold text-app-accent">100.000đ <span class="text-xs font-semibold text-app-muted">/ giờ</span></p>
        </div>
        <div class="flex items-center gap-4 rounded-2xl border border-app-line bg-white p-5 shadow-sm">
          <img loading="lazy" src="{{ asset('assets/svg-phuthuphatsinh/phi-vesinh.png') }}" class="h-16 w-16 shrink-0 rounded-xl object-contain">
          <div class="flex-1"><p class="text-sm font-bold">Phí nặng mùi hôi - thuốc lá</p><p class="mt-1 text-xs leading-5 text-app-muted">Chủ xe sẽ dựa vào tình trạng vệ sinh xe lúc khách hàng trả xe để thu phí.</p></div>
          <p class="shrink-0 text-lg font-extrabold text-app-accent">250.000đ</p>
        </div>
      </div>
    </section>
    <section>
      <h2 class="section-title text-lg font-extrabold">Quy định sử dụng xe</h2>
      <div class="mt-4 rounded-2xl border border-app-line bg-stone-50 p-6 text-sm leading-7 text-app-muted">
        <ul class="list-inside list-disc space-y-1">
          <li>Sử dụng xe đúng mục đích.</li>
          <li>Không sử dụng xe thuê vào mục đích phi pháp, trái pháp luật.</li>
          <li>Chỉ người đăng ký thuê mới được lái xe.</li>
          <li>Không cho thuê lại xe dưới mọi hình thức.</li>
          <li>Không chở quá số người quy định của xe.</li>
          <li>Không lái xe khi đã sử dụng rượu bia hoặc chất kích thích.</li>
          <li>Tuân thủ Luật Giao thông đường bộ.</li>
          <li>Không sử dụng xe thuê để cầm cố, thế chấp.</li>
          <li>Không hút thuốc, nhả kẹo cao su, phải giữ vệ sinh trong xe.</li>
          <li>Không chở hàng quốc cấm, dễ cháy nổ.</li>
          <li>Không chở hoa quả, thực phẩm nặng mùi trong xe.</li>
          <li>Khi trả xe, nếu xe bẩn hoặc có mùi trong xe, khách hàng vui lòng vệ sinh xe sạch sẽ hoặc gửi phụ thu phí vệ sinh xe.</li>
        </ul>
        <p class="mt-3 font-bold text-app-ink">Trân trọng cảm ơn, chúc quý khách có chuyến đi tuyệt vời!</p>
        <a href="{{ route('terms') }}" class="mt-4 flex items-center justify-center gap-2 rounded-xl border-2 border-app-accent py-3 text-sm font-extrabold text-app-accent transition-all hover:bg-app-accentSoft">
          Xem đầy đủ Điều khoản &amp; Chính sách thuê xe
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="mr-1 inline-block h-4 w-4">
            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
          </svg>
        </a>
      </div>
    </section>
    <section>
      <h2 class="section-title text-lg font-extrabold">Chính sách huỷ cọc</h2>
      <div class="mt-4 overflow-hidden rounded-2xl border border-app-line shadow-sm">
        <table class="w-full text-sm">
          <thead>
            <tr class="bg-app-accent text-white">
              <th class="px-5 py-3 text-left font-bold">Chính sách</th>
              <th class="px-5 py-3 text-center font-bold">Ngày thường</th>
              <th class="px-5 py-3 text-center font-bold">Ngày Lễ, Tết</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-app-line">
            <tr class="bg-white">
              <td class="px-5 py-3 font-semibold text-app-ink"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="mr-1 inline-block h-4 w-4 text-app-accent"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" /></svg> Hoàn 100% tiền giữ chỗ</td>
              <td class="px-5 py-3 text-center text-app-muted">Trước chuyến đi &gt; 10 ngày</td>
              <td class="px-5 py-3 text-center text-app-muted">Không áp dụng</td>
            </tr>
            <tr class="bg-stone-50">
              <td class="px-5 py-3 font-semibold text-app-ink"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="mr-1 inline-block h-4 w-4 text-app-accent"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" /></svg> Hoàn 30% tiền giữ chỗ</td>
              <td class="px-5 py-3 text-center text-app-muted">Trước chuyến đi &gt; 5 ngày</td>
              <td class="px-5 py-3 text-center text-app-muted">Trước chuyến đi &gt; 30 ngày</td>
            </tr>
            <tr class="bg-white">
              <td class="px-5 py-3 font-semibold text-app-ink"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="mr-1 inline-block h-4 w-4 text-red-500"><path stroke-linecap="round" stroke-linejoin="round" d="m9.75 9.75 4.5 4.5m0-4.5-4.5 4.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" /></svg> Không hoàn tiền giữ chỗ</td>
              <td class="px-5 py-3 text-center text-app-muted">Trong vòng 5 ngày trước chuyến đi</td>
              <td class="px-5 py-3 text-center text-app-muted">Trong vòng 30 ngày trước chuyến đi</td>
            </tr>
          </tbody>
        </table>
      </div>
    </section>
  </div>
</main>
@endsection

@section('content-mobile')
<div class="border-b border-app-line bg-white px-4 py-1 shadow-sm">
  <div class="relative flex items-center">
    <a href="{{ route('index') }}" class="flex h-9 w-9 items-center justify-center rounded-xl bg-app-accentSoft text-app-accent transition-all hover:bg-app-accent hover:text-white">
      <i class="ri-arrow-left-s-line text-lg"></i>
    </a>
    <h1 class="absolute left-1/2 -translate-x-1/2 text-lg font-extrabold">{{ $car->name }}</h1>
    <div class="ml-auto">
      <button class="flex h-9 w-9 items-center justify-center rounded-xl bg-stone-100 text-app-muted transition-all hover:bg-app-accentSoft hover:text-app-accent">
        <i class="ri-share-line text-base"></i>
      </button>
    </div>
  </div>
</div>

<main class="flex-1 overflow-y-auto pb-20" style="scroll-behavior: smooth">

  <section class="bg-white">
    <div class="swiper car-gallery-swiper bg-white">
      <div class="swiper-wrapper">
        @forelse($allImages as $img)
        <div class="swiper-slide">
          <img loading="lazy" src="{{ asset($img->path) }}" alt="{{ $car->name }}" class="block aspect-[4/3] w-full object-cover">
        </div>
        @empty
          @if($mainImage)
          <div class="swiper-slide">
            <img loading="lazy" src="{{ asset($mainImage) }}" alt="{{ $car->name }}" class="block aspect-[4/3] w-full object-cover">
          </div>
          @else
          <div class="swiper-slide">
            <div class="flex aspect-[4/3] w-full items-center justify-center bg-stone-200 text-sm font-bold text-app-muted">{{ $car->name }}</div>
          </div>
          @endif
        @endforelse
      </div>
      <div class="swiper-pagination car-gallery-pagination"></div>
    </div>

  </section>

  <section class="bg-white px-4 py-3">
    <h2 class="section-title text-base font-extrabold">Đặt lịch thuê xe</h2>
    <div class="mt-4 rounded-[12px] border border-app-line bg-white shadow-sm">
      <div class="tab-container grid grid-cols-3 gap-0 overflow-hidden rounded-t-[12px] bg-[#f4f4f3] text-center text-[11px] font-extrabold">
        <button data-tab="one-day" class="banner-tab whitespace-nowrap rounded-none bg-app-accent px-1 py-1.5 text-white">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="mx-auto mb-0.5 h-5 w-5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
          </svg> Thuê 1 ngày
        </button>
        <button data-tab="multi-day" class="banner-tab whitespace-nowrap rounded-none border-x border-[#e5e5e3] bg-white px-1 py-1.5 text-app-muted">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="mx-auto mb-0.5 h-5 w-5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5m-9-6h.008v.008H12v-.008ZM12 15h.008v.008H12V15Zm0 2.25h.008v.008H12v-.008ZM9.75 15h.008v.008H9.75V15Zm0 2.25h.008v.008H9.75v-.008ZM7.5 15h.008v.008H7.5V15Zm0 2.25h.008v.008H7.5v-.008Zm6.75-4.5h.008v.008h-.008v-.008Zm0 2.25h.008v.008h-.008V15Zm0 2.25h.008v.008h-.008v-.008Zm2.25-4.5h.008v.008H16.5v-.008Zm0 2.25h.008v.008H16.5V15Z" />
          </svg> Thuê nhiều ngày
        </button>
        <button data-tab="hourly" class="banner-tab whitespace-nowrap rounded-none bg-white px-1 py-1.5 text-app-muted">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="mx-auto mb-0.5 h-5 w-5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
          </svg> Thuê theo buổi
        </button>
      </div>
      <div class="bg-app-panel p-3 shadow-[inset_0_1px_0_rgba(255,255,255,0.7)]">
        <div class="mt-1">
          <div id="panel-one-day" class="booking-panel space-y-2">
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
                <p id="one-day-date-title-mobile" data-date-text class="text-[14px] font-semibold leading-5 text-slate-700">Từ 06:00, 27/06/2026<br>Đến 22:00, 27/06/2026</p>
              </div>
            </button>
            <div class="space-y-1.5">
              <p class="text-xs font-bold text-[#a1a1aa]">Hình thức nhận xe</p>
              <div class="grid grid-cols-2 gap-1.5">
                <button type="button" class="pickup-option pickup-shop rounded-[10px] border-2 border-app-accent bg-green-50 px-2 py-1.5 text-center transition-all">
                  <img loading="lazy" src="{{ asset('assets/image/nhantaishop.png') }}" class="mx-auto block h-14 w-14 rounded-xl object-contain">
                  <p class="mt-0.5 text-[12px] font-bold text-app-accent">Nhận tại shop</p>
                  <p class="text-[10px] text-slate-400">{{ $car->address }}</p>
                </button>
                <button type="button" class="pickup-option pickup-delivery rounded-[10px] border-2 border-[#d9e1e7] bg-white px-2 py-1.5 text-center transition-all">
                  <img loading="lazy" src="{{ asset('assets/image/giaotannoi.png') }}" class="mx-auto block h-14 w-14 rounded-xl object-contain">
                  <p class="mt-0.5 text-[12px] font-bold text-slate-500">Giao xe tận nơi</p>
                  <p class="text-[10px] text-slate-400">10k / km</p>
                </button>
              </div>
            </div>
            <p class="text-[12px] font-semibold leading-relaxed text-app-muted">Bạn cần điền SĐT và chọn ngày muốn thuê hoặc nhắn Zalo. Chúng tôi sẽ liên hệ tư vấn xe và giá cho bạn.</p>
          </div>
          <div id="panel-multi-day" class="booking-panel hidden space-y-2">
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
                <p id="multi-range-title-mobile" data-date-text class="text-[14px] font-semibold leading-5 text-slate-700">Từ 06:00, 27/06/2026<br>Đến 22:00, 29/06/2026</p>
              </div>
            </button>
            <div class="space-y-1.5">
              <p class="text-xs font-bold text-[#a1a1aa]">Hình thức nhận xe</p>
              <div class="grid grid-cols-2 gap-1.5">
                <button type="button" class="pickup-option pickup-shop rounded-[10px] border-2 border-app-accent bg-green-50 px-2 py-1.5 text-center transition-all">
                  <img loading="lazy" src="{{ asset('assets/image/nhantaishop.png') }}" class="mx-auto block h-14 w-14 rounded-xl object-contain">
                  <p class="mt-0.5 text-[12px] font-bold text-app-accent">Nhận tại shop</p>
                  <p class="text-[10px] text-slate-400">{{ $car->address }}</p>
                </button>
                <button type="button" class="pickup-option pickup-delivery rounded-[10px] border-2 border-[#d9e1e7] bg-white px-2 py-1.5 text-center transition-all">
                  <img loading="lazy" src="{{ asset('assets/image/giaotannoi.png') }}" class="mx-auto block h-14 w-14 rounded-xl object-contain">
                  <p class="mt-0.5 text-[12px] font-bold text-slate-500">Giao xe tận nơi</p>
                  <p class="text-[10px] text-slate-400">10k / km</p>
                </button>
              </div>
            </div>
            <p class="text-[12px] font-semibold leading-relaxed text-app-muted">Bạn cần điền SĐT và chọn ngày muốn thuê hoặc nhắn Zalo. Chúng tôi sẽ liên hệ tư vấn xe và giá cho bạn.</p>
          </div>
          <div id="panel-hourly" class="booking-panel hidden space-y-2">
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
                <p id="hourly-date-title-mobile" data-date-text class="text-[14px] font-semibold leading-5 text-slate-700">Sáng (6h-12h), 27/06/2026</p>
              </div>
            </button>
            <div class="space-y-1.5">
              <p class="text-xs font-bold text-[#a1a1aa]">Hình thức nhận xe</p>
              <div class="grid grid-cols-2 gap-1.5">
                <button type="button" class="pickup-option pickup-shop rounded-[10px] border-2 border-app-accent bg-green-50 px-2 py-1.5 text-center transition-all">
                  <img loading="lazy" src="{{ asset('assets/image/nhantaishop.png') }}" class="mx-auto block h-14 w-14 rounded-xl object-contain">
                  <p class="mt-0.5 text-[12px] font-bold text-app-accent">Nhận tại shop</p>
                  <p class="text-[10px] text-slate-400">{{ $car->address }}</p>
                </button>
                <button type="button" class="pickup-option pickup-delivery rounded-[10px] border-2 border-[#d9e1e7] bg-white px-2 py-1.5 text-center transition-all">
                  <img loading="lazy" src="{{ asset('assets/image/giaotannoi.png') }}" class="mx-auto block h-14 w-14 rounded-xl object-contain">
                  <p class="mt-0.5 text-[12px] font-bold text-slate-500">Giao xe tận nơi</p>
                  <p class="text-[10px] text-slate-400">10k / km</p>
                </button>
              </div>
            </div>
            <p class="text-[12px] font-semibold leading-relaxed text-app-muted">Bạn cần điền SĐT và chọn ngày muốn thuê hoặc nhắn Zalo. Chúng tôi sẽ liên hệ tư vấn xe và giá cho bạn.</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="bg-white px-4 py-3">
    <h2 class="section-title text-base font-extrabold">Thông số kỹ thuật</h2>
    <div class="mt-4 grid grid-cols-2 gap-3">
      <div class="flex items-center gap-4 rounded-[12px] bg-white p-4 shadow-sm">
        <img loading="lazy" src="{{ asset('assets/icon-chungtoi/icon-baohiem.png') }}" class="h-12 w-12 shrink-0 rounded-[12px] object-contain">
        <div><p class="text-xs font-bold text-app-muted">Bảo hiểm</p><p class="mt-0.5 text-base font-extrabold">{{ $car->insurance }}</p></div>
      </div>
      <div class="flex items-center gap-4 rounded-[12px] bg-white p-4 shadow-sm">
        <img loading="lazy" src="{{ asset('assets/icon-thongso/icon-namsanxuat.png') }}" class="h-12 w-12 shrink-0 rounded-[12px] object-contain">
        <div><p class="text-xs font-bold text-app-muted">Năm sản xuất</p><p class="mt-0.5 text-base font-extrabold">{{ $car->year }}</p></div>
      </div>
      <div class="flex items-center gap-4 rounded-[12px] bg-white p-4 shadow-sm">
        <img loading="lazy" src="{{ asset('assets/icon-thongso/icon-chôngi.png') }}" class="h-12 w-12 shrink-0 rounded-[12px] object-contain">
        <div><p class="text-xs font-bold text-app-muted">Số chỗ</p><p class="mt-0.5 text-base font-extrabold">{{ $car->seats }} chỗ</p></div>
      </div>
      <div class="flex items-center gap-4 rounded-[12px] bg-white p-4 shadow-sm">
        <img loading="lazy" src="{{ asset('assets/icon-thongso/icon-hopho.png') }}" class="h-12 w-12 shrink-0 rounded-[12px] object-contain">
        <div><p class="text-xs font-bold text-app-muted">Hộp số</p><p class="mt-0.5 text-base font-extrabold">{{ $car->transmission }}</p></div>
      </div>
      <div class="flex items-center gap-4 rounded-[12px] bg-white p-4 shadow-sm">
        <img loading="lazy" src="{{ asset('assets/icon-thongso/icon-nhienlieu.png') }}" class="h-12 w-12 shrink-0 rounded-[12px] object-contain">
        <div><p class="text-xs font-bold text-app-muted">Nhiên liệu</p><p class="mt-0.5 text-base font-extrabold">{{ $car->fuel }}</p></div>
      </div>
      <div class="flex items-center gap-4 rounded-[12px] bg-white p-4 shadow-sm">
        <img loading="lazy" src="{{ asset('assets/icon-thongso/icon-tieuhao.png') }}" class="h-12 w-12 shrink-0 rounded-[12px] object-contain">
        <div><p class="text-xs font-bold text-app-muted">Tiêu hao</p><p class="mt-0.5 text-base font-extrabold">{{ $car->fuel_consumption }}</p></div>
      </div>
    </div>
  </section>

  <section class="bg-white px-4 py-3">
    <h2 class="section-title text-base font-extrabold">Giấy tờ thuê xe</h2>
    <div class="mt-4 space-y-2.5">
      <div class="flex items-center gap-3 rounded-[12px] border border-app-line bg-white px-4 py-3.5 shadow-sm">
        <img loading="lazy" src="{{ asset('assets/icon-giayto/icon-CCCD.png') }}" class="h-12 w-16 shrink-0 rounded-[5px]">
        <div><p class="text-sm font-bold">Căn cước công dân (CCCD)</p><p class="mt-0.5 text-xs text-app-muted">Bản cứng hoặc mềm VNeID mức 2 đều được</p></div>
      </div>
      <div class="flex items-center gap-3 rounded-[12px] border border-app-line bg-white px-4 py-3.5 shadow-sm">
        <img loading="lazy" src="{{ asset('assets/icon-giayto/icon-GPLX.png') }}" class="h-12 w-16 shrink-0 rounded-[5px]">
        <div><p class="text-sm font-bold">Giấy phép lái xe (GPLX)</p><p class="mt-0.5 text-xs text-app-muted">Bản cứng hoặc mềm VNeID mức 2 đều được</p></div>
      </div>
      <div class="flex items-center gap-3 rounded-[12px] border border-app-line bg-white px-4 py-3.5 shadow-sm">
        <img loading="lazy" src="{{ asset('assets/icon-giayto/icon-diemGPLX.png') }}" class="h-12 w-16 shrink-0 rounded-[5px]">
        <div><p class="text-sm font-bold">GPLX còn điểm trên VNeTraffic</p><p class="mt-0.5 text-xs text-app-muted">Yêu cầu GPLX còn hiệu lực và đủ điểm theo quy định</p></div>
      </div>
    </div>
  </section>

  <section class="bg-white px-4 py-3">
    <h2 class="section-title text-base font-extrabold">Địa chỉ cửa hàng</h2>
    <div class="mt-4 flex items-center gap-4 rounded-[12px] bg-white p-4 shadow-sm">
      <img loading="lazy" src="{{ asset('assets/image/icon-thuexe.png') }}" class="h-16 w-20 shrink-0 rounded-[12px] object-contain">
      <div><p class="text-xs font-bold text-app-muted">Địa chỉ nhận xe</p><p class="mt-0.5 text-base font-extrabold">{{ $car->address }}</p></div>
    </div>
  </section>

  <section class="bg-white px-4 py-3">
    <h2 class="section-title text-base font-extrabold">Cọc và thế chấp</h2>
    <div class="mt-4 space-y-2.5">
      <div class="flex items-center gap-3 rounded-[12px] border border-app-line bg-white px-4 py-3.5 shadow-sm">
        <img loading="lazy" src="{{ asset('assets/icon-cocvathechap/icon-coctien.png') }}" class="h-16 w-16 shrink-0 rounded-[10px]">
        <div><p class="text-sm font-bold">Tiền cọc giữ slot xe</p><p class="mt-0.5 text-xs text-app-muted">{{ number_format($car->deposit_min) }}đ - {{ number_format($car->deposit_max) }}đ (tuỳ xe, tuỳ thời gian)</p></div>
      </div>
      <div class="flex items-center gap-3 rounded-[12px] border border-app-line bg-white px-4 py-3.5 shadow-sm">
        <img loading="lazy" src="{{ asset('assets/icon-cocvathechap/icon-xethechap.png') }}" class="h-16 w-16 shrink-0 rounded-[10px]">
        <div><p class="text-sm font-bold">Thuê xe có thế chấp</p><p class="mt-0.5 text-xs text-app-muted">Người thuê cần chuẩn bị: Tiền {{ number_format($car->deposit_asset) }}đ hoặc Xe máy tương đương {{ number_format($car->deposit_asset) }}đ giấy tờ chính chủ</p></div>
      </div>
    </div>
  </section>

  <section class="bg-white px-4 py-3">
    <h2 class="section-title text-base font-extrabold">Mô tả</h2>
    <div class="mt-4 rounded-[12px] border border-app-line bg-stone-50 p-4">
      <p class="text-sm leading-6 text-app-muted">{{ $car->description }}</p>
    </div>
  </section>

  <section class="bg-white px-4 py-3">
    <h2 class="section-title text-base font-extrabold">Bảng giá thuê</h2>
    <div class="mt-4 space-y-2.5">
      <div class="flex items-center justify-between rounded-[12px] border border-app-line bg-white px-4 py-3.5 shadow-sm">
        <div class="flex items-center gap-3">
          <img loading="lazy" src="{{ asset('assets/icon-thuexe/thue-1gio.png') }}" class="h-16 w-16 shrink-0 rounded-[10px] object-contain">
          <p class="text-sm font-bold">Theo buổi</p>
        </div>
        <p class="text-base font-extrabold text-app-accent">{{ number_format($car->price_per_session) }}đ <span class="text-xs font-semibold text-app-muted">/ buổi</span></p>
      </div>
      <div class="flex items-center justify-between rounded-[12px] border-2 border-app-accent bg-white px-4 py-3.5 shadow-sm">
        <div class="flex items-center gap-3">
          <img loading="lazy" src="{{ asset('assets/icon-thuexe/thue-1ngay.png') }}" class="h-16 w-16 shrink-0 rounded-[10px] object-contain">
          <div><p class="text-sm font-bold">1 ngày</p><p class="text-xs font-semibold text-app-muted">Trong tỉnh Đăk Lăk</p></div>
        </div>
        <p class="text-base font-extrabold text-app-accent">{{ number_format($car->price_per_day) }}đ <span class="text-xs font-semibold text-app-muted">/ ngày</span></p>
      </div>
      @php $multiDayDiscount = $car->price_per_day - $car->price_multi_day; @endphp
      <div class="flex items-center justify-between rounded-[12px] border border-app-line bg-white px-4 py-3.5 shadow-sm">
        <div class="flex items-center gap-3">
          <img loading="lazy" src="{{ asset('assets/icon-thuexe/thue-nhieungay.png') }}" class="h-16 w-16 shrink-0 rounded-[10px] object-contain">
          <div><p class="text-sm font-bold">3 ngày trở lên</p><p class="text-xs font-semibold text-app-muted">Giảm {{ number_format($multiDayDiscount) }}đ/ngày</p></div>
        </div>
        <p class="text-base font-extrabold">{{ number_format($car->price_multi_day) }}đ <span class="text-xs font-semibold text-app-muted">/ ngày</span></p>
      </div>
      <div class="flex items-center justify-between rounded-[12px] border border-dashed border-app-line bg-white px-4 py-3.5 shadow-sm">
        <div class="flex items-center gap-3">
          <img loading="lazy" src="{{ asset('assets/icon-thuexe/thue-ngoaitinh.png') }}" class="h-16 w-16 shrink-0 rounded-[10px] object-contain">
          <div><p class="text-sm font-bold">Phụ phí ra tỉnh</p><p class="text-xs font-semibold text-app-muted">Áp dụng khi đi liên tỉnh</p></div>
        </div>
        <p class="text-base font-extrabold">+{{ number_format($car->price_out_province) }}đ <span class="text-xs font-semibold text-app-muted">/ ngày</span></p>
      </div>
    </div>
  </section>

  <section class="bg-white px-4 py-3">
    <h2 class="section-title text-base font-extrabold">Tiện ích đi kèm</h2>
      <div class="mt-4 grid grid-cols-3 gap-3">
        @forelse($car->amenities as $i => $amenity)
        <div class="flex flex-col items-center gap-2 rounded-[12px] bg-stone-50 px-3 py-4 text-center transition-all hover:shadow-sm @if($i >= 6) tienich-item hidden tienich-more @endif">
          <div class="flex h-10 w-10 items-center justify-center rounded-full bg-app-accentSoft">
            @if($amenity->icon)
            <img loading="lazy" src="{{ asset(\Illuminate\Support\Str::startsWith($amenity->icon, 'storage/') ? $amenity->icon : 'assets/' . ltrim($amenity->icon, '/')) }}" alt="{{ $amenity->name }}" class="h-10 w-10 object-contain">
            @else
            <span class="text-base font-extrabold text-app-accent">{{ substr($amenity->name, 0, 1) }}</span>
            @endif
          </div>
          <span class="text-[12px] font-bold text-app-muted">{{ $amenity->name }}</span>
        </div>
        @empty
        <div class="col-span-full text-center text-sm font-bold text-app-muted">Chưa có tiện ích</div>
        @endforelse
      </div>
      @if($car->amenities->count() > 6)
      <button id="tienich-toggle" onclick="var items=document.querySelectorAll('.tienich-more'); var btn=this; items.forEach(function(el){el.classList.toggle('hidden')}); btn.querySelector('span').textContent=btn.querySelector('span').textContent=='Xem thêm'?'Thu gọn':'Xem thêm'; btn.querySelector('.tienich-arrow').classList.toggle('rotate-180')" class="mx-auto mt-3 flex items-center gap-1 rounded-[8px] px-4 py-2 text-[13px] font-bold text-app-accent transition-all">
        <span>Xem thêm</span>
        <svg class="h-4 w-4 tienich-arrow" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
      </button>
      @endif
  </section>

  <section class="bg-white px-4 py-3">
    <h2 class="section-title text-base font-extrabold">Phụ phí có thể phát sinh</h2>
    <div class="mt-3 space-y-2.5">
      <div class="flex items-center justify-between rounded-[12px] border border-app-line bg-white px-4 py-3.5 shadow-sm">
        <div class="flex items-center gap-3">
          <img loading="lazy" src="{{ asset('assets/svg-phuthuphatsinh/phi-cauduong.png') }}" alt="Phí cầu đường" class="h-16 w-16 shrink-0 rounded-[10px] object-contain">
          <div><p class="text-sm font-bold">Phí cầu đường</p><p class="mt-1 text-xs leading-5 text-app-muted">Chủ xe có thể yêu cầu thanh toán tất cả các khoản lệ phí cầu đường phát sinh trên tài khoản VETC trong thời gian thuê xe.</p></div>
        </div>
      </div>
      <div class="flex items-center justify-between rounded-[12px] border border-app-line bg-white px-4 py-3.5 shadow-sm">
        <div class="flex items-center gap-3">
          <img loading="lazy" src="{{ asset('assets/svg-phuthuphatsinh/phi-nhienlieu.png') }}" alt="Phụ thu nhiên liệu" class="h-16 w-16 shrink-0 rounded-[10px] object-contain">
          <div><p class="text-sm font-bold">Phụ thu nhiên liệu</p><p class="mt-1 text-xs leading-5 text-app-muted">Chủ xe chỉ thu khi vạch xăng thấp hơn lúc nhận xe. Trả lại đúng vạch xăng như lúc nhận để không phải trả phí này.</p></div>
        </div>
      </div>
      <div class="flex items-center justify-between rounded-[12px] border border-app-line bg-white px-4 py-3.5 shadow-sm">
        <div class="flex items-center gap-3">
          <img loading="lazy" src="{{ asset('assets/svg-phuthuphatsinh/phi-quagio.png') }}" alt="Phí trả trễ" class="h-16 w-16 shrink-0 rounded-[10px] object-contain">
          <div><p class="text-sm font-bold">Phí trả trễ</p><p class="mt-1 text-xs leading-5 text-app-muted">Áp dụng khi trả xe trễ hơn giờ đã thỏa thuận.</p></div>
        </div>
        <div class="shrink-0 text-right"><p class="text-base font-extrabold text-app-accent">100.000đ <span class="text-xs font-semibold text-app-muted">/ giờ</span></p></div>
      </div>
      <div class="flex items-center justify-between rounded-[12px] border border-app-line bg-white px-4 py-3.5 shadow-sm">
        <div class="flex items-center gap-3">
          <img loading="lazy" src="{{ asset('assets/svg-phuthuphatsinh/phi-vesinh.png') }}" alt="Phí nặng mùi hôi" class="h-16 w-16 shrink-0 rounded-[10px] object-contain">
          <div><p class="text-sm font-bold">Phí nặng mùi hôi - thuốc lá</p><p class="mt-1 text-xs leading-5 text-app-muted">Chủ xe sẽ dựa vào tình trạng vệ sinh xe lúc khách hàng trả xe để thu phí.</p></div>
        </div>
        <div class="shrink-0 text-right"><p class="text-base font-extrabold text-app-accent">250.000đ</p></div>
      </div>
    </div>
  </section>

  <section class="bg-white px-4 py-3">
    <h2 class="section-title text-base font-extrabold">Quy định sử dụng xe</h2>
    <div class="mt-4 rounded-[12px] border border-app-line bg-stone-50 p-4 text-xs leading-6 text-app-muted">
      <ul class="mt-1 list-inside list-disc space-y-0.5">
        <li>Sử dụng xe đúng mục đích.</li>
        <li>Không sử dụng xe thuê vào mục đích phi pháp, trái pháp luật.</li>
        <li>Chỉ người đăng ký thuê mới được lái xe.</li>
        <li>Không cho thuê lại xe dưới mọi hình thức.</li>
        <li>Không chở quá số người quy định của xe.</li>
        <li>Không lái xe khi đã sử dụng rượu bia hoặc chất kích thích.</li>
        <li>Tuân thủ Luật Giao thông đường bộ.</li>
        <li>Không sử dụng xe thuê để cầm cố, thế chấp.</li>
        <li>Không hút thuốc, nhả kẹo cao su, phải giữ vệ sinh trong xe.</li>
        <li>Không chở hàng quốc cấm, dễ cháy nổ.</li>
        <li>Không chở hoa quả, thực phẩm nặng mùi trong xe.</li>
        <li>Khi trả xe, nếu xe bẩn hoặc có mùi trong xe, khách hàng vui lòng vệ sinh xe sạch sẽ hoặc gửi phụ thu phí vệ sinh xe.</li>
      </ul>
      <p class="mt-2 font-semibold text-app-text">Trân trọng cảm ơn, chúc quý khách có chuyến đi tuyệt vời!</p>
      <a href="{{ route('terms') }}" class="mt-3 flex items-center justify-center gap-1 rounded-[10px] border border-[#5fcf86] py-2.5 text-xs font-extrabold text-[#5fcf86] transition-all active:scale-[0.98]">
        Xem đầy đủ Điều khoản &amp; Chính sách thuê xe
        <i class="ri-arrow-right-line"></i>
      </a>
    </div>
  </section>

  <section class="bg-white px-4 py-3">
    <h2 class="section-title text-base font-extrabold">Chính sách huỷ cọc</h2>
    <div class="mt-4 overflow-hidden rounded-[12px] border border-app-line shadow-sm">
      <table class="w-full text-xs">
        <thead>
          <tr class="bg-app-accent text-white">
            <th class="px-3 py-2.5 text-left font-bold">Chính sách</th>
            <th class="px-3 py-2.5 text-center font-bold">Ngày thường</th>
            <th class="px-3 py-2.5 text-center font-bold">Ngày Lễ, Tết</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-app-line">
          <tr class="bg-white">
            <td class="px-3 py-2.5 font-semibold text-app-text"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="-mt-0.5 mr-0.5 inline-block h-3.5 w-3.5 align-middle text-app-accent"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" /></svg> Hoàn 100% tiền giữ chỗ</td>
            <td class="px-3 py-2.5 text-center text-app-muted">Trước chuyến đi &gt; 10 ngày</td>
            <td class="px-3 py-2.5 text-center text-app-muted">Không áp dụng</td>
          </tr>
          <tr class="bg-stone-50">
            <td class="px-3 py-2.5 font-semibold text-app-text"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="-mt-0.5 mr-0.5 inline-block h-3.5 w-3.5 align-middle text-app-accent"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" /></svg> Hoàn 30% tiền giữ chỗ</td>
            <td class="px-3 py-2.5 text-center text-app-muted">Trước chuyến đi &gt; 5 ngày</td>
            <td class="px-3 py-2.5 text-center text-app-muted">Trước chuyến đi &gt; 30 ngày</td>
          </tr>
          <tr class="bg-white">
            <td class="px-3 py-2.5 font-semibold text-app-text"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="-mt-0.5 mr-0.5 inline-block h-3.5 w-3.5 align-middle text-red-500"><path stroke-linecap="round" stroke-linejoin="round" d="m9.75 9.75 4.5 4.5m0-4.5-4.5 4.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" /></svg> Không hoàn tiền giữ chỗ</td>
            <td class="px-3 py-2.5 text-center text-app-muted">Trong vòng 5 ngày trước chuyến đi</td>
            <td class="px-3 py-2.5 text-center text-app-muted">Trong vòng 30 ngày trước chuyến đi</td>
          </tr>
        </tbody>
      </table>
    </div>
  </section>
</main>

<div class="fixed bottom-0 left-1/2 z-50 w-full max-w-[460px] -translate-x-1/2 border-t border-app-line bg-white shadow-lg">
  <div class="flex items-center px-4 py-2">
    <div>
      <p class="text-sm font-bold text-app-muted">Tổng giá thuê: <span id="bottom-duration">1 ngày</span></p>
      <p id="bottom-total" class="text-xl font-extrabold text-app-accent">{{ number_format($car->price_per_day) }}đ</p>
      <p id="bottom-pickup" class="mt-0.5 text-[13px] font-semibold text-slate-400"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="mr-0.5 inline-block h-3.5 w-3.5 align-text-bottom text-app-accent"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" /><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" /></svg>Nhận tại shop</p>
    </div>
    <div class="ml-auto">
      <button id="btn-thue-ngay-mobile" data-car-price-day="{{ $car->price_per_day }}" data-car-price-session="{{ $car->price_per_session }}" data-car-price-multi-day="{{ $car->price_multi_day }}" onclick="openConfirmModal()" class="rounded-[10px] bg-app-accent px-5 py-2.5 text-sm font-extrabold uppercase tracking-wide text-white shadow-sm transition-all hover:bg-green-600 active:scale-[0.98]">
        Thuê ngay
      </button>
    </div>
  </div>
  <div class="h-[env(safe-area-inset-bottom)]"></div>
</div>
@endsection
