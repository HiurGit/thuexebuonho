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
  $siteFacebook = \App\Models\Setting::get('site_facebook', '{{ $siteFacebook }}');
  $collaborators = \App\Models\Collaborator::orderBy('sort_order')->get();
@endphp

@section('content-desktop')
@include('partials.marquee')
<div class="border-b border-app-line bg-white shadow-sm">
  <div class="mx-auto flex max-w-4xl items-center gap-4 px-6 py-3">
    <a href="javascript:history.back()" class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-app-accentSoft text-app-accent transition-all hover:bg-app-accent hover:text-white">
      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5"/></svg>
    </a>
    <h1 class="flex-1 text-center text-xl font-extrabold text-app-ink">Liên hệ</h1>
    <div class="w-10 shrink-0"></div>
  </div>
</div>

<main class="mx-auto flex max-w-4xl gap-6 px-6 py-8">
  <div class="w-96 shrink-0">
    <section class="rounded-2xl border border-app-line bg-white p-6 shadow-sm">
      <div class="flex items-center gap-4">
        <div class="flex h-16 w-16 shrink-0 items-center justify-center overflow-hidden rounded-2xl bg-app-accentSoft">
          @if($siteOwnerAvatar)
            <img src="{{ asset($siteOwnerAvatar) }}" alt="{{ $siteOwnerName }}" data-label="{{ $siteOwnerName }}" class="avatar-clickable h-full w-full object-cover">
          @else
            <img src="{{ asset('assets/image/logo.png') }}" alt="Logo" data-label="Thuê Xe Buôn Hồ" class="avatar-clickable h-full w-full object-contain p-1">
          @endif
        </div>
        <div>
          <h2 class="text-lg font-extrabold text-app-ink">{{ $siteOwnerName }}</h2>
          <p class="text-sm font-semibold text-app-accent">Chủ cửa hàng</p>
        </div>
      </div>

      <div class="mt-5 space-y-4">
        <div class="flex items-center gap-3">
          <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-app-accentSoft text-app-accent">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z"/></svg>
          </div>
          <div>
            <p class="text-xs font-semibold text-app-muted">Địa chỉ</p>
            <p class="text-base font-extrabold text-app-ink">{{ $siteAddress }}</p>
          </div>
        </div>

        <div class="flex items-center gap-3">
          <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-app-accentSoft text-app-accent">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 0 0 2.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 0 1-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 0 0-1.091-.852H4.5A2.25 2.25 0 0 0 2.25 4.5v2.25Z"/></svg>
          </div>
          <div>
            <p class="text-xs font-semibold text-app-muted">Hotline / Zalo</p>
            <a href="tel:{{ $sitePhone }}" class="text-base font-extrabold text-app-ink hover:text-app-accent">{{ $sitePhoneDisplay }}</a>
          </div>
        </div>
      </div>

      <div class="mt-5 flex gap-3">
        <a href="tel:{{ $sitePhone }}" class="flex flex-1 items-center justify-center gap-2 rounded-xl bg-app-accent px-4 py-3 text-sm font-extrabold text-white shadow-sm transition-all hover:bg-app-green">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 0 0 2.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 0 1-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 0 0-1.091-.852H4.5A2.25 2.25 0 0 0 2.25 4.5v2.25Z"/></svg>
          Gọi ngay
        </a>
        <a href="{{ $siteZaloUrl }}" target="_blank" rel="noopener" class="flex flex-1 items-center justify-center gap-2 rounded-xl bg-[#0068ff] px-4 py-3 text-sm font-extrabold text-white shadow-sm transition-all hover:bg-[#0056d6]">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5"><path stroke-linecap="round" stroke-linejoin="round" d="M8.625 9.75a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H8.25m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H12m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0h-.375m-13.5 3.01c0 1.6 1.123 2.994 2.707 3.227 1.087.16 2.185.283 3.293.369V21l4.184-4.183a1.14 1.14 0 0 1 .778-.332 48.294 48.294 0 0 0 5.83-.498c1.585-.233 2.708-1.626 2.708-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0 0 12 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018Z"/></svg>
          Chat Zalo
        </a>
      </div>

      <div class="mt-3 flex gap-3">
        <a href="{{ $siteFacebook }}" target="_blank" rel="noopener" class="flex flex-1 items-center justify-center gap-2 rounded-xl border border-app-line bg-white px-4 py-3 text-sm font-extrabold text-app-ink shadow-sm transition-all hover:bg-blue-50 hover:text-blue-600">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-5 w-5"><path d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z"/></svg>
          Facebook
        </a>
        <a href="{{ $siteMapUrl }}" target="_blank" rel="noopener" class="flex flex-1 items-center justify-center gap-2 rounded-xl border border-app-line bg-white px-4 py-3 text-sm font-extrabold text-app-ink shadow-sm transition-all hover:bg-red-50 hover:text-red-600">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z"/></svg>
          Xem bản đồ
        </a>
      </div>
    </section>

    <div class="mt-6 text-center">
      <a href="{{ route('index') }}" class="inline-flex items-center gap-2 rounded-xl bg-app-accent px-6 py-3 text-sm font-extrabold text-white shadow-sm transition-all hover:bg-app-green">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-4 w-4"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18"/></svg>
        Quay lại Trang chủ
      </a>
    </div>
  </div>

  <div class="flex-1">
    <section class="rounded-2xl border border-app-line bg-white shadow-sm">
      <div class="max-h-[calc(100vh-12rem)] overflow-y-auto p-6">
        <h2 class="mb-4 text-lg font-extrabold text-app-ink">Cộng tác viên</h2>

        <div class="divide-y divide-app-line">
          @foreach($collaborators as $index => $ctv)
          <div class="flex items-center gap-3 py-3 first:pt-0 last:pb-0">
            @if($ctv->avatar)
              <img src="{{ asset($ctv->avatar) }}" alt="{{ $ctv->name }}" data-label="{{ $ctv->name }}" data-sub="{{ $ctv->phone }}" class="avatar-clickable h-14 w-14 shrink-0 rounded-xl object-cover">
            @else
              <div class="flex h-14 w-14 shrink-0 items-center justify-center rounded-xl bg-orange-100 text-lg font-extrabold text-orange-600">
                {{ mb_substr($ctv->name, 0, 1) }}
              </div>
            @endif
            <div>
              <p class="text-sm font-extrabold text-app-ink">{{ $ctv->name }}</p>
              <p class="text-xs text-app-muted"><span class="font-semibold text-app-muted">Hotline:</span> <a href="tel:{{ $ctv->phone }}" class="font-semibold text-app-accent hover:underline">{{ $ctv->phone }}</a></p>
              <p class="text-xs text-app-muted"><span class="font-semibold text-app-muted">Địa chỉ:</span> {{ $ctv->address }}</p>
            </div>
          </div>
          @endforeach
        </div>
      </div>
    </section>
  </div>
