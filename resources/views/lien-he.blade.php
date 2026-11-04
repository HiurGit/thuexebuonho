@extends('layouts.app')

@section('title', 'Liên hệ - Thuê Xe Buôn Hồ')

@section('meta')
<meta name="description" content="Liên hệ với Thuê Xe Tự Lái Buôn Hồ qua hotline, Zalo, Facebook hoặc đến trực tiếp văn phòng tại 07 Chu Văn An, Buôn Hồ, Đăk Lăk.">
<meta property="og:title" content="Liên hệ - Thuê Xe Buôn Hồ">
<meta property="og:description" content="Liên hệ với Thuê Xe Tự Lái Buôn Hồ qua hotline, Zalo, Facebook hoặc đến trực tiếp văn phòng tại 07 Chu Văn An, Buôn Hồ, Đăk Lăk.">
<meta property="og:image" content="{{ asset('assets/image/bannerMXH.jpg') }}">
<meta property="og:image:width" content="1200">
<meta property="og:image:height" content="630">
<meta property="og:image:type" content="image/jpeg">
<meta property="og:image:alt" content="Thuê Xe Buôn Hồ - Liên hệ">
<meta property="og:url" content="{{ url()->current() }}">
<meta property="og:type" content="website">
<meta property="og:site_name" content="Thuê Xe Buôn Hồ">
<meta property="og:locale" content="vi_VN">
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="Liên hệ - Thuê Xe Buôn Hồ">
<meta name="twitter:description" content="Liên hệ với Thuê Xe Tự Lái Buôn Hồ qua hotline, Zalo, Facebook hoặc đến trực tiếp văn phòng.">
<meta name="twitter:image" content="{{ asset('assets/image/bannerMXH.jpg') }}">
@endsection

@php
  $sitePhone = \App\Models\Setting::get('site_phone', '0964918047');
  $sitePhoneDisplay = preg_replace('/(\d{4})(\d{3})(\d{3,})/', '$1.$2.$3', $sitePhone) ?: $sitePhone;
  $siteAddress = \App\Models\Setting::get('site_address', '07 Chu Van An, Buon Ho, Dak Lak');
  $siteMapUrl = \App\Models\Setting::get('site_map_url', 'https://maps.app.goo.gl/Qr6kWexgKnYdRdpq7');
  $siteZaloUrl = 'https://zalo.me/' . preg_replace('/\D+/', '', $sitePhone);
  $siteOwnerName = \App\Models\Setting::get('site_owner_name', 'Thuê Xe Tự Lái Buôn Hồ');
  $siteOwnerAvatar = \App\Models\Setting::get('site_owner_avatar', '');
  $siteFacebook = \App\Models\Setting::get('site_facebook', 'https://www.facebook.com/9999NDT/');
  $siteBusinessName = \App\Models\Setting::get('site_business_name', 'HỘ KINH DOANH THUÊ XE BUÔN HỒ');
  $siteTaxCode = \App\Models\Setting::get('site_tax_code', '8603250741-001');
  $siteRepresentative = \App\Models\Setting::get('site_representative', 'NGUYỄN ĐÌNH THẢO');
  $siteBankAccount = \App\Models\Setting::get('site_bank_account', '8869926323');
  $siteBankName = \App\Models\Setting::get('site_bank_name', 'BIDV');
  $collaborators = \App\Models\Collaborator::where('status', 'active')->orderBy('sort_order')->get();
@endphp

@section('content-desktop')
<div class="bg-white">
@include('partials.marquee')

<div class="border-b border-app-line bg-white shadow-sm">
  <div class="mx-auto flex max-w-4xl items-center gap-4 px-6 py-3">
    <a href="javascript:history.back()" class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-app-accentSoft text-app-accent transition-all hover:bg-app-accent hover:text-white">
      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5">
        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" />
      </svg>
    </a>
    <h1 class="flex-1 text-center text-xl font-extrabold text-app-ink">Liên hệ</h1>
    <div class="w-10 shrink-0"></div>
  </div>
</div>

