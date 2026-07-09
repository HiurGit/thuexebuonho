@php
  $sitePhone = \App\Models\Setting::get('site_phone', '0964918047');
  $sitePhoneDisplay = preg_replace('/(\d{4})(\d{3})(\d{3,})/', '$1.$2.$3', $sitePhone) ?: $sitePhone;
  $siteAddress = \App\Models\Setting::get('site_address', '07 Chu Van An, Buon Ho, Dak Lak');
  $siteMapUrl = \App\Models\Setting::get('site_map_url', 'https://maps.app.goo.gl/Qr6kWexgKnYdRdpq7');
  $siteZaloUrl = 'https://zalo.me/' . preg_replace('/\D+/', '', $sitePhone);
@endphp

<!-- ===== DATE MODAL ===== -->
<div id="date-modal" class="modal-overlay fixed inset-0 z-[60] hidden bg-black/30">
  <!-- Mobile: bottom sheet; Desktop: centered -->
  <div class="absolute inset-x-0 bottom-0 mx-auto w-full max-w-[460px] rounded-t-[20px] bg-white p-3 shadow-xl lg:inset-auto lg:left-1/2 lg:top-1/2 lg:max-w-md lg:-translate-x-1/2 lg:-translate-y-1/2 lg:rounded-2xl lg:p-5">
    <div class="mx-auto mb-4 h-1.5 w-14 rounded-full bg-stone-200 lg:hidden"></div>
    <div class="flex items-start justify-between">
      <div>
        <p class="text-sm font-bold text-app-muted">Chọn ngày</p>
        <h3 id="date-modal-title" class="text-xl font-extrabold">Chọn ngày thuê</h3>
      </div>
      <button type="button" data-close-modal="date" class="flex h-11 w-11 items-center justify-center rounded-2xl bg-stone-100 text-lg text-app-muted lg:h-9 lg:w-9 lg:rounded-xl lg:text-base">
        <i class="ri-close-line"></i>
      </button>
    </div>
    <input id="date-picker-input" class="hidden">
    <div id="date-picker-holder" class="mt-4 overflow-hidden rounded-[10px] border border-app-line lg:rounded-xl"></div>
    <div id="hourly-buoi-box" class="mt-3 hidden">
      <p class="mb-2 text-xs font-bold text-app-muted">Chọn buổi</p>
      <div class="grid grid-cols-3 gap-2">
        <button type="button" data-buoi="sang" class="buoi-option rounded-[12px] border-2 border-app-line bg-white py-3 text-center lg:rounded-xl">
          <p class="text-sm font-extrabold text-app-ink">Sáng</p>
          <p class="mt-0.5 text-[10px] font-semibold text-app-muted">6h - 12h</p>
        </button>
        <button type="button" data-buoi="chieu" class="buoi-option rounded-[12px] border-2 border-app-line bg-white py-3 text-center lg:rounded-xl">
          <p class="text-sm font-extrabold text-app-ink">Chiều</p>
          <p class="mt-0.5 text-[10px] font-semibold text-app-muted">12h - 18h</p>
        </button>
        <button type="button" data-buoi="toi" class="buoi-option rounded-[12px] border-2 border-app-line bg-white py-3 text-center lg:rounded-xl">
          <p class="text-sm font-extrabold text-app-ink">Tối</p>
          <p class="mt-0.5 text-[10px] font-semibold text-app-muted">18h - 23h</p>
        </button>
      </div>
      <input type="hidden" id="hourly-selected-buoi" value="sang">
    </div>
    <div class="mt-3 flex items-center justify-between rounded-[10px] bg-stone-50 px-3 py-2.5 lg:rounded-xl lg:px-4 lg:py-3">
      <div>
        <p class="text-xs font-bold text-app-muted">Đã chọn</p>
        <p id="date-preview" class="mt-0.5 text-sm font-extrabold leading-5">Chưa có ngày</p>
      </div>
      <button type="button" id="apply-date" class="rounded-[12px] bg-app-accent px-4 py-3 text-sm font-extrabold text-white lg:rounded-xl lg:py-2.5 lg:text-xs">
        Xác nhận
      </button>
    </div>
  </div>