</main>
@endsection

@section('content-mobile')
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

<main class="px-4 pb-28 pt-3">
  <section class="flex h-[calc(100vh-9rem)] flex-col overflow-hidden rounded-2xl bg-white shadow-sm">
    <div class="shrink-0 p-4 pb-0">
      <div class="flex items-center gap-3">
        <div class="flex h-20 w-20 shrink-0 items-center justify-center overflow-hidden rounded-2xl bg-app-accentSoft">
          @if($siteOwnerAvatar)
            <img src="{{ asset($siteOwnerAvatar) }}" alt="{{ $siteOwnerName }}" data-label="{{ $siteOwnerName }}" class="avatar-clickable h-full w-full object-cover">
          @else
            <img src="{{ asset('assets/image/logo.png') }}" alt="Logo" data-label="Thuê Xe Buôn Hồ" class="avatar-clickable h-full w-full object-contain p-1">
          @endif
        </div>
        <div>
          <h2 class="text-base font-extrabold text-app-ink">{{ $siteOwnerName }}</h2>
          <p class="text-xs font-semibold text-app-accent">Chủ cửa hàng</p>
        </div>
      </div>

      <div class="mt-3 space-y-2">
        <div class="flex items-center gap-3">
          <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-app-accentSoft text-app-accent">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-4 w-4"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z"/></svg>
          </div>
          <div>
            <p class="text-[11px] font-semibold text-app-muted">Địa chỉ</p>
            <p class="text-sm font-extrabold text-app-ink">{{ $siteAddress }}</p>
          </div>
        </div>

        <div class="flex items-center gap-3">
          <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-app-accentSoft text-app-accent">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-4 w-4"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 0 0 2.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 0 1-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 0 0-1.091-.852H4.5A2.25 2.25 0 0 0 2.25 4.5v2.25Z"/></svg>
          </div>
          <div>
            <p class="text-[11px] font-semibold text-app-muted">Hotline / Zalo</p>
            <a href="tel:{{ $sitePhone }}" class="text-sm font-extrabold text-app-ink hover:text-app-accent">{{ $sitePhoneDisplay }}</a>
          </div>
        </div>
      </div>

      <div class="mt-3 grid grid-cols-2 gap-2">
        <a href="tel:{{ $sitePhone }}" class="flex items-center justify-center gap-1.5 rounded-xl bg-app-accent px-3 py-2 text-xs font-extrabold text-white shadow-sm transition-all hover:bg-app-green active:scale-[0.98]">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-4 w-4"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 0 0 2.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 0 1-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 0 0-1.091-.852H4.5A2.25 2.25 0 0 0 2.25 4.5v2.25Z"/></svg>
          Gọi ngay
        </a>
        <a href="{{ $siteZaloUrl }}" target="_blank" rel="noopener" class="flex items-center justify-center gap-1.5 rounded-xl bg-[#0068ff] px-3 py-2 text-xs font-extrabold text-white shadow-sm transition-all hover:bg-[#0056d6] active:scale-[0.98]">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-4 w-4"><path stroke-linecap="round" stroke-linejoin="round" d="M8.625 9.75a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H8.25m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H12m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0h-.375m-13.5 3.01c0 1.6 1.123 2.994 2.707 3.227 1.087.16 2.185.283 3.293.369V21l4.184-4.183a1.14 1.14 0 0 1 .778-.332 48.294 48.294 0 0 0 5.83-.498c1.585-.233 2.708-1.626 2.708-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0 0 12 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018Z"/></svg>
          Chat Zalo
        </a>
        <a href="{{ $siteFacebook }}" target="_blank" rel="noopener" class="flex items-center justify-center gap-1.5 rounded-xl border border-app-line bg-white px-3 py-2 text-xs font-extrabold text-app-ink shadow-sm transition-all hover:bg-blue-50 hover:text-blue-600 active:scale-[0.98]">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-4 w-4"><path d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z"/></svg>
          Facebook
        </a>
        <a href="{{ $siteMapUrl }}" target="_blank" rel="noopener" class="flex items-center justify-center gap-1.5 rounded-xl border border-app-line bg-white px-3 py-2 text-xs font-extrabold text-app-ink shadow-sm transition-all hover:bg-red-50 hover:text-red-600 active:scale-[0.98]">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-4 w-4"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z"/></svg>
          Bản đồ
        </a>
      </div>
    </div>

    <div class="flex-1 overflow-y-auto p-4 pt-3">
      <h2 class="mb-3 text-base font-extrabold text-app-ink">Cộng tác viên</h2>

      <div class="divide-y divide-app-line">
        @foreach($collaborators as $index => $ctv)
        <div class="flex items-center gap-3 py-3 first:pt-0 last:pb-0">
          @if($ctv->avatar)
            <img src="{{ asset($ctv->avatar) }}" alt="{{ $ctv->name }}" data-label="{{ $ctv->name }}" data-sub="{{ $ctv->phone }}" class="avatar-clickable h-12 w-12 shrink-0 rounded-xl object-cover">
          @else
            <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-orange-100 text-base font-extrabold text-orange-600">
              {{ mb_substr($ctv->name, 0, 1) }}
            </div>
          @endif
          <div>
            <p class="text-sm font-extrabold text-app-ink">{{ $ctv->name }}</p>
            <p class="text-xs text-app-muted"><span class="font-semibold text-app-muted">Hotline:</span> <a href="tel:{{ $ctv->phone }}" class="font-semibold text-app-accent hover:underline">{{ $ctv->phone }}</a></p>
            <p class="text-xs text-app-muted"><span class="font-semibold text-app-muted">Địa chỉ:</span> {{ $ctv->address }}</p>
          </div>
        </div>
        @endforeach
      </div>
    </div>
  </section>
</main>
@endsection
