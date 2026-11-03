@extends('layouts.app')

@section('title', 'Dịch vụ - Thuê Xe Buôn Hồ')

@section('meta')
<meta name="description" content="Tất cả dịch vụ cho thuê xe tại Buôn Hồ, Đăk Lăk. Thuê xe tự lái, đưa đón sân bay, du lịch...">
<meta property="og:title" content="Dịch vụ - Thuê Xe Buôn Hồ">
<meta property="og:description" content="Tất cả dịch vụ cho thuê xe tại Buôn Hồ, Đăk Lăk.">
<meta property="og:image" content="{{ asset('assets/image/bannerMXH.jpg') }}">
<meta property="og:image:width" content="1200">
<meta property="og:image:height" content="630">
<meta property="og:url" content="{{ url()->current() }}">
<meta property="og:type" content="website">
<meta property="og:site_name" content="Thuê Xe Buôn Hồ">
<meta property="og:locale" content="vi_VN">
<meta property="og:image:type" content="image/jpeg">
<meta property="og:image:alt" content="Dịch vụ thuê xe - Thuê Xe Buôn Hồ">
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="Dịch vụ - Thuê Xe Buôn Hồ">
<meta name="twitter:description" content="Tất cả dịch vụ cho thuê xe tại Buôn Hồ, Đăk Lăk.">
<meta name="twitter:image" content="{{ asset('assets/image/bannerMXH.jpg') }}">
@endsection

