@extends('layouts.app')

@section('title', 'Danh Sách Xe - Thuê Xe Buôn Hồ')

@section('meta')
@php
    $listDesc = 'Danh sách xe tự lái và có tài xế tại Buôn Hồ, Đăk Lăk. Đa dạng dòng xe từ 4 chỗ, 7 chỗ giá rẻ chỉ từ 350k, thủ tục nhanh gọn uy tín.';
@endphp
<meta name="description" content="{{ $listDesc }}">
<meta property="og:title" content="Danh Sách Xe - Thuê Xe Buôn Hồ">
<meta property="og:description" content="{{ $listDesc }}">
<meta property="og:image" content="{{ asset('assets/image/banner-MXH-2.png') }}">
<meta name="twitter:image" content="{{ asset('assets/image/banner-MXH-2.png') }}">
<meta property="og:image:width" content="1200">
<meta property="og:image:height" content="630">
<meta property="og:url" content="{{ url()->current() }}">
<meta property="og:type" content="website">
<meta property="og:site_name" content="Thuê Xe Buôn Hồ">
<meta property="og:locale" content="vi_VN">
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="Danh Sách Xe - Thuê Xe Buôn Hồ">
<meta name="twitter:description" content="{{ $listDesc }}">
<meta property="og:image:type" content="image/png">
<meta property="og:image:alt" content="Danh Sách Xe - Thuê Xe Buôn Hồ">
@endsection

@section('content-desktop')
<section class="border-b border-app-line bg-white px-4 py-2 shadow-sm">
    <div class="mx-auto max-w-7xl">
        <h1 class="text-2xl font-extrabold text-app-ink">Danh sách xe</h1>
        <p class="mt-1 text-sm font-semibold text-app-muted">Danh sách xe tự lái và có tài xế tại Buôn Hồ, Đăk Lăk</p>
    </div>
</section>

<section class="border-b border-app-line">
    <div class="mx-auto max-w-7xl rounded-b-2xl bg-[#f5f5f4] px-6 pb-10">
        <div class="text-center">
            <span class="inline-block rounded-b-xl bg-[#5fcf86] px-8 py-3 text-3xl font-extrabold text-white">Danh sách xe</span>
        </div>
        @if($cars->count() > 0)
        <div class="mt-8 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
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
                        <h2 class="text-lg font-extrabold">{{ $car->name }}</h2>
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
        @else
        <p class="mt-8 text-center text-sm text-app-muted py-6">Chưa có xe nào.</p>
        @endif
    </div>
</section>
@endsection

@section('content-mobile')
<div class="border-b border-app-line bg-white px-4 py-2 shadow-sm">
    <div class="flex items-center gap-3">
        <a href="javascript:history.back()" class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-app-accentSoft text-app-accent transition-all hover:bg-app-accent hover:text-white">
            <i class="ri-arrow-left-s-line text-lg"></i>
        </a>
        <h1 class="flex-1 text-center text-lg font-extrabold">Danh sách xe</h1>
        <div class="w-9 shrink-0"></div>
    </div>
</div>

<section class="bg-white px-4 pb-28 pt-4">
    <div class="space-y-3">
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
                        <h2 class="text-lg font-extrabold">{{ $car->name }}</h2>
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
@endsection
