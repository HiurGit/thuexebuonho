@extends('layouts.app')

@section('title', 'Dịch vụ - Thuê Xe Buôn Hồ')

@section('meta')
<meta name="description" content="Tất cả dịch vụ cho thuê xe tại Buôn Hồ, Đăk Lăk. Thuê xe tự lái, đưa đón sân bay, du lịch...">
<meta property="og:title" content="Dịch vụ - Thuê Xe Buôn Hồ">
<meta property="og:description" content="Tất cả dịch vụ cho thuê xe tại Buôn Hồ, Đăk Lăk.">
<meta property="og:url" content="{{ url()->current() }}">
<meta name="twitter:title" content="Dịch vụ - Thuê Xe Buôn Hồ">
<meta name="twitter:description" content="Tất cả dịch vụ cho thuê xe tại Buôn Hồ, Đăk Lăk.">
@endsection

@section('content-desktop')
<section class="bg-white">
  <div class="mx-auto max-w-7xl px-6 py-8">
    <div class="overflow-hidden rounded-2xl bg-[#f5f5f4] shadow-sm">
      <img src="{{ asset('assets/image/banner-thuexe.png') }}" alt="Dịch vụ thuê xe" class="h-auto w-full object-cover">
    </div>
    <p class="mt-3 text-center text-sm font-bold text-app-muted">Tất cả dịch vụ đều có tài xế hoặc tự lái theo yêu cầu</p>
  </div>
</section>