@php
  $sitePhone = \App\Models\Setting::get('site_phone', '0964918047');
  $sitePhoneDisplay = preg_replace('/(\d{4})(\d{3})(\d{3,})/', '$1.$2.$3', $sitePhone) ?: $sitePhone;
  $siteZaloUrl = 'https://zalo.me/' . preg_replace('/\D+/', '', $sitePhone);

  $services = [
    [
      'icon' => 'dv-tulai.png',
      'alt' => 'Thuê xe tự lái',
      'title' => 'Thuê xe tự lái',
      'tagline' => 'Xe đời mới, sạch sẽ, an toàn',
      'tone' => 'text-app-accent',
      'description' => 'Nhận xe nhanh trong ngày, tự do chủ động lịch trình. Phù hợp cho mọi hành trình: đi chơi, du lịch, về quê, công tác. Xe đầy đủ bảo hiểm, camera hành trình, Vietmap Live Pro dẫn đường.',
      'features' => [
        'Nhận xe nhanh chỉ với CCCD + GPLX',
        'Giao xe tận nơi trong khu vực nội thị Buôn Hồ',
        'Hỗ trợ đưa đón sân bay, đi tỉnh',
      ],
      'chips' => [],
    ],
    [
      'icon' => 'dv-sanbay.png',
      'alt' => 'Đưa đón sân bay',
      'title' => 'Đưa đón sân bay',
      'tagline' => 'Đón tiễn đúng giờ, an tâm',
      'tone' => 'text-blue-500',
      'description' => 'Phục vụ đưa đón sân bay Buôn Ma Thuột và Cam Ranh. Đúng giờ, lịch sự, hỗ trợ xách đồ. Xe gia đình 5 chỗ 7 chỗ thoải mái cho đoàn.',
      'features' => [],
      'chips' => ['Sân bay Buôn Ma Thuột', 'Sân bay Cam Ranh'],
    ],
    [
      'icon' => 'dv-nhau.png',
      'alt' => 'Đưa đón đi nhậu',
      'title' => 'Đưa đón đi nhậu',
      'tagline' => 'Tận hưởng cuộc vui trọn vẹn',
      'tone' => 'text-orange-500',
      'description' => 'Đã uống rượu bia thì không lái xe. Hãy để chúng tôi đưa đón bạn và bạn bè tận nơi. Xe 5 chỗ 7 chỗ, tài xế chuyên nghiệp, phục vụ đến khi khách hài lòng.',
      'features' => [],
      'chips' => [],
    ],
    [
      'icon' => 'dv-dulich.png',
      'alt' => 'Đưa đón du lịch',
      'title' => 'Đưa đón du lịch',
      'tagline' => 'Khám phá Tây Nguyên & các tỉnh',
      'tone' => 'text-emerald-500',
      'description' => 'Du lịch Buôn Đôn, thác Dray Nur, hồ Lắk, TP. Buôn Ma Thuột hoặc liên tỉnh Đà Lạt, Nha Trang, Gia Lai, Đà Nẵng. Xe đời mới, tài xế thân thiện rành đường.',
      'features' => [],
      'chips' => [],
    ],
    [
      'icon' => 'dv-ngaydem.png',
      'alt' => 'Đưa đón ngày đêm',
      'title' => 'Đưa đón ngày đêm',
      'tagline' => 'Phục vụ mọi khung giờ',
      'tone' => 'text-indigo-500',
      'description' => 'Cần đi sớm lúc 3h sáng ra bến xe, đón khách tối khuya, hay về quê đêm khuya? Chúng tôi sẵn sàng 24/7, kể cả lễ, Tết với mức phí phụ trội hợp lý.',
      'features' => [],
      'chips' => [],
    ],
    [
      'icon' => 'dv-benhvien.png',
      'alt' => 'Đưa đón bệnh viện',
      'title' => 'Đưa đón bệnh viện',
      'tagline' => 'Ưu tiên an tâm, nhẹ nhàng',
      'tone' => 'text-red-500',
      'description' => 'Đưa đón bệnh nhân đi tái khám, cấp cứu, chở người già đi viện. Tài xế hỗ trợ đỡ đồ, dắt xe lăn, phong thái nhã nhặn và kín đáo.',
      'features' => [],
      'chips' => [],
    ],
    [
      'icon' => 'dv-congtac.png',
      'alt' => 'Đưa đón công tác',
      'title' => 'Đưa đón công tác',
      'tagline' => 'Chỉnh chu, đúng hẹn',
      'tone' => 'text-slate-500',
      'description' => 'Phục vụ doanh nghiệp, cán bộ đi công tác liên tỉnh. Xe sạch sẽ, máy lạnh, tài xế lịch sự, đúng giờ. Có thể đưa đón dài ngày theo đoàn.',
      'features' => [],
      'chips' => [],
    ],
    [
      'icon' => 'dv-dihoc.png',
      'alt' => 'Đưa đón đi học',
      'title' => 'Đưa đón đi học',
      'tagline' => 'An toàn cho bé mỗi ngày',
      'tone' => 'text-yellow-600',
      'description' => 'Đưa đón học sinh đi học theo giờ cố định, linh hoạt sáng-chiều. Xe 5 chỗ 7 chỗ, tài xế có kinh nghiệm, đón tận nhà và giao tận trường. Phù hợp với phụ huynh bận rộn.',
      'features' => [],
      'chips' => [],
    ],
    [
      'icon' => 'dv-dilam.png',
      'alt' => 'Đưa đón đi làm',
      'title' => 'Đưa đón đi làm',
      'tagline' => 'Đi làm đúng giờ, thoải mái',
      'tone' => 'text-violet-500',
      'description' => 'Dịch vụ đưa đón nhân viên văn phòng, công nhân theo ca, hoặc đón khách hàng mỗi sáng. Nhận đặt theo tuần / tháng với giá ưu đãi.',
      'features' => [],
      'chips' => [],
    ],
    [
      'icon' => 'dv-yeucau.png',
      'alt' => 'Xe theo yêu cầu',
      'title' => 'Xe theo yêu cầu',
      'tagline' => 'Thiết kế lịch trình riêng',
      'tone' => 'text-pink-500',
      'description' => 'Bạn có lịch trình đặc biệt? Cần lộ trình riêng, giờ giấc tuỳ chỉnh? Hãy gọi cho chúng tôi, chúng tôi sẽ thiết kế chuyến đi phù hợp nhất cho bạn với chi phí hợp lý.',
      'features' => [],
      'chips' => [],
    ],
  ];
@endphp

