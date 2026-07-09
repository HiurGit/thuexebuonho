<!DOCTYPE html>
<html lang="vi">
<head>
  @include('partials.head')
</head>
<body class="bg-app-bg font-sans text-app-ink antialiased">

<div id="desktop-wrapper" class="hidden lg:block">
  {{-- HEADER --}}
  <header class="sticky top-0 z-50 border-b border-app-line bg-white/95 backdrop-blur-md">
    <div class="mx-auto flex max-w-7xl items-center justify-between px-6 py-3">
      <a id="logo-link-desktop" href="{{ route('index') }}" class="flex items-center gap-3">
        <div class="flex h-12 w-12 items-center justify-center overflow-hidden rounded-xl bg-white">
          <img src="{{ asset('assets/image/logo.png') }}" alt="Logo" class="h-full w-full object-contain">
        </div>
        <div>
          <p class="text-lg font-extrabold leading-none text-app-ink">THUÊ XE TỰ LÁI BUÔN HỒ</p>
          <p class="mt-0.5 text-xs font-bold uppercase text-app-muted">Cho thuê xe tự lái & có tài xế</p>
        </div>
      </a>
      <nav class="hidden items-center gap-1 lg:flex">
        <a href="{{ route('index') }}#trang-chu" class="rounded-xl px-4 py-2 text-sm font-bold text-app-accent transition-colors hover:bg-app-accentSoft">Trang chủ</a>
        <a href="{{ route('index') }}#danh-sach-xe" class="rounded-xl px-4 py-2 text-sm font-bold text-app-muted transition-colors hover:bg-app-accentSoft hover:text-app-accent">Danh sách xe</a>
        <a href="{{ route('index') }}#dich-vu" class="rounded-xl px-4 py-2 text-sm font-bold text-app-muted transition-colors hover:bg-app-accentSoft hover:text-app-accent">Dịch vụ</a>
        <a href="{{ route('index') }}#bang-gia" class="rounded-xl px-4 py-2 text-sm font-bold text-app-muted transition-colors hover:bg-app-accentSoft hover:text-app-accent">Bảng giá</a>
        <a href="{{ route('index') }}#chung-toi" class="rounded-xl px-4 py-2 text-sm font-bold text-app-muted transition-colors hover:bg-app-accentSoft hover:text-app-accent">Về chúng tôi</a>
        <a href="{{ route('services') }}" class="rounded-xl px-4 py-2 text-sm font-bold text-app-muted transition-colors hover:bg-app-accentSoft hover:text-app-accent">Dịch vụ khác</a>
        <a href="{{ route('terms') }}" class="rounded-xl px-4 py-2 text-sm font-bold text-app-muted transition-colors hover:bg-app-accentSoft hover:text-app-accent">Điều khoản</a>
      </nav>
      <div class="flex items-center gap-3">
        <a href="tel:0964918047" class="hidden items-center gap-2 rounded-xl bg-app-accent px-4 py-2.5 text-sm font-extrabold text-white transition-all hover:bg-app-green sm:flex">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-4 w-4">
            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 0 0 2.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 0 1-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 0 0-1.091-.852H4.5A2.25 2.25 0 0 0 2.25 4.5v2.25Z" />
          </svg>
          0964.918.047
        </a>
        <button id="menu-toggle" class="flex h-11 w-11 items-center justify-center rounded-xl border border-app-line bg-white text-lg text-app-ink lg:hidden">
          <i class="ri-menu-3-line"></i>
        </button>
      </div>
    </div>
  </header>

 
  <div id="desktop-content">
  @yield('content-desktop')
  </div>

  {{-- FOOTER --}}
  <footer class="bg-app-dark text-white">
    <div class="mx-auto max-w-7xl px-6 py-12">
      <div class="grid gap-8 sm:grid-cols-2 lg:grid-cols-4">
        <div>
          <div class="flex items-center gap-3">
            <div class="flex h-12 w-12 items-center justify-center overflow-hidden rounded-xl bg-white">
              <img src="{{ asset('assets/image/logo.png') }}" alt="Logo" class="h-full w-full object-contain">
            </div>
            <div>
              <p class="text-base font-extrabold">THUÊ XE TỰ LÁI</p>
              <p class="text-xs font-bold text-white/60">BUÔN HỒ - ĐĂK LĂK</p>
            </div>
          </div>
          <p class="mt-4 text-sm leading-6 text-white/70">Dịch vụ cho thuê xe tự lái và có tài xế tại Buôn Hồ, Đăk Lăk. Uy tín, giá rẻ, thủ tục nhanh gọn.</p>
        </div>

        <div>
          <h3 class="text-sm font-extrabold uppercase tracking-wider text-white/80">Liên kết nhanh</h3>
          <ul class="mt-4 space-y-2">
            <li><a href="#danh-sach-xe" class="text-sm text-white/60 transition-colors hover:text-white">Danh sách xe</a></li>
            <li><a href="#dich-vu" class="text-sm text-white/60 transition-colors hover:text-white">Dịch vụ</a></li>
            <li><a href="#bang-gia" class="text-sm text-white/60 transition-colors hover:text-white">Bảng giá</a></li>
            <li><a href="{{ route('services') }}" class="text-sm text-white/60 transition-colors hover:text-white">Dịch vụ khác</a></li>
          </ul>
        </div>

        <div>
          <h3 class="text-sm font-extrabold uppercase tracking-wider text-white/80">Chính sách</h3>
          <ul class="mt-4 space-y-2">
            <li><a href="{{ route('terms') }}" class="text-sm text-white/60 transition-colors hover:text-white">Điều khoản & Điều kiện</a></li>
            <li><a href="{{ route('privacy') }}" class="text-sm text-white/60 transition-colors hover:text-white">Chính sách bảo mật</a></li>
            <li><a href="{{ route('huongdan') }}" class="text-sm text-white/60 transition-colors hover:text-white">Hướng dẫn</a></li>
            <li><a href="{{ route('da-giao') }}" class="text-sm text-white/60 transition-colors hover:text-white">Đã giao</a></li>
          </ul>
        </div>

        <div>
          <h3 class="text-sm font-extrabold uppercase tracking-wider text-white/80">Liên hệ</h3>
          <ul class="mt-4 space-y-3">
            <li class="flex items-center gap-3">
              <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-white/10">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-4 w-4 text-app-accent">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 0 0 2.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 0 1-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 0 0-1.091-.852H4.5A2.25 2.25 0 0 0 2.25 4.5v2.25Z" />
                </svg>
              </div>
              <div>
                <p class="text-xs text-white/50">Hotline / Zalo</p>
                <a href="tel:0964918047" class="text-sm font-extrabold text-white hover:text-app-accent">0964.918.047</a>
              </div>
            </li>
            <li class="flex items-center gap-3">
              <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-white/10">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-4 w-4 text-app-accent">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                  <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                </svg>
              </div>
              <div>
                <p class="text-xs text-white/50">Địa chỉ</p>
                <p class="text-sm font-semibold text-white">07 Chu Văn An, Buôn Hồ</p>
              </div>
            </li>
            <li class="flex gap-2 pt-2">
              <a href="https://zalo.me/0964918047" target="_blank" rel="noopener" class="flex h-9 w-9 items-center justify-center rounded-lg bg-white/10 text-white transition-colors hover:bg-[#0068ff]">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-4 w-4">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M8.625 9.75a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H8.25m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H12m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0h-.375m-13.5 3.01c0 1.6 1.123 2.994 2.707 3.227 1.087.16 2.185.283 3.293.369V21l4.184-4.183a1.14 1.14 0 0 1 .778-.332 48.294 48.294 0 0 0 5.83-.498c1.585-.233 2.708-1.626 2.708-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0 0 12 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018Z" />
                </svg>
              </a>
              <a href="https://www.facebook.com/9999NDT/" target="_blank" rel="noopener" class="flex h-9 w-9 items-center justify-center rounded-lg bg-white/10 text-white transition-colors hover:bg-blue-600">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-4 w-4">
                  <path d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z"/>
                </svg>
              </a>
            </li>
          </ul>
        </div>
      </div>
    </div>
    <div class="border-t border-white/10">
      <div class="mx-auto max-w-7xl px-6 py-4 text-center">
        <p class="text-sm text-white/50">&copy; 2026 Thuê Xe Buôn Hồ. Tất cả quyền được bảo lưu.</p>
      </div>
    </div>
  </footer>