<main class="mx-auto max-w-5xl px-6 py-8">
  <div class="grid grid-cols-1 gap-10 lg:grid-cols-12">
    {{-- Thông tin cửa hàng --}}
    <div class="lg:col-span-5">
      <div class="flex items-center gap-4">
        <div class="flex h-20 w-20 shrink-0 items-center justify-center overflow-hidden rounded-full bg-app-accentSoft ring-1 ring-app-line">
          @if($siteOwnerAvatar)
            <img src="{{ asset($siteOwnerAvatar) }}" alt="{{ $siteOwnerName }}" data-label="{{ $siteOwnerName }}" class="avatar-clickable h-full w-full object-cover">
          @else
            <img src="{{ asset('assets/image/logo.png') }}" alt="Logo" data-label="Thuê Xe Buôn Hồ" class="avatar-clickable h-full w-full object-contain p-1.5">
          @endif
        </div>
        <div>
          <h2 class="text-xl font-extrabold text-app-ink">{{ $siteOwnerName }}</h2>
          <p class="mt-1 inline-flex items-center gap-1.5 text-[13px] font-bold text-app-accent">
            <span class="h-2 w-2 rounded-full bg-app-accent"></span>
            Chủ cửa hàng
          </p>
        </div>
      </div>

      <div class="mt-8 overflow-hidden rounded-2xl border border-app-line bg-stone-50">
        <div class="flex items-center gap-2 border-b border-app-line bg-white px-4 py-3">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.6" stroke="currentColor" class="h-4 w-4 shrink-0 text-app-accent">
            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21" />
          </svg>
          <p class="text-[11px] font-extrabold uppercase tracking-wider text-app-muted">Thông tin cửa hàng</p>
        </div>
        <div class="divide-y divide-app-line">
          <div class="flex gap-3.5 px-4 py-3">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="mt-0.5 h-5 w-5 shrink-0 text-app-accent">
              <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21" />
            </svg>
            <div class="min-w-0">
              <p class="text-[11px] font-extrabold uppercase tracking-wider text-app-muted">Tên đơn vị</p>
              <p class="mt-0.5 text-sm font-extrabold leading-6 text-app-ink">{{ $siteBusinessName }}</p>
            </div>
          </div>

          <div class="flex gap-3.5 px-4 py-3">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="mt-0.5 h-5 w-5 shrink-0 text-app-accent">
              <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
            </svg>
            <div class="min-w-0">
              <p class="text-[11px] font-extrabold uppercase tracking-wider text-app-muted">Mã số thuế tổ chức</p>
              <p class="mt-0.5 text-sm font-extrabold leading-6 text-app-ink">{{ $siteTaxCode }}</p>
            </div>
          </div>

          <div class="flex gap-3.5 px-4 py-3">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="mt-0.5 h-5 w-5 shrink-0 text-app-accent">
              <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
            </svg>
            <div class="min-w-0">
              <p class="text-[11px] font-extrabold uppercase tracking-wider text-app-muted">Người đại diện</p>
              <p class="mt-0.5 text-sm font-extrabold leading-6 text-app-ink">{{ $siteRepresentative }}</p>
            </div>
          </div>

          <div class="flex gap-3.5 px-4 py-3">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="mt-0.5 h-5 w-5 shrink-0 text-app-accent">
              <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 0 0 2.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 0 1-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 0 0-1.091-.852H4.5A2.25 2.25 0 0 0 2.25 4.5v2.25Z" />
            </svg>
            <div class="min-w-0">
              <p class="text-[11px] font-extrabold uppercase tracking-wider text-app-muted">Hotline / Zalo</p>
              <a href="tel:{{ $sitePhone }}" class="mt-0.5 block text-base font-extrabold text-app-ink transition-colors hover:text-app-accent">{{ $sitePhoneDisplay }}</a>
            </div>
          </div>

          <div class="flex gap-3.5 px-4 py-3">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="mt-0.5 h-5 w-5 shrink-0 text-app-accent">
              <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
              <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
            </svg>
            <div class="min-w-0">
              <p class="text-[11px] font-extrabold uppercase tracking-wider text-app-muted">Địa chỉ</p>
              <p class="mt-0.5 text-sm font-extrabold leading-6 text-app-ink">{{ $siteAddress }}</p>
            </div>
          </div>
        </div>
      </div>

      <div class="mt-8 grid grid-cols-2 gap-3">
        <a href="tel:{{ $sitePhone }}" class="flex items-center justify-center gap-2 rounded-xl bg-app-accent px-4 py-3 text-sm font-extrabold text-white transition-colors hover:bg-app-green">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="h-4 w-4">
            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 0 0 2.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 0 1-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 0 0-1.091-.852H4.5A2.25 2.25 0 0 0 2.25 4.5v2.25Z" />
          </svg>
          Gọi ngay
        </a>
        <a href="{{ $siteZaloUrl }}" target="_blank" rel="noopener" class="flex items-center justify-center gap-2 rounded-xl bg-[#0068ff] px-4 py-3 text-sm font-extrabold text-white transition-colors hover:bg-[#0056d6]">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="h-4 w-4">
            <path stroke-linecap="round" stroke-linejoin="round" d="M8.625 9.75a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H8.25m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H12m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0h-.375m-13.5 3.01c0 1.6 1.123 2.994 2.707 3.227 1.087.16 2.185.283 3.293.369V21l4.184-4.183a1.14 1.14 0 0 1 .778-.332 48.294 48.294 0 0 0 5.83-.498c1.585-.233 2.708-1.626 2.708-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0 0 12 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018Z" />
          </svg>
          Chat Zalo
        </a>
      </div>

      <div class="mt-4 flex items-center gap-5">
        <a href="{{ $siteFacebook }}" target="_blank" rel="noopener" class="inline-flex items-center gap-2 text-[13px] font-extrabold text-app-muted transition-colors hover:text-[#1877f2]">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-4 w-4">
            <path d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" />
          </svg>
          Facebook
        </a>
        <span class="h-4 w-px bg-app-line"></span>
        <a href="{{ $siteMapUrl }}" target="_blank" rel="noopener" class="inline-flex items-center gap-2 text-[13px] font-extrabold text-app-muted transition-colors hover:text-app-accent">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="h-4 w-4">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
          </svg>
          Chỉ đường
        </a>
      </div>

      @if($siteBankAccount)
      <div class="mt-6 overflow-hidden rounded-2xl border border-app-line bg-stone-50">
        <div class="flex items-center gap-2 border-b border-app-line bg-white px-4 py-3">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.6" stroke="currentColor" class="h-4 w-4 shrink-0 text-app-accent">
            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 0 0 2.25-2.25V6.75A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25v10.5A2.25 2.25 0 0 0 4.5 19.5Z" />
          </svg>
          <p class="text-[11px] font-extrabold uppercase tracking-wider text-app-muted">Thông tin chuyển khoản</p>
        </div>
        <div class="px-4 py-3.5">
          <p class="text-sm font-extrabold text-app-ink">{{ $siteBusinessName }}</p>
          <div class="mt-3 grid grid-cols-2 gap-3">
            <div>
              <p class="text-[11px] font-bold uppercase tracking-wide text-app-muted">Số tài khoản</p>
              <p class="mt-0.5 text-base font-extrabold text-app-ink">{{ $siteBankAccount }}</p>
            </div>
            <div>
              <p class="text-[11px] font-bold uppercase tracking-wide text-app-muted">Ngân hàng</p>
              <p class="mt-0.5 text-base font-extrabold text-app-ink">{{ $siteBankName }}</p>
            </div>
          </div>
          <button type="button" data-copy="{{ $siteBankAccount }}" class="btn-copy-stk mt-3.5 inline-flex w-full items-center justify-center gap-1.5 rounded-xl border border-app-accent/40 bg-white px-3 py-2.5 text-xs font-extrabold text-app-accent transition-colors hover:bg-app-accent hover:text-white">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.6" stroke="currentColor" class="h-4 w-4">
              <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 17.25v3.375c0 .621-.504 1.125-1.125 1.125h-9.75a1.125 1.125 0 0 1-1.125-1.125V7.875c0-.621.504-1.125 1.125-1.125H6.75a9.06 9.06 0 0 1 1.5.124m7.5 10.376h3.375c.621 0 1.125-.504 1.125-1.125V11.25c0-4.46-3.243-8.161-7.5-8.876a9.06 9.06 0 0 0-1.5-.124H9.375c-.621 0-1.125.504-1.125 1.125v3.5m7.5 10.375H9.375a1.125 1.125 0 0 1-1.125-1.125v-9.25m12 6.625v-1.875a3.375 3.375 0 0 0-3.375-3.375h-1.5a1.125 1.125 0 0 1-1.125-1.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H9.75" />
            </svg>
            Sao chép số tài khoản
          </button>

          <div data-open-qr role="button" tabindex="0" class="mt-3 flex cursor-zoom-in items-center gap-3 rounded-xl border border-app-line bg-white p-2.5 transition-colors hover:border-app-accent/50">
            <img
              src="{{ asset('assets/image/QR-ThueXe.jpg') }}"
              alt="Mã QR chuyển khoản"
              data-label="Mã QR chuyển khoản"
              data-sub="{{ $siteBusinessName }} – {{ $siteBankName }}"
              loading="lazy"
              class="avatar-clickable h-20 w-20 shrink-0 cursor-zoom-in rounded-lg border border-app-line bg-white object-contain"
            >
            <div class="min-w-0 flex-1">
              <p class="text-[11px] font-extrabold uppercase tracking-wide text-app-muted">Mã QR chuyển khoản</p>
              <p class="mt-0.5 text-xs font-bold text-app-ink">Nhấn vào mã QR để xem lớn hơn</p>
            </div>
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.6" stroke="currentColor" class="h-4 w-4 shrink-0 text-app-muted">
              <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 3.75v4.5m0-4.5h4.5m-4.5 0L9 9M3.75 20.25v-4.5m0 4.5h4.5m-4.5 0L9 15M20.25 3.75h-4.5m4.5 0v4.5m0-4.5L15 9m5.25 11.25h-4.5m4.5 0v-4.5m0 4.5L15 15" />
            </svg>
          </div>
        </div>
      </div>
      @endif
    </div>

    {{-- Cộng tác viên --}}
    <div class="lg:col-span-7 lg:border-l lg:border-app-line lg:pl-10">
      <div class="flex items-end justify-between gap-4">
        <div>
          <p class="text-[11px] font-extrabold uppercase tracking-[0.2em] text-app-muted">Mạng lưới</p>
          <h2 class="mt-1 text-xl font-extrabold text-app-ink">Cộng tác viên</h2>
        </div>
        <span class="rounded-full bg-app-accentSoft px-3 py-1 text-xs font-extrabold text-app-accent">{{ $collaborators->count() }} người</span>
      </div>

      @if($collaborators->isEmpty())
        <p class="mt-8 text-sm font-semibold text-app-muted">Chưa có cộng tác viên.</p>
      @else
        <div class="mt-5 divide-y divide-app-line">
          @foreach($collaborators as $ctv)
            <div class="flex items-start gap-4 py-4 first:pt-0 last:pb-0">
              @if($ctv->avatar)
                <img src="{{ asset($ctv->avatar) }}" alt="{{ $ctv->name }}" data-label="{{ $ctv->name }}" data-sub="{{ $ctv->phone }}" class="avatar-clickable h-14 w-14 shrink-0 rounded-2xl object-cover">
              @else
                <div class="flex h-14 w-14 shrink-0 items-center justify-center rounded-2xl bg-app-accentSoft text-lg font-extrabold text-app-accent">
                  {{ mb_substr($ctv->name, 0, 1) }}
                </div>
              @endif

              <div class="min-w-0 flex-1">
                <p class="text-sm font-extrabold text-app-ink">{{ $ctv->name }}</p>
                <div class="mt-1 flex flex-wrap items-center gap-x-2 gap-y-1 text-xs font-semibold text-app-muted">
                  <a href="tel:{{ $ctv->phone }}" class="font-extrabold text-app-accent transition-colors hover:underline">{{ $ctv->phone }}</a>
                  <span class="text-app-line">•</span>
                  <span>{{ $ctv->address ?: 'Chưa cập nhật địa chỉ' }}</span>
                </div>
              </div>

              <a href="tel:{{ $ctv->phone }}" class="mt-0.5 flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-app-accentSoft text-app-accent transition-colors hover:bg-app-accent hover:text-white" aria-label="Gọi {{ $ctv->name }}">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="h-4 w-4">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 0 0 2.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 0 1-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 0 0-1.091-.852H4.5A2.25 2.25 0 0 0 2.25 4.5v2.25Z" />
                </svg>
              </a>
            </div>
          @endforeach
        </div>
      @endif
    </div>
  </div>
