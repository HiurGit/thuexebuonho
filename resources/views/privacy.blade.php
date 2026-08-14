@extends('layouts.app')

@section('title', 'Chính sách bảo mật - Thuê Xe Buôn Hồ')

@section('meta')
<meta name="description" content="Chính sách bảo mật thông tin khách hàng của Thuê Xe Tự Lái Buôn Hồ.">
<meta property="og:title" content="Chính sách bảo mật - Thuê Xe Buôn Hồ">
<meta property="og:description" content="Chính sách bảo mật thông tin khách hàng của Thuê Xe Tự Lái Buôn Hồ.">
<meta property="og:image" content="{{ asset('assets/image/bannerMXH.jpg') }}">
<meta property="og:image:width" content="1200">
<meta property="og:image:height" content="630">
<meta property="og:image:type" content="image/jpeg">
<meta property="og:image:alt" content="Thuê Xe Buôn Hồ - Chính sách bảo mật">
<meta property="og:url" content="{{ url()->current() }}">
<meta property="og:type" content="website">
<meta property="og:site_name" content="Thuê Xe Buôn Hồ">
<meta property="og:locale" content="vi_VN">
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="Chính sách bảo mật - Thuê Xe Buôn Hồ">
<meta name="twitter:description" content="Chính sách bảo mật thông tin khách hàng của Thuê Xe Tự Lái Buôn Hồ.">
<meta name="twitter:image" content="{{ asset('assets/image/bannerMXH.jpg') }}">
@endsection

@section('content-desktop')
<div class="border-b border-app-line bg-white shadow-sm">
  <div class="mx-auto flex max-w-4xl items-center gap-4 px-6 py-3">
    <a href="javascript:history.back()" class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-app-accentSoft text-app-accent transition-all hover:bg-app-accent hover:text-white">
      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5"/></svg>
    </a>
    <h1 class="flex-1 text-center text-xl font-extrabold text-app-ink">Chính sách bảo mật</h1>
    <div class="w-10 shrink-0"></div>
  </div>
</div>