@section('content-desktop')
<div class="bg-white">
@include('partials.marquee')

<section>
  <div class="mx-auto max-w-7xl px-6 pt-8">
    <img src="{{ asset('assets/image/banner-thuexe.png') }}" alt="Dịch vụ thuê xe" loading="eager" fetchpriority="high" class="h-auto w-full rounded-xl object-cover">
    <p class="mt-3 text-center text-sm font-bold text-app-muted">Tất cả dịch vụ đều có tài xế hoặc tự lái theo yêu cầu</p>
  </div>
</section>

<section class="py-10">
  <div class="mx-auto max-w-6xl px-6">
    <div class="pb-2">
      <p class="text-[11px] font-extrabold uppercase tracking-[0.2em] text-app-accent">Dịch vụ</p>
      <h1 class="mt-1 text-3xl font-extrabold text-app-ink">Dịch vụ của chúng tôi</h1>
      <p class="mt-2 text-sm font-semibold text-app-muted">10 dịch vụ đáp ứng mọi nhu cầu di chuyển của bạn</p>
    </div>

    <div class="mt-6 grid md:grid-cols-2 md:gap-x-12">
      @foreach($services as $service)
        <article class="border-t border-app-line py-7">
          <div class="flex items-start gap-4">
            <img src="{{ asset('assets/icon-dichvu/' . $service['icon']) }}" alt="{{ $service['alt'] }}" loading="lazy" class="h-16 w-16 shrink-0 object-contain">
            <div class="min-w-0">
              <h2 class="text-base font-extrabold text-app-ink">{{ $service['title'] }}</h2>
              <p class="mt-0.5 text-xs font-bold {{ $service['tone'] }}">{{ $service['tagline'] }}</p>
            </div>
          </div>

          <p class="mt-4 text-sm leading-6 text-app-muted">{{ $service['description'] }}</p>

          @if(!empty($service['features']))
            <ul class="mt-3 space-y-1.5">
              @foreach($service['features'] as $feature)
                <li class="flex items-start gap-2 text-[13px] font-semibold text-app-muted">
                  <svg class="mt-0.5 h-4 w-4 shrink-0 text-app-accent" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5"/>
                  </svg>
                  {{ $feature }}
                </li>
              @endforeach
            </ul>
          @endif

          @if(!empty($service['chips']))
            <p class="mt-3 text-xs font-bold text-app-muted">{{ implode(' • ', $service['chips']) }}</p>
          @endif
        </article>
      @endforeach
    </div>
  </div>
</section>

<section class="pb-12 pt-2">
  <div class="mx-auto max-w-6xl px-6 text-center">
    <h2 class="text-2xl font-extrabold text-app-ink">Bạn cần đặt dịch vụ?</h2>
    <p class="mt-2 text-sm font-semibold text-app-muted">Liên hệ ngay để được tư vấn và báo giá nhanh nhất</p>
    <div class="mt-6 flex flex-wrap justify-center gap-4">
      <a href="{{ $siteZaloUrl }}" target="_blank" rel="noopener" class="inline-flex items-center gap-2 rounded-xl bg-[#0068ff] px-6 py-3.5 text-sm font-extrabold text-white transition-colors hover:bg-[#0056d6]">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5"><path stroke-linecap="round" stroke-linejoin="round" d="M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6 1.123 2.994 2.707 3.227 1.129.166 2.27.293 3.423.379.35.026.67.21.865.501L12 21l2.755-4.133a1.14 1.14 0 0 1 .865-.501 48.172 48.172 0 0 0 3.423-.379c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0 0 12 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018Z" /></svg>
        Nhắn tin Zalo để đặt dịch vụ
      </a>
      <a href="tel:{{ $sitePhone }}" class="inline-flex items-center gap-2 rounded-xl border border-app-accent bg-white px-6 py-3.5 text-sm font-extrabold text-app-accent transition-colors hover:bg-app-accent hover:text-white">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 0 0 2.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 0 1-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 0 0-1.091-.852H4.5A2.25 2.25 0 0 0 2.25 4.5v2.25Z" /></svg>
        Gọi ngay: {{ $sitePhoneDisplay }}
      </a>
    </div>
  </div>