</main>
</div>
@endsection

@section('content-mobile')
<div class="min-h-full bg-white">
@include('partials.marquee')

<div class="bg-white px-4 py-1 shadow-sm">
  <div class="flex items-center gap-3">
    <a href="javascript:history.back()" class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-app-accentSoft text-app-accent transition-all hover:bg-app-accent hover:text-white">
      <i class="ri-arrow-left-s-line text-lg"></i>
    </a>
    <h1 class="flex-1 text-center text-lg font-extrabold">Liên hệ</h1>
    <div class="w-9 shrink-0"></div>
  </div>
</div>

<main class="px-4 pb-28 pt-4">
  <div class="flex items-center gap-4">
    <div class="flex h-16 w-16 shrink-0 items-center justify-center overflow-hidden rounded-full bg-app-accentSoft ring-1 ring-app-line">
      @if($siteOwnerAvatar)
        <img src="{{ asset($siteOwnerAvatar) }}" alt="{{ $siteOwnerName }}" data-label="{{ $siteOwnerName }}" class="avatar-clickable h-full w-full object-cover">
      @else
        <img src="{{ asset('assets/image/logo.png') }}" alt="Logo" data-label="Thuê Xe Buôn Hồ" class="avatar-clickable h-full w-full object-contain p-1">
      @endif
    </div>
    <div>
      <h2 class="text-base font-extrabold text-app-ink">{{ $siteOwnerName }}</h2>
      <p class="mt-1 inline-flex items-center gap-1.5 text-xs font-bold text-app-accent">
        <span class="h-1.5 w-1.5 rounded-full bg-app-accent"></span>
        Chủ cửa hàng
      </p>
    </div>
  </div>

  <div class="mt-5 overflow-hidden rounded-2xl border border-app-line bg-stone-50">
    <div class="flex items-center gap-2 border-b border-app-line bg-white px-3.5 py-2.5">
      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.6" stroke="currentColor" class="h-4 w-4 shrink-0 text-app-accent">
        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21" />
      </svg>
      <p class="text-[11px] font-extrabold uppercase tracking-wider text-app-muted">Thông tin cửa hàng</p>
    </div>
    <div class="divide-y divide-app-line">
      <div class="flex gap-3 px-3.5 py-3">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="mt-0.5 h-4 w-4 shrink-0 text-app-accent">
          <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21" />
        </svg>
        <div class="min-w-0">
          <p class="text-[11px] font-extrabold uppercase tracking-wider text-app-muted">Tên đơn vị</p>
          <p class="mt-0.5 text-sm font-extrabold leading-5 text-app-ink">{{ $siteBusinessName }}</p>
        </div>
      </div>

      <div class="flex gap-3 px-3.5 py-3">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="mt-0.5 h-4 w-4 shrink-0 text-app-accent">
          <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
        </svg>
        <div class="min-w-0">
          <p class="text-[11px] font-extrabold uppercase tracking-wider text-app-muted">Mã số thuế tổ chức</p>
          <p class="mt-0.5 text-sm font-extrabold leading-5 text-app-ink">{{ $siteTaxCode }}</p>
        </div>
      </div>

      <div class="flex gap-3 px-3.5 py-3">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="mt-0.5 h-4 w-4 shrink-0 text-app-accent">
          <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
        </svg>
        <div class="min-w-0">
          <p class="text-[11px] font-extrabold uppercase tracking-wider text-app-muted">Người đại diện</p>
          <p class="mt-0.5 text-sm font-extrabold leading-5 text-app-ink">{{ $siteRepresentative }}</p>
        </div>
      </div>

      <div class="flex gap-3 px-3.5 py-3">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="mt-0.5 h-4 w-4 shrink-0 text-app-accent">
          <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 0 0 2.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 0 1-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 0 0-1.091-.852H4.5A2.25 2.25 0 0 0 2.25 4.5v2.25Z" />
        </svg>
        <div class="min-w-0">
          <p class="text-[11px] font-extrabold uppercase tracking-wider text-app-muted">Hotline / Zalo</p>
          <a href="tel:{{ $sitePhone }}" class="mt-0.5 block text-sm font-extrabold text-app-ink transition-colors hover:text-app-accent">{{ $sitePhoneDisplay }}</a>
        </div>
      </div>

      <div class="flex gap-3 px-3.5 py-3">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="mt-0.5 h-4 w-4 shrink-0 text-app-accent">
          <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
          <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
        </svg>
        <div class="min-w-0">
          <p class="text-[11px] font-extrabold uppercase tracking-wider text-app-muted">Địa chỉ</p>
          <p class="mt-0.5 text-sm font-extrabold leading-5 text-app-ink">{{ $siteAddress }}</p>
        </div>
      </div>
    </div>
  </div>

  <div class="mt-5 grid grid-cols-2 gap-2.5">
    <a href="tel:{{ $sitePhone }}" class="flex items-center justify-center gap-1.5 rounded-xl bg-app-accent px-3 py-2.5 text-xs font-extrabold text-white transition-all hover:bg-app-green active:scale-[0.98]">
      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="h-4 w-4">
        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 0 0 2.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 0 1-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 0 0-1.091-.852H4.5A2.25 2.25 0 0 0 2.25 4.5v2.25Z" />
      </svg>
      Gọi ngay
    </a>
    <a href="{{ $siteZaloUrl }}" target="_blank" rel="noopener" class="flex items-center justify-center gap-1.5 rounded-xl bg-[#0068ff] px-3 py-2.5 text-xs font-extrabold text-white transition-all hover:bg-[#0056d6] active:scale-[0.98]">
      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="h-4 w-4">
        <path stroke-linecap="round" stroke-linejoin="round" d="M8.625 9.75a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H8.25m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H12m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0h-.375m-13.5 3.01c0 1.6 1.123 2.994 2.707 3.227 1.087.16 2.185.283 3.293.369V21l4.184-4.183a1.14 1.14 0 0 1 .778-.332 48.294 48.294 0 0 0 5.83-.498c1.585-.233 2.708-1.626 2.708-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0 0 12 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018Z" />
      </svg>
      Chat Zalo
    </a>
  </div>

  <div class="mt-4 flex items-center justify-center gap-5">
    <a href="{{ $siteFacebook }}" target="_blank" rel="noopener" class="inline-flex items-center gap-1.5 text-xs font-extrabold text-app-muted transition-colors hover:text-[#1877f2]">
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-4 w-4">
        <path d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" />
      </svg>
      Facebook
    </a>
    <span class="h-3 w-px bg-app-line"></span>
    <a href="{{ $siteMapUrl }}" target="_blank" rel="noopener" class="inline-flex items-center gap-1.5 text-xs font-extrabold text-app-muted transition-colors hover:text-app-accent">
      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="h-4 w-4">
        <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
      </svg>
      Chỉ đường
    </a>
  </div>

  @if($siteBankAccount)
  <div class="mt-6 overflow-hidden rounded-2xl border border-app-line bg-stone-50">
    <div class="flex items-center gap-2 border-b border-app-line bg-white px-3.5 py-2.5">
      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.6" stroke="currentColor" class="h-4 w-4 shrink-0 text-app-accent">
        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 0 0 2.25-2.25V6.75A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25v10.5A2.25 2.25 0 0 0 4.5 19.5Z" />
      </svg>
      <p class="text-[11px] font-extrabold uppercase tracking-wider text-app-muted">Thông tin chuyển khoản</p>
    </div>
    <div class="px-3.5 py-3">
      <p class="text-sm font-extrabold text-app-ink">{{ $siteBusinessName }}</p>
      <div class="mt-2.5 grid grid-cols-2 gap-3">
        <div>
          <p class="text-[10px] font-bold uppercase tracking-wide text-app-muted">Số tài khoản</p>
          <p class="mt-0.5 text-sm font-extrabold text-app-ink">{{ $siteBankAccount }}</p>
        </div>
        <div>
          <p class="text-[10px] font-bold uppercase tracking-wide text-app-muted">Ngân hàng</p>
          <p class="mt-0.5 text-sm font-extrabold text-app-ink">{{ $siteBankName }}</p>
        </div>
      </div>
      <button type="button" data-copy="{{ $siteBankAccount }}" class="btn-copy-stk mt-3 inline-flex w-full items-center justify-center gap-1.5 rounded-xl border border-app-accent/40 bg-white px-3 py-2 text-[11px] font-extrabold text-app-accent transition-colors hover:bg-app-accent hover:text-white active:scale-[0.98]">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.6" stroke="currentColor" class="h-4 w-4">
          <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 17.25v3.375c0 .621-.504 1.125-1.125 1.125h-9.75a1.125 1.125 0 0 1-1.125-1.125V7.875c0-.621.504-1.125 1.125-1.125H6.75a9.06 9.06 0 0 1 1.5.124m7.5 10.376h3.375c.621 0 1.125-.504 1.125-1.125V11.25c0-4.46-3.243-8.161-7.5-8.876a9.06 9.06 0 0 0-1.5-.124H9.375c-.621 0-1.125.504-1.125 1.125v3.5m7.5 10.375H9.375a1.125 1.125 0 0 1-1.125-1.125v-9.25m12 6.625v-1.875a3.375 3.375 0 0 0-3.375-3.375h-1.5a1.125 1.125 0 0 1-1.125-1.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H9.75" />
        </svg>
        Sao chép số tài khoản
      </button>

      <div data-open-qr role="button" tabindex="0" class="mt-2.5 flex cursor-zoom-in items-center gap-2.5 rounded-xl border border-app-line bg-white p-2 transition-colors hover:border-app-accent/50">
        <img
          src="{{ asset('assets/image/QR-ThueXe.jpg') }}"
          alt="Mã QR chuyển khoản"
          data-label="Mã QR chuyển khoản"
          data-sub="{{ $siteBusinessName }} – {{ $siteBankName }}"
          loading="lazy"
          class="avatar-clickable h-16 w-16 shrink-0 cursor-zoom-in rounded-lg border border-app-line bg-white object-contain"
        >
        <div class="min-w-0 flex-1">
          <p class="text-[10px] font-extrabold uppercase tracking-wide text-app-muted">Mã QR chuyển khoản</p>
          <p class="mt-0.5 text-[11px] font-bold text-app-ink">Nhấn vào mã QR để xem lớn hơn</p>
        </div>
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.6" stroke="currentColor" class="h-4 w-4 shrink-0 text-app-muted">
          <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 3.75v4.5m0-4.5h4.5m-4.5 0L9 9M3.75 20.25v-4.5m0 4.5h4.5m-4.5 0L9 15M20.25 3.75h-4.5m4.5 0v4.5m0-4.5L15 9m5.25 11.25h-4.5m4.5 0v-4.5m0 4.5L15 15" />
        </svg>
      </div>
    </div>
  </div>
  @endif

  <div class="mt-8 border-t border-app-line pt-5">
    <div class="flex items-center justify-between gap-3">
      <div>
        <p class="text-[11px] font-extrabold uppercase tracking-[0.18em] text-app-muted">Mạng lưới</p>
        <h2 class="mt-0.5 text-base font-extrabold text-app-ink">Cộng tác viên</h2>
      </div>
      <span class="rounded-full bg-app-accentSoft px-2.5 py-1 text-[11px] font-extrabold text-app-accent">{{ $collaborators->count() }} người</span>
    </div>

    @if($collaborators->isEmpty())
      <p class="mt-4 text-sm font-semibold text-app-muted">Chưa có cộng tác viên.</p>
    @else
      <div class="mt-1 divide-y divide-app-line">
        @foreach($collaborators as $ctv)
          <div class="flex items-start gap-3 py-3.5 first:pt-0 last:pb-0">
            @if($ctv->avatar)
              <img src="{{ asset($ctv->avatar) }}" alt="{{ $ctv->name }}" data-label="{{ $ctv->name }}" data-sub="{{ $ctv->phone }}" class="avatar-clickable h-12 w-12 shrink-0 rounded-xl object-cover">
            @else
              <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-app-accentSoft text-base font-extrabold text-app-accent">
                {{ mb_substr($ctv->name, 0, 1) }}
              </div>
            @endif

            <div class="min-w-0 flex-1">
              <p class="text-sm font-extrabold text-app-ink">{{ $ctv->name }}</p>
              <div class="mt-1 flex flex-wrap items-center gap-x-2 gap-y-0.5 text-xs font-semibold text-app-muted">
                <a href="tel:{{ $ctv->phone }}" class="font-extrabold text-app-accent transition-colors hover:underline">{{ $ctv->phone }}</a>
                <span class="text-app-line">•</span>
                <span>{{ $ctv->address ?: 'Chưa cập nhật địa chỉ' }}</span>
              </div>
            </div>

            <a href="tel:{{ $ctv->phone }}" class="mt-0.5 flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-app-accentSoft text-app-accent transition-colors hover:bg-app-accent hover:text-white" aria-label="Gọi {{ $ctv->name }}">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="h-3.5 w-3.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 0 0 2.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 0 1-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 0 0-1.091-.852H4.5A2.25 2.25 0 0 0 2.25 4.5v2.25Z" />
              </svg>
            </a>
          </div>
        @endforeach
      </div>
    @endif

    <a href="{{ route('kiem-tien') }}" class="mt-4 flex items-center gap-3 rounded-2xl border border-app-line bg-white px-3.5 py-3 transition-colors hover:border-app-accent">
      <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-app-accent text-white">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="h-5 w-5 money-coin-anim">
          <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
        </svg>
      </span>
      <span class="min-w-0 flex-1">
        <span class="block text-[13px] font-extrabold text-app-ink leading-tight">Giới thiệu khách mới<br>Nhận hoa hồng 10% mỗi hợp đồng</span>
        <span class="mt-0.5 block text-[11px] font-semibold text-app-muted">Đăng ký đối tác giới thiệu Thuê Xe Buôn Hồ</span>
      </span>
      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="h-4 w-4 shrink-0 text-app-accent">
        <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5"/>
      </svg>
    </a>
  </div>
