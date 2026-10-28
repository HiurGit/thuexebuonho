@extends('layouts.app')

@section('title', 'Lái Xe An Toàn - Thuê Xe Buôn Hồ')

@section('meta')
<meta name="description" content="9 điều cần nhớ khi lái xe: không vượt đèn đỏ, không rượu bia, tốc độ vừa phải, chủ động chân phanh và giữ an toàn tuyệt đối trên mọi cung đường.">
<meta property="og:title" content="Lái Xe An Toàn - Thuê Xe Buôn Hồ">
<meta property="og:description" content="9 điều cần nhớ khi lái xe: không vượt đèn đỏ, không rượu bia, tốc độ vừa phải, chủ động chân phanh và giữ an toàn tuyệt đối trên mọi cung đường.">
<meta property="og:image" content="{{ asset('assets/image/bannerMXH.jpg') }}">
<meta property="og:image:width" content="1200">
<meta property="og:image:height" content="630">
<meta property="og:image:type" content="image/jpeg">
<meta property="og:image:alt" content="Thuê Xe Buôn Hồ - Lái Xe An Toàn">
<meta property="og:url" content="{{ url()->current() }}">
<meta property="og:type" content="website">
<meta property="og:site_name" content="Thuê Xe Buôn Hồ">
<meta property="og:locale" content="vi_VN">
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="Lái Xe An Toàn - Thuê Xe Buôn Hồ">
<meta name="twitter:description" content="9 điều cần nhớ khi lái xe: không vượt đèn đỏ, không rượu bia, tốc độ vừa phải, chủ động chân phanh và giữ an toàn tuyệt đối trên mọi cung đường.">
<meta name="twitter:image" content="{{ asset('assets/image/bannerMXH.jpg') }}">
@endsection

@php
$safetyRules = [
    [
        'title' => 'Không vượt đèn đỏ và đèn vàng',
        'content' => 'Tuyệt đối không vượt đèn đỏ và đèn vàng. Đèn xanh chỉ còn 4–5 giây cũng không cố tăng tốc để vượt qua.',
        'absolute' => true,
    ],
    [
        'title' => 'Không uống rượu bia khi tham gia giao thông',
        'content' => 'Hậu quả rất nghiêm trọng: Công an giữ xe, bảo hiểm xét nghiệm có nồng độ cồn sẽ từ chối bồi thường.',
        'absolute' => true,
    ],
    [
        'title' => 'Tốc độ vừa phải',
        'content' => 'Xe lạ nên quý khách hãy chạy chậm, giữ tốc độ vừa phải.',
    ],
    [
        'title' => 'Luôn chủ động chân phanh',
        'content' => 'Khi không sử dụng chân ga, hãy để chân phải sẵn sàng chuyển sang chân phanh. Rảnh chân là đặt chân vào phanh.',
    ],
    [
        'title' => 'Không vượt ẩu, vượt khi khuất tầm nhìn',
        'content' => 'Chỉ vượt khi đủ điều kiện an toàn, quan sát rõ đoạn đường phía trước. Tuyệt đối không vượt tại khúc cua, đỉnh dốc hoặc nơi tầm nhìn bị hạn chế.',
    ],
    [
        'title' => 'Giữ khoảng cách an toàn',
        'content' => 'Không bám đuôi xe phía trước. Luôn giữ khoảng cách đủ để xử lý khi xe trước phanh gấp hoặc có tình huống bất ngờ.',
    ],
    [
        'title' => 'Không sử dụng điện thoại khi lái xe',
        'content' => 'Tập trung quan sát đường đi, gương chiếu hậu, biển báo và các phương tiện xung quanh.',
    ],
    [
        'title' => 'Không chủ quan khi đi đường lạ',
        'content' => 'Giảm tốc độ tại ngã tư, đường đông dân cư, trường học, khu vực có trẻ em, đường trơn trượt hoặc trời mưa.',
    ],
    [
        'title' => 'An toàn là trên hết',
        'content' => 'Đi chậm một chút không sao, đến muộn vài phút không sao. Quan trọng nhất là quý khách và mọi người đều đến nơi an toàn.',
        'final' => true,
    ],
];
@endphp

