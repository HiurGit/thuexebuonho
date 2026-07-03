@extends('layouts.app')

@section('title', 'Đã giao - Thuê Xe Buôn Hồ')

@section('meta')
<meta name="description" content="Thành tích phục vụ của Thuê Xe Tự Lái Buôn Hồ - hình ảnh giao xe thực tế cho khách hàng.">
<meta property="og:title" content="Đã giao - Thuê Xe Buôn Hồ">
<meta property="og:description" content="Hình ảnh giao xe thực tế, uy tín làm nên thương hiệu.">
<meta property="og:image" content="{{ asset('assets/image/bannerMXH.jpg') }}">
<meta property="og:image:width" content="1200">
<meta property="og:image:height" content="630">
<meta property="og:url" content="{{ url()->current() }}">
<meta property="og:type" content="website">
<meta property="og:site_name" content="Thuê Xe Buôn Hồ">
<meta property="og:locale" content="vi_VN">
<meta property="og:image:type" content="image/jpeg">
<meta property="og:image:alt" content="Thuê Xe Buôn Hồ - Đã giao">
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="Đã giao - Thuê Xe Buôn Hồ">
<meta name="twitter:description" content="Hình ảnh giao xe thực tế, uy tín làm nên thương hiệu.">
<meta name="twitter:image" content="{{ asset('assets/image/bannerMXH.jpg') }}">
@endsection

@php
    $proofs = $deliveredProofs ?? collect();
@endphp

@section('content-desktop')
<div class="border-b border-app-line bg-white shadow-sm">
  <div class="mx-auto flex max-w-7xl items-center justify-between px-6 py-3">
    <div class="flex items-center gap-3">
      <a href="{{ route('index') }}" class="flex h-9 w-9 items-center justify-center rounded-xl bg-app-accentSoft text-app-accent transition-all hover:bg-app-accent hover:text-white">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" /></svg>
      </a>
      <h1 class="text-xl font-extrabold">Đã giao</h1>
    </div>
    <div class="flex items-center gap-2">
      <button id="guide-btn" class="flex h-9 w-9 items-center justify-center rounded-xl bg-amber-50 text-amber-500 transition-all">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5">
          <path stroke-linecap="round" stroke-linejoin="round" d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z" />
        </svg>
      </button>
      <button id="search-toggle" class="flex h-9 w-9 items-center justify-center rounded-xl bg-app-accentSoft text-app-accent transition-all">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5">
          <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
        </svg>
      </button>
    </div>
  </div>
</div>

<div id="guide-popup" class="hidden border-b border-app-line bg-amber-50/80">
  <div class="mx-auto max-w-7xl px-6 py-3">
    <div class="rounded-xl border border-amber-200 bg-white p-4 text-sm font-bold text-app-ink shadow-sm">
      <p>Đây là nơi shop ghi lại những khách hàng đã được phục vụ:</p>
      <p>• Hình ảnh giao xe thực tế</p>
      <p>• Khách đã nhận xe</p>
      <p>• Các chuyến giao xe hoàn thành</p>
      <p class="text-amber-600">→ Nhằm tăng uy tín và sự tin tưởng cho khách hàng mới.</p>
    </div>
  </div>
</div>

<div id="search-bar" class="hidden border-b border-app-line bg-white">
  <div class="mx-auto max-w-7xl px-6 py-3">
    <div class="relative mx-auto max-w-lg">
      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-app-muted"><path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" /></svg>
      <input id="search-input" type="text" placeholder="Tìm theo tiêu đề, ngày..." class="w-full rounded-full border border-app-line bg-app-bg py-2.5 pl-9 pr-4 text-sm font-bold text-app-ink outline-none placeholder:text-app-muted/60 focus:border-app-accent focus:ring-1 focus:ring-app-accent/30">
      <button id="search-clear" class="absolute right-2 top-1/2 hidden h-6 w-6 -translate-y-1/2 items-center justify-center rounded-full bg-app-muted/20 text-app-muted">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-3 w-3"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" /></svg>
      </button>
    </div>
  </div>
</div>

<main>
  <section class="mx-auto max-w-7xl px-6 py-8">
    <div id="proof-grid" class="grid grid-cols-5 gap-4">
      @forelse($proofs as $proof)
      <div class="proof-card">
        <div class="aspect-square overflow-hidden rounded-xl bg-gradient-to-br from-emerald-100 to-emerald-50">
          <img src="{{ asset($proof->image_path) }}" alt="{{ $proof->title }}" class="h-full w-full object-cover">
        </div>
        <p class="mt-1.5 truncate text-sm font-extrabold">{{ $proof->title }}</p>
        <p class="truncate text-xs font-bold text-app-muted">{{ $proof->created_at->format('d/m/Y') }}</p>
      </div>
      @empty
      <div class="col-span-full rounded-2xl border border-dashed border-app-line bg-white px-6 py-14 text-center text-sm font-bold text-app-muted">
        Chưa có dữ liệu đã giao.
      </div>
      @endforelse
    </div>

    <p id="search-empty" class="mt-10 hidden text-center text-sm font-bold text-app-muted">Không tìm thấy kết quả</p>
  </section>