<section class="border-b border-app-line bg-white py-10">
  <div class="mx-auto max-w-7xl px-6">
    <div class="mb-8 text-center">
      <h2 class="text-2xl font-extrabold text-app-ink">Dịch vụ của chúng tôi</h2>
      <p class="mt-2 text-sm font-semibold text-app-muted">10 dịch vụ đáp ứng mọi nhu cầu di chuyển của bạn</p>
    </div>
    <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">

      <div class="rounded-2xl border border-app-line bg-white p-5 shadow-sm transition-all hover:-translate-y-1 hover:shadow-card">
        <div class="flex items-center gap-4">
          <div class="flex h-20 w-20 shrink-0 items-center justify-center">
            <img src="{{ asset('assets/icon-dichvu/dv-tulai.png') }}" alt="Thuê xe tự lái" class="h-full w-full object-contain">
          </div>
          <div>
            <h3 class="text-base font-extrabold">Thuê xe tự lái</h3>
            <p class="mt-0.5 text-xs font-bold text-app-accent">Xe đời mới, sạch sẽ, an toàn</p>
          </div>
        </div>
        <div class="mt-3 border-t border-dashed border-app-line pt-3">
          <p class="text-xs leading-5 text-app-muted">
            Nhận xe nhanh trong ngày, tự do chủ động lịch trình. Phù hợp cho mọi hành trình:
            đi chơi, du lịch, về quê, công tác. Xe đầy đủ bảo hiểm, camera hành trình,
            Vietmap Live Pro dẫn đường.
          </p>
          <ul class="mt-2 space-y-1">
            <li class="flex items-start gap-2 text-xs font-semibold text-app-muted">
              <svg class="mt-0.5 h-4 w-4 shrink-0 text-app-accent" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5"/></svg>
              Nhận xe nhanh chỉ với CCCD + GPLX
            </li>
            <li class="flex items-start gap-2 text-xs font-semibold text-app-muted">
              <svg class="mt-0.5 h-4 w-4 shrink-0 text-app-accent" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5"/></svg>
              Giao xe tận nơi trong khu vực nội thị Buôn Hồ
            </li>
            <li class="flex items-start gap-2 text-xs font-semibold text-app-muted">
              <svg class="mt-0.5 h-4 w-4 shrink-0 text-app-accent" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5"/></svg>
              Hỗ trợ đưa đón sân bay, đi tỉnh
            </li>
          </ul>
        </div>
      </div>

      <div class="rounded-2xl border border-app-line bg-white p-5 shadow-sm transition-all hover:-translate-y-1 hover:shadow-card">
        <div class="flex items-center gap-4">
          <div class="flex h-20 w-20 shrink-0 items-center justify-center">
            <img src="{{ asset('assets/icon-dichvu/dv-sanbay.png') }}" alt="Đưa đón sân bay" class="h-full w-full object-contain">
          </div>
          <div>
            <h3 class="text-base font-extrabold">Đưa đón sân bay</h3>
            <p class="mt-0.5 text-xs font-bold text-blue-500">Đón tiễn đúng giờ, an tâm</p>
          </div>
        </div>
        <div class="mt-3 border-t border-dashed border-app-line pt-3">
          <p class="text-xs leading-5 text-app-muted">
            Phục vụ đưa đón sân bay Buôn Ma Thuột và Cam Ranh. Đúng giờ,
            lịch sự, hỗ trợ xách đồ. Xe gia đình 5 chỗ 7 chỗ thoải mái cho đoàn.
          </p>
          <div class="mt-2 flex flex-wrap gap-1.5">
            <span class="rounded-full bg-stone-100 px-2.5 py-1 text-[11px] font-bold text-app-muted">Sân bay Buôn Ma Thuột</span>
            <span class="rounded-full bg-stone-100 px-2.5 py-1 text-[11px] font-bold text-app-muted">Sân bay Cam Ranh</span>
          </div>
        </div>
      </div>

      <div class="rounded-2xl border border-app-line bg-white p-5 shadow-sm transition-all hover:-translate-y-1 hover:shadow-card">
        <div class="flex items-center gap-4">
          <div class="flex h-20 w-20 shrink-0 items-center justify-center">
            <img src="{{ asset('assets/icon-dichvu/dv-nhau.png') }}" alt="Đưa đón đi nhậu" class="h-full w-full object-contain">
          </div>
          <div>
            <h3 class="text-base font-extrabold">Đưa đón đi nhậu</h3>
            <p class="mt-0.5 text-xs font-bold text-orange-500">Tận hưởng cuộc vui trọn vẹn</p>
          </div>
        </div>
        <div class="mt-3 border-t border-dashed border-app-line pt-3">
          <p class="text-xs leading-5 text-app-muted">
            Đã uống rượu bia thì không lái xe. Hãy để chúng tôi đưa đón bạn và bạn bè
            tận nơi. Xe 5 chỗ 7 chỗ, tài xế chuyên nghiệp, phục vụ đến khi khách hài lòng.
          </p>
        </div>
      </div>

      <div class="rounded-2xl border border-app-line bg-white p-5 shadow-sm transition-all hover:-translate-y-1 hover:shadow-card">
        <div class="flex items-center gap-4">
          <div class="flex h-20 w-20 shrink-0 items-center justify-center">
            <img src="{{ asset('assets/icon-dichvu/dv-dulich.png') }}" alt="Đưa đón du lịch" class="h-full w-full object-contain">
          </div>
          <div>
            <h3 class="text-base font-extrabold">Đưa đón du lịch</h3>
            <p class="mt-0.5 text-xs font-bold text-emerald-500">Khám phá Tây Nguyên & các tỉnh</p>
          </div>
        </div>
        <div class="mt-3 border-t border-dashed border-app-line pt-3">
          <p class="text-xs leading-5 text-app-muted">
            Du lịch Buôn Đôn, thác Dray Nur, hồ Lắk, TP. Buôn Ma Thuột hoặc liên tỉnh
            Đà Lạt, Nha Trang, Gia Lai, Đà Nẵng. Xe đời mới, tài xế thân thiện rành đường.
          </p>
        </div>
      </div>

      <div class="rounded-2xl border border-app-line bg-white p-5 shadow-sm transition-all hover:-translate-y-1 hover:shadow-card">
        <div class="flex items-center gap-4">
          <div class="flex h-20 w-20 shrink-0 items-center justify-center">
            <img src="{{ asset('assets/icon-dichvu/dv-ngaydem.png') }}" alt="Đưa đón ngày đêm" class="h-full w-full object-contain">
          </div>
          <div>
            <h3 class="text-base font-extrabold">Đưa đón ngày đêm</h3>
            <p class="mt-0.5 text-xs font-bold text-indigo-500">Phục vụ mọi khung giờ</p>
          </div>
        </div>
        <div class="mt-3 border-t border-dashed border-app-line pt-3">
          <p class="text-xs leading-5 text-app-muted">
            Cần đi sớm lúc 3h sáng ra bến xe, đón khách tối khuya, hay về quê đêm khuya?
            Chúng tôi sẵn sàng 24/7, kể cả lễ, Tết với mức phí phụ trội hợp lý.
          </p>
        </div>
      </div>

      <div class="rounded-2xl border border-app-line bg-white p-5 shadow-sm transition-all hover:-translate-y-1 hover:shadow-card">
        <div class="flex items-center gap-4">
          <div class="flex h-20 w-20 shrink-0 items-center justify-center">
            <img src="{{ asset('assets/icon-dichvu/dv-benhvien.png') }}" alt="Đưa đón bệnh viện" class="h-full w-full object-contain">
          </div>
          <div>
            <h3 class="text-base font-extrabold">Đưa đón bệnh viện</h3>
            <p class="mt-0.5 text-xs font-bold text-red-500">Ưu tiên an tâm, nhẹ nhàng</p>
          </div>
        </div>
        <div class="mt-3 border-t border-dashed border-app-line pt-3">
          <p class="text-xs leading-5 text-app-muted">
            Đưa đón bệnh nhân đi tái khám, cấp cứu, chở người già đi viện.
            Tài xế hỗ trợ đỡ đồ, dắt xe lăn, phong thái nhã nhặn và kín đáo.
          </p>
        </div>
      </div>

      <div class="rounded-2xl border border-app-line bg-white p-5 shadow-sm transition-all hover:-translate-y-1 hover:shadow-card">
        <div class="flex items-center gap-4">
          <div class="flex h-20 w-20 shrink-0 items-center justify-center">
            <img src="{{ asset('assets/icon-dichvu/dv-congtac.png') }}" alt="Đưa đón công tác" class="h-full w-full object-contain">
          </div>
          <div>
            <h3 class="text-base font-extrabold">Đưa đón công tác</h3>
            <p class="mt-0.5 text-xs font-bold text-slate-500">Chỉnh chu, đúng hẹn</p>
          </div>
        </div>
        <div class="mt-3 border-t border-dashed border-app-line pt-3">
          <p class="text-xs leading-5 text-app-muted">
            Phục vụ doanh nghiệp, cán bộ đi công tác liên tỉnh. Xe sạch sẽ, máy lạnh,
            tài xế lịch sự, đúng giờ. Có thể đưa đón dài ngày theo đoàn.
          </p>
        </div>
      </div>

      <div class="rounded-2xl border border-app-line bg-white p-5 shadow-sm transition-all hover:-translate-y-1 hover:shadow-card">
        <div class="flex items-center gap-4">
          <div class="flex h-20 w-20 shrink-0 items-center justify-center">
            <img src="{{ asset('assets/icon-dichvu/dv-dihoc.png') }}" alt="Đưa đón đi học" class="h-full w-full object-contain">
          </div>
          <div>
            <h3 class="text-base font-extrabold">Đưa đón đi học</h3>
            <p class="mt-0.5 text-xs font-bold text-yellow-600">An toàn cho bé mỗi ngày</p>
          </div>
        </div>
        <div class="mt-3 border-t border-dashed border-app-line pt-3">
          <p class="text-xs leading-5 text-app-muted">
            Đưa đón học sinh đi học theo giờ cố định, linh hoạt sáng-chiều.
            Xe 5 chỗ 7 chỗ, tài xế có kinh nghiệm, đón tận nhà và giao tận trường.
            Phù hợp với phụ huynh bận rộn.
          </p>
        </div>
      </div>

      <div class="rounded-2xl border border-app-line bg-white p-5 shadow-sm transition-all hover:-translate-y-1 hover:shadow-card">
        <div class="flex items-center gap-4">
          <div class="flex h-20 w-20 shrink-0 items-center justify-center">
            <img src="{{ asset('assets/icon-dichvu/dv-dilam.png') }}" alt="Đưa đón đi làm" class="h-full w-full object-contain">
          </div>
          <div>
            <h3 class="text-base font-extrabold">Đưa đón đi làm</h3>
            <p class="mt-0.5 text-xs font-bold text-violet-500">Đi làm đúng giờ, thoải mái</p>
          </div>
        </div>
        <div class="mt-3 border-t border-dashed border-app-line pt-3">
          <p class="text-xs leading-5 text-app-muted">
            Dịch vụ đưa đón nhân viên văn phòng, công nhân theo ca, hoặc đón khách
            hàng mỗi sáng. Nhận đặt theo tuần / tháng với giá ưu đãi.
          </p>
        </div>
      </div>

      <div class="rounded-2xl border border-app-line bg-white p-5 shadow-sm transition-all hover:-translate-y-1 hover:shadow-card">
        <div class="flex items-center gap-4">
          <div class="flex h-20 w-20 shrink-0 items-center justify-center">
            <img src="{{ asset('assets/icon-dichvu/dv-yeucau.png') }}" alt="Xe theo yêu cầu" class="h-full w-full object-contain">
          </div>
          <div>
            <h3 class="text-base font-extrabold">Xe theo yêu cầu</h3>
            <p class="mt-0.5 text-xs font-bold text-pink-500">Thiết kế lịch trình riêng</p>
          </div>
        </div>
        <div class="mt-3 border-t border-dashed border-app-line pt-3">
          <p class="text-xs leading-5 text-app-muted">
            Bạn có lịch trình đặc biệt? Cần lộ trình riêng, giờ giấc tuỳ chỉnh?
            Hãy gọi cho chúng tôi, chúng tôi sẽ thiết kế chuyến đi phù hợp nhất
            cho bạn với chi phí hợp lý.
          </p>
        </div>
      </div>

    </div>
  </div>
