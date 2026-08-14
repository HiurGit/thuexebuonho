<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<meta name="theme-color" content="#5fcf86">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>Gửi báo cáo cảnh báo - Cộng đồng chủ cho thuê xe</title>
<meta name="description" content="Gửi báo cáo, cảnh báo khách thuê dành cho cộng đồng chủ cho thuê xe. Nhập SĐT, CCCD, bằng lái.">
<meta name="robots" content="noindex, nofollow">
<meta property="og:title" content="Gửi báo cáo cảnh báo - Cộng đồng chủ cho thuê xe">
<meta property="og:description" content="Gửi báo cáo, cảnh báo khách thuê dành cho cộng đồng chủ cho thuê xe. Nhập SĐT, CCCD, bằng lái.">
<meta property="og:image" content="{{ asset('assets/icon-checkkhach/banner-checkkhach.png') }}">
<meta property="og:image:width" content="1200">
<meta property="og:image:height" content="630">
<meta property="og:url" content="{{ url()->current() }}">
<meta property="og:type" content="website">
<meta property="og:site_name" content="Cộng đồng chủ cho thuê xe">
<meta property="og:locale" content="vi_VN">
<meta property="og:image:type" content="image/png">
<meta property="og:image:alt" content="Gửi báo cáo cảnh báo - Cộng đồng chủ cho thuê xe">
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="Gửi báo cáo cảnh báo - Cộng đồng chủ cho thuê xe">
<meta name="twitter:description" content="Gửi báo cáo, cảnh báo khách thuê dành cho cộng đồng chủ cho thuê xe. Nhập SĐT, CCCD, bằng lái.">
<meta name="twitter:image" content="{{ asset('assets/icon-checkkhach/banner-checkkhach.png') }}">
<link rel="icon" type="image/png" sizes="32x32" href="{{ asset('assets/favicon-32.png') }}">
<link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/favicon-16.png') }}">
@vite(['resources/css/app.css', 'resources/js/app.js', 'resources/js/check-khach-qr.js'])
<script>window.__CHECK_KHACH_GEMINI_OCR_URL = @json(route('check-khach-thue.ocr-gemini'));</script>
<link href="{{ asset('assets/vendor/remixicon/remixicon.css') }}" rel="stylesheet">
<link rel="preload" href="{{ asset('assets/fonts/nunito/nunito-vietnamese.woff2') }}" as="font" type="font/woff2" crossorigin>
<link rel="preload" href="{{ asset('assets/fonts/nunito/nunito-latin.woff2') }}" as="font" type="font/woff2" crossorigin>
<style>
  @font-face {
    font-family: 'Nunito';
    font-style: normal;
    font-weight: 100 900;
    font-display: swap;
    src: url('{{ asset("assets/fonts/nunito/nunito-vietnamese.woff2") }}') format('woff2');
    unicode-range: U+0102-0103, U+0110-0111, U+0128-0129, U+0168-0169, U+01A0-01A1, U+01AF-01B0, U+0300-0301, U+0303-0304, U+0308-0309, U+0323, U+0329, U+1EA0-1EF9, U+20AB;
  }
  @font-face {
    font-family: 'Nunito';
    font-style: normal;
    font-weight: 100 900;
    font-display: swap;
    src: url('{{ asset("assets/fonts/nunito/nunito-latin.woff2") }}') format('woff2');
    unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+0304, U+0308, U+0329, U+2000-206F, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
  }
  html, body { margin: 0; padding: 0; }
  [x-cloak] { display: none !important; }
  @media (max-width: 767px) {
    input, select, textarea { font-size: 16px !important; }
  }
</style>
</head>
<body class="min-h-screen bg-white font-sans text-app-ink antialiased">

