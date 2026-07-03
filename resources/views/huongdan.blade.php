@extends('layouts.app')

@section('title', 'Hướng dẫn - Thuê Xe Buôn Hồ')

@section('meta')
<meta name="description" content="Hướng dẫn sử dụng xe, xử lý tai nạn và bảo hiểm khi thuê xe tại Buôn Hồ.">
<meta property="og:title" content="Hướng dẫn - Thuê Xe Buôn Hồ">
<meta property="og:description" content="Hướng dẫn sử dụng xe, xử lý tai nạn và bảo hiểm khi thuê xe tại Buôn Hồ.">
<meta property="og:image" content="{{ asset('assets/image/bannerMXH.jpg') }}">
<meta property="og:image:width" content="1200">
<meta property="og:image:height" content="630">
<meta property="og:url" content="{{ url()->current() }}">
<meta property="og:type" content="website">
<meta property="og:site_name" content="Thuê Xe Buôn Hồ">
<meta property="og:locale" content="vi_VN">
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="Hướng dẫn - Thuê Xe Buôn Hồ">
<meta name="twitter:description" content="Hướng dẫn sử dụng xe, xử lý tai nạn và bảo hiểm khi thuê xe tại Buôn Hồ.">
<meta name="twitter:image" content="{{ asset('assets/image/bannerMXH.jpg') }}">
<meta property="og:image:type" content="image/jpeg">
<meta property="og:image:alt" content="Thuê Xe Buôn Hồ - Hướng dẫn">
@endsection

@php
$typeInfo = [
    'usage' => [
        'label' => 'Hướng dẫn sử dụng xe',
        'desc' => 'Hướng dẫn chi tiết cách sử dụng xe an toàn và hiệu quả từ khi nhận xe đến khi trả xe.',
        'icon' => 'icon-sudung.png',
        'color' => 'border-app-accent',
    ],
    'accident' => [
        'label' => 'Xử lý tai nạn',
        'desc' => 'Quy trình xử lý khi xảy ra tai nạn, đảm bảo an toàn và bảo vệ quyền lợi.',
        'icon' => 'icon-tainan.png',
        'color' => 'border-app-accent',
    ],
    'insurance' => [
        'label' => 'Xử lý bảo hiểm',
        'desc' => 'Hướng dẫn quy trình làm việc với bảo hiểm khi có sự cố xảy ra.',
        'icon' => 'icon-baohiem.png',
        'color' => 'border-blue-400',
    ],
];
$typeColors = ['usage' => 'app-accent', 'accident' => 'app-accent', 'insurance' => 'blue-400'];
@endphp

