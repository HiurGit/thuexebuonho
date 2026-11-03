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
            'Kiểm tra giấy tờ xe cần thiết.',
            'Kiểm tra chìa khóa',
        ],
    ],
    [
        'title' => 'Hướng dẫn thao tác trên xe',
        'items' => [
              'Hướng dẫn khởi động và tắt máy xe',
            'Hướng dẫn cần số P – R – N – D',
            'Hướng dẫn đèn pha, cos, xi nhan',
            'Hướng dẫn bật/tắt đèn Hazard (đèn cảnh báo)',
              'Hướng dẫn sử dụng camera 360°',
            'Hướng dẫn màn hình vào Vietmap Live',
             'Hướng dẫn điều hòa và sấy kính',
                    'Hướng dẫn sử dụng dây an toàn',
            'Hướng dẫn vị trí nút mở nắp bình xăng',
            'Hướng dẫn mở cốp sau và nắp capo niêm phong',
              'Hướng dẫn chỉnh ghế, gương chiếu hậu',
                    'Hướng dẫn phanh tay / phanh tay điện tử',
          
            'Hướng dẫn gạt mưa và rửa kính',
      
           
          
            'Hướng dẫn khóa/mở cửa bên phải, lock trái',
            'Hướng dẫn bình chữa cháy vs phá kính',
            'Hướng dẫn lốp dự phòng, đèn tam giác cảnh báo',
        ],
    ],
];
$safetyRules = [
    ['title' => 'KHÔNG VƯỢT ĐÈN VÀNG VÀ ĐÈN ĐỎ', 'content' => 'Đèn xanh chỉ còn 3 – 4 giây cũng không cố tăng tốc để vượt qua.', 'absolute' => true],
    ['title' => 'KHÔNG UỐNG RƯỢU BIA KHI THAM GIA GIAO THÔNG', 'content' => 'Hậu quả rất nghiêm trọng: Công an giữ xe, bảo hiểm xét nghiệm có nồng độ cồn sẽ từ chối bồi thường.', 'absolute' => true],
    ['title' => 'LUÔN CHỦ ĐỘNG CHÂN PHANH', 'content' => 'Khi không sử dụng chân ga, hãy để chân phải sẵn sàng chân phanh. Rảnh chân là đặt chân vào phanh.'],
    ['title' => 'TỐC ĐỘ VỪA PHẢI', 'content' => 'Xe lạ nên quý khách hãy chạy chậm, giữ tốc độ vừa phải.'],

    ['title' => 'KHÔNG VƯỢT ẨU, VƯỢT KHI KHUẤT TẦM NHÌN', 'content' => 'Chỉ vượt khi đủ điều kiện an toàn, quan sát rõ đoạn đường phía trước. Tuyệt đối không vượt tại khúc cua, đỉnh dốc hoặc nơi tầm nhìn bị hạn chế.'],
    ['title' => 'GIỮ KHOẢNG CÁCH AN TOÀN', 'content' => 'Không bám đuôi xe phía trước. Luôn giữ khoảng cách đủ để xử lý khi xe trước phanh gấp hoặc có tình huống bất ngờ.'],
    ['title' => 'KHÔNG SỬ DỤNG ĐIỆN THOẠI KHI LÁI XE', 'content' => 'Tập trung quan sát đường đi, gương chiếu hậu, biển báo và các phương tiện xung quanh.'],
    ['title' => 'KHÔNG CHỦ QUAN KHI ĐI ĐƯỜNG LẠ', 'content' => 'Giảm tốc độ tại ngã tư, đường đông dân cư, trường học, khu vực có trẻ em, đường trơn trượt hoặc trời mưa.'],
    ['title' => 'AN TOÀN LÀ TRÊN HẾT', 'content' => 'Đi chậm một chút không sao, đến muộn vài phút không sao. Quan trọng nhất là quý khách và mọi người đều đến nơi an toàn.', 'final' => true],
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
          <p class="text-2xl font-extrabold text-app-accent js-check-count">0/19</p>
          <button type="button" class="js-check-reset mt-0.5 text-xs font-bold text-app-muted underline transition-colors hover:text-app-accent">Đặt lại</button>
        </div>
      </div>
      <div class="mt-4 h-2.5 overflow-hidden rounded-full bg-stone-100">
        <div class="js-check-progress h-full w-0 rounded-full bg-app-accent transition-all duration-300"></div>
      </div>
    </div>

    <!-- Lưu ý an toàn -->
    <div class="overflow-hidden rounded-2xl border border-amber-200 bg-gradient-to-br from-amber-50 via-orange-50 to-amber-100 p-4 shadow-sm">
      <div class="flex items-start gap-3">
        <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-amber-500 text-white shadow-md">
          <i class="ri-error-warning-fill text-xl"></i>
        </span>
        <div class="space-y-1.5">
          <p class="text-xs font-extrabold uppercase tracking-widest text-amber-700">Lưu ý an toàn</p>
          <p class="text-sm font-extrabold uppercase leading-6 text-amber-900">Sử dụng các phím nút nhẹ tay , Không leo trèo, ngồi lên mui xe, nắp capo.</p>
          <p class="text-sm font-bold uppercase leading-6 text-amber-800"> VÌ Các bộ phận này rất mỏng và mềm, dễ bị móp méo, hư hỏng.</p>
        </div>
      </div>
    </div>

    <!-- Danh sách checklist -->
    @include('partials.checklist', ['checklistGrid' => 'grid-cols-2 gap-3 p-4'])
  </main>

  <!-- ===== LÁI XE AN TOÀN ===== -->
  <section id="lai-xe-an-toan" class="mx-auto max-w-4xl px-6 pb-10 pt-2">
    <div class="mb-6 flex items-center gap-3">
      <div class="h-8 w-1.5 rounded-full bg-app-accent"></div>
      <div>
        <h2 class="text-xl font-extrabold text-app-ink">Lái xe an toàn</h2>
        <p class="text-sm font-semibold  ">9 điều cần nhớ khi lái xe</p>
      </div>
    </div>
    <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-3">
      @foreach($safetyRules as $rule)
        @if(!empty($rule['final']))
        <div class="relative rounded-2xl bg-white p-5 shadow-sm transition-all hover:-translate-y-1 hover:shadow-card">
          <div class="mb-4 flex items-center justify-end">
            <span class="text-4xl font-extrabold leading-none select-none text-stone-300">{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
          </div>
          <h3 class="text-base font-extrabold uppercase tracking-wide text-app-ink">{{ $rule['title'] }}</h3>
          <p class="mt-2 text-sm leading-6  ">{{ $rule['content'] }}</p>
          <p class="mt-3 text-sm font-extrabold text-app-green">Chúc quý khách có những chuyến đi an toàn và vui vẻ cùng Thuê Xe Tự Lái Buôn Hồ!</p>
        </div>
        @else
        <div class="relative rounded-2xl bg-white p-5 shadow-sm transition-all hover:-translate-y-1 hover:shadow-card {{ !empty($rule['absolute']) ? 'ring-1 ring-red-200' : '' }}">
          @if(!empty($rule['absolute']))
          <span class="absolute -left-2 -top-2 z-10 whitespace-nowrap rounded-full bg-red-600 px-2.5 py-1 text-[10px] font-extrabold uppercase tracking-wide text-white shadow-md ring-2 ring-white">Tuyệt đối</span>
          @endif
          <div class="mb-4 flex items-center justify-end">
            <span class="text-4xl font-extrabold leading-none select-none {{ !empty($rule['absolute']) ? 'text-red-200' : 'text-stone-300' }}">{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
          </div>
          <h3 class="text-base font-extrabold text-app-ink">{{ $rule['title'] }}</h3>
          <p class="mt-2 text-sm leading-6  ">{{ $rule['content'] }}</p>
        </div>
        @endif
      @endforeach
    </div>
  </section>

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
          <p class="text-xl font-extrabold text-app-accent js-check-count">0/19</p>
          <button type="button" class="js-check-reset mt-0.5 text-xs font-bold text-app-muted underline">Đặt lại</button>
        </div>
      </div>
      <div class="mt-3 h-2.5 overflow-hidden rounded-full bg-stone-100">
        <div class="js-check-progress h-full w-0 rounded-full bg-app-accent transition-all duration-300"></div>
      </div>
    </div>

    <!-- Lưu ý an toàn -->
    <div class="overflow-hidden rounded-2xl border border-amber-200 bg-gradient-to-br from-amber-50 via-orange-50 to-amber-100 p-4 shadow-sm">
      <div class="flex items-start gap-3">
        <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-amber-500 text-white shadow-md">
          <i class="ri-error-warning-fill text-xl"></i>
        </span>
        <div class="space-y-1.5">
          <p class="text-xs font-extrabold uppercase tracking-widest text-amber-700">Lưu ý an toàn</p>
          <p class="text-sm font-extrabold uppercase leading-6 text-amber-900">Sử dụng các phím nút nhẹ tay , Không leo trèo, ngồi lên mui xe, nắp capo.</p>
          <p class="text-sm font-bold uppercase leading-6 text-amber-800">Các bộ phận này rất mỏng và mềm, dễ bị móp méo, hư hỏng.</p>
        </div>
      </div>
    </div>

    <!-- Danh sách checklist -->
    @include('partials.checklist', ['checklistGrid' => 'grid-cols-1 gap-2 p-3'])

    <!-- Lái xe an toàn -->
    <div id="lai-xe-an-toan" class="space-y-3">
      <div class="flex items-center gap-2 px-1">
        <div class="h-6 w-1 rounded-full bg-app-accent"></div>
        <div>
          <h2 class="text-base font-extrabold text-app-ink">Lái xe an toàn</h2>
          <p class="text-xs font-semibold text-app-muted">9 điều cần nhớ khi lái xe</p>
        </div>
      </div>
      @foreach($safetyRules as $rule)
        @if(!empty($rule['final']))
        <div class="relative rounded-xl bg-white p-4 shadow-sm">
          <div class="mb-3 flex items-center justify-end">
            <span class="text-3xl font-extrabold leading-none select-none text-stone-300">{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
          </div>
          <h3 class="text-sm font-extrabold uppercase tracking-wide text-app-ink">{{ $rule['title'] }}</h3>
          <p class="mt-1.5 text-sm leading-6 text-app-muted">{{ $rule['content'] }}</p>
          <p class="mt-2.5 text-xs font-extrabold leading-5 text-app-green">Chúc quý khách có những chuyến đi an toàn và vui vẻ cùng Thuê Xe Tự Lái Buôn Hồ!</p>
        </div>
        @else
        <div class="relative rounded-xl bg-white p-4 shadow-sm">
          @if(!empty($rule['absolute']))
          <span class="absolute -left-2 -top-2 z-10 whitespace-nowrap rounded-full bg-red-600 px-2 py-0.5 text-[10px] font-extrabold uppercase tracking-wide text-white shadow-md ring-2 ring-white">Tuyệt đối</span>
          @endif
          <div class="mb-3 flex items-center justify-end">
            <span class="text-3xl font-extrabold leading-none select-none {{ !empty($rule['absolute']) ? 'text-red-200' : 'text-stone-300' }}">{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
          </div>
          <h3 class="text-sm font-extrabold text-app-ink">{{ $rule['title'] }}</h3>
          <p class="mt-1.5 text-sm leading-6 text-app-muted">{{ $rule['content'] }}</p>
        </div>
        @endif
      @endforeach
    </div>
  </div>
@endsection