@section('content-desktop')
  <!-- ===== HERO ===== -->
  <div class="border-b border-app-line bg-white shadow-sm">
    <div class="mx-auto flex max-w-5xl items-center gap-4 px-6 py-3">
      <a href="javascript:history.back()" class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-app-accentSoft text-app-accent transition-all hover:bg-app-accent hover:text-white">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5"/></svg>
      </a>
      <h1 class="flex-1 text-center text-xl font-extrabold text-app-ink">Lái Xe An Toàn</h1>
      <div class="w-10 shrink-0"></div>
    </div>
  </div>

  <!-- ===== RULE CARDS ===== -->
  <main class="mx-auto max-w-5xl px-6 pb-8 pt-6">
    <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-3">
      @foreach($safetyRules as $rule)
        @if(!empty($rule['final']))
        <!-- ===== BANNER: An toàn là trên hết ===== -->
        <div class="relative rounded-2xl border border-app-line bg-white p-5 shadow-sm transition-all hover:-translate-y-1 hover:shadow-card">
          <div class="mb-4 flex items-center justify-end">
            <span class="text-4xl font-extrabold leading-none select-none text-stone-300">{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
          </div>
          <h2 class="text-base font-extrabold uppercase tracking-wide text-app-ink">{{ $rule['title'] }}</h2>
          <p class="mt-2 text-sm leading-6 text-app-muted">{{ $rule['content'] }}</p>
          <p class="mt-3 text-sm font-extrabold text-app-green">Chúc quý khách có những chuyến đi an toàn và vui vẻ cùng Thuê Xe Tự Lái Buôn Hồ!</p>
        </div>
        @else
        <div class="relative rounded-2xl border p-5 shadow-sm transition-all hover:-translate-y-1 hover:shadow-card {{ !empty($rule['absolute']) ? 'border-red-200 bg-white' : 'border-app-line bg-white' }}">
          @if(!empty($rule['absolute']))
          <span class="absolute -left-2 -top-2 z-10 whitespace-nowrap rounded-full bg-red-600 px-2.5 py-1 text-[10px] font-extrabold uppercase tracking-wide text-white shadow-md ring-2 ring-white">Tuyệt đối</span>
          @endif
          <div class="mb-4 flex items-center justify-end">
            <span class="text-4xl font-extrabold leading-none select-none {{ !empty($rule['absolute']) ? 'text-red-200' : 'text-stone-300' }}">{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
          </div>
          <h2 class="text-base font-extrabold text-app-ink">{{ $rule['title'] }}</h2>
          <p class="mt-2 text-sm leading-6 text-app-muted">{{ $rule['content'] }}</p>
        </div>
        @endif
      @endforeach
    </div>
  </main>
@endsection

@section('content-mobile')
  <!-- ===== HERO ===== -->
  <div class="border-b border-app-line bg-white shadow-sm">
    <div class="flex items-center gap-3 px-4 py-1">
      <a href="javascript:history.back()" class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-app-accentSoft text-app-accent transition-all hover:bg-app-accent hover:text-white">
        <i class="ri-arrow-left-s-line text-lg"></i>
      </a>
      <h1 class="flex-1 text-center text-lg font-extrabold">Lái Xe An Toàn</h1>
      <div class="w-9 shrink-0"></div>
    </div>
  </div>

  <!-- ===== RULE CARDS ===== -->
  <div class="px-4 pb-4 pt-3">
    @foreach($safetyRules as $rule)
      @if(!empty($rule['final']))
      <!-- ===== BANNER: An toàn là trên hết ===== -->
      <div class="relative rounded-xl border border-app-line bg-white p-4 shadow-sm">
        <div class="mb-3 flex items-center justify-end">
          <span class="text-3xl font-extrabold leading-none select-none text-stone-300">{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
        </div>
        <h2 class="text-sm font-extrabold uppercase tracking-wide text-app-ink">{{ $rule['title'] }}</h2>
        <p class="mt-1.5 text-sm leading-6 text-app-muted">{{ $rule['content'] }}</p>
        <p class="mt-2.5 text-xs font-extrabold leading-5 text-app-green">Chúc quý khách có những chuyến đi an toàn và vui vẻ cùng Thuê Xe Tự Lái Buôn Hồ!</p>
      </div>
      @else
      <div class="relative rounded-xl border border-app-line bg-white p-4 shadow-sm">
        @if(!empty($rule['absolute']))
        <span class="absolute -left-2 -top-2 z-10 whitespace-nowrap rounded-full bg-red-600 px-2 py-0.5 text-[10px] font-extrabold uppercase tracking-wide text-white shadow-md ring-2 ring-white">Tuyệt đối</span>
        @endif
        <div class="mb-3 flex items-center justify-end">
          <span class="text-3xl font-extrabold leading-none select-none {{ !empty($rule['absolute']) ? 'text-red-200' : 'text-stone-300' }}">{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
        </div>
        <h2 class="text-sm font-extrabold text-app-ink">{{ $rule['title'] }}</h2>
        <p class="mt-1.5 text-sm leading-6 text-app-muted">{{ $rule['content'] }}</p>
      </div>
      @endif
    @endforeach
  </div>
@endsection