<main class="mx-auto max-w-4xl px-6 py-8">
  <div class="space-y-1 rounded-2xl border border-app-line bg-white shadow-sm">
    <section class="px-6 py-5">
      <h2 class="section-title text-base font-extrabold">1. Mục đích thu thập thông tin</h2>
      <div class="mt-3 space-y-2 text-sm leading-6 text-app-muted">
        <p>Khi khách hàng sử dụng dịch vụ thuê xe tự lái của chúng tôi, chúng tôi có thể thu thập các thông tin sau:</p>
        <ul class="list-inside list-disc space-y-1.5 pl-2">
          <li>Họ và tên.</li>
          <li>Số điện thoại.</li>
          <li>Địa chỉ email (nếu có).</li>
          <li>Địa chỉ cư trú.</li>
          <li>Số CCCD/CMND hoặc Hộ chiếu.</li>
          <li>Giấy phép lái xe.</li>
          <li>Thông tin thanh toán (nếu có).</li>
          <li>Thông tin đặt xe và lịch sử thuê xe.</li>
        </ul>
        <p class="mt-2">Các thông tin này được sử dụng nhằm:</p>
        <ul class="list-inside list-disc space-y-1.5 pl-2">
          <li>Xác minh danh tính khách hàng.</li>
          <li>Thực hiện hợp đồng thuê xe.</li>
          <li>Liên hệ xác nhận đặt xe.</li>
          <li>Hỗ trợ chăm sóc khách hàng.</li>
          <li>Giải quyết khiếu nại và tranh chấp.</li>
          <li>Tuân thủ các quy định của pháp luật.</li>
        </ul>
      </div>
    </section>

    <section class="border-t border-app-line px-6 py-5">
      <h2 class="section-title text-base font-extrabold">2. Phạm vi sử dụng thông tin</h2>
      <div class="mt-3 space-y-2 text-sm leading-6 text-app-muted">
        <p>Thông tin cá nhân của khách hàng chỉ được sử dụng cho mục đích cung cấp dịch vụ thuê xe và không bán hoặc chia sẻ cho bên thứ ba, ngoại trừ:</p>
        <ul class="list-inside list-disc space-y-1.5 pl-2">
          <li>Có sự đồng ý của khách hàng.</li>
          <li>Theo yêu cầu của cơ quan nhà nước có thẩm quyền.</li>
          <li>Phục vụ việc xử lý vi phạm hoặc tranh chấp phát sinh.</li>
        </ul>
      </div>
    </section>

    <section class="border-t border-app-line px-6 py-5">
      <h2 class="section-title text-base font-extrabold">3. Thời gian lưu trữ</h2>
      <div class="mt-3 space-y-2 text-sm leading-6 text-app-muted">
        <p>Thông tin cá nhân được lưu trữ trong thời gian cần thiết để phục vụ việc cung cấp dịch vụ hoặc theo quy định của pháp luật. Khi không còn nhu cầu sử dụng, dữ liệu sẽ được xóa hoặc ẩn danh theo quy định.</p>
      </div>
    </section>

    <section class="border-t border-app-line px-6 py-5">
      <h2 class="section-title text-base font-extrabold">4. Bảo mật thông tin</h2>
      <div class="mt-3 space-y-2 text-sm leading-6 text-app-muted">
        <p>Chúng tôi áp dụng các biện pháp kỹ thuật và quản lý phù hợp nhằm bảo vệ thông tin cá nhân khỏi việc truy cập trái phép, mất mát, tiết lộ hoặc sử dụng sai mục đích.</p>
      </div>
    </section>

    <section class="border-t border-app-line px-6 py-5">
      <h2 class="section-title text-base font-extrabold">5. Quyền của khách hàng</h2>
      <div class="mt-3 space-y-2 text-sm leading-6 text-app-muted">
        <p>Khách hàng có quyền:</p>
        <ul class="list-inside list-disc space-y-1.5 pl-2">
          <li>Yêu cầu xem, chỉnh sửa hoặc cập nhật thông tin cá nhân.</li>
          <li>Yêu cầu xóa thông tin khi không còn sử dụng dịch vụ (trừ trường hợp pháp luật yêu cầu lưu trữ).</li>
          <li>Khiếu nại nếu phát hiện thông tin bị sử dụng sai mục đích.</li>
        </ul>
      </div>
    </section>

    <section class="border-t border-app-line px-6 py-5">
      <h2 class="section-title text-base font-extrabold">6. Cam kết</h2>
      <div class="mt-3 space-y-2 text-sm leading-6 text-app-muted">
        <p>Chúng tôi cam kết bảo mật thông tin cá nhân của khách hàng theo quy định của pháp luật Việt Nam và chỉ sử dụng thông tin đúng mục đích đã thông báo.</p>
      </div>
    </section>

    <section class="border-t border-app-line px-6 py-5">
      <h2 class="section-title text-base font-extrabold">7. Thông tin liên hệ</h2>
      <div class="mt-3 space-y-2 text-sm leading-6 text-app-muted">
        <p>Nếu có bất kỳ câu hỏi nào liên quan đến Chính sách bảo mật, vui lòng liên hệ:</p>
        <ul class="list-inside list-disc space-y-1.5 pl-2">
          <li><strong class="text-app-ink">Tên đơn vị:</strong> Thuê Xe Tự Lái Buôn Hồ</li>
          <li><strong class="text-app-ink">Địa chỉ:</strong> {{ \App\Models\Setting::get('site_address', '07 Chu Van An, Buon Ho, Dak Lak') }}</li>
          <li><strong class="text-app-ink">Điện thoại:</strong> 0964.918.047</li>
          <li><strong class="text-app-ink">Facebook:</strong> {{ \App\Models\Setting::get('site_facebook', 'https://www.facebook.com/9999NDT/') }}</li>
        </ul>
        <p class="mt-2">Chúng tôi sẽ tiếp nhận và phản hồi trong thời gian sớm nhất.</p>
      </div>
    </section>
  </div>

  <div class="mt-6 text-center">
    <a href="{{ route('index') }}" class="inline-flex items-center gap-2 rounded-xl bg-app-accent px-6 py-3 text-sm font-extrabold text-white shadow-sm transition-all hover:bg-app-green">
      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-4 w-4"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18"/></svg>
      Quay lại Trang chủ
    </a>
  </div>
</main>
@endsection

@section('content-mobile')
<div class="border-b border-app-line bg-white px-4 py-1 shadow-sm">
  <div class="flex items-center gap-3">
    <a href="javascript:history.back()" class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-app-accentSoft text-app-accent transition-all hover:bg-app-accent hover:text-white">
      <i class="ri-arrow-left-s-line text-lg"></i>
    </a>
    <h1 class="flex-1 text-center text-lg font-extrabold">Chính sách bảo mật</h1>
    <div class="w-9 shrink-0"></div>
  </div>
</div>

<section class="bg-white px-4 py-3">
  <h2 class="section-title text-base font-extrabold">1. Mục đích thu thập thông tin</h2>
  <div class="mt-3 space-y-2 text-sm leading-6 text-app-muted">
    <p>Khi khách hàng sử dụng dịch vụ thuê xe tự lái của chúng tôi, chúng tôi có thể thu thập các thông tin sau:</p>
    <ul class="list-inside list-disc space-y-1.5 pl-2">
      <li>Họ và tên.</li>
      <li>Số điện thoại.</li>
      <li>Địa chỉ email (nếu có).</li>
      <li>Địa chỉ cư trú.</li>
      <li>Số CCCD/CMND hoặc Hộ chiếu.</li>
      <li>Giấy phép lái xe.</li>
      <li>Thông tin thanh toán (nếu có).</li>
      <li>Thông tin đặt xe và lịch sử thuê xe.</li>
    </ul>
    <p class="mt-2">Các thông tin này được sử dụng nhằm:</p>
    <ul class="list-inside list-disc space-y-1.5 pl-2">
      <li>Xác minh danh tính khách hàng.</li>
      <li>Thực hiện hợp đồng thuê xe.</li>
      <li>Liên hệ xác nhận đặt xe.</li>
      <li>Hỗ trợ chăm sóc khách hàng.</li>
      <li>Giải quyết khiếu nại và tranh chấp.</li>
      <li>Tuân thủ các quy định của pháp luật.</li>
    </ul>
  </div>