<div class="mx-auto max-w-3xl px-4 py-6 sm:py-10">

  <div id="report-form">
    <div id="report-website-wrap" class="hidden" aria-hidden="true">
      <input type="text" id="report-website" name="website" tabindex="-1" autocomplete="off">
    </div>
    <div class="hidden" aria-hidden="true">
      <input type="email" id="report-email" name="email" tabindex="-1" autocomplete="off">
    </div>
    {{-- Header --}}
    <div class="mb-6">
      <a href="{{ route('check-khach-thue') }}" class="inline-flex items-center gap-1.5 text-[#0b296c] font-extrabold text-sm hover:underline">
        <i class="ri-arrow-left-line"></i>
        Quay lại tra cứu
      </a>
    </div>

    <div class="flex items-center justify-center gap-3 sm:gap-5 mb-6">
      <img
        src="{{ asset('assets/icon-checkkhach/icon-logo-check.png') }}"
        alt="Hệ thống báo cáo khách thuê ô tô"
        class="h-16 w-16 sm:h-24 sm:w-24 flex-none object-contain"
        width="112" height="112"
      >
      <div>
        <h1 class="text-[clamp(1.25rem,6vw,2.75rem)] font-extrabold uppercase leading-tight tracking-tight text-[#052c61]">
          Gửi Cảnh Báo<br>Khách Thuê
        </h1>
      </div>
    </div>

    {{-- Quét CCCD --}}
    <div id="qr-scan-wrap" class="mb-4">
      <div class="grid grid-cols-2 gap-2.5">
        <button type="button" id="qr-scan-btn" class="flex items-center justify-center gap-2 py-3 rounded-md font-extrabold text-[15px] text-white bg-[#0b296c] hover:bg-[#0a2458] active:scale-[0.97] transition">
          <i class="ri-qr-scan-2-line text-lg"></i>
          Quét CCCD
        </button>
        <button type="button" id="qr-upload-btn" class="flex items-center justify-center gap-2 py-3 rounded-md font-extrabold text-[15px] text-[#0b296c] bg-white border-[1.5px] border-[#0b296c] hover:bg-[#0b296c] hover:text-white active:scale-[0.97] transition">
          <i class="ri-upload-2-line text-lg"></i>
          Upload CCCD
        </button>
      </div>
      <input type="file" id="qr-upload-file" accept="image/*" class="hidden">
      <div id="qr-reader" class="hidden mt-3 relative overflow-hidden rounded-xl bg-black" style="aspect-ratio: 16 / 10;">
        <video id="qr-video" class="h-full w-full object-cover" playsinline muted></video>
      </div>
      <div id="qr-controls" class="hidden mt-3 flex flex-wrap gap-2.5">
        <button type="button" id="qr-stop-btn" class="flex-1 py-2.5 rounded-md font-bold text-[14px] text-center bg-[#F1F2F8] text-app-muted hover:bg-[#E7E9F2] transition">Đóng camera</button>
        <button type="button" id="qr-capture-btn" class="flex-1 py-2.5 rounded-md font-bold text-[14px] text-center bg-[#0b296c] text-white hover:bg-[#0a2458] transition">Chụp</button>
        <button type="button" id="qr-flash-btn" class="flex-1 py-2.5 rounded-md font-bold text-[14px] text-center bg-[#F1F2F8] text-app-muted hover:bg-[#E7E9F2] transition">Đèn flash</button>
      </div>
      <p id="qr-status" class="hidden mt-3 text-[13px] font-bold text-app-muted"></p>
    </div>

    {{-- Form --}}
    <div class="bg-white rounded-md border border-app-line shadow-card p-4 sm:p-6">
      <div class="mb-3">
        <label class="block text-[12.5px] font-bold text-app-ink mb-1.5" for="report-name">Họ và tên người báo cáo</label>
        <input id="report-name" type="text" placeholder="VD: Nguyễn Văn A" class="w-full px-3.5 py-2.5 rounded-md border-[1.5px] border-app-line bg-[#FAFBFF] text-[13.5px] outline-none focus:border-app-accent focus:ring-2 focus:ring-app-accentSoft transition">
      </div>
      <div class="mb-3">
        <label class="block text-[12.5px] font-bold text-app-ink mb-1.5" for="report-cccd">CCCD <span class="font-semibold text-app-muted">(tuỳ chọn)</span></label>
        <input id="report-cccd" type="text" placeholder="VD: 041203000123" class="w-full px-3.5 py-2.5 rounded-md border-[1.5px] border-app-line bg-[#FAFBFF] text-[13.5px] outline-none focus:border-app-accent focus:ring-2 focus:ring-app-accentSoft transition">
      </div>
      <div class="mb-3">
        <label class="block text-[12.5px] font-bold text-app-ink mb-1.5" for="report-license">Bằng lái <span class="font-semibold text-app-muted">(tuỳ chọn)</span></label>
        <input id="report-license" type="text" placeholder="VD: 790000123456" class="w-full px-3.5 py-2.5 rounded-md border-[1.5px] border-app-line bg-[#FAFBFF] text-[13.5px] outline-none focus:border-app-accent focus:ring-2 focus:ring-app-accentSoft transition">
      </div>
      <div class="mb-3">
        <label class="block text-[12.5px] font-bold text-app-ink mb-1.5" for="report-phone">SĐT <span class="font-semibold text-app-muted">(tuỳ chọn)</span></label>
        <input id="report-phone" type="text" placeholder="VD: 0901234567" class="w-full px-3.5 py-2.5 rounded-md border-[1.5px] border-app-line bg-[#FAFBFF] text-[13.5px] outline-none focus:border-app-accent focus:ring-2 focus:ring-app-accentSoft transition">
      </div>
      <div class="grid grid-cols-2 gap-2.5 mb-3">
        <div>
          <label class="block text-[12.5px] font-bold text-app-ink mb-1.5" for="report-dob">Ngày sinh <span class="font-semibold text-app-muted">(tuỳ chọn)</span></label>
          <input id="report-dob" type="text" placeholder="12/03/1995" class="w-full px-3.5 py-2.5 rounded-md border-[1.5px] border-app-line bg-[#FAFBFF] text-[13.5px] outline-none focus:border-app-accent focus:ring-2 focus:ring-app-accentSoft transition">
        </div>
        <div>
          <label class="block text-[12.5px] font-bold text-app-ink mb-1.5" for="report-gender">Giới tính <span class="font-semibold text-app-muted">(tuỳ chọn)</span></label>
          <select id="report-gender" class="w-full px-3 py-2.5 rounded-md border-[1.5px] border-app-line bg-[#FAFBFF] text-[13.5px] outline-none focus:border-app-accent focus:ring-2 focus:ring-app-accentSoft transition">
            <option value="">-- Chọn --</option>
            <option value="Nam">Nam</option>
            <option value="Nữ">Nữ</option>
          </select>
        </div>
      </div>

      <div class="mb-3">
        <label class="block text-[12.5px] font-bold text-app-ink mb-1.5" for="report-address">Địa chỉ thường trú <span class="font-semibold text-app-muted">(tuỳ chọn)</span></label>
        <input id="report-address" type="text" placeholder="VD: Số 12, Đường 3/2, Quận 10, TP. Hồ Chí Minh" class="w-full px-3.5 py-2.5 rounded-md border-[1.5px] border-app-line bg-[#FAFBFF] text-[13.5px] outline-none focus:border-app-accent focus:ring-2 focus:ring-app-accentSoft transition">
      </div>
      <div class="mb-3">
        <label class="block text-[12.5px] font-bold text-app-ink mb-1.5" for="report-issue-date">Ngày cấp CCCD <span class="font-semibold text-app-muted">(tuỳ chọn)</span></label>
        <input id="report-issue-date" type="text" placeholder="15/10/2024" class="w-full px-3.5 py-2.5 rounded-md border-[1.5px] border-app-line bg-[#FAFBFF] text-[13.5px] outline-none focus:border-app-accent focus:ring-2 focus:ring-app-accentSoft transition">
      </div>

      <div class="mb-3">
        <label class="block text-[12.5px] font-bold text-app-ink mb-1.5" for="report-detail">Nội dung cảnh báo <span class="text-[#e02923]">*</span></label>
        <textarea id="report-detail" rows="3" placeholder="Mô tả chi tiết sự việc..." class="w-full px-3.5 py-2.5 rounded-md border-[1.5px] border-app-line bg-[#FAFBFF] text-[13.5px] outline-none focus:border-app-accent focus:ring-2 focus:ring-app-accentSoft transition resize-y min-h-[70px]"></textarea>
        <p id="report-detail-error" class="hidden mt-1.5 text-[12px] font-bold text-[#e02923]">Vui lòng nhập nội dung cảnh báo.</p>
      </div>
      <div class="mb-3">
        <label class="block text-[12.5px] font-bold text-app-ink mb-1.5">Ảnh khách hàng <span class="font-semibold text-app-muted">(tuỳ chọn)</span></label>
        <div id="report-images" class="hidden flex flex-wrap gap-2 mb-2"></div>
        <label for="report-file" class="flex w-full cursor-pointer flex-col items-center justify-center gap-1.5 rounded-md border-[1.5px] border-dashed border-app-line bg-[#FAFBFF] py-4 text-app-muted transition hover:border-app-accent hover:text-app-accent">
          <i class="ri-image-add-line text-2xl"></i>
          <span class="text-[12.5px] font-bold">Thêm ảnh tải lên</span>
        </label>
        <input id="report-file" type="file" accept="image/*" multiple class="hidden">
      </div>
      <div id="report-error" class="hidden mb-4 rounded-md border border-[#e02923] bg-red-50 text-[#e02923] text-[13px] font-bold px-3.5 py-2.5"></div>
      <hr class="border-t border-app-line mb-4">
      <div class="flex gap-2.5">
        <a href="{{ route('check-khach-thue') }}" class="flex-1 py-3 rounded-md font-bold text-[15px] text-center bg-[#F1F2F8] text-app-muted hover:bg-[#E7E9F2] transition">Huỷ</a>
        <button type="button" onclick="submitReport()" class="flex-1 py-3 rounded-md font-bold text-[15px] text-white bg-red-500 hover:bg-red-600 active:scale-[0.97] transition">Gửi đi</button>
      </div>
    </div>
  </div>

  {{-- Success --}}
  <div id="report-success" class="hidden text-center py-10">
    <div class="mx-auto mb-4 flex h-20 w-20 items-center justify-center rounded-full bg-app-accentSoft">
      <i class="ri-check-line text-5xl text-[#0b296c]"></i>
    </div>
    <h2 class="text-[clamp(1.25rem,5vw,1.5rem)] font-extrabold text-[#052c61] mb-2">Đã gửi báo cáo thành công</h2>
    <p class="text-[clamp(0.875rem,3.8vw,0.9375rem)] font-bold text-app-muted mb-6">Báo cáo của bạn đang chờ kiểm duyệt trước khi hiển thị công khai.</p>
    <a href="{{ route('check-khach-thue') }}" class="inline-flex items-center justify-center gap-2 px-6 py-3 rounded-md text-white font-extrabold text-[15px] bg-[#195cc2] hover:bg-[#164fa6] active:scale-[0.97] transition">
      <i class="ri-search-line text-base"></i>
      Quay về tra cứu
    </a>
  </div>

