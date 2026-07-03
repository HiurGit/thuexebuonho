@extends('layouts.app')

@section('title', 'Điều khoản & Điều kiện - Thuê Xe Buôn Hồ')

@section('meta')
<meta name="description" content="Điều khoản và điều kiện cho thuê xe tại Buôn Hồ, Đăk Lăk.">
<meta property="og:title" content="Điều khoản & Điều kiện - Thuê Xe Buôn Hồ">
<meta property="og:description" content="Điều khoản và điều kiện cho thuê xe tại Buôn Hồ, Đăk Lăk.">
<meta property="og:image" content="https://thuexebuonho.com/assets/image/bannerMXH.jpg">
<meta property="og:image:width" content="1200">
<meta property="og:image:height" content="630">
<meta property="og:image:type" content="image/jpeg">
<meta property="og:image:alt" content="Thuê Xe Buôn Hồ - Điều khoản & Điều kiện">
<meta property="og:url" content="{{ url()->current() }}">
<meta property="og:type" content="website">
<meta property="og:site_name" content="Thuê Xe Buôn Hồ">
<meta property="og:locale" content="vi_VN">
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="Điều khoản & Điều kiện - Thuê Xe Buôn Hồ">
<meta name="twitter:description" content="Điều khoản và điều kiện cho thuê xe tại Buôn Hồ, Đăk Lăk.">
<meta name="twitter:image" content="https://thuexebuonho.com/assets/image/bannerMXH.jpg">
@endsection