</main>
</div>
@endsection

@push('modals')
  @include('partials.popup-banner', ['popupForceShow' => true])

  <script>
    document.addEventListener('click', function (e) {
      var btn = e.target.closest('.btn-copy-stk');
      if (!btn) return;

      var text = btn.getAttribute('data-copy') || '';

      function done() {
        if (typeof showToast === 'function') {
          showToast('Đã sao chép số tài khoản', 'success');
        }
      }

      function fallbackCopy(value) {
        var ta = document.createElement('textarea');
        ta.value = value;
        ta.style.position = 'fixed';
        ta.style.opacity = '0';
        document.body.appendChild(ta);
        ta.select();
        try {
          document.execCommand('copy');
          done();
        } catch (err) {}
        document.body.removeChild(ta);
      }

      if (navigator.clipboard && window.isSecureContext) {
        navigator.clipboard.writeText(text).then(done).catch(function () {
          fallbackCopy(text);
        });
      } else {
        fallbackCopy(text);
      }
    });

    // Bấm vào cả khối QR để mở ảnh lớn (dùng lightbox chung của site)
    document.addEventListener('click', function (e) {
      var row = e.target.closest('[data-open-qr]');
      if (!row) return;
      if (e.target.closest('img.avatar-clickable')) return;
      var img = row.querySelector('img.avatar-clickable');
      if (img) img.click();
    });

    document.addEventListener('keydown', function (e) {
      if (e.key !== 'Enter' && e.key !== ' ') return;
      var row = e.target.closest('[data-open-qr]');
      if (!row) return;
      e.preventDefault();
      var img = row.querySelector('img.avatar-clickable');
      if (img) img.click();
    });
  </script>
@endpush