</div>

<!-- ===== CONTACT MODAL (DESKTOP) ===== -->
<div id="contact-desktop-modal" class="modal-overlay fixed inset-0 z-[60] hidden bg-black/30">
  <div class="modal-panel absolute left-1/2 top-1/2 mx-auto w-full max-w-md -translate-x-1/2 -translate-y-1/2 rounded-2xl bg-white p-5 shadow-2xl">
    <div class="flex items-start justify-between">
      <div>
        <p class="text-xs font-bold text-app-muted">Thông tin liên hệ</p>
        <h3 class="text-lg font-extrabold">Liên hệ với chúng tôi</h3>
      </div>
      <button type="button" data-close-modal="contact-desktop" class="flex h-9 w-9 items-center justify-center rounded-xl bg-stone-100 text-base text-app-muted">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5">
          <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
        </svg>
      </button>
    </div>
    <div class="mt-4 space-y-2">
      <a href="tel:{{ $sitePhone }}" class="flex items-center gap-3 rounded-xl border border-app-line bg-white p-3 shadow-sm transition-all hover:border-app-accent hover:bg-green-50">
        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-app-accentSoft">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5 text-app-accent">
            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 0 0 2.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 0 1-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 0 0-1.091-.852H4.5A2.25 2.25 0 0 0 2.25 4.5v2.25Z" />
          </svg>
        </div>
        <div class="flex-1">
          <p class="text-xs font-bold text-app-muted">Gọi điện</p>
          <p class="text-sm font-extrabold">{{ $sitePhoneDisplay }}</p>
        </div>
      </a>
      <a href="{{ $siteZaloUrl }}" target="_blank" rel="noopener" class="flex items-center gap-3 rounded-xl border border-app-line bg-white p-3 shadow-sm transition-all hover:border-[#0068ff] hover:bg-blue-50">
        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-blue-50">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="#0068ff" class="h-5 w-5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M8.625 9.75a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H8.25m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H12m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0h-.375m-13.5 3.01c0 1.6 1.123 2.994 2.707 3.227 1.087.16 2.185.283 3.293.369V21l4.184-4.183a1.14 1.14 0 0 1 .778-.332 48.294 48.294 0 0 0 5.83-.498c1.585-.233 2.708-1.626 2.708-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0 0 12 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018Z" />
          </svg>
        </div>
        <div class="flex-1">
          <p class="text-xs font-bold text-app-muted">Nhắn Zalo</p>
          <p class="text-sm font-extrabold">0964.918.047</p>
        </div>
      </a>
      <a href="https://www.facebook.com/9999NDT/" target="_blank" rel="noopener" class="flex items-center gap-3 rounded-xl border border-app-line bg-white p-3 shadow-sm transition-all hover:border-sky-500 hover:bg-sky-50">
        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-sky-50">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="#0284c7" class="h-5 w-5">
            <path d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z"/>
          </svg>
        </div>
        <div class="flex-1">
          <p class="text-xs font-bold text-app-muted">Facebook</p>
          <p class="text-sm font-extrabold">Nguyễn Đình Thảo</p>
        </div>
      </a>
      <div class="flex items-center gap-3 rounded-xl border border-app-line bg-white p-3 shadow-sm">
        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-amber-50">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="#d97706" class="h-5 w-5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
          </svg>
        </div>
        <div>
          <p class="text-xs font-bold text-app-muted">Địa chỉ</p>
          <p class="text-sm font-extrabold">{{ $siteAddress }}</p>
        </div>
      </div>
    </div>
    <a href="{{ $siteZaloUrl }}" target="_blank" rel="noopener" class="mt-3 flex w-full items-center justify-center gap-2 rounded-xl bg-[#0068ff] px-4 py-3 text-sm font-extrabold text-white transition-all hover:bg-[#0056d6]">
      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-4 w-4">
        <path stroke-linecap="round" stroke-linejoin="round" d="M8.625 9.75a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H8.25m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H12m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0h-.375m-13.5 3.01c0 1.6 1.123 2.994 2.707 3.227 1.087.16 2.185.283 3.293.369V21l4.184-4.183a1.14 1.14 0 0 1 .778-.332 48.294 48.294 0 0 0 5.83-.498c1.585-.233 2.708-1.626 2.708-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0 0 12 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018Z" />
      </svg>
      Nhắn tin Zalo ngay
    </a>
  </div>