@section('content-desktop')
<div class="hidden lg:block bg-app-bg min-h-screen">
  <section class="border-b border-app-line bg-white">
    <div class="mx-auto max-w-7xl px-5 py-4">
      <h1 class="text-2xl font-extrabold text-app-ink">Hướng dẫn</h1>
      <p class="mt-1 text-sm font-semibold text-app-muted">Hướng dẫn sử dụng xe, xử lý tai nạn và bảo hiểm</p>
    </div>
  </section>

  <main class="mx-auto max-w-7xl px-5 py-6 space-y-8">
    <section>
      <h2 class="section-title text-lg font-extrabold mb-4">Hướng dẫn chung</h2>
      <div class="grid grid-cols-3 gap-4">
        @foreach(['usage', 'accident', 'insurance'] as $t)
        @php $info = $typeInfo[$t]; $items = $guides->get($t, collect()); @endphp
        <div class="guide-card cursor-pointer rounded-2xl border border-app-line bg-white p-5 shadow-sm transition-all hover:shadow-card hover:border-app-accent" onclick="document.getElementById('modal-{{ $t }}').classList.remove('hidden');document.body.style.overflow='hidden'">
          <img src="{{ asset('assets/icon-huongdan/' . $info['icon']) }}" alt="{{ $info['label'] }}" class="h-20 w-20 object-contain mb-3">
          <h3 class="text-base font-extrabold text-app-ink mb-2">{{ $info['label'] }}</h3>
          <p class="text-sm text-app-muted leading-relaxed mb-4">{{ $info['desc'] }}</p>
          <div class="flex items-center gap-1.5 text-app-accent font-bold text-sm">
            <span>Xem chi tiết</span>
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="h-4 w-4"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
          </div>
        </div>
        @endforeach
      </div>
    </section>

    @if($cars->count() > 0)
    <section>
        
      <h2 class="section-title text-lg font-extrabold mb-1">Hướng dẫn theo từng loại xe</h2>
      
      <div class="grid grid-cols-3 gap-4">
        @foreach($cars as $car)
        <div class="cursor-pointer rounded-2xl border border-app-line bg-white p-4 shadow-sm transition-all hover:shadow-card hover:border-app-accent group" onclick="openCarModal({{ $car->id }})">
          <div class="aspect-[4/3] overflow-hidden rounded-xl bg-stone-100 mb-3">
            @if($car->mainImage)
            <img src="{{ asset($car->mainImage->path) }}" alt="{{ $car->name }}" class="h-full w-full object-cover group-hover:scale-105 transition-transform duration-300">
            @else
            <div class="h-full w-full flex items-center justify-center text-app-muted text-sm font-bold">{{ $car->name }}</div>
            @endif
          </div>
          <h3 class="text-base font-extrabold text-app-ink">{{ $car->name }}</h3>
          <p class="text-xs text-app-muted mt-0.5">{{ $car->seats }} chỗ - {{ $car->transmission }} - {{ $car->fuel }}</p>
          <div class="mt-2 flex items-center gap-1.5 text-app-accent font-bold text-xs">
            <span>Xem hướng dẫn</span>
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="h-3 w-3"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
          </div>
        </div>
        @endforeach
      </div>
    </section>
    @endif
  </main>
</div>
@endsection

@push('modals')
{{-- Global guide modals --}}
@foreach(['usage', 'accident', 'insurance'] as $t)
@php $info = $typeInfo[$t]; $items = $guides->get($t, collect()); @endphp
<div id="modal-{{ $t }}" class="fixed inset-0 z-[70] hidden bg-black/30" onclick="if(event.target===this){this.classList.add('hidden');document.body.style.overflow=''}">
  <div class="absolute inset-x-0 bottom-0 mx-auto w-full max-w-[460px] max-h-[90vh] overflow-y-auto rounded-t-[20px] bg-white p-4 pb-6 shadow-xl lg:inset-auto lg:left-1/2 lg:top-1/2 lg:max-w-xl lg:-translate-x-1/2 lg:-translate-y-1/2 lg:rounded-2xl lg:p-5 lg:max-h-[85vh]">
    <div class="mx-auto mb-3 h-1 w-14 rounded-full bg-stone-200 lg:hidden"></div>
    <div class="flex items-center justify-between mb-3">
      <h3 class="text-lg font-extrabold text-app-ink">{{ $info['label'] }}</h3>
      <button type="button" onclick="this.closest('[id^=modal-]').classList.add('hidden');document.body.style.overflow=''" class="flex h-8 w-8 items-center justify-center rounded-full bg-stone-100 text-base text-app-muted lg:rounded-xl">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12"/></svg>
      </button>
    </div>
    <div class="space-y-3 text-sm">
      @forelse($items as $i => $guide)
      <div class="rounded-xl border border-app-line bg-white p-3">
        <h4 class="text-base font-extrabold text-app-ink mb-1.5 flex items-center gap-2">
          <span class="flex h-6 w-6 items-center justify-center rounded-lg bg-app-accentSoft text-xs font-extrabold text-app-accent">{{ $loop->iteration }}</span>
          {{ $guide->section_title }}
        </h4>
        <div class="ml-8 text-app-muted leading-relaxed whitespace-pre-wrap">{!! $guide->content !!}</div>
      </div>
      @empty
      <p class="text-center text-app-muted py-6">Nội dung đang được cập nhật...</p>
      @endforelse
    </div>
    <div class="mt-4">
      <button type="button" onclick="this.closest('[id^=modal-]').classList.add('hidden');document.body.style.overflow=''" class="w-full rounded-xl bg-app-accent px-4 py-2.5 text-sm font-extrabold text-white shadow-sm transition-all hover:bg-app-green active:scale-[0.98]">Đã hiểu</button>
    </div>
  </div>