</section>

<section class="bg-white py-12">
  <div class="mx-auto max-w-7xl px-6 text-center">
    <h2 class="text-2xl font-extrabold text-app-ink">Bạn cần đặt dịch vụ?</h2>
    <p class="mt-2 text-sm font-semibold text-app-muted">Liên hệ ngay để được tư vấn và báo giá nhanh nhất</p>
    <div class="mt-6 flex flex-wrap justify-center gap-4">
      <a href="https://zalo.me/0964918047" target="_blank" rel="noopener" class="inline-flex items-center gap-2 rounded-xl bg-[#0068ff] px-6 py-3.5 text-sm font-extrabold text-white shadow-sm transition-all hover:bg-[#0056d6]">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5"><path stroke-linecap="round" stroke-linejoin="round" d="M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6 1.123 2.994 2.707 3.227 1.129.166 2.27.293 3.423.379.35.026.67.21.865.501L12 21l2.755-4.133a1.14 1.14 0 0 1 .865-.501 48.172 48.172 0 0 0 3.423-.379c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0 0 12 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018Z" /></svg>
        Nhắn tin Zalo để đặt dịch vụ
      </a>
      <a href="tel:0964918047" class="inline-flex items-center gap-2 rounded-xl border-2 border-app-accent bg-app-accentSoft px-6 py-3.5 text-sm font-extrabold text-app-accent shadow-sm transition-all hover:bg-app-accent hover:text-white">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 0 0 2.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 0 1-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 0 0-1.091-.852H4.5A2.25 2.25 0 0 0 2.25 4.5v2.25Z" /></svg>
        Gọi ngay: 0964.918.047
      </a>
    </div>
  </div>
