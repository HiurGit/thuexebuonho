<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="robots" content="noindex, nofollow">
<title>Hợp đồng {{ $contract->contract_code }}</title>
<style>
  * { box-sizing: border-box; }
  html, body { margin: 0; padding: 0; background: #eef1f5; }
  body { font-family: Cambria, Georgia, "Times New Roman", Times, serif; color: #111827; font-size: 15px; line-height: 1.55; }
  .toolbar { position: sticky; top: 0; z-index: 10; display: flex; flex-wrap: wrap; gap: 8px; align-items: center; padding: 10px 16px; background: #0b296c; color: #fff; }
  .toolbar .code { font-weight: 700; margin-right: auto; }
  .toolbar button, .toolbar a { display: inline-flex; align-items: center; gap: 6px; padding: 8px 14px; border-radius: 6px; border: 0; font: inherit; font-size: 13px; font-weight: 700; cursor: pointer; text-decoration: none; }
  .toolbar button { background: #195cc2; color: #fff; }
  .toolbar button:hover { background: #164fa6; }
  .toolbar a { background: #fff; color: #0b296c; }
  .doc { max-width: 820px; margin: 24px auto; background: #fff; padding: 48px 56px; box-shadow: 0 8px 30px rgba(15, 23, 42, 0.12); }
  .center { text-align: center; }
  .head-nation { font-weight: 700; font-size: 16px; }
  .head-motto { font-weight: 700; font-size: 15px; }
  .head-line { width: 200px; margin: 2px auto 0; border-top: 1.5px solid #111; }
  h1.title { text-align: center; font-size: 22px; font-weight: 700; text-transform: uppercase; margin: 22px 0 18px; }
  h2.section { font-size: 15px; font-weight: 700; text-transform: uppercase; margin: 20px 0 8px; }
  h2.party { font-size: 15px; font-weight: 700; margin: 16px 0 6px; }
  p { margin: 4px 0; text-align: justify; }
  .indent { padding-left: 22px; }
  table.info { width: 100%; border-collapse: collapse; margin: 6px 0 4px; }
  table.info td { border: 1px solid #000; padding: 5px 8px; vertical-align: top; }
  table.info td.lbl { width: 30%; font-weight: 700; background: #f3f4f6; }
  table.vehicle td.lbl { width: 18%; font-weight: 700; background: #f3f4f6; }
  table.vehicle td.val { width: 32%; }
  .bullet { padding-left: 6px; }
  .fill { font-weight: 700; }
  .sign { width: 100%; border-collapse: collapse; margin-top: 26px; }
  .sign td { width: 50%; text-align: center; vertical-align: top; padding: 6px; }
  .sign .role { font-weight: 700; text-transform: uppercase; }
  .sign .note { font-style: italic; font-size: 13px; }
  .sign .space { height: 90px; }
  .appendix { margin-top: 48px; padding-top: 24px; border-top: 2px dashed #9ca3af; }
  @media print {
    body { background: #fff; font-size: 13.5px; }
    .toolbar { display: none !important; }
    .doc { max-width: none; margin: 0; padding: 0; box-shadow: none; }
    .appendix { page-break-before: always; border-top: 0; }
  }
  @media (max-width: 640px) {
    .doc { margin: 0; padding: 20px 16px; }
  }
</style>
</head>
<body>

<div class="toolbar">
  <span class="code">Hợp đồng {{ $contract->contract_code }}</span>
  <a href="{{ $backUrl }}">Quay lại</a>
</div>

<div class="doc">

  <div class="center">
    <div class="head-nation">CỘNG HÒA XÃ HỘI CHỦ NGHĨA VIỆT NAM</div>
    <div class="head-motto">Độc lập - Tự do - Hạnh phúc</div>
    <div class="head-line"></div>
  </div>

  <h1 class="title">Hợp đồng cho thuê xe ô tô</h1>

  <p>Hôm nay, ngày <span class="fill">{{ $doc['contract_day'] }}</span> tháng <span class="fill">{{ $doc['contract_month'] }}</span> năm <span class="fill">{{ $doc['contract_year'] }}</span>, tại <span class="fill">{{ $doc['contract_place'] }}</span>, chúng tôi gồm:</p>

  <h2 class="party">BÊN CHO THUÊ XE (BÊN A)</h2>
  <table class="info">
    <tr><td class="lbl">Tên đơn vị/cá nhân</td><td>HỘ KINH DOANH THUÊ XE BUÔN HỒ</td></tr>
    <tr><td class="lbl">Mã số thuế tổ chức</td><td>8603250741-001</td></tr>
    <tr><td class="lbl">Người đại diện</td><td>NGUYỄN ĐÌNH THẢO</td></tr>
    <tr><td class="lbl">Địa chỉ</td><td>07 CHU VĂN AN, PHƯỜNG BUÔN HỒ, TỈNH ĐẮK LẮK</td></tr>
    <tr><td class="lbl">Điện thoại</td><td>0964.918.047</td></tr>
    <tr><td class="lbl">Tài Khoản/STK/Ngân hàng</td><td>HỘ KINH DOANH THUÊ XE BUÔN HỒ / 8869926323 / BIDV</td></tr>
  </table>

  <h2 class="party">BÊN THUÊ XE (BÊN B)</h2>
  <table class="info">
    <tr><td class="lbl">Họ và tên</td><td><span class="fill">{{ $doc['customer_name'] }}</span></td></tr>
    <tr><td class="lbl">CCCD/Hộ chiếu</td><td>Số: <span class="fill">{{ $doc['cccd'] }}</span> &nbsp; Cấp ngày: <span class="fill">{{ $doc['cccd_issue_date'] }}</span> &nbsp; Nơi cấp: <span class="fill">{{ $doc['cccd_issue_place'] }}</span></td></tr>
    <tr><td class="lbl">Ngày sinh</td><td><span class="fill">{{ $doc['dob'] }}</span></td></tr>
    <tr><td class="lbl">Nơi ở hiện tại</td><td><span class="fill">{{ $doc['customer_address'] }}</span></td></tr>
    <tr><td class="lbl">Điện thoại</td><td><span class="fill">{{ $doc['customer_phone'] }}</span></td></tr>
    <tr><td class="lbl">GPLX</td><td>Số: <span class="fill">{{ $doc['license_no'] }}</span> &nbsp; Hạng: <span class="fill">{{ $doc['license_class'] }}</span> &nbsp; Có giá trị đến: <span class="fill">{{ $doc['license_expiry'] }}</span></td></tr>
  </table>

  <h2 class="section">ĐIỀU 1. ĐỐI TƯỢNG, THỜI HẠN VÀ PHẠM VI THUÊ</h2>
  <p>1.1. Bên A cho Bên B thuê 01 xe ô tô tự lái với thông tin như sau:</p>
  <table class="info vehicle">
    <tr><td class="lbl">Nhãn hiệu</td><td class="val"><span class="fill">{{ $doc['car_brand'] }}</span></td><td class="lbl">Model/Phiên bản</td><td class="val"><span class="fill">{{ $doc['car_model'] }}</span></td></tr>
    <tr><td class="lbl">Biển số</td><td class="val"><span class="fill">{{ $doc['car_plate'] }}</span></td><td class="lbl">Màu sơn</td><td class="val"><span class="fill">{{ $doc['car_color'] }}</span></td></tr>
    <tr><td class="lbl">Năm sản xuất</td><td class="val"><span class="fill">{{ $doc['car_year'] }}</span></td><td class="lbl">Số Khung</td><td class="val"><span class="fill">{{ $doc['car_chassis'] }}</span></td></tr>
    <tr><td class="lbl">Chủ xe</td><td class="val"><span class="fill">{{ $doc['car_owner'] }}</span></td><td class="lbl">Số Máy</td><td class="val"><span class="fill">{{ $doc['car_engine'] }}</span></td></tr>
  </table>
  <p>1.2. Mục đích thuê: sử dụng xe tự lái cho nhu cầu cá nhân hợp pháp theo thỏa thuận. Bên B không được sử dụng xe cho vận tải hành khách/hàng hóa có thu tiền, cho thuê lại, cầm cố, thế chấp, đua xe hoặc hoạt động trái pháp luật nếu không có thỏa thuận bằng văn bản của Bên A và/hoặc pháp luật không cho phép.</p>
  <p>1.3. Thời gian thuê: từ <span class="fill">{{ $doc['pickup_hour'] }}</span> giờ <span class="fill">{{ $doc['pickup_minute'] }}</span> phút, ngày <span class="fill">{{ $doc['pickup_date'] }}</span> đến <span class="fill">{{ $doc['return_hour'] }}</span> giờ <span class="fill">{{ $doc['return_minute'] }}</span> phút, ngày <span class="fill">{{ $doc['return_date'] }}</span></p>
  <p>1.4. Địa điểm nhận xe: <span class="fill">{{ $doc['pickup_location'] }}</span></p>
  <p>1.5. Khu vực / lộ trình di chuyển: <span class="fill">{{ $doc['route'] }}</span></p>
  @if($doc['route_line'] !== '')
    <p>{{ $doc['route_line'] }}</p>
  @endif

  <h2 class="section">ĐIỀU 2. GIÁ THUÊ VÀ PHƯƠNG THỨC THANH TOÁN</h2>
  <p>2.1. Bên B sẽ thế chấp / tài sản đảm bảo cho Bên A gồm:</p>
  <p class="bullet">- Xe máy hiệu: <span class="fill">{{ $doc['deposit_moto_brand'] }}</span> &nbsp; Biển số: <span class="fill">{{ $doc['deposit_moto_plate'] }}</span> &nbsp; Giấy ĐKXE (bản chính): <span class="fill">{{ $doc['deposit_moto_registration'] }}</span></p>
  <p class="bullet">- Tiền cọc: <span class="fill">{{ $doc['deposit_amount'] }}</span> VNĐ, Bằng chữ: <span class="fill">{{ $doc['deposit_words'] }}</span> đồng.</p>
  <p class="bullet">- Khác: <span class="fill">{{ $doc['deposit_other'] }}</span></p>
  <p>Thế chấp và Cọc tiền sẽ được Bên A hoàn trả cho Bên B khi trả xe và sau khi Bên B thanh toán toàn bộ chi phí cho Bên A.</p>
  <p>2.2. Phương thức thanh toán:</p>
  <p class="indent">Đơn giá: <span class="fill">{{ $doc['daily_rate'] }}</span> VNĐ, Thuê <span class="fill">{{ $doc['rental_days'] }}</span> Ngày <span class="fill">{{ $doc['rental_unit'] }}</span> Buổi.</p>
  <p class="indent">Tổng tiền: <span class="fill">{{ $doc['total_fee'] }}</span> VNĐ</p>
  <p>Bên B thanh toán tiền thuê xe cho Bên A ngay khi nhận xe.</p>

  <h2 class="section">ĐIỀU 3. BÀN GIAO VÀ HOÀN TRẢ XE</h2>
  <p>3.1. Tình trạng lúc giao: Bên A bàn giao xe cho Bên B với đầy đủ trang thiết bị tiện nghi theo tiêu chuẩn nhà sản xuất, ngoài ra còn kèm theo:</p>
  <p class="bullet">- Giấy đăng ký xe ô tô, sổ đăng kiểm, bảo hiểm.</p>
  <p class="bullet">- Phụ tùng, bánh xe dự phòng, cam hành trình và thiết bị khác gắn trên xe.</p>
  <p>3.2. Bên A và B có trách nhiệm kiểm tra xe, chụp ảnh/video hiện trạng khi nhận xe.</p>
  <p>3.3. Bên B có trách nhiệm hoàn trả xe như tình trạng khi nhận xe, trừ hao mòn tự nhiên. Mọi hư hỏng, mất mát do lỗi của Bên B, Bên B phải sửa chữa hoặc bồi thường.</p>

  <h2 class="section">ĐIỀU 4. QUYỀN VÀ NGHĨA VỤ CỦA BÊN A</h2>
  <p>- Bảo đảm quyền cho thuê hợp pháp và chịu trách nhiệm về nguồn gốc, quyền sở hữu/quyền sử dụng hợp pháp của xe trong phạm vi Bên A có nghĩa vụ.</p>
  <p>- Bảo đảm xe ở trạng thái an toàn phù hợp với việc cho thuê; chịu chi phí sửa chữa đối với hư hỏng do hao mòn tự nhiên hoặc lỗi kỹ thuật không do Bên B gây ra.</p>
  <p>- Hỗ trợ Bên B trong trường hợp xe hỏng hoặc tai nạn; phối hợp với doanh nghiệp bảo hiểm/cơ quan chức năng khi cần thiết.</p>
  <p>- Có quyền thu hồi xe hoặc chấm dứt Hợp đồng nếu Bên B vi phạm nghiêm trọng, bao gồm: sử dụng trái pháp luật; cho người không được phép lái xe; cố ý che giấu vị trí xe, tự ý sửa chữa trái thỏa thuận, không trả xe đúng hạn và không liên lạc được, hoặc có nguy cơ rõ ràng gây mất an toàn cho người hoặc tài sản.</p>
  <p>- Trong thời gian bên B sử dụng xe nếu bên A thấy xe mất tín hiệu định vị xe, bên A có quyền yêu cầu bên B mang xe về cho bên A hoặc bên A có quyền thu hồi xe đồng thời chấm dứt hợp đồng ngay lập tức với bên B; nếu phát hiện cũng như kiểm tra hệ thống định vị trên xe bị tháo thì bên B phải chịu hoàn toàn trách nhiệm trước pháp luật.</p>
  <p>- Bên A có quyền lấy lại xe dùng khóa dự phòng mà không cần thông báo trước khi thấy bên B thanh toán muộn, sử dụng xe không đúng mục đích, không báo quản xe, thiết bị GPS không hoạt động, không liên lạc được với bên B và bên A được biết là do bên B lừa đảo.</p>

  <h2 class="section">ĐIỀU 5. QUYỀN VÀ NGHĨA VỤ CỦA BÊN B</h2>
  <p>- Nhận xe và hồ sơ/giấy tờ liên quan theo thỏa thuận, được sử dụng xe đúng mục đích, đúng lộ trình và thời hạn thuê.</p>
  <p>- Bảo quản xe, không hút thuốc trong xe, không để vật nuôi hoặc hàng hóa gây mùi/ẩm ướt/hư hỏng nội thất nếu không có thỏa thuận, giữ gìn xe và phụ kiện và thiết bị đi kèm.</p>
  <p>- Không chuyển giao quyền sử dụng, cho thuê lại, cầm cố, thế chấp hoặc giao xe cho người khác sử dụng.</p>
  <p>- Không sử dụng xe vào đua xe, kéo/đẩy trái quy định, chở quá tải, vận chuyển hàng cấm/chất cháy nổ hoặc hoạt động trái pháp luật; không tự ý đưa xe ra ngoài khu vực đã thỏa thuận.</p>
  <p>- Bên B có trách nhiệm trả xe đúng thời hạn theo Hợp đồng. Trường hợp có nhu cầu gia hạn phải thông báo và được Bên A chấp thuận trước thời điểm kết thúc thời hạn thuê.</p>
  <p>- Tuân thủ pháp luật giao thông và tự chịu trách nhiệm đối với hành vi vi phạm do mình.</p>
  <p>- Báo ngay cho Bên A khi xảy ra tai nạn, hư hỏng, sự cố, trường hợp khẩn cấp phải ưu tiên bảo vệ người và gọi cơ quan chức năng.</p>

  <h2 class="section">ĐIỀU 6. NGƯỜI ĐIỀU KHIỂN, SỬ DỤNG XE VÀ HÀNH VI BỊ CẤM</h2>
  <p>6.1. Bên B chịu trách nhiệm đối với hành vi lái xe trong thời gian thuê.</p>
  <p>6.2. Không tự ý tháo, vô hiệu hóa, can thiệp vào thiết bị, linh kiện của xe.</p>
  <p>6.3. Nghiêm cấm: đua xe; lái xe khi có nồng độ cồn/chất ma túy hoặc chất kích thích trái pháp luật; chở hàng cấm, dùng xe cho hoạt động kinh doanh vận tải nhận chở khách thu tiền, dùng xe làm tài sản bảo đảm cho giao dịch khác, tháo thiết bị, vượt biên giới quốc gia trái quy định.</p>
  <p>6.4. Nếu Bên A có căn cứ rõ ràng về việc xe đang bị sử dụng theo cách có nguy cơ gây thiệt hại tài sản hoặc trái pháp luật, Bên A có quyền yêu cầu dừng sử dụng, trả xe ngay và áp dụng các biện pháp pháp lý cần thiết để bảo vệ tài sản. Mọi xử lý phải tuân thủ pháp luật.</p>

  <h2 class="section">ĐIỀU 7. VI PHẠM GIAO THÔNG, PHẠT NGUỘI VÀ CHI PHÍ PHÁT SINH</h2>
  <p>7.1. Bên B chịu trách nhiệm đối với tiền phạt, phí, lệ phí, phí cầu đường, bãi đỗ và các khoản phải nộp phát sinh do hành vi của Bên B, kể cả trường hợp cơ quan chức năng thông báo sau khi Hợp đồng đã thanh toán.</p>
  <p>7.2. Khi nhận được thông báo/biên bản phạt nguội hoặc yêu cầu làm việc của cơ quan chức năng liên quan đến thời gian Bên B thuê xe, Bên A cung cấp cho Bên B thông tin, hình ảnh hoặc tài liệu mà Bên A có thể cung cấp hợp pháp. Bên B có trách nhiệm phối hợp xác nhận và thanh toán khoản phạt thuộc trách nhiệm của mình trong thời hạn 7 ngày kể từ ngày nhận thông báo hợp lệ.</p>
  <p>7.3. Nếu Bên A phải trực tiếp đi lại, làm việc hoặc thực hiện thủ tục thay cho Bên B do lỗi hoặc sự không hợp tác của Bên B, Bên B hoàn trả các chi phí hợp lý.</p>
  <p>7.4. Hai bên lập Phụ lục 01 - Cam kết xử lý vi phạm giao thông; trường hợp có tranh chấp, hai bên phối hợp xác minh với cơ quan có thẩm quyền.</p>

  <h2 class="section">ĐIỀU 8. TAI NẠN, HƯ HỎNG, BẢO HIỂM VÀ BỒI THƯỜNG</h2>
  <p>8.1. Khi xảy ra tai nạn/hư hỏng, Bên B phải: bảo đảm an toàn người, gọi ngay bên A để được hướng dẫn, giữ nguyên hiện trường trong phạm vi pháp luật cho phép, chụp ảnh/video.</p>
  <p>8.2. Bên B chịu trách nhiệm bồi thường thiệt hại thực tế, căn cứ chứng minh nếu thiệt hại phát sinh do lỗi của Bên B, bao gồm chi phí sửa chữa hợp lý, phụ tùng cần thay thế, chi phí kéo/cứu hộ và các khoản bảo hiểm không chi trả do hành vi vi phạm của Bên B.</p>
  <p>8.3. Việc sửa chữa ưu tiên thực hiện tại cơ sở do Bên A hoặc doanh nghiệp bảo hiểm lựa chọn, phù hợp với điều kiện bảo hành và bảo hiểm. Nếu cần sửa chữa khẩn cấp để ngăn ngừa thiệt hại lớn hơn mà không liên lạc được Bên A, Bên B được quyền thực hiện trong phạm vi cần thiết và phải lưu đầy đủ hóa đơn/chứng từ.</p>
  <p>8.4. Trong trường hợp xe không thể lưu hành do lỗi của Bên B, Bên B chịu chi phí mất doanh thu cho thời gian xe thực tế không thể cho thuê, tính theo đơn giá thuê tương ứng trong Hợp đồng, trên cơ sở có căn cứ về thời gian xe phải sửa chữa hoặc ngừng khai thác, và không tính trùng phần thiệt hại đã được bảo hiểm hoặc được bên thứ ba bồi thường.</p>
  <p>8.5. Trường hợp xe bị mất hoặc tổn thất toàn bộ do lỗi của Bên B, mức bồi thường được xác định theo giá trị thị trường hợp lý của xe ngay trước thời điểm tổn thất, cộng các chi phí hợp lý không được bảo hiểm chi trả và trừ các khoản Bên A đã được bảo hiểm hoặc bên thứ ba thanh toán bồi thường cho cùng một tổn thất. Hai bên không đồng thời yêu cầu bồi thường trùng lặp cho cùng một thiệt hại.</p>
  <p>8.6. Đối với hư hỏng nội thất, mùi, vết bẩn hoặc hư hỏng do sử dụng không đúng quy định, Bên B thanh toán chi phí vệ sinh/sửa chữa thực tế hoặc theo bảng giá đã được thông báo trước khi thuê. Nếu xe không thể phục vụ khách tiếp theo do lỗi của Bên B, Bên B chịu thêm thiệt hại thực tế, hợp lý và có chứng minh.</p>

  <h2 class="section">ĐIỀU 9. ĐIỀU KHOẢN CHUNG</h2>
  <p>- Phụ lục 01 (Cam kết xử lý vi phạm giao thông) và các phụ lục khác được ký hợp lệ là bộ phận không tách rời của Hợp đồng.</p>
  <p>- Hai bên đồng ý thực hiện theo đúng nội dung Hợp đồng. Trường hợp có tranh chấp hoặc một bên vi phạm hợp đồng thì cả hai bên sẽ giải quyết bằng thương lượng hòa giải. Nếu vẫn không thể giải quyết được tranh chấp, hai bên sẽ đưa vụ việc ra Tòa án có thẩm quyền để giải quyết. Mọi chi phí tố tụng do bên thua kiện chịu.</p>
  <p>- Hợp đồng có hiệu lực từ thời điểm ký. Các bên xác nhận đã đọc, hiểu nội dung, tự nguyện ký kết và cam kết thực hiện đúng Hợp đồng.</p>

  <h2 class="section center">ĐẠI DIỆN CÁC BÊN KÝ TÊN XÁC NHẬN</h2>
  <table class="sign">
    <tr>
      <td>
        <div class="role">Đại diện Bên A</div>
        <div class="note">(Ký, ghi rõ họ tên, điểm chỉ nếu có)</div>
        <div class="space"></div>
      </td>
      <td>
        <div class="role">Đại diện Bên B</div>
        <div class="note">(Ký, ghi rõ họ tên, điểm chỉ nếu có)</div>
        <div class="space"></div>
      </td>
    </tr>
  </table>

  <div class="appendix">
    <h1 class="title">PHỤ LỤC 01</h1>
    <h2 class="section center">CAM KẾT XỬ LÝ VI PHẠM GIAO THÔNG / PHẠT NGUỘI</h2>

    <p>Tôi là: <span class="fill">{{ $doc['appendix_name'] }}</span></p>
    <p>CCCD số: <span class="fill">{{ $doc['appendix_cccd'] }}</span> &nbsp; Cấp ngày: <span class="fill">{{ $doc['appendix_cccd_date'] }}</span></p>
    <p>GPLX số: <span class="fill">{{ $doc['appendix_license_no'] }}</span> &nbsp; Cấp ngày: <span class="fill">{{ $doc['appendix_license_date'] }}</span></p>
    <p>Là Bên B lái xe được phép điều khiển xe biển số: <span class="fill">{{ $doc['appendix_car_plate'] }}</span></p>
    <p>Trong thời gian từ <span class="fill">{{ $doc['ap_pickup_hour'] }}</span> giờ <span class="fill">{{ $doc['ap_pickup_minute'] }}</span> phút ngày <span class="fill">{{ $doc['ap_pickup_date'] }}</span> đến <span class="fill">{{ $doc['ap_return_hour'] }}</span> giờ <span class="fill">{{ $doc['ap_return_minute'] }}</span> phút ngày <span class="fill">{{ $doc['ap_return_date'] }}</span>, tôi cam kết:</p>
    <p class="bullet">1. Nếu xe phát sinh vi phạm giao thông trong thời gian tôi thuê và sử dụng xe, kể cả trường hợp cơ quan chức năng thông báo sau khi tôi đã trả xe hoặc Hợp đồng đã kết thúc, tôi xác nhận và chịu trách nhiệm phối hợp xử lý vi phạm theo quy định.</p>
    <p class="bullet">2. Căn cứ xác định vi phạm và thời gian sử dụng xe gồm: hình ảnh, video, thông báo/biên bản phạt nguội của cơ quan chức năng, Hợp đồng thuê xe, thời gian giao nhận xe và các tài liệu, chứng cứ hợp pháp khác có liên quan.</p>
    <p class="bullet">3. Khi nhận được thông báo của Bên A về vi phạm thuộc trách nhiệm của mình, tôi cam kết phản hồi và phối hợp trong vòng 7 ngày kể từ khi nhận thông báo, đồng thời cung cấp thông tin cần thiết, đến cơ quan có thẩm quyền khi được yêu cầu và thực hiện đầy đủ thủ tục xử lý vi phạm.</p>
    <p class="bullet">4. Tôi cam kết nộp toàn bộ tiền phạt và các khoản phải nộp khác liên quan đến vi phạm thuộc trách nhiệm của mình. Tôi đồng thời có trách nhiệm thanh toán cho Bên A các chi phí hợp lý, thực tế phát sinh để xử lý vi phạm, bao gồm chi phí đi lại, làm việc với cơ quan chức năng và các chi phí liên quan khác.</p>
    <p class="bullet">5. Trường hợp tôi không phối hợp, chậm phối hợp hoặc không thực hiện đúng cam kết, tôi chịu trách nhiệm theo quy định pháp luật và có trách nhiệm hoàn trả, bồi hoàn cho Bên A các khoản tiền, chi phí và thiệt hại thực tế phát sinh do việc vi phạm hoặc không thực hiện cam kết của tôi gây ra.</p>
    <p class="bullet">6. Tôi đồng ý rằng việc đã trả xe hoặc chấm dứt Hợp đồng không làm chấm dứt trách nhiệm đối với các vi phạm giao thông trong thời gian tôi thuê và sử dụng xe. Trường hợp phạt nguội được cơ quan chức năng thông báo sau khi Hợp đồng kết thúc, tôi vẫn có trách nhiệm phối hợp và xử lý đầy đủ nếu vi phạm xảy ra trong thời gian tôi thuê xe.</p>
    <p>Cam kết này là bộ phận không tách rời của Hợp đồng thuê xe, có hiệu lực cùng Hợp đồng và tiếp tục áp dụng đối với các vi phạm giao thông trong thời gian thuê xe nhưng được thông báo sau đó.</p>

    <table class="sign">
      <tr>
        <td>
          <div class="role">Đại diện Bên A</div>
          <div class="note">(Ký, ghi rõ họ tên, điểm chỉ nếu có)</div>
          <div class="space"></div>
        </td>
        <td>
          <div class="role">Đại diện Bên B</div>
          <div class="note">(Ký, ghi rõ họ tên, điểm chỉ nếu có)</div>
          <div class="space"></div>
        </td>
      </tr>
    </table>
  </div>

</div>

</body>
</html>