</div>
@endforeach

{{-- Per-car guide modals --}}
@foreach($cars as $car)
<div id="car-modal-{{ $car->id }}" class="fixed inset-0 z-[70] hidden bg-black/30" onclick="if(event.target===this){closeCarModal(this)}">
  <div class="absolute inset-x-0 bottom-0 mx-auto w-full max-w-[460px] max-h-[90vh] overflow-y-auto rounded-t-[20px] bg-white p-4 pb-6 shadow-xl lg:inset-auto lg:left-1/2 lg:top-1/2 lg:max-w-xl lg:-translate-x-1/2 lg:-translate-y-1/2 lg:rounded-2xl lg:p-5 lg:max-h-[85vh]">
    <div class="mx-auto mb-3 h-1 w-14 rounded-full bg-stone-200 lg:hidden"></div>
    <div class="flex items-center justify-between mb-3">
      <div>
        <p class="text-xs font-bold text-app-muted">Hướng dẫn chi tiết</p>
        <h3 class="text-lg font-extrabold text-app-ink">{{ $car->name }}</h3>
      </div>
      <button type="button" onclick="closeCarModal(this)" class="flex h-8 w-8 items-center justify-center rounded-full bg-stone-100 text-base text-app-muted lg:rounded-xl">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12"/></svg>
      </button>
    </div>
    <div class="space-y-3 text-sm">
      @forelse($car->guides as $guide)
      <div class="rounded-xl border border-app-line bg-white p-3">
        <h4 class="text-base font-extrabold text-app-ink mb-2 flex items-center gap-2">
          <span class="flex h-6 w-6 items-center justify-center rounded-lg bg-app-accentSoft text-xs font-extrabold text-app-accent">{{ $loop->iteration }}</span>
          {{ $guide->title }}
        </h4>
        @if($guide->video_path)
        <div class="text-right">
          <button type="button" onclick="openVideoViewer('{{ asset($guide->video_path) }}')" class="inline-flex items-center gap-2 rounded-xl bg-app-accentSoft px-4 py-2 text-sm font-extrabold text-app-accent transition-all hover:bg-app-accent hover:text-white">
            <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
            Xem video
          </button>
        </div>
        @endif
      </div>
      @empty
      <p class="text-center text-app-muted py-6">Chưa có hướng dẫn cho xe này.</p>
      @endforelse
    </div>
    <div class="mt-4">
      <button type="button" onclick="closeCarModal(this)" class="w-full rounded-xl bg-app-accent px-4 py-2.5 text-sm font-extrabold text-white shadow-sm transition-all hover:bg-app-green active:scale-[0.98]">Đã hiểu</button>
    </div>
  </div>
</div>
@endforeach

<script>
function openCarModal(id) {
  var modal = document.getElementById('car-modal-' + id);
  if (!modal) return;
  modal.classList.remove('hidden');
  document.body.style.overflow = 'hidden';
}
function closeCarModal(btn) {
  var modal = btn.closest('[id^=car-modal-]');
  if (!modal) return;
  modal.classList.add('hidden');
  document.body.style.overflow = '';
}
function openVideoViewer(src) {
  var viewer = document.getElementById('video-viewer');
  var video = document.getElementById('viewer-video');
  video.src = src;
  viewer.classList.remove('hidden');
  viewer.classList.add('flex');
  document.body.style.overflow = 'hidden';
  video.play();
}
function closeVideoViewer() {
  var viewer = document.getElementById('video-viewer');
  var video = document.getElementById('viewer-video');
  video.pause();
  video.src = '';
  viewer.classList.add('hidden');
  viewer.classList.remove('flex');
  document.body.style.overflow = '';
}
</script>

