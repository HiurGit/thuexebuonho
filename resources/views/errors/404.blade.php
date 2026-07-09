<!DOCTYPE html>
<html lang="vi">
<head>
  @section('title', '404 - Lạc đường rồi | Thuê xe Buôn Hồ')
  @section('meta')
  <meta name="description" content="Trang bạn đang tìm kiếm không tồn tại hoặc đã được chuyển hướng.">
  @endsection
  @include('partials.head')
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
  <style>
    body { font-family: 'Be Vietnam Pro', sans-serif; }

    .road-dash {
      stroke-dasharray: 14 14;
      animation: dashmove 1.1s linear infinite;
    }

    @keyframes dashmove {
      to { stroke-dashoffset: -56; }
    }

    .car-wiggle {
      animation: wiggle 2.6s ease-in-out infinite;
      transform-origin: 50% 100%;
    }

    @keyframes wiggle {
      0%, 100% { transform: translateY(0) rotate(-1.5deg); }
      50% { transform: translateY(-4px) rotate(1.5deg); }
    }

    .sign-sway {
      animation: sway 3.4s ease-in-out infinite;
      transform-origin: 50% 0%;
    }

    @keyframes sway {
      0%, 100% { transform: rotate(-2deg); }
      50% { transform: rotate(2deg); }
    }

    @media (prefers-reduced-motion: reduce) {
      .road-dash, .car-wiggle, .sign-sway { animation: none; }
    }
  </style>
</head>
<body class="min-h-screen bg-[#f6f8f3] text-[#0f2e1e]">
  <main class="flex min-h-screen items-center justify-center px-5 py-8 sm:px-8">
    <div class="w-full max-w-5xl rounded-[28px] border border-white/70 bg-white/55 p-6 shadow-[0_28px_80px_rgba(15,46,30,0.10)] backdrop-blur-sm sm:p-8 lg:p-10">
      <div class="grid items-center gap-8 lg:grid-cols-[0.95fr_1.05fr] lg:gap-12">
        <section class="order-2 text-center lg:order-1 lg:text-left">
          <p class="text-xs font-black uppercase tracking-[0.28em] text-app-accent">Rẽ nhầm lối rồi</p>
          <h1 class="mt-3 text-3xl font-black leading-snug text-[#0f2e1e] sm:text-4xl lg:text-5xl">
            Trang này không có
            <span class="block">trên bản đồ của chúng tôi</span>
          </h1>
          <p class="mx-auto mt-4 max-w-md text-sm leading-relaxed text-[#0f2e1e]/62 sm:text-[15px] lg:mx-0 lg:text-base">
            Đường dẫn bạn vừa mở có thể đã đổi hướng hoặc không còn tồn tại. Quay lại lộ trình quen thuộc để tiếp tục xem xe và đặt lịch nhé.
          </p>

          <div class="mt-7 flex flex-col gap-3 sm:mx-auto sm:max-w-xs lg:mx-0">
            <a href="{{ route('index') }}" class="flex w-full items-center justify-center gap-2 rounded-xl bg-app-accent px-5 py-3.5 text-sm font-black text-white shadow-[0_16px_34px_rgba(95,207,134,0.35)] transition active:scale-95 hover:bg-app-green">
              <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.3" stroke-linecap="round" stroke-linejoin="round"><path d="M3 12l9-9 9 9"/><path d="M5 10v10a1 1 0 0 0 1 1h4v-6h4v6h4a1 1 0 0 0 1-1V10"/></svg>
              Về trang chủ
            </a>
            <a href="{{ route('index') }}#danh-sach-xe" class="flex w-full items-center justify-center gap-2 rounded-xl border border-[#0f2e1e]/10 bg-white px-5 py-3.5 text-sm font-black text-[#0f2e1e] transition active:scale-95 hover:border-app-accent hover:text-app-accent">
              <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.3" stroke-linecap="round" stroke-linejoin="round"><path d="M3 13l1.5-4.5A2 2 0 0 1 6.4 7h11.2a2 2 0 0 1 1.9 1.5L21 13"/><path d="M3 13h18v4a1 1 0 0 1-1 1h-1a1 1 0 0 1-1-1v-1H6v1a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1v-4z"/></svg>
              Xem danh sách xe
            </a>
          </div>
        </section>

        <section class="order-1 lg:order-2">
          <div class="mx-auto w-full max-w-xs sm:max-w-sm lg:max-w-md">
      <svg viewBox="0 0 320 220" class="h-auto w-full" xmlns="http://www.w3.org/2000/svg">
        <ellipse cx="160" cy="196" rx="150" ry="14" fill="#E7F3E0"/>

        <path d="M10 150 C 80 110, 120 190, 190 150 S 300 100, 305 60"
              stroke="#D9DFD3" stroke-width="34" fill="none" stroke-linecap="round"/>
        <path class="road-dash" d="M10 150 C 80 110, 120 190, 190 150 S 300 100, 305 60"
              stroke="#FFD23F" stroke-width="3" fill="none" stroke-linecap="round"/>

        <g class="sign-sway">
          <rect x="252" y="24" width="6" height="42" rx="2" fill="#0F2E1E"/>
          <rect x="228" y="14" width="54" height="34" rx="6" fill="#FFFFFF" stroke="#0F2E1E" stroke-width="3"/>
          <text x="255" y="37" text-anchor="middle" font-family="Be Vietnam Pro, sans-serif" font-weight="800" font-size="16" fill="#E8192C">404</text>
        </g>

        <g class="car-wiggle" transform="translate(60,118)">
          <ellipse cx="30" cy="52" rx="34" ry="6" fill="#00000012"/>
          <path d="M2 34c0-6 5-10 12-10l6-14c2-4 6-6 10-6h14c5 0 9 3 11 7l8 13c6 1 11 5 11 10v9c0 3-2 5-5 5H7c-3 0-5-2-5-5v-9z" fill="#03CF5E"/>
          <path d="M22 14l-5 10h30l-6-11c-1-2-3-3-5-3H27c-2 0-4 1-5 4z" fill="#EAFBF0"/>
          <circle cx="17" cy="46" r="8" fill="#0F2E1E"/>
          <circle cx="17" cy="46" r="3" fill="#D9DFD3"/>
          <circle cx="49" cy="46" r="8" fill="#0F2E1E"/>
          <circle cx="49" cy="46" r="3" fill="#D9DFD3"/>
        </g>

        <text x="95" y="90" font-family="Be Vietnam Pro, sans-serif" font-weight="800" font-size="26" fill="#E8192C" opacity="0.85">?</text>
      </svg>
          </div>
        </section>
      </div>
    </div>
  </main>
</body>
</html>