</main>
@endsection

@section('content-mobile')
<div class="border-b border-app-line bg-white px-4 py-2 shadow-sm">
  <div class="flex items-center justify-between">
    <a href="{{ route('index') }}" class="flex h-9 w-9 items-center justify-center rounded-xl bg-app-accentSoft text-app-accent transition-all hover:bg-app-accent hover:text-white">
      <i class="ri-arrow-left-s-line text-lg"></i>
    </a>
    <div class="flex items-center gap-2">
      <h1 class="text-lg font-extrabold">Đã giao</h1>
    </div>
    <div class="relative">
      <button id="mobile-actions-toggle" class="flex h-10 w-10 items-center justify-center rounded-xl border border-app-line text-app-accent transition-all">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="h-6 w-6">
          <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
        </svg>
      </button>
      <div id="mobile-actions-menu" class="absolute right-0 top-full z-50 mt-2 hidden flex-col gap-2 rounded-2xl border border-app-line bg-white p-2 shadow-card">
        <button id="guide-btn-mobile" class="flex h-10 w-10 items-center justify-center rounded-xl border border-app-line">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="h-6 w-6 text-amber-500">
            <path stroke-linecap="round" stroke-linejoin="round" d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z" />
          </svg>
        </button>
        <button id="search-toggle-mobile" class="flex h-10 w-10 items-center justify-center rounded-xl border border-app-line">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="h-6 w-6 text-app-accent">
            <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
          </svg>
        </button>
      </div>
    </div>
  </div>
</div>

<div id="guide-popup-mobile" class="hidden border-b border-app-line bg-amber-50/80 px-4 py-3">
  <div class="rounded-xl border border-amber-200 bg-white p-3 text-xs font-bold text-app-ink shadow-sm">
    <p>Đây là nơi shop ghi lại những khách hàng đã được phục vụ:</p>
    <p>• Hình ảnh giao xe thực tế</p>
    <p>• Khách đã nhận xe</p>
    <p>• Các chuyến giao xe hoàn thành</p>
    <p class="text-amber-600">→ Nhằm tăng uy tín và sự tin tưởng cho khách hàng mới.</p>
  </div>
</div>

<div id="search-bar-mobile" class="hidden border-b border-app-line bg-white px-4 py-3">
  <div class="relative">
    <i class="ri-search-line absolute left-3 top-1/2 -translate-y-1/2 text-sm text-app-muted"></i>
    <input id="search-input-mobile" type="text" placeholder="Tìm theo tiêu đề, ngày..." class="w-full rounded-full border border-app-line bg-app-bg py-2.5 pl-9 pr-4 text-sm font-bold text-app-ink outline-none placeholder:text-app-muted/60 focus:border-app-accent focus:ring-1 focus:ring-app-accent/30">
    <button id="search-clear-mobile" class="absolute right-2 top-1/2 hidden h-6 w-6 -translate-y-1/2 items-center justify-center rounded-full bg-app-muted/20 text-app-muted">
      <i class="ri-close-line text-xs"></i>
    </button>
  </div>
</div>

<section class="px-4 pb-28 pt-4">
  <div id="proof-grid-mobile" class="grid grid-cols-3 gap-2">
    @forelse($proofs as $proof)
    <div class="proof-card">
      <div class="aspect-square overflow-hidden rounded-xl bg-gradient-to-br from-emerald-100 to-emerald-50">
        <img src="{{ asset($proof->image_path) }}" alt="{{ $proof->title }}" class="h-full w-full object-cover">
      </div>
      <p class="mt-1 truncate text-[10px] font-extrabold">{{ $proof->title }}</p>
      <p class="truncate text-[9px] font-bold text-app-muted">{{ $proof->created_at->format('d/m/Y') }}</p>
    </div>
    @empty
    <div class="col-span-full rounded-2xl border border-dashed border-app-line bg-white px-4 py-10 text-center text-sm font-bold text-app-muted">
      Chưa có dữ liệu đã giao.
    </div>
    @endforelse
  </div>

  <p id="search-empty-mobile" class="mt-10 hidden text-center text-sm font-bold text-app-muted">Không tìm thấy kết quả</p>
</section>
@endsection