</div>

<script>
(function() {
  var pendingImages = [];
  var pendingFiles = [];

  function showError(msg) {
    var err = document.getElementById('report-error');
    if (!err) return;
    err.textContent = msg;
    err.classList.remove('hidden');
  }

  function renderImageThumbs() {
    var wrap = document.getElementById('report-images');
    if (!wrap) return;
    if (pendingImages.length === 0) {
      wrap.classList.add('hidden');
      wrap.innerHTML = '';
      return;
    }
    wrap.classList.remove('hidden');
    wrap.innerHTML = pendingImages.map(function(src, idx) {
      return '<div class="relative h-14 w-14 flex-none overflow-hidden rounded-md border border-app-line">' +
        '<img src="' + src + '" alt="Ảnh khách hàng" class="h-full w-full object-cover">' +
        '<button type="button" data-remove-img="' + idx + '" class="absolute -right-1.5 -top-1.5 flex h-5 w-5 items-center justify-center rounded-full bg-[#e02923] text-white">' +
          '<i class="ri-close-line text-[12px]"></i>' +
        '</button>' +
      '</div>';
    }).join('');
  }

  function addFile(file) {
    if (!file || file.type.indexOf('image/') !== 0) return;
    if (pendingFiles.length >= 5) {
      showError('Chỉ được gửi tối đa 5 ảnh.');
      return;
    }
    pendingFiles.push(file);
    var reader = new FileReader();
    reader.onload = function(e) {
      pendingImages.push(e.target.result);
      renderImageThumbs();
    };
    reader.readAsDataURL(file);
  }

  window.addImages = function(input) {
    if (!input || !input.files) return;
    var files = Array.prototype.slice.call(input.files);
    files.forEach(addFile);
    input.value = '';
  };

  window.addReportImage = function(file) {
    addFile(file);
  };

  window.submitReport = function() {
    var err = document.getElementById('report-error');
    if (err) err.classList.add('hidden');
    var detailError = document.getElementById('report-detail-error');
    if (detailError) detailError.classList.add('hidden');

    var hp = document.getElementById('report-website');
    if (hp && hp.value.trim()) {
      var form = document.getElementById('report-form');
      var success = document.getElementById('report-success');
      if (form) form.classList.add('hidden');
      if (success) success.classList.remove('hidden');
      window.scrollTo(0, 0);
      return;
    }

    var nameEl = document.getElementById('report-name');
    var detailEl = document.getElementById('report-detail');
    if (!nameEl) return;
    var name = nameEl.value.trim();
    var detail = detailEl ? detailEl.value.trim() : '';
    if (!name) {
      var nn = document.getElementById('report-name');
      if (nn) nn.focus();
      showError('Vui lòng nhập Họ và tên.');
      return;
    }
    if (!detail) {
      if (detailEl) detailEl.focus();
      if (detailError) detailError.classList.remove('hidden');
      showError('Vui lòng nhập nội dung cảnh báo.');
      return;
    }

    var fd = new FormData();
    fd.append('name', name);
    var cccdEl = document.getElementById('report-cccd');
    if (cccdEl && cccdEl.value.trim()) fd.append('cccd', cccdEl.value.trim());
    ['report-license', 'report-phone', 'report-dob', 'report-gender', 'report-address', 'report-issue-date', 'report-detail'].forEach(function(id) {
      var el = document.getElementById(id);
      if (el && el.value) fd.append(id.replace('report-', '').replace('-', '_'), el.value.trim());
    });
    pendingFiles.forEach(function(f) { fd.append('images[]', f); });

    var csrf = document.querySelector('meta[name="csrf-token"]');
    var headers = { 'Accept': 'application/json' };
    if (csrf) headers['X-CSRF-TOKEN'] = csrf.getAttribute('content');

    var btn = document.querySelector('button[onclick="submitReport()"]');
    if (btn) btn.disabled = true;

    fetch('{{ route('check-khach-thue.report.store') }}', {
      method: 'POST',
      headers: headers,
      body: fd
    })
    .then(function(r) { return r.json().catch(function() { return {}; }).then(function(data) { return { ok: r.ok, status: r.status, data: data }; }); })
    .then(function(res) {
      if (res.status === 429) {
        showError('Bạn đã gửi quá nhiều lần trong thời gian ngắn, vui lòng đợi vài phút rồi thử lại.');
        return;
      }
      if (res.ok && res.data.success) {
        var form = document.getElementById('report-form');
        var success = document.getElementById('report-success');
        if (form) form.classList.add('hidden');
        if (success) success.classList.remove('hidden');
        window.scrollTo(0, 0);
      } else {
        showError(res.data.message || 'Gửi báo cáo thất bại, vui lòng thử lại.');
      }
    })
    .catch(function() {
      showError('Lỗi kết nối, vui lòng thử lại.');
    })
    .finally(function() {
      if (btn) btn.disabled = false;
    });
  };

  var fileEl = document.getElementById('report-file');
  if (fileEl) {
    fileEl.addEventListener('change', function() { addImages(fileEl); });
  }

  var detailInput = document.getElementById('report-detail');
  if (detailInput) {
    detailInput.addEventListener('input', function() {
      var detailError = document.getElementById('report-detail-error');
      if (detailInput.value.trim() && detailError) detailError.classList.add('hidden');
    });
  }

  document.addEventListener('click', function(e) {
    var rm = e.target.closest('[data-remove-img]');
    if (rm) {
      var idx = parseInt(rm.getAttribute('data-remove-img'), 10);
      pendingImages.splice(idx, 1);
      pendingFiles.splice(idx, 1);
      renderImageThumbs();
    }
  });
})();
</script>

</body>
</html>