</section>
</div>
@endsection

@section('content-mobile')
<div class="min-h-full bg-white">
@include('partials.marquee')

<section class="px-4 pt-4">
  <img src="{{ asset('assets/image/banner-thuexe.png') }}" alt="Dịch vụ thuê xe" class="h-auto w-full rounded-xl object-cover">
  <p class="mt-3 text-center text-xs font-bold text-app-muted">Tất cả dịch vụ đều có tài xế hoặc tự lái theo yêu cầu</p>
</section>

<section class="px-4 pb-4 pt-6">
  <p class="text-[11px] font-extrabold uppercase tracking-[0.18em] text-app-accent">Dịch vụ</p>
  <h1 class="mt-1 text-xl font-extrabold text-app-ink">Dịch vụ của chúng tôi</h1>
  <p class="mt-1 text-xs font-semibold text-app-muted">10 dịch vụ đáp ứng mọi nhu cầu di chuyển của bạn</p>

  <div class="mt-4 divide-y divide-app-line">
    @foreach($services as $service)
      <article class="py-5">
        <div class="flex items-start gap-3">
          <img src="{{ asset('assets/icon-dichvu/' . $service['icon']) }}" alt="{{ $service['alt'] }}" loading="lazy" class="h-14 w-14 shrink-0 object-contain">
          <div class="min-w-0 flex-1">
            <h2 class="text-sm font-extrabold text-app-ink">{{ $service['title'] }}</h2>
            <p class="mt-0.5 text-xs font-bold {{ $service['tone'] }}">{{ $service['tagline'] }}</p>
          </div>
        </div>

        <p class="mt-3 text-xs leading-5 text-app-muted">{{ $service['description'] }}</p>

        @if(!empty($service['features']))
          <ul class="mt-2 space-y-1">
            @foreach($service['features'] as $feature)
              <li class="flex items-start gap-2 text-xs font-semibold text-app-muted">
                <svg class="mt-0.5 h-4 w-4 shrink-0 text-app-accent" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                  <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5"/>
                </svg>
                {{ $feature }}
              </li>
            @endforeach
          </ul>
        @endif

        @if(!empty($service['chips']))
          <p class="mt-2 text-xs font-bold text-app-muted">{{ implode(' • ', $service['chips']) }}</p>
        @endif
      </article>
    @endforeach
  </div>
</section>

<section class="px-4 pb-16 pt-2">
  <a href="{{ $siteZaloUrl }}" target="_blank" rel="noopener" class="flex items-center justify-center gap-2 rounded-xl bg-[#0068ff] px-4 py-3.5 text-sm font-extrabold text-white transition-colors hover:bg-[#0056d6] active:scale-[0.98]">
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5">
      <path stroke-linecap="round" stroke-linejoin="round" d="M8.625 9.75a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H8.25m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H12m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0h-.375m-13.5 3.01c0 1.6 1.123 2.994 2.707 3.227 1.087.16 2.185.283 3.293.369V21l4.184-4.183a1.14 1.14 0 0 1 .778-.332 48.294 48.294 0 0 0 5.83-.498c1.585-.233 2.708-1.626 2.708-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0 0 12 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018Z" />
    </svg>
    Nhắn tin Zalo để đặt dịch vụ
  </a>
  <a href="tel:{{ $sitePhone }}" class="mt-2 flex items-center justify-center gap-2 rounded-xl border border-app-accent bg-white px-4 py-3.5 text-sm font-extrabold text-app-accent transition-colors hover:bg-app-accent hover:text-white active:scale-[0.98]">
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5">
      <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 0 0 2.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 0 1-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 0 0-1.091-.852H4.5A2.25 2.25 0 0 0 2.25 4.5v2.25Z" />
    </svg>
    Gọi ngay: {{ $sitePhoneDisplay }}
  </a>
</section>
</div>
@endsection