</section>
@endsection

@section('content-mobile')
<section class="px-4 pt-4">
  <div class="overflow-hidden rounded-[12px] border border-app-line bg-[#f5f5f4] shadow-sm">
    <img src="{{ asset('assets/image/banner-thuexe.png') }}" alt="Dịch vụ thuê xe" class="h-auto w-full object-cover">
  </div>
  <p class="mt-3 text-center text-xs font-bold text-app-muted">Tất cả dịch vụ đều có tài xế hoặc tự lái theo yêu cầu</p>
</section>

<section class="mt-4 space-y-3 px-4">

  <div class="rounded-[14px] border border-app-line bg-white p-4 shadow-sm">
    <div class="flex items-center gap-3">
      <div class="flex h-16 w-16 shrink-0 items-center justify-center">
        <img src="{{ asset('assets/icon-dichvu/dv-tulai.png') }}" alt="Thuê xe tự lái" class="h-17 w-17 object-contain">
      </div>
      <div class="min-w-0 flex-1">
        <h3 class="text-base font-extrabold">Thuê xe tự lái</h3>
        <p class="mt-0.5 text-xs font-bold text-app-accent">Xe đời mới, sạch sẽ, an toàn</p>
      </div>
    </div>
    <div class="mt-3 border-t border-dashed border-app-line pt-3">
      <p class="text-xs leading-5 text-app-muted">
        Nhận xe nhanh trong ngày, tự do chủ động lịch trình. Phù hợp cho mọi hành trình:
        đi chơi, du lịch, về quê, công tác. Xe đầy đủ bảo hiểm, camera hành trình,
        Vietmap Live Pro dẫn đường.
      </p>
      <ul class="mt-2 space-y-1">
        <li class="flex items-start gap-2 text-xs font-semibold text-app-muted">
          <svg class="mt-0.5 h-4 w-4 shrink-0 text-app-accent" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5"/></svg>
          Nhận xe nhanh chỉ với CCCD + GPLX
        </li>
        <li class="flex items-start gap-2 text-xs font-semibold text-app-muted">
          <svg class="mt-0.5 h-4 w-4 shrink-0 text-app-accent" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5"/></svg>
          Giao xe tận nơi trong khu vực nội thị Buôn Hồ
        </li>
        <li class="flex items-start gap-2 text-xs font-semibold text-app-muted">
          <svg class="mt-0.5 h-4 w-4 shrink-0 text-app-accent" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5"/></svg>
          Hỗ trợ đưa đón sân bay, đi tỉnh
        </li>
      </ul>
    </div>
  </div>

  <div class="rounded-[14px] border border-app-line bg-white p-4 shadow-sm">
    <div class="flex items-center gap-3">
      <div class="flex h-16 w-16 shrink-0 items-center justify-center">
        <img src="{{ asset('assets/icon-dichvu/dv-sanbay.png') }}" alt="Đưa đón sân bay" class="h-17 w-17 object-contain">
      </div>
      <div class="min-w-0 flex-1">
        <h3 class="text-base font-extrabold">Đưa đón sân bay</h3>
        <p class="mt-0.5 text-xs font-bold text-blue-500">Đón tiễn đúng giờ, an tâm</p>
      </div>
    </div>
    <div class="mt-3 border-t border-dashed border-app-line pt-3">
      <p class="text-xs leading-5 text-app-muted">
        Phục vụ đưa đón sân bay Buôn Ma Thuột và Cam Ranh. Đúng giờ,
        lịch sự, hỗ trợ xách đồ. Xe gia đình 5 chỗ 7 chỗ thoải mái cho đoàn.
      </p>
      <div class="mt-2 flex flex-wrap gap-1.5">
        <span class="rounded-full bg-stone-100 px-2.5 py-1 text-[11px] font-bold text-app-muted">Sân bay Buôn Ma Thuột</span>
        <span class="rounded-full bg-stone-100 px-2.5 py-1 text-[11px] font-bold text-app-muted">Sân bay Cam Ranh</span>
      </div>
    </div>
  </div>

  <div class="rounded-[14px] border border-app-line bg-white p-4 shadow-sm">
    <div class="flex items-center gap-3">
      <div class="flex h-16 w-16 shrink-0 items-center justify-center">
        <img src="{{ asset('assets/icon-dichvu/dv-nhau.png') }}" alt="Đưa đón đi nhậu" class="h-17 w-17 object-contain">
      </div>
      <div class="min-w-0 flex-1">
        <h3 class="text-base font-extrabold">Đưa đón đi nhậu</h3>
        <p class="mt-0.5 text-xs font-bold text-orange-500">Tận hưởng cuộc vui trọn vẹn</p>
      </div>
    </div>
    <div class="mt-3 border-t border-dashed border-app-line pt-3">
      <p class="text-xs leading-5 text-app-muted">
        Đã uống rượu bia thì không lái xe. Hãy để chúng tôi đưa đón bạn và bạn bè
        tận nơi. Xe 5 chỗ 7 chỗ, tài xế chuyên nghiệp, phục vụ đến khi khách hài lòng.
      </p>
    </div>
  </div>

  <div class="rounded-[14px] border border-app-line bg-white p-4 shadow-sm">
    <div class="flex items-center gap-3">
      <div class="flex h-16 w-16 shrink-0 items-center justify-center">
        <img src="{{ asset('assets/icon-dichvu/dv-dulich.png') }}" alt="Đưa đón du lịch" class="h-17 w-17 object-contain">
      </div>
      <div class="min-w-0 flex-1">
        <h3 class="text-base font-extrabold">Đưa đón du lịch</h3>
        <p class="mt-0.5 text-xs font-bold text-emerald-500">Khám phá Tây Nguyên & các tỉnh</p>
      </div>
    </div>
    <div class="mt-3 border-t border-dashed border-app-line pt-3">
      <p class="text-xs leading-5 text-app-muted">
        Du lịch Buôn Đôn, thác Dray Nur, hồ Lắk, TP. Buôn Ma Thuột hoặc liên tỉnh
        Đà Lạt, Nha Trang, Gia Lai, Đà Nẵng. Xe đời mới, tài xế thân thiện rành đường.
      </p>
    </div>
  </div>

  <div class="rounded-[14px] border border-app-line bg-white p-4 shadow-sm">
    <div class="flex items-center gap-3">
      <div class="flex h-16 w-16 shrink-0 items-center justify-center">
        <img src="{{ asset('assets/icon-dichvu/dv-ngaydem.png') }}" alt="Đưa đón ngày đêm" class="h-17 w-17 object-contain">
      </div>
      <div class="min-w-0 flex-1">
        <h3 class="text-base font-extrabold">Đưa đón ngày đêm</h3>
        <p class="mt-0.5 text-xs font-bold text-indigo-500">Phục vụ mọi khung giờ</p>
      </div>
    </div>
    <div class="mt-3 border-t border-dashed border-app-line pt-3">
      <p class="text-xs leading-5 text-app-muted">
        Cần đi sớm lúc 3h sáng ra bến xe, đón khách tối khuya, hay về quê đêm khuya?
        Chúng tôi sẵn sàng 24/7, kể cả lễ, Tết với mức phí phụ trội hợp lý.
      </p>
    </div>
  </div>

  <div class="rounded-[14px] border border-app-line bg-white p-4 shadow-sm">
    <div class="flex items-center gap-3">
      <div class="flex h-16 w-16 shrink-0 items-center justify-center">
        <img src="{{ asset('assets/icon-dichvu/dv-benhvien.png') }}" alt="Đưa đón bệnh viện" class="h-17 w-17 object-contain">
      </div>
      <div class="min-w-0 flex-1">
        <h3 class="text-base font-extrabold">Đưa đón bệnh viện</h3>
        <p class="mt-0.5 text-xs font-bold text-red-500">Ưu tiên an tâm, nhẹ nhàng</p>
      </div>
    </div>
    <div class="mt-3 border-t border-dashed border-app-line pt-3">
      <p class="text-xs leading-5 text-app-muted">
        Đưa đón bệnh nhân đi tái khám, cấp cứu, chở người già đi viện.
        Tài xế hỗ trợ đỡ đồ, dắt xe lăn, phong thái nhã nhặn và kín đáo.
      </p>
    </div>
  </div>

  <div class="rounded-[14px] border border-app-line bg-white p-4 shadow-sm">
    <div class="flex items-center gap-3">
      <div class="flex h-16 w-16 shrink-0 items-center justify-center">
        <img src="{{ asset('assets/icon-dichvu/dv-congtac.png') }}" alt="Đưa đón công tác" class="h-17 w-17 object-contain">
      </div>
      <div class="min-w-0 flex-1">
        <h3 class="text-base font-extrabold">Đưa đón công tác</h3>
        <p class="mt-0.5 text-xs font-bold text-slate-500">Chỉnh chu, đúng hẹn</p>
      </div>
    </div>
    <div class="mt-3 border-t border-dashed border-app-line pt-3">
      <p class="text-xs leading-5 text-app-muted">
        Phục vụ doanh nghiệp, cán bộ đi công tác liên tỉnh. Xe sạch sẽ, máy lạnh,
        tài xế lịch sự, đúng giờ. Có thể đưa đón dài ngày theo đoàn.
      </p>
    </div>
  </div>

  <div class="rounded-[14px] border border-app-line bg-white p-4 shadow-sm">
    <div class="flex items-center gap-3">
      <div class="flex h-16 w-16 shrink-0 items-center justify-center">
        <img src="{{ asset('assets/icon-dichvu/dv-dihoc.png') }}" alt="Đưa đón đi học" class="h-17 w-17 object-contain">
      </div>
      <div class="min-w-0 flex-1">
        <h3 class="text-base font-extrabold">Đưa đón đi học</h3>
        <p class="mt-0.5 text-xs font-bold text-yellow-600">An toàn cho bé mỗi ngày</p>
      </div>
    </div>
    <div class="mt-3 border-t border-dashed border-app-line pt-3">
      <p class="text-xs leading-5 text-app-muted">
        Đưa đón học sinh đi học theo giờ cố định, linh hoạt sáng-chiều.
        Xe 5 chỗ 7 chỗ, tài xế có kinh nghiệm, đón tận nhà và giao tận trường.
        Phù hợp với phụ huynh bận rộn.
      </p>
    </div>
  </div>

  <div class="rounded-[14px] border border-app-line bg-white p-4 shadow-sm">
    <div class="flex items-center gap-3">
      <div class="flex h-16 w-16 shrink-0 items-center justify-center">
        <img src="{{ asset('assets/icon-dichvu/dv-dilam.png') }}" alt="Đưa đón đi làm" class="h-17 w-17 object-contain">
      </div>
      <div class="min-w-0 flex-1">
        <h3 class="text-base font-extrabold">Đưa đón đi làm</h3>
        <p class="mt-0.5 text-xs font-bold text-violet-500">Đi làm đúng giờ, thoải mái</p>
      </div>
    </div>
    <div class="mt-3 border-t border-dashed border-app-line pt-3">
      <p class="text-xs leading-5 text-app-muted">
        Dịch vụ đưa đón nhân viên văn phòng, công nhân theo ca, hoặc đón khách
        hàng mỗi sáng. Nhận đặt theo tuần / tháng với giá ưu đãi.
      </p>
    </div>
  </div>

  <div class="rounded-[14px] border border-app-line bg-white p-4 shadow-sm">
    <div class="flex items-center gap-3">
      <div class="flex h-16 w-16 shrink-0 items-center justify-center">
        <img src="{{ asset('assets/icon-dichvu/dv-yeucau.png') }}" alt="Xe theo yêu cầu" class="h-17 w-17 object-contain">
      </div>
      <div class="min-w-0 flex-1">
        <h3 class="text-base font-extrabold">Xe theo yêu cầu</h3>
        <p class="mt-0.5 text-xs font-bold text-pink-500">Thiết kế lịch trình riêng</p>
      </div>
    </div>
    <div class="mt-3 border-t border-dashed border-app-line pt-3">
      <p class="text-xs leading-5 text-app-muted">
        Bạn có lịch trình đặc biệt? Cần lộ trình riêng, giờ giấc tuỳ chỉnh?
        Hãy gọi cho chúng tôi, chúng tôi sẽ thiết kế chuyến đi phù hợp nhất
        cho bạn với chi phí hợp lý.
      </p>
    </div>
  </div>