</section>

<section class="border-t border-app-line bg-white px-4 py-3">
  <h2 class="section-title text-base font-extrabold">2. Phạm vi sử dụng thông tin</h2>
  <div class="mt-3 space-y-2 text-sm leading-6 text-app-muted">
    <p>Thông tin cá nhân của khách hàng chỉ được sử dụng cho mục đích cung cấp dịch vụ thuê xe và không bán hoặc chia sẻ cho bên thứ ba, ngoại trừ:</p>
    <ul class="list-inside list-disc space-y-1.5 pl-2">
      <li>Có sự đồng ý của khách hàng.</li>
      <li>Theo yêu cầu của cơ quan nhà nước có thẩm quyền.</li>
      <li>Phục vụ việc xử lý vi phạm hoặc tranh chấp phát sinh.</li>
    </ul>
  </div>
</section>

<section class="border-t border-app-line bg-white px-4 py-3">
  <h2 class="section-title text-base font-extrabold">3. Thời gian lưu trữ</h2>
  <div class="mt-3 space-y-2 text-sm leading-6 text-app-muted">
    <p>Thông tin cá nhân được lưu trữ trong thời gian cần thiết để phục vụ việc cung cấp dịch vụ hoặc theo quy định của pháp luật. Khi không còn nhu cầu sử dụng, dữ liệu sẽ được xóa hoặc ẩn danh theo quy định.</p>
  </div>
</section>

<section class="border-t border-app-line bg-white px-4 py-3">
  <h2 class="section-title text-base font-extrabold">4. Bảo mật thông tin</h2>
  <div class="mt-3 space-y-2 text-sm leading-6 text-app-muted">
    <p>Chúng tôi áp dụng các biện pháp kỹ thuật và quản lý phù hợp nhằm bảo vệ thông tin cá nhân khỏi việc truy cập trái phép, mất mát, tiết lộ hoặc sử dụng sai mục đích.</p>
  </div>
</section>

<section class="border-t border-app-line bg-white px-4 py-3">
  <h2 class="section-title text-base font-extrabold">5. Quyền của khách hàng</h2>
  <div class="mt-3 space-y-2 text-sm leading-6 text-app-muted">
    <p>Khách hàng có quyền:</p>
    <ul class="list-inside list-disc space-y-1.5 pl-2">
      <li>Yêu cầu xem, chỉnh sửa hoặc cập nhật thông tin cá nhân.</li>
      <li>Yêu cầu xóa thông tin khi không còn sử dụng dịch vụ (trừ trường hợp pháp luật yêu cầu lưu trữ).</li>
      <li>Khiếu nại nếu phát hiện thông tin bị sử dụng sai mục đích.</li>
    </ul>
  </div>
</section>

<section class="border-t border-app-line bg-white px-4 py-3">
  <h2 class="section-title text-base font-extrabold">6. Cam kết</h2>
  <div class="mt-3 space-y-2 text-sm leading-6 text-app-muted">
    <p>Chúng tôi cam kết bảo mật thông tin cá nhân của khách hàng theo quy định của pháp luật Việt Nam và chỉ sử dụng thông tin đúng mục đích đã thông báo.</p>
  </div>
</section>

<section class="border-t border-app-line bg-white px-4 py-3">
  <h2 class="section-title text-base font-extrabold">7. Thông tin liên hệ</h2>
  <div class="mt-3 space-y-2 text-sm leading-6 text-app-muted">
    <p>Nếu có bất kỳ câu hỏi nào liên quan đến Chính sách bảo mật, vui lòng liên hệ:</p>
    <ul class="list-inside list-disc space-y-1.5 pl-2">
      <li><strong class="text-app-ink">Tên đơn vị:</strong> Thuê Xe Tự Lái Buôn Hồ</li>
      <li><strong class="text-app-ink">Địa chỉ:</strong> {{ \App\Models\Setting::get('site_address', '07 Chu Van An, Buon Ho, Dak Lak') }}</li>
      <li><strong class="text-app-ink">Điện thoại:</strong> 0964.918.047</li>
      <li><strong class="text-app-ink">Facebook:</strong> {{ \App\Models\Setting::get('site_facebook', 'https://www.facebook.com/9999NDT/') }}</li>
    </ul>
    <p class="mt-2">Chúng tôi sẽ tiếp nhận và phản hồi trong thời gian sớm nhất.</p>
  </div>
</section>

<section class="bg-white px-4 py-3 pb-28 text-center">
  <a href="{{ route('index') }}" class="inline-flex items-center gap-2 rounded-[10px] bg-app-accent px-6 py-3 text-sm font-extrabold text-white shadow-sm transition-all hover:bg-green-600 active:scale-[0.98]">
    <i class="ri-arrow-left-line"></i>
    Quay lại Trang chủ
  </a>
</section>
@endsection