@section('content-desktop')
  <!-- ===== PAGE HEADER ===== -->
  <div class="border-b border-app-line bg-white shadow-sm">
    <div class="mx-auto flex max-w-4xl items-center gap-4 px-6 py-3">
      <a href="javascript:history.back()" class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-app-accentSoft text-app-accent transition-all hover:bg-app-accent hover:text-white">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5"/></svg>
      </a>
      <h1 class="flex-1 text-center text-xl font-extrabold text-app-ink">Điều khoản & Điều kiện</h1>
      <div class="w-10 shrink-0"></div>
    </div>
  </div>

  <!-- ===== MAIN CONTENT ===== -->
  <main class="mx-auto max-w-4xl px-6 py-8">
    <div class="space-y-1 rounded-2xl border border-app-line bg-white shadow-sm">
      <section class="px-6 py-5">
        <h2 class="section-title text-base font-extrabold">1. Phạm vi áp dụng</h2>
        <div class="mt-3 space-y-2 text-sm leading-6 text-app-muted">
          <p>Các điều khoản và điều kiện này áp dụng cho tất cả các giao dịch thuê xe giữa <strong class="text-app-ink">Thuê Xe Tự Lái Buôn Hồ</strong> (sau đây gọi là "Bên cho thuê") và khách hàng (sau đây gọi là "Bên thuê").</p>
          <p>Khi thực hiện giao dịch thuê xe, Bên thuê được xem là đã đọc, hiểu và đồng ý với tất cả các điều khoản được quy định dưới đây.</p>
        </div>
      </section>

      <section class="border-t border-app-line px-6 py-5">
        <h2 class="section-title text-base font-extrabold">2. Đối tượng thuê xe</h2>
        <div class="mt-3 space-y-2 text-sm leading-6 text-app-muted">
          <p>Bên thuê phải đáp ứng các điều kiện sau:</p>
          <ul class="list-inside list-disc space-y-1.5 pl-2">
            <li>Có năng lực hành vi dân sự đầy đủ theo quy định pháp luật Việt Nam.</li>
            <li>Có Giấy phép lái xe (GPLX) hợp lệ, còn hiệu lực, phù hợp với loại xe thuê.</li>
            <li>Có CCCD còn hiệu lực hoặc VNeID mức 2.</li>
            <li>GPLX còn điểm trên ứng dụng VNeTraffic theo quy định.</li>
            <li>Không trong tình trạng sử dụng chất kích thích, rượu bia.</li>
          </ul>
        </div>
      </section>

      <section class="border-t border-app-line px-6 py-5">
        <h2 class="section-title text-base font-extrabold">3. Quy định về đặt xe và thanh toán</h2>
        <div class="mt-3 space-y-2 text-sm leading-6 text-app-muted">
          <p><strong class="text-app-ink">Đặt cọc giữ xe:</strong> Bên thuê phải đặt cọc một khoản tiền (300.000đ - 1.000.000đ tùy loại xe và thời gian) để giữ slot xe. Khoản cọc này sẽ được trừ vào tổng tiền thuê khi nhận xe.</p>
          <p><strong class="text-app-ink">Thanh toán:</strong> Bên thuê thanh toán toàn bộ chi phí thuê xe trước hoặc tại thời điểm nhận xe. Hình thức thanh toán: tiền mặt, chuyển khoản hoặc thẻ ngân hàng.</p>
          <p><strong class="text-app-ink">Thời gian thuê:</strong> Được tính theo giờ hoặc ngày tùy theo gói dịch vụ. Quá giờ trả xe sẽ tính phí phụ trội theo quy định.</p>
          <p><strong class="text-app-ink">Thuê xe có thế chấp:</strong> Người thuê cần chuẩn bị Tiền 15tr hoặc Xe máy tương đương 15tr giấy tờ gốc chính chủ.</p>
        </div>
      </section>

      <section class="border-t border-app-line px-6 py-5">
        <h2 class="section-title text-base font-extrabold">4. Trách nhiệm của Bên thuê</h2>
        <div class="mt-3 space-y-2 text-sm leading-6 text-app-muted">
          <ul class="list-inside list-disc space-y-1.5 pl-2">
            <li>Sử dụng xe đúng mục đích</li>
            <li>Chỉ người đăng ký thuê mới được lái xe.</li>
            <li>không sử dụng xe vào hoạt động phi pháp, trái pháp luật.</li>
            <li>Không cho thuê lại xe dưới mọi hình thức.</li>
            <li>Không chở quá số người quy định của xe.</li>
            <li>Không lái xe khi đã sử dụng rượu bia hoặc chất kích thích.</li>
            <li>Tuân thủ Luật Giao thông đường bộ trong suốt thời gian thuê xe.</li>
            <li>Không cầm cố, thế chấp, cho mượn xe dưới mọi hình thức.</li>
            <li>Không hút thuốc, nhả kẹo cao su, phải giữ vệ sinh trong xe.</li>
            <li>Không chở hàng quốc cấm, dễ cháy nổ, hoa quả hoặc thực phẩm nặng mùi.</li>
            <li>Chịu trách nhiệm về mọi hành vi vi phạm luật giao thông, phạt nguội trong thời gian thuê xe.</li>
            <li>Bảo quản xe cẩn thận, trả xe đúng tình trạng như lúc nhận (trừ hao mòn tự nhiên).</li>
            <li>Thông báo ngay cho Bên cho thuê nếu xảy ra sự cố, tai nạn, hư hỏng trong quá trình sử dụng.</li>
          </ul>
        </div>
      </section>

      <section class="border-t border-app-line px-6 py-5">
        <h2 class="section-title text-base font-extrabold">5. Trách nhiệm của Bên cho thuê</h2>
        <div class="mt-3 space-y-2 text-sm leading-6 text-app-muted">
          <ul class="list-inside list-disc space-y-1.5 pl-2">
            <li>Giao xe đúng loại, đúng thời gian và địa điểm đã thỏa thuận.</li>
            <li>Xe đảm bảo chất lượng vận hành tốt, sạch sẽ, đầy đủ trang thiết bị theo tiêu chuẩn.</li>
            <li>Có bảo hiểm dân sự bắt buộc và bảo hiểm thân vỏ theo quy định.</li>
            <li>Hỗ trợ 24/7 trong suốt thời gian thuê xe.</li>
          </ul>
        </div>
      </section>

      <section class="border-t border-app-line px-6 py-5">
        <h2 class="section-title text-base font-extrabold">6. Quy định về nhiên liệu</h2>
        <div class="mt-3 space-y-2 text-sm leading-6 text-app-muted">
          <ul class="list-inside list-disc space-y-1.5 pl-2">
            <li>Khách hàng nhận xe với mức nhiên liệu đã được ghi nhận trong biên bản bàn giao.</li>
            <li>Khi trả xe, khách hàng có trách nhiệm hoàn trả đúng mức nhiên liệu như lúc nhận.</li>
            <li>Trường hợp thiếu nhiên liệu, khách hàng thanh toán phần nhiên liệu thiếu theo giá thực tế cộng phí dịch vụ.</li>
          </ul>
        </div>
      </section>

      <section class="border-t border-app-line px-6 py-5">
        <h2 class="section-title text-base font-extrabold">7. Vi phạm giao thông</h2>
        <div class="mt-3 space-y-2 text-sm leading-6 text-app-muted">
          <p>Mọi lỗi vi phạm phát sinh trong thời gian thuê bao gồm:</p>
          <ul class="list-inside list-disc space-y-1.5 pl-2">
            <li>Phạt nguội.</li>
            <li>Phạt trực tiếp.</li>
            <li>Phí giữ xe.</li>
            <li>Phí kéo xe.</li>
            <li>Các khoản xử phạt khác.</li>
          </ul>
          <p class="mt-2">Đều do <strong class="text-app-ink">khách hàng</strong> chịu trách nhiệm thanh toán.</p>
        </div>
      </section>

      <section class="border-t border-app-line px-6 py-5">
        <h2 class="section-title text-base font-extrabold">8. Trường hợp thu hồi xe</h2>
        <div class="mt-3 space-y-2 text-sm leading-6 text-app-muted">
          <p>Công ty được quyền chấm dứt hợp đồng và thu hồi xe ngay khi:</p>
          <ul class="list-inside list-disc space-y-1.5 pl-2">
            <li>Khách hàng cung cấp giấy tờ giả.</li>
            <li>Cho người khác mượn xe trái quy định.</li>
            <li>Sử dụng xe trái pháp luật.</li>
            <li>Không thanh toán đúng hạn.</li>
            <li>Không liên lạc được với khách hàng.</li>
            <li>Xe có dấu hiệu chiếm đoạt.</li>
          </ul>
        </div>
      </section>

      <section class="border-t border-app-line px-6 py-5">
        <h2 class="section-title text-base font-extrabold">9. Chính sách huỷ cọc</h2>
        <div class="mt-3 space-y-2 text-sm leading-6 text-app-muted">
          <div class="overflow-hidden rounded-xl border border-app-line shadow-sm">
            <table class="w-full text-sm">
              <thead>
                <tr class="bg-app-accent text-white">
                  <th class="px-4 py-3 text-left font-bold">Chính sách</th>
                  <th class="px-4 py-3 text-center font-bold">Ngày thường</th>
                  <th class="px-4 py-3 text-center font-bold">Ngày Lễ, Tết</th>
                </tr>
              </thead>
              <tbody class="divide-y divide-app-line">
                <tr class="bg-white">
                  <td class="px-4 py-3 font-semibold"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="-mt-0.5 mr-1 inline-block h-4 w-4 align-middle text-app-accent"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" /></svg> Hoàn 100% tiền giữ chỗ</td>
                  <td class="px-4 py-3 text-center text-app-muted">Trước chuyến đi &gt; 10 ngày</td>
                  <td class="px-4 py-3 text-center text-app-muted">Không áp dụng</td>
                </tr>
                <tr class="bg-stone-50">
                  <td class="px-4 py-3 font-semibold"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="-mt-0.5 mr-1 inline-block h-4 w-4 align-middle text-app-accent"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" /></svg> Hoàn 30% tiền giữ chỗ</td>
                  <td class="px-4 py-3 text-center text-app-muted">Trước chuyến đi &gt; 5 ngày</td>
                  <td class="px-4 py-3 text-center text-app-muted">Trước chuyến đi &gt; 30 ngày</td>
                </tr>
                <tr class="bg-white">
                  <td class="px-4 py-3 font-semibold"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="-mt-0.5 mr-1 inline-block h-4 w-4 align-middle text-red-500"><path stroke-linecap="round" stroke-linejoin="round" d="m9.75 9.75 4.5 4.5m0-4.5-4.5 4.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" /></svg> Không hoàn tiền giữ chỗ</td>
                  <td class="px-4 py-3 text-center text-app-muted">Trong vòng 5 ngày trước chuyến đi</td>
                  <td class="px-4 py-3 text-center text-app-muted">Trong vòng 30 ngày trước chuyến đi</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </section>

      <section class="border-t border-app-line px-6 py-5">
        <h2 class="section-title text-base font-extrabold">10. Phụ phí có thể phát sinh</h2>
        <div class="mt-3 space-y-2 text-sm leading-6 text-app-muted">
          <ul class="list-inside list-disc space-y-1.5 pl-2">
            <li><strong class="text-app-ink">Phí cầu đường:</strong> Bên thuê chịu toàn bộ phí cầu đường phát sinh trong thời gian thuê.</li>
            <li><strong class="text-app-ink">Phụ thu nhiên liệu:</strong> Áp dụng khi vạch xăng thấp hơn lúc nhận xe.</li>
            <li><strong class="text-app-ink">Phí trả trễ:</strong> 100.000đ/giờ nếu trả xe muộn hơn giờ thỏa thuận.</li>
            <li><strong class="text-app-ink">Phí vệ sinh:</strong> 250.000đ nếu xe có mùi hôi, thuốc lá hoặc bẩn khi trả xe.</li>
            <li><strong class="text-app-ink">Phụ phí ra tỉnh:</strong> +100.000đ/ngày khi đi liên tỉnh.</li>
          </ul>
        </div>
      </section>

      <section class="border-t border-app-line px-6 py-5">
        <h2 class="section-title text-base font-extrabold">11. Xử lý sự cố, tai nạn</h2>
        <div class="mt-3 space-y-2 text-sm leading-6 text-app-muted">
          <p>Trong trường hợp xảy ra tai nạn hoặc sự cố:</p>
          <ul class="list-inside list-disc space-y-1.5 pl-2">
            <li>Bên thuê phải báo ngay cho Bên cho thuê và cơ quan chức năng (nếu cần).</li>
            <li>Không tự ý xử lý, thỏa thuận với bên thứ ba khi chưa có sự đồng ý của Bên cho thuê.</li>
            <li>Chi phí sửa chữa do lỗi của Bên thuê sẽ do Bên thuê chịu trách nhiệm.</li>
            <li>Trường hợp do bảo hiểm chi trả, Bên thuê chịu phần khấu trừ theo quy định của bảo hiểm.</li>
          </ul>
        </div>
      </section>

      <section class="border-t border-app-line px-6 py-5">
        <h2 class="section-title text-base font-extrabold">12. Điều khoản chung</h2>
        <div class="mt-3 space-y-2 text-sm leading-6 text-app-muted">
          <p>Mọi tranh chấp phát sinh sẽ được giải quyết thương lượng trên tinh thần hợp tác. Nếu không thể thương lượng, vụ việc sẽ được đưa ra Tòa án nhân dân có thẩm quyền tại Đăk Lăk để giải quyết.</p>
          <p>Bên cho thuê có quyền thay đổi, cập nhật các điều khoản này bất cứ lúc nào mà không cần thông báo trước.</p>
          <p class="mt-4 font-semibold text-app-ink">Trân trọng cảm ơn Quý khách đã tin tưởng và sử dụng dịch vụ của <strong>Thuê Xe Tự Lái Buôn Hồ</strong>!</p>
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
  <!-- Nút back + tiêu đề -->
  <div class="border-b border-app-line bg-white px-4 py-1 shadow-sm">
    <div class="flex items-center gap-3">
      <a href="javascript:history.back()" class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-app-accentSoft text-app-accent transition-all hover:bg-app-accent hover:text-white">
        <i class="ri-arrow-left-s-line text-lg"></i>
      </a>
      <h1 class="flex-1 text-center text-lg font-extrabold">Điều khoản & Điều kiện</h1>
      <div class="w-9 shrink-0"></div>
    </div>
  </div>

  <section class="bg-white px-4 py-3">
    <h2 class="section-title text-base font-extrabold">1. Phạm vi áp dụng</h2>
    <div class="mt-3 space-y-2 text-sm leading-6 text-app-muted">
      <p>Các điều khoản và điều kiện này áp dụng cho tất cả các giao dịch thuê xe giữa <strong class="text-app-ink">Thuê Xe Tự Lái Buôn Hồ</strong> (sau đây gọi là "Bên cho thuê") và khách hàng (sau đây gọi là "Bên thuê").</p>
      <p>Khi thực hiện giao dịch thuê xe, Bên thuê được xem là đã đọc, hiểu và đồng ý với tất cả các điều khoản được quy định dưới đây.</p>
    </div>
  </section>

  <section class="border-t border-app-line bg-white px-4 py-3">
    <h2 class="section-title text-base font-extrabold">2. Đối tượng thuê xe</h2>
    <div class="mt-3 space-y-2 text-sm leading-6 text-app-muted">
      <p>Bên thuê phải đáp ứng các điều kiện sau:</p>
      <ul class="list-inside list-disc space-y-1.5 pl-2">
        <li>Có năng lực hành vi dân sự đầy đủ theo quy định pháp luật Việt Nam.</li>
        <li>Có Giấy phép lái xe (GPLX) hợp lệ, còn hiệu lực, phù hợp với loại xe thuê.</li>
        <li>Có CCCD còn hiệu lực hoặc VNeID mức 2.</li>
        <li>GPLX còn điểm trên ứng dụng VNeTraffic theo quy định.</li>
        <li>Không trong tình trạng sử dụng chất kích thích, rượu bia.</li>
      </ul>
    </div>
  </section>

  <section class="border-t border-app-line bg-white px-4 py-3">
    <h2 class="section-title text-base font-extrabold">3. Quy định về đặt xe và thanh toán</h2>
    <div class="mt-3 space-y-2 text-sm leading-6 text-app-muted">
      <p><strong class="text-app-ink">Đặt cọc giữ xe:</strong> Bên thuê phải đặt cọc một khoản tiền (300.000đ - 1.000.000đ tùy loại xe và thời gian) để giữ slot xe. Khoản cọc này sẽ được trừ vào tổng tiền thuê khi nhận xe.</p>
      <p><strong class="text-app-ink">Thanh toán:</strong> Bên thuê thanh toán toàn bộ chi phí thuê xe trước hoặc tại thời điểm nhận xe. Hình thức thanh toán: tiền mặt, chuyển khoản hoặc thẻ ngân hàng.</p>
      <p><strong class="text-app-ink">Thời gian thuê:</strong> Được tính theo giờ hoặc ngày tùy theo gói dịch vụ. Quá giờ trả xe sẽ tính phí phụ trội theo quy định.</p>
      <p><strong class="text-app-ink">Thuê xe có thế chấp:</strong> Người thuê cần chuẩn bị Tiền 15tr hoặc Xe máy tương đương 15tr giấy tờ gốc chính chủ.</p>
    </div>
  </section>

  <section class="border-t border-app-line bg-white px-4 py-3">
    <h2 class="section-title text-base font-extrabold">4. Trách nhiệm của Bên thuê</h2>
    <div class="mt-3 space-y-2 text-sm leading-6 text-app-muted">
      <ul class="list-inside list-disc space-y-1.5 pl-2">
        <li>Sử dụng xe đúng mục đích</li>
        <li>Chỉ người đăng ký thuê mới được lái xe.</li>
        <li>không sử dụng xe vào hoạt động phi pháp, trái pháp luật.</li>
        <li>Không cho thuê lại xe dưới mọi hình thức.</li>
        <li>Không chở quá số người quy định của xe.</li>
        <li>Không lái xe khi đã sử dụng rượu bia hoặc chất kích thích.</li>
        <li>Tuân thủ Luật Giao thông đường bộ trong suốt thời gian thuê xe.</li>
        <li>Không cầm cố, thế chấp, cho mượn xe dưới mọi hình thức.</li>
        <li>Không hút thuốc, nhả kẹo cao su, phải giữ vệ sinh trong xe.</li>
        <li>Không chở hàng quốc cấm, dễ cháy nổ, hoa quả hoặc thực phẩm nặng mùi.</li>
        <li>Chịu trách nhiệm về mọi hành vi vi phạm luật giao thông, phạt nguội trong thời gian thuê xe.</li>
        <li>Bảo quản xe cẩn thận, trả xe đúng tình trạng như lúc nhận (trừ hao mòn tự nhiên).</li>
        <li>Thông báo ngay cho Bên cho thuê nếu xảy ra sự cố, tai nạn, hư hỏng trong quá trình sử dụng.</li>
      </ul>
    </div>
  </section>

  <section class="border-t border-app-line bg-white px-4 py-3">
    <h2 class="section-title text-base font-extrabold">5. Trách nhiệm của Bên cho thuê</h2>
    <div class="mt-3 space-y-2 text-sm leading-6 text-app-muted">
      <ul class="list-inside list-disc space-y-1.5 pl-2">
        <li>Giao xe đúng loại, đúng thời gian và địa điểm đã thỏa thuận.</li>
        <li>Xe đảm bảo chất lượng vận hành tốt, sạch sẽ, đầy đủ trang thiết bị theo tiêu chuẩn.</li>
        <li>Có bảo hiểm dân sự bắt buộc và bảo hiểm thân vỏ theo quy định.</li>
        <li>Hỗ trợ 24/7 trong suốt thời gian thuê xe.</li>
      </ul>
    </div>
  </section>

  <section class="border-t border-app-line bg-white px-4 py-3">
    <h2 class="section-title text-base font-extrabold">6. Quy định về nhiên liệu</h2>
    <div class="mt-3 space-y-2 text-sm leading-6 text-app-muted">
      <ul class="list-inside list-disc space-y-1.5 pl-2">
        <li>Khách hàng nhận xe với mức nhiên liệu đã được ghi nhận trong biên bản bàn giao.</li>
        <li>Khi trả xe, khách hàng có trách nhiệm hoàn trả đúng mức nhiên liệu như lúc nhận.</li>
        <li>Trường hợp thiếu nhiên liệu, khách hàng thanh toán phần nhiên liệu thiếu theo giá thực tế cộng phí dịch vụ.</li>
      </ul>
    </div>
  </section>

  <section class="border-t border-app-line bg-white px-4 py-3">
    <h2 class="section-title text-base font-extrabold">7. Vi phạm giao thông</h2>
    <div class="mt-3 space-y-2 text-sm leading-6 text-app-muted">
      <p>Mọi lỗi vi phạm phát sinh trong thời gian thuê bao gồm:</p>
      <ul class="list-inside list-disc space-y-1.5 pl-2">
        <li>Phạt nguội.</li>
        <li>Phạt trực tiếp.</li>
        <li>Phí giữ xe.</li>
        <li>Phí kéo xe.</li>
        <li>Các khoản xử phạt khác.</li>
      </ul>
      <p class="mt-2">Đều do <strong class="text-app-ink">khách hàng</strong> chịu trách nhiệm thanh toán.</p>
    </div>
  </section>

  <section class="border-t border-app-line bg-white px-4 py-3">
    <h2 class="section-title text-base font-extrabold">8. Trường hợp thu hồi xe</h2>
    <div class="mt-3 space-y-2 text-sm leading-6 text-app-muted">
      <p>Công ty được quyền chấm dứt hợp đồng và thu hồi xe ngay khi:</p>
      <ul class="list-inside list-disc space-y-1.5 pl-2">
        <li>Khách hàng cung cấp giấy tờ giả.</li>
        <li>Cho người khác mượn xe trái quy định.</li>
        <li>Sử dụng xe trái pháp luật.</li>
        <li>Không thanh toán đúng hạn.</li>
        <li>Không liên lạc được với khách hàng.</li>
        <li>Xe có dấu hiệu chiếm đoạt.</li>
      </ul>
    </div>
  </section>

  <section class="border-t border-app-line bg-white px-4 py-3">
    <h2 class="section-title text-base font-extrabold">9. Chính sách huỷ cọc</h2>
    <div class="mt-3 space-y-2 text-sm leading-6 text-app-muted">
      <div class="overflow-hidden rounded-[12px] border border-app-line shadow-sm">
        <table class="w-full text-xs">
          <thead>
            <tr class="bg-app-accent text-white">
              <th class="px-3 py-2.5 text-left font-bold">Chính sách</th>
              <th class="px-3 py-2.5 text-center font-bold">Ngày thường</th>
              <th class="px-3 py-2.5 text-center font-bold">Ngày Lễ, Tết</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-app-line">
            <tr class="bg-white">
              <td class="px-3 py-2.5 font-semibold text-app-text"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="-mt-0.5 mr-0.5 inline-block h-3.5 w-3.5 align-middle text-app-accent"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" /></svg> Hoàn 100% tiền giữ chỗ</td>
              <td class="px-3 py-2.5 text-center text-app-muted">Trước chuyến đi &gt; 10 ngày</td>
              <td class="px-3 py-2.5 text-center text-app-muted">Không áp dụng</td>
            </tr>
            <tr class="bg-stone-50">
              <td class="px-3 py-2.5 font-semibold text-app-text"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="-mt-0.5 mr-0.5 inline-block h-3.5 w-3.5 align-middle text-app-accent"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" /></svg> Hoàn 30% tiền giữ chỗ</td>
              <td class="px-3 py-2.5 text-center text-app-muted">Trước chuyến đi &gt; 5 ngày</td>
              <td class="px-3 py-2.5 text-center text-app-muted">Trước chuyến đi &gt; 30 ngày</td>
            </tr>
            <tr class="bg-white">
              <td class="px-3 py-2.5 font-semibold text-app-text"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="-mt-0.5 mr-0.5 inline-block h-3.5 w-3.5 align-middle text-red-500"><path stroke-linecap="round" stroke-linejoin="round" d="m9.75 9.75 4.5 4.5m0-4.5-4.5 4.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" /></svg> Không hoàn tiền giữ chỗ</td>
              <td class="px-3 py-2.5 text-center text-app-muted">Trong vòng 5 ngày trước chuyến đi</td>
              <td class="px-3 py-2.5 text-center text-app-muted">Trong vòng 30 ngày trước chuyến đi</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </section>

  <section class="border-t border-app-line bg-white px-4 py-3">
    <h2 class="section-title text-base font-extrabold">10. Phụ phí có thể phát sinh</h2>
    <div class="mt-3 space-y-2 text-sm leading-6 text-app-muted">
      <ul class="list-inside list-disc space-y-1.5 pl-2">
        <li><strong class="text-app-ink">Phí cầu đường:</strong> Bên thuê chịu toàn bộ phí cầu đường phát sinh trong thời gian thuê.</li>
        <li><strong class="text-app-ink">Phụ thu nhiên liệu:</strong> Áp dụng khi vạch xăng thấp hơn lúc nhận xe.</li>
        <li><strong class="text-app-ink">Phí trả trễ:</strong> 100.000đ/giờ nếu trả xe muộn hơn giờ thỏa thuận.</li>
        <li><strong class="text-app-ink">Phí vệ sinh:</strong> 250.000đ nếu xe có mùi hôi, thuốc lá hoặc bẩn khi trả xe.</li>
        <li><strong class="text-app-ink">Phụ phí ra tỉnh:</strong> +100.000đ/ngày khi đi liên tỉnh.</li>
      </ul>
    </div>
  </section>

  <section class="border-t border-app-line bg-white px-4 py-3">
    <h2 class="section-title text-base font-extrabold">11. Xử lý sự cố, tai nạn</h2>
    <div class="mt-3 space-y-2 text-sm leading-6 text-app-muted">
      <p>Trong trường hợp xảy ra tai nạn hoặc sự cố:</p>
      <ul class="list-inside list-disc space-y-1.5 pl-2">
        <li>Bên thuê phải báo ngay cho Bên cho thuê và cơ quan chức năng (nếu cần).</li>
        <li>Không tự ý xử lý, thỏa thuận với bên thứ ba khi chưa có sự đồng ý của Bên cho thuê.</li>
        <li>Chi phí sửa chữa do lỗi của Bên thuê sẽ do Bên thuê chịu trách nhiệm.</li>
        <li>Trường hợp do bảo hiểm chi trả, Bên thuê chịu phần khấu trừ theo quy định của bảo hiểm.</li>
      </ul>
    </div>
  </section>

  <section class="border-t border-app-line bg-white px-4 py-3">
    <h2 class="section-title text-base font-extrabold">12. Điều khoản chung</h2>
    <div class="mt-3 space-y-2 text-sm leading-6 text-app-muted">
      <p>Mọi tranh chấp phát sinh sẽ được giải quyết thương lượng trên tinh thần hợp tác. Nếu không thể thương lượng, vụ việc sẽ được đưa ra Tòa án nhân dân có thẩm quyền tại Đăk Lăk để giải quyết.</p>
      <p>Bên cho thuê có quyền thay đổi, cập nhật các điều khoản này bất cứ lúc nào mà không cần thông báo trước.</p>
      <p class="mt-4 font-semibold text-app-ink">Trân trọng cảm ơn Quý khách đã tin tưởng và sử dụng dịch vụ của <strong>Thuê Xe Tự Lái Buôn Hồ</strong>!</p>
    </div>
  </section>

  <section class="bg-white px-4 py-3 pb-28 text-center">
    <a href="{{ route('index') }}" class="inline-flex items-center gap-2 rounded-[10px] bg-app-accent px-6 py-3 text-sm font-extrabold text-white shadow-sm transition-all hover:bg-green-600 active:scale-[0.98]">
      <i class="ri-arrow-left-line"></i>
      Quay lại Trang chủ
    </a>
  </section>
@endsection