</div>

<!-- ===== CONTACT MODAL (MOBILE) ===== -->
<div id="contact-mobile-modal" class="modal-overlay fixed inset-0 z-[60] hidden bg-black/30">
  <div class="absolute inset-x-0 bottom-0 mx-auto w-full max-w-[460px] rounded-t-[28px] bg-white p-4 shadow-2xl">
    <div class="mx-auto mb-3 h-1 w-12 rounded-full bg-stone-200"></div>
    <div class="flex items-start justify-between">
      <div>
        <p class="text-xs font-bold text-app-muted">Thông tin liên hệ</p>
        <h3 class="text-lg font-extrabold">Liên hệ với chúng tôi</h3>
      </div>
      <button type="button" data-close-modal="contact-mobile" class="flex h-9 w-9 items-center justify-center rounded-2xl bg-stone-100 text-base text-app-muted">
        <i class="ri-close-line"></i>
      </button>
    </div>

    <div class="mt-4 space-y-2">
      <a href="tel:{{ $sitePhone }}" class="flex items-center gap-3 rounded-[12px] border border-app-line bg-white p-3 shadow-sm transition-all hover:bg-green-50 hover:border-app-accent">
        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-app-accentSoft">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5 text-app-accent">
            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 0 0 2.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 0 1-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 0 0-1.091-.852H4.5A2.25 2.25 0 0 0 2.25 4.5v2.25Z" />
          </svg>
        </div>
        <div class="flex-1">
          <p class="text-xs font-bold text-app-muted">Gọi điện</p>
          <p class="text-sm font-extrabold">{{ $sitePhoneDisplay }}</p>
        </div>
        <div class="flex h-8 w-8 items-center justify-center rounded-full bg-app-accentSoft">
          <i class="ri-arrow-right-s-line text-base text-app-accent"></i>
        </div>
      </a>

      <a href="{{ $siteZaloUrl }}" target="_blank" rel="noopener" class="flex items-center gap-3 rounded-[12px] border border-app-line bg-white p-3 shadow-sm transition-all hover:bg-blue-50 hover:border-[#0068ff]">
        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-blue-50">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="#0068ff" class="h-5 w-5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M8.625 9.75a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H8.25m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H12m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0h-.375m-13.5 3.01c0 1.6 1.123 2.994 2.707 3.227 1.087.16 2.185.283 3.293.369V21l4.184-4.183a1.14 1.14 0 0 1 .778-.332 48.294 48.294 0 0 0 5.83-.498c1.585-.233 2.708-1.626 2.708-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0 0 12 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018Z" />
          </svg>
        </div>
        <div class="flex-1">
          <p class="text-xs font-bold text-app-muted">Nhắn Zalo</p>
          <p class="text-sm font-extrabold">0964.918.047</p>
        </div>
        <div class="flex h-8 w-8 items-center justify-center rounded-full bg-blue-50">
          <i class="ri-arrow-right-s-line text-base text-[#0068ff]"></i>
        </div>
      </a>

      <!-- <a href="https://zalo.me/g/your-group-id" target="_blank" rel="noopener" class="flex items-center gap-3 rounded-[12px] border border-app-line bg-white p-3 shadow-sm transition-all hover:bg-violet-50 hover:border-violet-400">
        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-violet-50">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="#7c3aed" class="h-5 w-5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" />
          </svg>
        </div>
        <div class="flex-1">
          <p class="text-xs font-bold text-app-muted">Nhóm Zalo giao lưu</p>
          <p class="text-sm font-extrabold">Tham gia nhóm</p>
        </div>
        <div class="flex h-8 w-8 items-center justify-center rounded-full bg-violet-50">
          <i class="ri-arrow-right-s-line text-base text-violet-600"></i>
        </div>
      </a> -->

      <a href="https://www.facebook.com/9999NDT/" target="_blank" rel="noopener" class="flex items-center gap-3 rounded-[12px] border border-app-line bg-white p-3 shadow-sm transition-all hover:bg-sky-50 hover:border-sky-500">
        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-sky-50">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="#0284c7" class="h-5 w-5">
            <path d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z"/>
          </svg>
        </div>
        <div class="flex-1">
          <p class="text-xs font-bold text-app-muted">Facebook</p>
          <p class="text-sm font-extrabold">Fb: Nguyễn Đình Thảo</p>
        </div>
        <div class="flex h-8 w-8 items-center justify-center rounded-full bg-sky-50">
          <i class="ri-arrow-right-s-line text-base text-sky-600"></i>
        </div>
      </a>
  <a href="{{ $siteMapUrl }}" target="_blank" rel="noopener" class="flex items-center gap-3 rounded-[12px] border border-app-line bg-white p-3 shadow-sm transition-all hover:bg-sky-50 hover:border-sky-500">
        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-sky-50">
           <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="#d97706" class="h-5 w-5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
          </svg>
        </div>
        <div class="flex-1">
           <p class="text-xs font-bold text-app-muted">Địa chỉ</p>
          <p class="text-sm font-extrabold">{{ $siteAddress }}</p>
        </div>
        <div class="flex h-8 w-8 items-center justify-center rounded-full bg-sky-50">
          <i class="ri-arrow-right-s-line text-base text-sky-600"></i>
        </div>
      </a>
      <!-- <div class="flex items-center gap-3 rounded-[12px] border border-app-line bg-white p-3 shadow-sm">
        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-amber-50">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="#d97706" class="h-5 w-5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
          </svg>
        </div>
        <div>
          <p class="text-xs font-bold text-app-muted">Địa chỉ</p>
          <p class="text-sm font-extrabold">{{ $siteAddress }}</p>
        </div>
      </div> -->
    </div>

    <a href="{{ $siteZaloUrl }}" target="_blank" rel="noopener" class="mt-3 flex w-full items-center justify-center gap-2 rounded-[10px] bg-[#0068ff] px-4 py-3 text-sm font-extrabold text-white shadow-sm transition-all hover:bg-[#0056d6] active:scale-[0.98]">
      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-4 w-4">
        <path stroke-linecap="round" stroke-linejoin="round" d="M8.625 9.75a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H8.25m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H12m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0h-.375m-13.5 3.01c0 1.6 1.123 2.994 2.707 3.227 1.087.16 2.185.283 3.293.369V21l4.184-4.183a1.14 1.14 0 0 1 .778-.332 48.294 48.294 0 0 0 5.83-.498c1.585-.233 2.708-1.626 2.708-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0 0 12 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018Z" />
      </svg>
      Nhắn tin Zalo ngay
    </a>
  </div>