</div>

{{-- MODALS --}}
@include('partials.modals')
@stack('modals')

{{-- MOBILE VERSION --}}
<div id="mobile-wrapper" class="block lg:hidden">
  <div class="mx-auto flex h-dvh max-w-[460px] flex-col overflow-hidden bg-app-bg md:my-6 md:min-h-[920px] md:border md:border-white/60">

    {{-- MOBILE HEADER --}}
    <header class="shrink-0">
      <div class="border-b border-app-line bg-white px-3.5 py-2">
        <div class="flex items-center justify-between">
          <div class="flex items-center gap-3">
            <a id="logo-link" href="{{ route('index') }}" class="flex shrink-0">
              <div class="flex h-11 w-11 items-center justify-center bg-white overflow-hidden">
                <img src="{{ asset('assets/image/logo.png') }}" alt="Logo" class="h-full w-full object-contain">
              </div>
            </a>
            <div>
              <span class="text-base font-extrabold leading-none text-app-ink">THUÊ XE TỰ LÁI BUÔN HỒ</span>
              <a href="{{ route('services') }}" class="mt-1 block text-xs font-bold uppercase text-app-muted no-underline hover:text-app-accent">Nhận chạy các dịch vụ khác</a>
            </div>
          </div>

          <div class="flex items-center gap-2">
            <button id="menu-btn" class="flex h-11 w-11 items-center justify-center rounded-2xl bg-app-accent text-lg text-white">
              <i class="ri-menu-3-line"></i>
            </button>
          </div>
        </div>
        @if(request()->routeIs('index'))
        <div class="nav-swiper-container overflow-hidden">
          <div class="swiper nav-swiper">
            <div class="swiper-wrapper">
              <div class="swiper-slide w-auto">
                <a href="#trang-chu" class="whitespace-nowrap rounded-[10px] bg-app-accentSoft px-3 py-2.5 text-[12px] font-extrabold text-app-accent">Trang chủ</a>
              </div>
              <div class="swiper-slide w-auto">
                <a href="#danh-sach-xe" class="whitespace-nowrap rounded-[10px] px-2 py-2.5 text-[12px] font-extrabold text-app-muted">Danh sách xe</a>
              </div>
              <div class="swiper-slide w-auto">
                <a href="#dich-vu" class="whitespace-nowrap rounded-[10px] px-2 py-2.5 text-[12px] font-extrabold text-app-muted">Dịch vụ khác</a>
              </div>
              <div class="swiper-slide w-auto">
                <a href="#bang-gia" class="whitespace-nowrap rounded-[10px] px-2 py-2.5 text-[12px] font-extrabold text-app-muted">Cách tính giá</a>
              </div>
              <div class="swiper-slide w-auto">
                <a href="#huong-dan" class="whitespace-nowrap rounded-[10px] px-2 py-2.5 text-[12px] font-extrabold text-app-muted">Liên hệ thuê xe</a>
              </div>
              <div class="swiper-slide w-auto">
                <a href="#phat-sinh" class="whitespace-nowrap rounded-[10px] px-2 py-2.5 text-[12px] font-extrabold text-app-muted">Có Thể Phát Sinh</a>
              </div>
              <div class="swiper-slide w-auto">
                <a href="#chung-toi" class="whitespace-nowrap rounded-[10px] px-2 py-2.5 text-[12px] font-extrabold text-app-muted">Chúng tôi có ?</a>
              </div>
            </div>
          </div>
        </div>
        @endif
      </div>
    </header>

    {{-- MOBILE CONTENT --}}
    <main id="mobile-content" class="flex-1 overflow-y-auto" style="scroll-behavior: smooth">
      @yield('content-mobile')
    </main>

    @if(!request()->routeIs('car-detail'))
    {{-- MOBILE BOTTOM NAV --}}
    <nav class="fixed bottom-0 left-1/2 z-50 w-full max-w-[460px] -translate-x-1/2 border-t border-app-line bg-white/95 backdrop-blur-md">
      <div class="flex items-center justify-around px-2 py-1" id="bottom-nav">
        <a href="{{ route('index') }}" class="nav-item flex flex-col items-center gap-0.5 rounded-xl px-3 py-1.5 transition-colors @if(request()->routeIs('index')) text-app-accent @else text-app-muted @endif" data-nav="home">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6 w-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
          </svg>
          <span class="text-[10px] font-extrabold">Trang chủ</span>
        </a>

        <a href="{{ route('da-giao') }}" class="nav-item flex flex-col items-center gap-0.5 rounded-xl px-3 py-1.5 transition-colors @if(request()->routeIs('da-giao')) text-app-accent @else text-app-muted @endif" data-nav="orders">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6 w-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 18.75h-9m9 0a3 3 0 0 1 3 3h-15a3 3 0 0 1 3-3m9 0v-3.375c0-.621-.503-1.125-1.125-1.125h-.871M7.5 18.75v-3.375c0-.621.504-1.125 1.125-1.125h.872m5.007 0H9.497m5.007 0a7.454 7.454 0 0 1-.982-3.172M9.497 14.25a7.454 7.454 0 0 0 .981-3.172M5.25 4.236c-.982.143-1.954.317-2.916.52A6.003 6.003 0 0 0 7.73 9.728M5.25 4.236V4.5c0 2.108.966 3.99 2.48 5.228M5.25 4.236V2.721C7.456 2.41 9.71 2.25 12 2.25c2.291 0 4.545.16 6.75.47v1.516M7.73 9.728a6.726 6.726 0 0 0 2.748 1.35m8.272-6.842V4.5c0 2.108-.966 3.99-2.48 5.228m2.48-5.492a46.32 46.32 0 0 1 2.916.52 6.003 6.003 0 0 1-5.395 4.972m0 0a6.726 6.726 0 0 1-2.749 1.35m0 0a6.772 6.772 0 0 1-3.044 0" />
          </svg>
          <span class="text-[10px] font-extrabold">Đã giao</span>
        </a>

        <a href="{{ route('services') }}" class="nav-item flex flex-col items-center gap-0.5 rounded-xl px-3 py-1.5 transition-colors @if(request()->routeIs('services')) text-app-accent @else text-app-muted @endif" data-nav="services">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6 w-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 0 1 6 3.75h2.25A2.25 2.25 0 0 1 10.5 6v2.25a2.25 2.25 0 0 1-2.25 2.25H6a2.25 2.25 0 0 1-2.25-2.25V6ZM3.75 15.75A2.25 2.25 0 0 1 6 13.5h2.25a2.25 2.25 0 0 1 2.25 2.25V18a2.25 2.25 0 0 1-2.25 2.25H6A2.25 2.25 0 0 1 3.75 18v-2.25ZM13.5 6a2.25 2.25 0 0 1 2.25-2.25H18A2.25 2.25 0 0 1 20.25 6v2.25A2.25 2.25 0 0 1 18 10.5h-2.25a2.25 2.25 0 0 1-2.25-2.25V6ZM13.5 15.75a2.25 2.25 0 0 1 2.25-2.25H18a2.25 2.25 0 0 1 2.25 2.25V18A2.25 2.25 0 0 1 18 20.25h-2.25A2.25 2.25 0 0 1 13.5 18v-2.25Z" />
          </svg>
          <span class="text-[10px] font-extrabold">Dịch vụ</span>
        </a>

        <a id="nav-contact" href="#" class="nav-item flex flex-col items-center gap-0.5 rounded-xl px-3 py-1.5 text-app-muted transition-colors" data-nav="contact">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6 w-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 0 0 2.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 0 1-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 0 0-1.091-.852H4.5A2.25 2.25 0 0 0 2.25 4.5v2.25Z" />
          </svg>
          <span class="text-[10px] font-extrabold">Liên hệ</span>
        </a>

        <a href="{{ route('huongdan') }}" class="nav-item relative flex flex-col items-center gap-0.5 rounded-xl px-3 py-1.5 transition-colors @if(request()->routeIs('huongdan')) text-app-accent @else text-app-muted @endif" data-nav="huongdan">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6 w-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
          </svg>
          <span class="text-[10px] font-extrabold">Hướng dẫn</span>
        </a>
      </div>
      <div class="h-[env(safe-area-inset-bottom)]"></div>
    </nav>
    @else
    @yield('mobile-fixed-bottom')
    @endif
  </div>
