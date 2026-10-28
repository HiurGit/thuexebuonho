@extends('layouts.app')

@section('title', 'Checklist hướng dẫn khi giao xe - Thuê Xe Buôn Hồ')

@section('meta')
<meta name="description" content="Danh sách kiểm tra và hướng dẫn bàn giao xe khi thuê xe tại Buôn Hồ: nhiên liệu, ngoại thất, cần số, đèn, camera, điều hòa và các thao tác cơ bản.">
<meta property="og:title" content="Checklist hướng dẫn khi giao xe - Thuê Xe Buôn Hồ">
<meta property="og:description" content="Danh sách kiểm tra và hướng dẫn bàn giao xe khi thuê xe tại Buôn Hồ: nhiên liệu, ngoại thất, cần số, đèn, camera, điều hòa và các thao tác cơ bản.">
<meta property="og:image" content="{{ asset('assets/image/bannerMXH.jpg') }}">
<meta property="og:image:width" content="1200">
<meta property="og:image:height" content="630">
<meta property="og:image:type" content="image/jpeg">
<meta property="og:image:alt" content="Thuê Xe Buôn Hồ - Checklist hướng dẫn khi giao xe">
<meta property="og:url" content="{{ url()->current() }}">
<meta property="og:type" content="website">
<meta property="og:site_name" content="Thuê Xe Buôn Hồ">
<meta property="og:locale" content="vi_VN">
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="Checklist hướng dẫn khi giao xe - Thuê Xe Buôn Hồ">
<meta name="twitter:description" content="Danh sách kiểm tra và hướng dẫn bàn giao xe khi thuê xe tại Buôn Hồ.">
<meta name="twitter:image" content="{{ asset('assets/image/bannerMXH.jpg') }}">
@endsection

@php
$checklistGroups = [
    [
        'title' => 'Bàn giao & kiểm tra xe',
        'items' => [
            'Chụp ảnh công-tơ-mét, mức xăng/pin khi bàn giao',
            'Kiểm tra ngoại thất, nội thất và tình trạng xe',
        ],
    ],
    [
        'title' => 'Hướng dẫn thao tác trên xe',
        'items' => [
            'Hướng dẫn cần số P – R – N – D',
            'Hướng dẫn khởi động và tắt máy xe',
            'Hướng dẫn đèn pha, cos, xi nhan',
            'Hướng dẫn bật/tắt đèn Hazard (đèn cảnh báo)',
            'Hướng dẫn vị trí nút mở nắp bình xăng',
            'Hướng dẫn mở cốp sau và nắp capo',
            'Hướng dẫn sử dụng camera lùi / camera 360°',
            'Hướng dẫn gạt mưa và rửa kính',
            'Hướng dẫn phanh tay / phanh tay điện tử',
            'Hướng dẫn điều hòa và màn hình giải trí',
            'Hướng dẫn chỉnh ghế, gương chiếu hậu',
            'Hướng dẫn khóa/mở cửa xe',
            'Hướng dẫn vị trí lốp dự phòng',
        ],
    ],
];
@endphp

