<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<meta name="theme-color" content="#5fcf86">
<title>Check khách thuê - Cộng đồng chủ cho thuê xe</title>
<meta name="description" content="Hệ thống báo cáo, cảnh báo khách thuê dành cho cộng đồng chủ cho thuê xe. Tra cứu SĐT, CCCD, bằng lái.">
<meta name="robots" content="index, follow">
<meta name="keywords" content="check khách thuê, báo cáo khách thuê, danh sách đen, thuê xe, cho thuê xe">
<meta property="og:title" content="Check khách thuê - Cộng đồng chủ cho thuê xe">
<meta property="og:description" content="Hệ thống báo cáo, cảnh báo khách thuê dành cho cộng đồng chủ cho thuê xe. Tra cứu SĐT, CCCD, bằng lái.">
<meta property="og:image" content="{{ asset('assets/icon-checkkhach/banner-checkkhach.png') }}">
<meta property="og:image:width" content="1200">
<meta property="og:image:height" content="630">
<meta property="og:url" content="{{ url()->current() }}">
<meta property="og:type" content="website">
<meta property="og:site_name" content="Cộng đồng chủ cho thuê xe">
<meta property="og:locale" content="vi_VN">
<meta property="og:image:type" content="image/png">
<meta property="og:image:alt" content="Check khách thuê - Cộng đồng chủ cho thuê xe">
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="Check khách thuê - Cộng đồng chủ cho thuê xe">
<meta name="twitter:description" content="Hệ thống báo cáo, cảnh báo khách thuê dành cho cộng đồng chủ cho thuê xe. Tra cứu SĐT, CCCD, bằng lái, số tài khoản.">
<meta name="twitter:image" content="{{ asset('assets/icon-checkkhach/banner-checkkhach.png') }}">
<link rel="icon" type="image/png" sizes="32x32" href="{{ asset('assets/favicon-32.png') }}">
<link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/favicon-16.png') }}">
@vite(['resources/css/app.css', 'resources/js/app.js'])
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

 

  {{-- Header --}}
  <div class="flex items-center justify-center gap-3 sm:gap-5 mb-6">
    <img
      src="{{ asset('assets/icon-checkkhach/icon-logo-check.png') }}"
      alt="Hệ thống báo cáo khách thuê ô tô"
      class="h-16 w-16 sm:h-24 sm:w-24 flex-none object-contain"
      width="112" height="112"
    >
    <h1 class="text-[clamp(1.25rem,6vw,2.75rem)] font-extrabold uppercase leading-tight tracking-tight text-[#052c61]">
      Hệ Thống Báo Cáo<br>
      Khách Thuê Ô Tô
    </h1>
  </div>

  {{-- Stats --}}
  <div class="mb-5 grid grid-cols-3 gap-2.5 sm:gap-4">
    <div class="bg-white rounded-md border border-app-line shadow-card text-center p-3.5 sm:p-5">
      <img src="{{ asset('assets/icon-checkkhach/icon-tongbaocao.png') }}" alt="Tổng số báo cáo" class="w-12 h-12 sm:w-14 sm:h-14 mx-auto mb-2 sm:mb-3 object-contain">
      <div id="stat-total" class="text-[clamp(1.125rem,6.5vw,1.5rem)] font-extrabold text-[#0b296c] tracking-tight">0</div>
      <div class="text-[clamp(0.625rem,3vw,0.78125rem)] font-bold text-[#0b296c] mt-0.5">Tổng số báo cáo</div>
    </div>
    <div class="bg-white rounded-md border border-app-line shadow-card text-center p-3.5 sm:p-5">
      <img src="{{ asset('assets/icon-checkkhach/icon-danhsachden.png') }}" alt="Khách DS đen" class="w-12 h-12 sm:w-14 sm:h-14 mx-auto mb-2 sm:mb-3 object-contain">
      <div id="stat-users" class="text-[clamp(1.125rem,6.5vw,1.5rem)] font-extrabold text-[#0b296c] tracking-tight">0</div>
      <div class="text-[clamp(0.625rem,3vw,0.78125rem)] font-bold text-[#0b296c] mt-0.5">Danh sách đen</div>
    </div>
    <div class="bg-white rounded-md border border-app-line shadow-card text-center p-3.5 sm:p-5">
      <img src="{{ asset('assets/icon-checkkhach/icon-nguoidung.png') }}" alt="Người dùng" class="w-12 h-12 sm:w-14 sm:h-14 mx-auto mb-2 sm:mb-3 object-contain">
      <div id="stat-verified" class="text-[clamp(1.125rem,6.5vw,1.5rem)] font-extrabold text-[#0b296c] tracking-tight">0</div>
      <div class="text-[clamp(0.625rem,3vw,0.78125rem)] font-bold text-[#0b296c] mt-0.5">Người dùng</div>
    </div>
  </div>

  {{-- Search --}}
  <div class="relative mb-4">
    <i class="ri-search-line absolute left-[18px] top-1/2 -translate-y-1/2 text-[19px] text-[#0b296c]"></i>
    <input
      id="report-search"
      type="text"
      placeholder="Ô tìm kiếm TÊN / SĐT / CCCD / BẰNG LÁI"
      class="w-full pl-[50px] pr-[18px] py-4 rounded-md border-[1.5px] border-app-line bg-white text-sm text-app-ink tracking-wide outline-none placeholder:uppercase placeholder:text-[13px] placeholder:text-app-muted/60 focus:border-app-accent focus:ring-4 focus:ring-app-accentSoft transition"
    >
  </div>

  {{-- Actions --}}
  <div class="mb-6 grid grid-cols-2 gap-2.5 sm:gap-3">
    <button type="button" onclick="runSearch()" class="flex items-center justify-center gap-2 py-2.5 sm:py-3 rounded-md text-white font-extrabold text-[clamp(0.8125rem,3.6vw,0.875rem)] whitespace-nowrap bg-[#195cc2] shadow-[0_10px_20px_-10px_rgba(25,92,194,0.6)] hover:bg-[#164fa6] active:scale-[0.97] transition">
      <i class="ri-search-line text-base"></i>
      Tra cứu
    </button>
    <a href="{{ route('check-khach-thue.report') }}" class="flex items-center justify-center gap-2 py-2.5 sm:py-3 rounded-md text-white font-extrabold text-[clamp(0.8125rem,3.6vw,0.875rem)] whitespace-nowrap bg-[#e02923] shadow-[0_10px_20px_-10px_rgba(224,41,35,0.55)] hover:bg-[#c7241e] active:scale-[0.97] transition">
      <i class="ri-add-line text-base"></i>
      Gửi báo cáo
    </a>
  </div>

  {{-- List panel --}}
  <div class="bg-white rounded-md border border-app-line shadow-card p-4 sm:p-6">
    <div class="flex items-center gap-2.5 mb-5">
      <i class="ri-notification-3-line text-[#0b296c] text-xl"></i>
      <h2 class="text-[clamp(0.9375rem,4vw,1.125rem)] font-extrabold text-[#0b296c]">Danh sách cảnh báo mới nhất</h2>
    </div>
    <div id="report-list"></div>
    <div id="report-empty" class="hidden text-center py-8 px-2.5 text-app-muted text-sm">Không tìm thấy kết quả phù hợp.</div>
    <button type="button" id="report-more" onclick="loadMore()" class="hidden w-full mt-4 flex items-center justify-center gap-2 border-[1.5px] border-[#0b296c] text-[#0b296c] bg-white font-extrabold text-[clamp(0.8125rem,3.6vw,0.875rem)] px-4 py-2.5 rounded-md hover:bg-[#0b296c] hover:text-white transition">
      <span>Xem thêm</span>
      <i class="ri-arrow-down-line"></i>
    </button>
  </div>