</div>

<!-- ===== THUÊ XE MODAL (DESKTOP) ===== -->
<div id="thuexe-modal" class="modal-overlay fixed inset-0 z-[60] hidden bg-black/30">
  <div class="modal-panel absolute left-1/2 top-1/2 mx-auto w-full max-w-md -translate-x-1/2 -translate-y-1/2 rounded-2xl bg-white p-5 pb-6 shadow-2xl">
    <div class="flex items-center justify-between">
      <h3 class="text-lg font-extrabold text-app-ink">Thuê xe nhanh</h3>
      <button type="button" id="thuexe-close" class="flex h-9 w-9 items-center justify-center rounded-xl bg-stone-100 text-base text-app-muted">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5">
          <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
        </svg>
      </button>
    </div>

    <div id="thuexe-review">
      <div class="mt-4 space-y-2.5 rounded-xl border border-dashed border-stone-200 p-4">
        <div class="flex items-center justify-between border-b border-dashed border-stone-200 pb-2">
          <span class="text-xs font-bold text-app-muted">Thời gian thuê</span>
          <span id="thuexe-time" class="text-right text-sm font-extrabold text-app-ink"></span>
        </div>
        <div id="thuexe-start-row" class="flex items-center justify-between border-b border-dashed border-stone-200 pb-2">
          <span class="text-xs font-bold text-app-muted">Thời gian nhận xe</span>
          <span id="thuexe-start-display" class="text-right text-sm font-extrabold text-app-ink"></span>
        </div>
        <div id="thuexe-hours-row" class="hidden flex items-center justify-between border-b border-dashed border-stone-200 pb-2">
          <span class="text-xs font-bold text-app-muted">Buổi</span>
          <span id="thuexe-hours-display" class="text-sm font-extrabold text-app-ink"></span>
        </div>
        <div class="flex items-center justify-between border-b border-dashed border-stone-200 pb-2">
          <span class="text-xs font-bold text-app-muted">Số điện thoại</span>
          <span id="thuexe-phone-display" class="text-sm font-extrabold text-app-ink">Chưa nhập</span>
        </div>
        <div id="thuexe-days-row" class="hidden flex items-center justify-between border-b border-dashed border-stone-200 pb-2">
          <span class="text-xs font-bold text-app-muted">Số ngày thuê</span>
          <span id="thuexe-days-display" class="text-sm font-extrabold text-app-ink"></span>
        </div>
        <div id="thuexe-end-row" class="hidden flex items-center justify-between border-b border-dashed border-stone-200 pb-2">
          <span class="text-xs font-bold text-app-muted">Thời gian trả xe</span>
          <span id="thuexe-end-display" class="text-right text-sm font-extrabold text-app-ink"></span>
        </div>
      </div>
      <div class="mt-3 rounded-xl border border-amber-100 bg-amber-50/80 px-3 py-2.5 text-center">
        <p class="text-[11px] font-bold uppercase tracking-[0.18em] text-amber-700">Trạng thái gửi</p>
        <p id="thuexe-submit-status" class="mt-1 text-sm font-extrabold text-app-ink">Sẵn sàng gửi yêu cầu</p>
      </div>
      <div class="mt-4 grid grid-cols-2 gap-3">
        <button type="button" id="thuexe-back" class="rounded-xl border-2 border-app-line px-4 py-3 text-sm font-extrabold text-app-muted transition-all hover:bg-stone-50">Quay lại</button>
        <button type="button" id="thuexe-submit" data-default-label="Gửi liên lạc" class="rounded-xl bg-app-accent px-4 py-3 text-sm font-extrabold text-white shadow-sm transition-all hover:bg-green-600 disabled:cursor-not-allowed disabled:bg-[#9adcb1]">
          <span class="inline-flex items-center justify-center gap-2">
            <svg data-loading-icon xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="hidden h-4 w-4 animate-spin fill-none stroke-current" aria-hidden="true">
              <circle cx="12" cy="12" r="9" class="opacity-25" stroke-width="3"></circle>
              <path d="M21 12a9 9 0 0 0-9-9" class="opacity-100" stroke-width="3" stroke-linecap="round"></path>
            </svg>
            <span data-submit-label>Gửi liên lạc</span>
          </span>
        </button>
      </div>
    </div>

    <div id="thuexe-success" class="hidden">
      <div class="py-8 text-center">
        <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-app-accentSoft ring-8 ring-[#e9f8ef]">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-8 w-8 text-app-accent">
            <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
          </svg>
        </div>
        <h3 class="mt-3 text-xl font-extrabold text-app-ink">Gửi liên lạc thành công!</h3>
        <p class="mt-1 text-sm font-bold text-app-muted">Cảm ơn bạn. Từ 5 đến 10 phút nữa chúng tôi sẽ liên hệ.</p>
       
        <button type="button" id="thuexe-done" class="mt-4 rounded-xl bg-app-accent px-6 py-2.5 text-xs font-extrabold text-white shadow-sm transition-all hover:bg-green-600">Đã hiểu</button>
    </div>
  </div>
</div>
</div>

<!-- ===== THUÊ XE MODAL (MOBILE) ===== -->
<div id="thuexe-modal-mobile" class="modal-overlay fixed inset-0 z-[60] hidden bg-black/30">
  <div class="absolute inset-x-0 bottom-0 mx-auto w-full max-w-[460px] rounded-t-[28px] bg-white p-5 pb-8 shadow-2xl">
    <div class="mx-auto mb-4 h-1.5 w-14 rounded-full bg-stone-200"></div>
    <div class="flex items-center justify-between">
      <h3 class="text-lg font-extrabold text-app-ink">Thuê xe nhanh</h3>
      <button type="button" id="thuexe-close-mobile" class="flex h-9 w-9 items-center justify-center rounded-full bg-stone-100 text-base text-app-muted">
        <i class="ri-close-line"></i>
      </button>
    </div>

    <div id="thuexe-review-mobile">
      <div class="mt-4 space-y-2.5 rounded-[12px] border border-dashed border-stone-200 p-3.5">
        <div class="flex items-center justify-between border-b border-dashed border-stone-200 pb-2">
          <span class="text-xs font-bold text-app-muted">Thời gian thuê</span>
          <span id="thuexe-time-mobile" class="text-right text-sm font-extrabold text-app-ink"></span>
        </div>
        <div id="thuexe-start-row-mobile" class="flex items-center justify-between border-b border-dashed border-stone-200 pb-2">
          <span class="text-xs font-bold text-app-muted">Thời gian nhận xe</span>
          <span id="thuexe-start-display-mobile" class="text-sm font-extrabold text-app-ink"></span>
        </div>
        <div id="thuexe-hours-row-mobile" class="hidden flex items-center justify-between border-b border-dashed border-stone-200 pb-2">
          <span class="text-xs font-bold text-app-muted">Buổi</span>
          <span id="thuexe-hours-display-mobile" class="text-sm font-extrabold text-app-ink"></span>
        </div>
        <div class="flex items-center justify-between border-b border-dashed border-stone-200 pb-2">
          <span class="text-xs font-bold text-app-muted">Số điện thoại</span>
          <span id="thuexe-phone-display-mobile" class="text-sm font-extrabold text-app-ink">Chưa nhập</span>
        </div>
        <div id="thuexe-days-row-mobile" class="hidden flex items-center justify-between border-b border-dashed border-stone-200 pb-2">
          <span class="text-xs font-bold text-app-muted">Số ngày thuê</span>
          <span id="thuexe-days-display-mobile" class="text-sm font-extrabold text-app-ink"></span>
        </div>
        <div id="thuexe-end-row-mobile" class="hidden flex items-center justify-between border-b border-dashed border-stone-200 pb-2">
          <span class="text-xs font-bold text-app-muted">Thời gian trả xe</span>
          <span id="thuexe-end-display-mobile" class="text-sm font-extrabold text-app-ink"></span>
        </div>
      </div>
      <div class="mt-3 rounded-[12px] border border-amber-100 bg-amber-50/80 px-3 py-2.5 text-center">
        <p class="text-[11px] font-bold uppercase tracking-[0.18em] text-amber-700">Trạng thái gửi</p>
        <p id="thuexe-submit-status-mobile" class="mt-1 text-sm font-extrabold text-app-ink">Sẵn sàng gửi yêu cầu</p>
      </div>
      <div class="mt-4 grid grid-cols-2 gap-3">
        <button type="button" id="thuexe-back-mobile" class="rounded-[12px] border-2 border-app-line px-4 py-3 text-sm font-extrabold text-app-muted transition-all hover:bg-stone-50">Quay lại</button>
        <button type="button" id="thuexe-submit-mobile" data-default-label="Gửi liên lạc" class="rounded-[12px] bg-app-accent px-4 py-3 text-sm font-extrabold text-white shadow-sm transition-all hover:bg-green-600 active:scale-[0.98] disabled:cursor-not-allowed disabled:bg-[#9adcb1]">
          <span class="inline-flex items-center justify-center gap-2">
            <svg data-loading-icon xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="hidden h-4 w-4 animate-spin fill-none stroke-current" aria-hidden="true">
              <circle cx="12" cy="12" r="9" class="opacity-25" stroke-width="3"></circle>
              <path d="M21 12a9 9 0 0 0-9-9" class="opacity-100" stroke-width="3" stroke-linecap="round"></path>
            </svg>
            <span data-submit-label>Gửi liên lạc</span>
          </span>
        </button>
      </div>
    </div>

    <div id="thuexe-success-mobile" class="hidden">
      <div class="py-8 text-center">
        <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-app-accentSoft ring-8 ring-[#e9f8ef]">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-8 w-8 text-app-accent">
            <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
          </svg>
        </div>
        <h3 class="mt-3 text-xl font-extrabold text-app-ink">Gửi liên lạc thành công!</h3>
        <p class="mt-1 text-sm font-bold text-app-muted">Cảm ơn bạn đã gửi yêu cầu. Từ 5 đến 10 phút nữa chúng tôi sẽ liên hệ bạn.</p>
        
        <button type="button" id="thuexe-done-mobile" class="mt-4 rounded-[10px] bg-app-accent px-6 py-2.5 text-xs font-extrabold text-white shadow-sm transition-all hover:bg-green-600 active:scale-[0.98]">Đã hiểu</button>
      </div>
    </div>
  </div>
</div>

@if(request()->routeIs('car-detail'))
<!-- ===== CONFIRM MODAL ===== -->
<div id="confirm-modal" class="fixed inset-0 z-[70] hidden bg-black/30" data-car-id="{{ $car->id ?? '' }}">
  <div class="absolute inset-x-0 bottom-0 mx-auto w-full max-w-[460px] rounded-t-[20px] bg-white p-5 pb-8 shadow-xl lg:inset-auto lg:left-1/2 lg:top-1/2 lg:max-w-md lg:-translate-x-1/2 lg:-translate-y-1/2 lg:rounded-2xl lg:p-5 lg:pb-6">
    <div id="confirm-review">
      <div class="mx-auto mb-4 h-1 w-14 rounded-full bg-stone-200 lg:hidden"></div>
      <div class="flex items-center justify-between">
        <h3 class="text-lg font-extrabold text-app-ink">Xác nhận thông tin</h3>
        <button type="button" id="confirm-close" class="flex h-9 w-9 items-center justify-center rounded-full bg-stone-100 text-base text-app-muted lg:rounded-xl">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
          </svg>
        </button>
      </div>
      <div class="mt-4 space-y-3">
        <div id="confirm-start-row" class="flex items-center justify-between border-b border-dashed border-stone-200 pb-2.5">
          <span class="text-xs font-bold text-app-muted">Tên xe</span>
          <span id="confirm-car" class="text-sm font-extrabold text-app-ink">{{ $car->name ?? 'Chi tiết xe' }}</span>
        </div>
        <div id="confirm-end-row" class="flex items-center justify-between border-b border-dashed border-stone-200 pb-2.5">
          <span class="text-xs font-bold text-app-muted">Thời gian thuê</span>
          <span id="confirm-duration" class="text-right text-sm font-extrabold text-app-ink">1 ngày</span>
        </div>
        <div class="flex items-center justify-between border-b border-dashed border-stone-200 pb-2.5">
          <span class="text-xs font-bold text-app-muted">Số điện thoại</span>
          <span id="confirm-phone" class="text-sm font-extrabold text-app-ink">Chưa nhập</span>
        </div>
        <div id="confirm-days-row" class="hidden flex items-center justify-between border-b border-dashed border-stone-200 pb-2.5">
          <span class="text-xs font-bold text-app-muted">Số ngày thuê</span>
          <span id="confirm-days" class="text-sm font-extrabold text-app-ink"></span>
        </div>
        <div id="confirm-hours-row" class="hidden flex items-center justify-between border-b border-dashed border-stone-200 pb-2.5">
          <span class="text-xs font-bold text-app-muted">Buổ</span>
          <span id="confirm-hours" class="text-sm font-extrabold text-app-ink"></span>
        </div>
        <div class="flex items-center justify-between border-b border-dashed border-stone-200 pb-2.5">
          <span class="text-xs font-bold text-app-muted">Ngày nhận xe</span>
          <span id="confirm-start" class="text-sm font-extrabold text-app-ink">Chưa chọn</span>
        </div>
        <div class="flex items-center justify-between border-b border-dashed border-stone-200 pb-2.5">
          <span class="text-xs font-bold text-app-muted">Ngày trả xe</span>
          <span id="confirm-end" class="text-sm font-extrabold text-app-ink">Chưa chọn</span>
        </div>
        <div class="flex items-center justify-between border-b border-dashed border-stone-200 pb-2.5">
          <span class="text-xs font-bold text-app-muted">Hình thức nhận</span>
          <span id="confirm-pickup" class="text-sm font-extrabold text-app-ink">Chưa chọn</span>
        </div>
        <div class="flex items-center justify-between border-b border-dashed border-stone-200 pb-2.5">
          <span class="text-xs font-bold text-app-muted">Kế hoạch chuyến đi</span>
          <span id="confirm-trip-plan" class="text-sm font-extrabold text-app-ink">Trong tỉnh</span>
        </div>
        <div class="flex items-center justify-between pt-1">
          <span class="text-base font-bold text-app-ink">Tổng tiền</span>
          <span id="confirm-total" class="text-xl font-extrabold text-app-accent">0đ</span>
        </div>
      </div>
      <div class="mt-5 grid grid-cols-2 gap-3">
        <button type="button" id="confirm-back" class="rounded-[10px] border-2 border-app-line px-4 py-3 text-sm font-extrabold text-app-muted transition-all hover:bg-stone-50 lg:rounded-xl">
          Quay lại
        </button>
        <button type="button" id="confirm-submit" class="rounded-[10px] bg-app-accent px-4 py-3 text-sm font-extrabold text-white shadow-sm transition-all hover:bg-green-600 active:scale-[0.98] lg:rounded-xl">
          Xác nhận đặt xe
        </button>
      </div>
    </div>
    <div id="confirm-success" class="hidden">
      <div class="py-6 text-center">
        <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-app-accentSoft">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="h-7 w-7 text-app-accent">
            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/>
          </svg>
        </div>
        <h3 class="mt-3 text-xl font-extrabold text-app-ink">Đặt xe thành công!</h3>
        <p class="mt-1 text-sm text-app-muted">Cảm ơn bạn đã đặt xe. Từ 5 đến 10 phút nữa chúng tôi sẽ liên hệ bạn.</p>
        <button type="button" id="confirm-done" class="mt-4 rounded-[10px] bg-app-accent px-6 py-2.5 text-xs font-extrabold text-white shadow-sm transition-all hover:bg-green-600 active:scale-[0.98] lg:rounded-xl">
          Đã hiểu
        </button>
      </div>
    </div>
  </div>
</div>
@endif

{{-- IMAGE LIGHTBOX --}}
<div id="lightbox" class="fixed inset-0 z-[90] hidden items-center justify-center bg-black/80 px-4">
  <button id="lightbox-close" type="button" class="absolute right-4 top-4 z-10 flex h-10 w-10 items-center justify-center rounded-full bg-white/20 text-white transition-all hover:bg-white/30">
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6 w-6"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" /></svg>
  </button>
  <div class="flex max-h-[90vh] max-w-full flex-col items-center">
    <div class="relative w-full max-w-full">
      <button id="lightbox-prev" type="button" class="lightbox-nav absolute left-2 top-1/2 z-10 hidden flex h-10 w-10 -translate-y-1/2 items-center justify-center rounded-full bg-black/55 text-white transition-all hover:bg-black/70">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.75" stroke="currentColor" class="h-5 w-5"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" /></svg>
      </button>
      <button id="lightbox-next" type="button" class="lightbox-nav absolute right-2 top-1/2 z-10 hidden flex h-10 w-10 -translate-y-1/2 items-center justify-center rounded-full bg-black/55 text-white transition-all hover:bg-black/70">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.75" stroke="currentColor" class="h-5 w-5"><path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" /></svg>
      </button>
      <div id="lightbox-swiper" class="swiper w-full max-w-full">
        <div id="lightbox-swiper-wrapper" class="swiper-wrapper"></div>
      </div>
    </div>
    <p id="lightbox-label" class="mt-3 text-sm font-extrabold text-white/90"></p>
    <p id="lightbox-sub" class="mt-0.5 text-xs font-bold text-white/60"></p>
    <p id="lightbox-counter" class="mt-1 text-xs font-bold text-white/50"></p>
  </div>
</div>