{{-- Video viewer overlay --}}
<div id="video-viewer" class="fixed inset-0 z-[80] hidden bg-black/80 flex-col items-center justify-center" onclick="if(event.target===this) closeVideoViewer()">
  <div class="relative mx-auto w-full max-w-3xl px-4">
    <button type="button" onclick="closeVideoViewer()" class="absolute -top-10 right-4 flex h-8 w-8 items-center justify-center rounded-full bg-white/20 text-white backdrop-blur transition-all hover:bg-white/40">
      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="h-5 w-5"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12"/></svg>
    </button>
    <video id="viewer-video" class="w-full rounded-xl" controls playsinline></video>
  </div>
</div>
@endpush

@section('content-mobile')
<div class="block lg:hidden bg-app-bg min-h-screen pb-20">

  <div class="border-b border-app-line bg-white px-4 py-2 shadow-sm">
    <div class="flex items-center justify-between">
      <a href="{{ route('index') }}" class="flex h-9 w-9 items-center justify-center rounded-xl bg-app-accentSoft text-app-accent transition-all hover:bg-app-accent hover:text-white">
        <i class="ri-arrow-left-s-line text-lg"></i>
      </a>
      <h1 class="text-lg font-extrabold">Hướng dẫn</h1>
      <div class="w-9"></div>
    </div>
  </div>

  <main class="flex-1 overflow-y-auto" style="scroll-behavior: smooth">
    <div class="px-4 pb-24 pt-3 space-y-6">
      <section>
        <h2 class="section-title text-base font-extrabold mb-3">Hướng dẫn chung</h2>
        <div class="space-y-2">
          @foreach(['usage', 'accident', 'insurance'] as $t)
          @php $info = $typeInfo[$t]; @endphp
          <div class="guide-card cursor-pointer rounded-xl border border-app-line bg-white p-3.5 shadow-sm transition-all active:scale-[0.98]" onclick="document.getElementById('modal-{{ $t }}').classList.remove('hidden');document.body.style.overflow='hidden'">
            <div class="flex items-start gap-3">
              <img src="{{ asset('assets/icon-huongdan/' . $info['icon']) }}" alt="{{ $info['label'] }}" class="h-14 w-14 shrink-0 object-contain">
              <div class="flex-1 min-w-0">
                <h3 class="text-sm font-extrabold text-app-ink">{{ $info['label'] }}</h3>
                <p class="text-xs text-app-muted mt-0.5 leading-relaxed">{{ $info['desc'] }}</p>
                <div class="mt-2 flex items-center gap-1.5 text-app-accent font-bold text-xs">
                  <span>Xem chi tiết</span>
                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="h-3 w-3"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
                </div>
              </div>
            </div>
          </div>
          @endforeach
        </div>
      </section>

      @if($cars->count() > 0)
      <section>
        <h2 class="section-title mt-4 mb-4 text-base font-extrabold">Hướng dẫn theo từng loại xe</h2>
        <div class="space-y-2">
          @foreach($cars as $car)
          <div class="cursor-pointer rounded-xl border border-app-line bg-white p-3.5 shadow-sm transition-all active:scale-[0.98]" onclick="openCarModal({{ $car->id }})">
            <div class="flex items-start gap-3">
              <div class="h-14 w-14 shrink-0 overflow-hidden rounded-xl bg-stone-100">
                @if($car->mainImage)
                <img src="{{ asset($car->mainImage->path) }}" alt="{{ $car->name }}" class="h-full w-full object-cover">
                @else
                <div class="h-full w-full flex items-center justify-center text-xs font-bold text-app-muted">{{ $car->name }}</div>
                @endif
              </div>
              <div class="flex-1 min-w-0">
                <h3 class="text-sm font-extrabold text-app-ink">{{ $car->name }}</h3>
                <p class="text-xs text-app-muted mt-0.5 leading-relaxed">{{ $car->seats }} chỗ - {{ $car->transmission }}</p>
                <div class="mt-2 flex items-center gap-1.5 text-app-accent font-bold text-xs">
                  <span>Xem hướng dẫn</span>
                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="h-3 w-3"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
                </div>
              </div>
            </div>
          </div>
          @endforeach
        </div>
      </section>
      @endif
    </div>
  </main>

</div>
@endsection