@section('content-desktop')
  <!-- ===== PAGE HEADER ===== -->
  <div class="border-b border-app-line bg-white shadow-sm">
    <div class="mx-auto flex max-w-4xl items-center gap-4 px-6 py-3">
      <a href="javascript:history.back()" class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-app-accentSoft text-app-accent transition-all hover:bg-app-accent hover:text-white">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5"/></svg>
      </a>
      <div class="flex-1 text-center">
        <h1 class="text-xl font-extrabold text-app-ink">Checklist hướng dẫn khi giao xe</h1>
        <p class="mt-0.5 text-sm font-semibold text-app-muted">Các bước kiểm tra và hướng dẫn khách hàng khi bàn giao xe</p>
      </div>
      <div class="w-10 shrink-0"></div>
    </div>
  </div>

  <!-- ===== MAIN CONTENT ===== -->
  <main class="mx-auto max-w-4xl space-y-6 px-6 py-8">
    <!-- Tiến độ -->
    <div class="rounded-2xl border border-app-line bg-white p-5 shadow-sm">
      <div class="flex items-center justify-between gap-4">
        <div>
          <h2 class="text-base font-extrabold text-app-ink">Tiến độ bàn giao</h2>
          <p class="mt-0.5 text-sm text-app-muted">Tick vào các mục đã hoàn thành trong lúc hướng dẫn khách</p>
        </div>
        <div class="shrink-0 text-right">
          <p class="text-2xl font-extrabold text-app-accent js-check-count">0/15</p>
          <button type="button" class="js-check-reset mt-0.5 text-xs font-bold text-app-muted underline transition-colors hover:text-app-accent">Đặt lại</button>
        </div>
      </div>
      <div class="mt-4 h-2.5 overflow-hidden rounded-full bg-stone-100">
        <div class="js-check-progress h-full w-0 rounded-full bg-app-accent transition-all duration-300"></div>
      </div>
    </div>

    <!-- Danh sách checklist -->
    @include('partials.checklist', ['checklistGrid' => 'grid-cols-2 gap-3 p-4'])
  </main>

  <script>
  document.addEventListener('DOMContentLoaded', function() {
    var STORAGE_KEY = 'htx-checklist-giao-xe';
    var boxes = Array.prototype.slice.call(document.querySelectorAll('.check-item input[type="checkbox"]'));
    if (!boxes.length) return;

    var total = boxes.reduce(function(set, b) { set[b.dataset.checkId] = true; return set; }, {});
    total = Object.keys(total).length;

    var state = {};
    try { state = JSON.parse(localStorage.getItem(STORAGE_KEY) || '{}') || {}; } catch (e) { state = {}; }

    function syncBoxes() {
      boxes.forEach(function(b) {
        var on = !!state[b.dataset.checkId];
        b.checked = on;
        var item = b.closest('.check-item');
        var box = item.querySelector('.check-box');
        var icon = box.querySelector('svg');
        if (on) {
          box.classList.add('border-app-accent', 'bg-app-accentSoft');
          box.classList.remove('border-stone-300', 'bg-white');
          icon.classList.remove('opacity-0');
          item.classList.add('border-app-accent', 'bg-app-accentSoft');
          item.classList.remove('border-app-line', 'bg-white');
        } else {
          box.classList.remove('border-app-accent', 'bg-app-accentSoft');
          box.classList.add('border-stone-300', 'bg-white');
          icon.classList.add('opacity-0');
          item.classList.remove('border-app-accent', 'bg-app-accentSoft');
          item.classList.add('border-app-line', 'bg-white');
        }
      });
    }

    function renderProgress() {
      var done = 0;
      Object.keys(state).forEach(function(k) { if (state[k]) done++; });
      if (done > total) done = total;
      document.querySelectorAll('.js-check-count').forEach(function(el) { el.textContent = done + '/' + total; });
      document.querySelectorAll('.js-check-progress').forEach(function(el) { el.style.width = (total ? (done / total * 100) : 0) + '%'; });
    }

    boxes.forEach(function(b) {
      b.addEventListener('change', function() {
        state[b.dataset.checkId] = b.checked;
        try { localStorage.setItem(STORAGE_KEY, JSON.stringify(state)); } catch (e) {}
        syncBoxes();
        renderProgress();
      });
    });

    document.querySelectorAll('.js-check-reset').forEach(function(btn) {
      btn.addEventListener('click', function() {
        state = {};
        try { localStorage.removeItem(STORAGE_KEY); } catch (e) {}
        syncBoxes();
        renderProgress();
      });
    });

    syncBoxes();
    renderProgress();
  });
  </script>
@endsection

@section('content-mobile')
  <!-- Nút back + tiêu đề -->
  <div class="border-b border-app-line bg-white px-4 py-1 shadow-sm">
    <div class="flex items-center gap-3">
      <a href="javascript:history.back()" class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-app-accentSoft text-app-accent transition-all hover:bg-app-accent hover:text-white">
        <i class="ri-arrow-left-s-line text-lg"></i>
      </a>
      <h1 class="flex-1 text-center text-lg font-extrabold">Checklist giao xe</h1>
      <div class="w-9 shrink-0"></div>
    </div>
  </div>

  <div class="space-y-4 px-4 py-3 pb-24">
    <!-- Tiến độ -->
    <div class="rounded-2xl border border-app-line bg-white p-4 shadow-sm">
      <div class="flex items-center justify-between gap-4">
        <div>
          <h2 class="text-sm font-extrabold text-app-ink">Tiến độ bàn giao</h2>
          <p class="mt-0.5 text-xs text-app-muted">Tick các mục đã hoàn thành</p>
        </div>
        <div class="shrink-0 text-right">
          <p class="text-xl font-extrabold text-app-accent js-check-count">0/15</p>
          <button type="button" class="js-check-reset mt-0.5 text-xs font-bold text-app-muted underline">Đặt lại</button>
        </div>
      </div>
      <div class="mt-3 h-2.5 overflow-hidden rounded-full bg-stone-100">
        <div class="js-check-progress h-full w-0 rounded-full bg-app-accent transition-all duration-300"></div>
      </div>
    </div>

    <!-- Danh sách checklist -->
    @include('partials.checklist', ['checklistGrid' => 'grid-cols-1 gap-2 p-3'])
  </div>
@endsection