</div>

<script>
(function() {
  var items = @json($items);
  var stats = @json($stats);
  var visibleCount = 5;

  function normalizeSearch(str) {
    str = String(str || '').toLowerCase().trim();
    if (typeof str.normalize === 'function') {
      str = str.normalize('NFD').replace(/[\u0300-\u036f]/g, '');
    }
    str = str.replace(/đ/g, 'd').replace(/\s+/g, ' ');
    return str;
  }

  items = items.map(function(item) {
    item._search = {
      name: normalizeSearch(item.name),
      reason: normalizeSearch(item.reason),
      phone: normalizeSearch(item.phone),
      cccd: normalizeSearch(item.cccd),
      license: normalizeSearch(item.license)
    };
    return item;
  });

  function esc(str) {
    return String(str).replace(/[&<>"']/g, function(c) {
      return { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[c];
    });
  }

  function truncateWords(str, n) {
    str = String(str || '').trim();
    var words = str.split(/\s+/);
    return words.length > n ? words.slice(0, n).join(' ') + '...' : str;
  }

  function maskNumber(value) {
    var digits = String(value || '').replace(/\D/g, '');
    if (!digits) return '';
    if (digits.length <= 4) return 'xxxx';
    return digits.slice(0, digits.length - 4) + 'xxxx';
  }

  function isExactMatch(item) {
    var q = getQuery().replace(/\D/g, '');
    if (!q) return false;
    var cccd = String(item.cccd || '').replace(/\D/g, '');
    var phone = String(item.phone || '').replace(/\D/g, '');
    var license = String(item.license || '').replace(/\D/g, '');
    return q === cccd || q === phone || q === license;
  }

  function getQuery() {
    var el = document.getElementById('report-search');
    return normalizeSearch((el && el.value) || '');
  }

  function getFiltered() {
    var q = getQuery();
    if (!q) return items;
    return items.filter(function(i) {
      return i._search.name.indexOf(q) !== -1 ||
        i._search.phone.indexOf(q) !== -1 ||
        i._search.cccd.indexOf(q) !== -1 ||
        i._search.license.indexOf(q) !== -1 ||
        i._search.reason.indexOf(q) !== -1;
    });
  }

  function cardHTML(item) {
    var badge = item.verified
      ? '<span class="flex-none text-[clamp(0.625rem,2.8vw,0.6875rem)] font-extrabold px-2.5 py-1 rounded-md uppercase tracking-wide bg-app-accentSoft text-[#0b296c]">Đã xác minh</span>'
      : '<span class="flex-none text-[clamp(0.625rem,2.8vw,0.6875rem)] font-extrabold px-2.5 py-1 rounded-md uppercase tracking-wide bg-[#FDF1DE] text-[#0b296c]">Chờ xác minh</span>';

    var q = getQuery();
    var reveal = isExactMatch(item);
    var phoneShown = item.phone ? (reveal ? item.phone : maskNumber(item.phone)) : '';
    var cccdShown = item.cccd ? (reveal ? item.cccd : maskNumber(item.cccd)) : '';
    var licenseShown = item.license ? (reveal ? item.license : maskNumber(item.license)) : '';

    return '' +
      '<div class="border border-app-line rounded-md px-3 py-3.5 sm:px-4 sm:py-4 mb-3.5 bg-white hover:shadow-card hover:-translate-y-px transition">' +
        '<div class="flex items-start justify-between gap-3">' +
          '<div class="flex gap-3 min-w-0">' +
            '<div class="flex-none w-[30px] h-[30px] mt-0.5 rounded-md flex items-center justify-center overflow-hidden">' +
              '<img src="{{ asset('assets/icon-checkkhach/icon-avt.png') }}" alt="Khách hàng" class="w-full h-full object-contain">' +
            '</div>' +
            '<div class="min-w-0">' +
              '<p class="text-[clamp(0.9375rem,4.4vw,1rem)] font-extrabold text-black mb-0.5">' + esc(item.name) + '</p>' +
              (phoneShown ? '<p class="text-[clamp(0.8rem,3.6vw,0.8125rem)] font-bold text-black mb-0.5"><span class="text-[#0b296c]">SĐT:</span> ' + esc(phoneShown) + '</p>' : '') +
              (cccdShown ? '<p class="text-[clamp(0.8rem,3.6vw,0.8125rem)] font-bold text-black mb-0.5"><span class="text-[#0b296c]">CCCD:</span> ' + esc(cccdShown) + '</p>' : '') +
              (licenseShown ? '<p class="text-[clamp(0.8rem,3.6vw,0.8125rem)] font-bold text-black mb-1"><span class="text-[#0b296c]">Bằng lái:</span> ' + esc(licenseShown) + '</p>' : '') +
              '<p class="text-[clamp(0.82rem,3.7vw,0.875rem)] font-bold text-[#e02923]">' + esc(truncateWords(item.reason, 4)) + '</p>' +
            '</div>' +
          '</div>' +
          badge +
        '</div>' +
        '<hr class="border-t border-app-line my-3.5">' +
        '<div class="flex items-center justify-between flex-wrap gap-2.5">' +
          '<div class="flex items-center gap-4 text-[clamp(0.75rem,3.3vw,0.78125rem)] font-bold text-[#0b296c]">' +
            '<span class="flex items-center gap-1.5 whitespace-nowrap"><i class="ri-calendar-line"></i> ' + esc(item.date) + '</span>' +
            '<span class="flex items-center gap-1.5 whitespace-nowrap"><i class="ri-eye-line"></i> ' + item.views + ' check</span>' +
          '</div>' +
          '<a href="' + '{{ route('check-khach-thue.detail', '__CID__') }}'.replace('__CID__', item.customer_id) + '?q=' + encodeURIComponent(q) + '" class="flex items-center gap-1 border-[1.5px] border-[#0b296c] text-[#0b296c] bg-white font-extrabold text-[clamp(0.75rem,3.3vw,0.8125rem)] px-4 py-2 rounded-md hover:bg-[#0b296c] hover:text-white transition">' +
            '<i class="ri-eye-line text-sm"></i> Xem chi tiết' +
          '</a>' +
        '</div>' +
      '</div>';
  }

  function renderStats() {
    var t = document.getElementById('stat-total');
    var u = document.getElementById('stat-users');
    var v = document.getElementById('stat-verified');
    if (t) t.textContent = stats.total.toLocaleString('vi-VN');
    if (u) u.textContent = stats.users.toLocaleString('vi-VN');
    if (v) v.textContent = stats.verified.toLocaleString('vi-VN');
  }

  function renderList() {
    var list = getFiltered();
    var q = getQuery();
    var shown = q ? list : list.slice(0, visibleCount);
    var container = document.getElementById('report-list');
    var empty = document.getElementById('report-empty');
    if (container) {
      var html = '';
      shown.forEach(function(item) { html += cardHTML(item); });
      container.innerHTML = html;
      if (empty) empty.classList.toggle('hidden', shown.length !== 0);
    }
    var moreBtn = document.getElementById('report-more');
    if (moreBtn) {
      var remaining = list.length - visibleCount;
      var showBtn = !q && list.length > visibleCount;
      moreBtn.classList.toggle('hidden', !showBtn);
      moreBtn.querySelector('span').textContent = 'Xem thêm (' + remaining + ')';
    }
  }

  window.loadMore = function() {
    visibleCount += 5;
    renderList();
  };

  window.runSearch = function() {
    renderList();
  };

  var searchEl = document.getElementById('report-search');
  if (searchEl) {
    searchEl.addEventListener('input', renderList);
  }

  document.addEventListener('DOMContentLoaded', function() {
    renderStats();
    renderList();
  });
})();
</script>
</body>
</html>