</section>

<section class="px-4 pb-16 pt-6">
  <a href="https://zalo.me/0964918047" target="_blank" rel="noopener" class="flex items-center justify-center gap-2 rounded-[12px] bg-[#0068ff] px-4 py-3.5 text-sm font-extrabold text-white shadow-sm transition-all hover:bg-[#0056d6] active:scale-[0.98]">
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5">
      <path stroke-linecap="round" stroke-linejoin="round" d="M8.625 9.75a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H8.25m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H12m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0h-.375m-13.5 3.01c0 1.6 1.123 2.994 2.707 3.227 1.087.16 2.185.283 3.293.369V21l4.184-4.183a1.14 1.14 0 0 1 .778-.332 48.294 48.294 0 0 0 5.83-.498c1.585-.233 2.708-1.626 2.708-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0 0 12 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018Z" />
    </svg>
    Nhắn tin Zalo để đặt dịch vụ
  </a>
  <a href="tel:0964918047" class="mt-2 flex items-center justify-center gap-2 rounded-[12px] border-2 border-app-accent bg-app-accentSoft px-4 py-3.5 text-sm font-extrabold text-app-accent transition-all hover:bg-app-accent hover:text-white active:scale-[0.98]">
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5">
      <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 0 0 2.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 0 1-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 0 0-1.091-.852H4.5A2.25 2.25 0 0 0 2.25 4.5v2.25Z" />
    </svg>
    Gọi ngay: 0964.918.047
  </a>
</section>
@endsection