</div>

{{-- DRAWER --}}
<div id="drawer-overlay" class="fixed inset-0 z-[70] bg-black/50 opacity-0 pointer-events-none hidden"></div>

<!-- Drawer panel -->
<div id="drawer-panel" class="fixed inset-y-0 right-0 z-[80] flex w-[360px] translate-x-full flex-col hidden bg-[#F7F7F7]">
  <div class="flex items-center justify-between px-5 p-5">
    <span class="text-xl font-bold text-app-ink mt-4 mb-3">Thông tin khác</span>
    <button id="drawer-close" class="flex h-9 w-9 items-center justify-center rounded-full bg-[#E8E8E8]">
      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="#333" class="h-5 w-5"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12"/></svg>
    </button>
  </div>

  <div class="flex-1 overflow-y-auto px-5">
    <!-- Card 1: Đăng nhập/Đăng ký - Liên hệ Zalo - Vào nhóm Zalo -->
    <div class="bg-white rounded-[20px] shadow-[0_2px_12px_rgba(0,0,0,0.06)]">
      <a href="#" class="flex items-center h-[52px] px-5">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="#333" class="h-5 w-5 shrink-0">
          <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15m3 0 3-3m0 0-3-3m3 3H9"/>
        </svg>
        <span class="flex-1 text-base font-medium text-app-ink ml-3">Đăng nhập / Đăng ký</span>
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="#999" class="h-4 w-4 shrink-0">
          <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5"/>
        </svg>
      </a>
      <div class="h-px bg-[#EEEEEE] mx-5"></div>
      <a href="https://zalo.me/0964918047" target="_blank" rel="noopener" class="flex items-center h-[52px] px-5">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="#333" class="h-5 w-5 shrink-0">
          <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 8.511c.884.284 1.5 1.128 1.5 2.097v4.286c0 1.136-.847 2.1-1.98 2.193-.34.027-.68.052-1.02.072v3.091l-3-3c-1.354 0-2.694-.055-4.02-.163a2.115 2.115 0 0 1-.825-.242m9.345-8.334a2.126 2.126 0 0 0-.476-.095 48.64 48.64 0 0 0-8.048 0c-1.131.094-1.976 1.057-1.976 2.192v4.286c0 .837.46 1.58 1.155 1.951m9.345-8.334V6.637c0-1.621-1.152-3.026-2.76-3.235A48.455 48.455 0 0 0 11.25 3c-2.115 0-4.198.137-6.24.402-1.608.209-2.76 1.614-2.76 3.235v6.226c0 1.621 1.152 3.026 2.76 3.235.577.075 1.157.14 1.74.194V21l4.155-4.155"/>
        </svg>
        <span class="flex-1 text-base font-medium text-app-ink ml-3">Liên hệ Zalo</span>
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="#999" class="h-4 w-4 shrink-0">
          <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5"/>
        </svg>
      </a>
      <div class="h-px bg-[#EEEEEE] mx-5"></div>
      <a href="#" class="flex items-center h-[52px] px-5">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="#333" class="h-5 w-5 shrink-0">
          <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z"/>
        </svg>
        <span class="flex-1 text-base font-medium text-app-ink ml-3">Vào nhóm Zalo</span>
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="#999" class="h-4 w-4 shrink-0">
          <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5"/>
        </svg>
      </a>
    </div>

    <!-- Card 2: Thông tin -->
    <div class="mt-3 bg-white rounded-[20px] shadow-[0_2px_12px_rgba(0,0,0,0.06)]">
      <a href="tel:0964918047" class="flex items-center h-[52px] px-5">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="#333" class="h-5 w-5 shrink-0">
          <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 0 0 2.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 0 1-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 0 0-1.091-.852H4.5A2.25 2.25 0 0 0 2.25 4.5v2.25Z"/>
        </svg>
        <span class="flex-1 text-base font-medium text-app-ink ml-3">0964.918.047</span>
      </a>
      <div class="h-px bg-[#EEEEEE] mx-5"></div>
      <div class="flex items-center h-[52px] px-5">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="#333" class="h-5 w-5 shrink-0">
          <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z"/>
        </svg>
        <span class="flex-1 text-base font-medium text-app-ink ml-3">07 Chu Văn An, Buôn Hồ, Đăk Lăk</span>
      </div>
    </div>

    <!-- Card 3: Chính sách -->
    <div class="mt-3 mb-6 bg-white rounded-[20px] shadow-[0_2px_12px_rgba(0,0,0,0.06)]">
      <a href="{{ route('services') }}" class="flex items-center h-[52px] px-5">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="#333" class="h-5 w-5 shrink-0">
          <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 0 1 6 3.75h2.25A2.25 2.25 0 0 1 10.5 6v2.25a2.25 2.25 0 0 1-2.25 2.25H6a2.25 2.25 0 0 1-2.25-2.25V6ZM3.75 15.75A2.25 2.25 0 0 1 6 13.5h2.25a2.25 2.25 0 0 1 2.25 2.25V18A2.25 2.25 0 0 1 6 20.25h-2.25A2.25 2.25 0 0 1 3.75 18v-2.25ZM13.5 6a2.25 2.25 0 0 1 2.25-2.25H18A2.25 2.25 0 0 1 20.25 6v2.25a2.25 2.25 0 0 1-2.25 2.25h-2.25a2.25 2.25 0 0 1-2.25-2.25V6ZM13.5 15.75a2.25 2.25 0 0 1 2.25-2.25H18a2.25 2.25 0 0 1 2.25 2.25V18A2.25 2.25 0 0 1 18 20.25h-2.25A2.25 2.25 0 0 1 13.5 18v-2.25Z" />
        </svg>
        <span class="flex-1 text-base font-medium text-app-ink ml-3">Dịch vụ</span>
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="#999" class="h-4 w-4 shrink-0">
          <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5"/>
        </svg>
      </a>
      <div class="h-px bg-[#EEEEEE] mx-5"></div>
      <a href="{{ route('huongdan') }}" class="flex items-center h-[52px] px-5">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="#333" class="h-5 w-5 shrink-0">
          <path stroke-linecap="round" stroke-linejoin="round" d="M6.827 6.175A2.31 2.31 0 0 1 5.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18V9.574c0-1.067-.75-1.994-1.802-2.16a47.474 47.474 0 0 0-1.134-.175 2.31 2.31 0 0 1-1.64-1.055l-.822-1.316a2.192 2.192 0 0 0-1.736-1.039 48.774 48.774 0 0 0-5.232 0 2.192 2.192 0 0 0-1.736 1.039l-.821 1.316Z"/>
          <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 12.75a4.5 4.5 0 1 1-9 0 4.5 4.5 0 0 1 9 0Z"/>
        </svg>
        <span class="flex-1 text-base font-medium text-app-ink ml-3">Hướng dẫn</span>
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="#999" class="h-4 w-4 shrink-0">
          <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5"/>
        </svg>
      </a>
      <div class="h-px bg-[#EEEEEE] mx-5"></div>
      <a href="{{ route('terms') }}" class="flex items-center h-[52px] px-5">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="#333" class="h-5 w-5 shrink-0">
          <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z"/>
        </svg>
        <span class="flex-1 text-base font-medium text-app-ink ml-3">Điều khoản & Điều kiện</span>
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="#999" class="h-4 w-4 shrink-0">
          <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5"/>
        </svg>
      </a>
      <div class="h-px bg-[#EEEEEE] mx-5"></div>
      <a href="{{ route('privacy') }}" class="flex items-center h-[52px] px-5">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="#333" class="h-5 w-5 shrink-0">
          <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75m-3-7.036A11.959 11.959 0 0 1 3.598 6 11.99 11.99 0 0 0 3 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285Z"/>
        </svg>
        <span class="flex-1 text-base font-medium text-app-ink ml-3">Chính sách bảo mật</span>
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="#999" class="h-4 w-4 shrink-0">
          <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5"/>
        </svg>
      </a>
      <div class="h-px bg-[#EEEEEE] mx-5"></div>
      <a href="{{ route('index') }}?desktop" class="flex items-center h-[52px] px-5">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="#333" class="h-5 w-5 shrink-0">
          <path stroke-linecap="round" stroke-linejoin="round" d="M9 17.25v1.007a3 3 0 0 1-.879 2.122L7.5 21h9l-.621-.621A3 3 0 0 1 15 18.257V17.25m6-12V15a2.25 2.25 0 0 1-2.25 2.25H5.25A2.25 2.25 0 0 1 3 15V5.25m18 0A2.25 2.25 0 0 0 18.75 3H5.25A2.25 2.25 0 0 0 3 5.25m18 0V12a2.25 2.25 0 0 1-2.25 2.25H5.25A2.25 2.25 0 0 1 3 12V5.25"/>
        </svg>
        <span class="flex-1 text-base font-medium text-app-ink ml-3">Xem bản Desktop</span>
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="#999" class="h-4 w-4 shrink-0">
          <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5"/>
        </svg>
      </a>
    </div>
  </div>
</div>

{{-- TOAST NOTIFICATION --}}
<div id="toast" class="fixed top-1/2 left-1/2 z-[100] -translate-x-1/2 -translate-y-1/2 hidden items-center gap-3 rounded-2xl bg-white px-6 py-4 shadow-xl border border-app-line" style="width: 300px; max-width: 90vw">
  <svg id="toast-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6 w-6 shrink-0 text-amber-500">
    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
  </svg>
  <p id="toast-msg" class="text-sm font-bold text-app-ink"></p>
</div>
@include('partials.scripts')

</body>
</html>
