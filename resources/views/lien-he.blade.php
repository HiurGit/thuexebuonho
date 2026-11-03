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
  $collaborators = \App\Models\Collaborator::orderBy('sort_order')->get();
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

      <div class="mt-8 space-y-6 border-t border-app-line pt-7">
        <div class="flex gap-3.5">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="mt-0.5 h-5 w-5 shrink-0 text-app-accent">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
          </svg>
          <div class="min-w-0">
            <p class="text-[11px] font-extrabold uppercase tracking-wider text-app-muted">Địa chỉ</p>
            <p class="mt-1 text-sm font-extrabold leading-6 text-app-ink">{{ $siteAddress }}</p>
          </div>
        </div>

        <div class="flex gap-3.5">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="mt-0.5 h-5 w-5 shrink-0 text-app-accent">
            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 0 0 2.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 0 1-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 0 0-1.091-.852H4.5A2.25 2.25 0 0 0 2.25 4.5v2.25Z" />
          </svg>
          <div class="min-w-0">
            <p class="text-[11px] font-extrabold uppercase tracking-wider text-app-muted">Hotline / Zalo</p>
            <a href="tel:{{ $sitePhone }}" class="mt-1 block text-base font-extrabold text-app-ink transition-colors hover:text-app-accent">{{ $sitePhoneDisplay }}</a>
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

  <div class="mt-5 space-y-4 border-t border-app-line pt-5">
    <div class="flex gap-3">
      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="mt-0.5 h-4 w-4 shrink-0 text-app-accent">
        <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
      </svg>
      <div class="min-w-0">
        <p class="text-[11px] font-extrabold uppercase tracking-wider text-app-muted">Địa chỉ</p>
        <p class="mt-0.5 text-sm font-extrabold leading-5 text-app-ink">{{ $siteAddress }}</p>
      </div>
    </div>

    <div class="flex gap-3">
      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="mt-0.5 h-4 w-4 shrink-0 text-app-accent">
        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 0 0 2.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 0 1-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 0 0-1.091-.852H4.5A2.25 2.25 0 0 0 2.25 4.5v2.25Z" />
      </svg>
      <div class="min-w-0">
        <p class="text-[11px] font-extrabold uppercase tracking-wider text-app-muted">Hotline / Zalo</p>
        <a href="tel:{{ $sitePhone }}" class="mt-0.5 block text-sm font-extrabold text-app-ink transition-colors hover:text-app-accent">{{ $sitePhoneDisplay }}</a>
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
  </div>
</main>
</div>
@endsection

@push('modals')
  @include('partials.popup-banner', ['popupForceShow' => true])
@endpush
