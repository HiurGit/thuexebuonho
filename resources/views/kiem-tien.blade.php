@extends('layouts.app')

@section('title', 'Đối tác giới thiệu - Thuê Xe Buôn Hồ')

@section('meta')
<meta name="description" content="Chương trình đối tác giới thiệu Thuê Xe Buôn Hồ: giới thiệu khách thuê xe, nhận hoa hồng 10% mỗi hợp đồng. Khách của bạn được giữ nguyên nguồn cho mọi lần thuê lại.">
<meta property="og:title" content="Đối tác giới thiệu - Thuê Xe Buôn Hồ">
<meta property="og:description" content="Giới thiệu một lần - hưởng hoa hồng lâu dài. Hoa hồng 10% mỗi hợp đồng thuê xe từ khách do bạn giới thiệu.">
<meta property="og:image" content="{{ asset('assets/banner-kiemtien/banner-hoahong.webp') }}">
<meta property="og:image:width" content="1672">
<meta property="og:image:height" content="941">
<meta property="og:image:type" content="image/webp">
<meta property="og:image:alt" content="Thuê Xe Buôn Hồ - Đối tác giới thiệu">
<meta property="og:url" content="{{ url()->current() }}">
<meta property="og:type" content="website">
<meta property="og:site_name" content="Thuê Xe Buôn Hồ">
<meta property="og:locale" content="vi_VN">
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="Đối tác giới thiệu - Thuê Xe Buôn Hồ">
<meta name="twitter:description" content="Giới thiệu khách thuê xe, nhận hoa hồng 10% mỗi hợp đồng. Khách của bạn - hoa hồng của bạn.">
<meta name="twitter:image" content="{{ asset('assets/banner-kiemtien/banner-hoahong.webp') }}">
@endsection

@php
    $sitePhone = \App\Models\Setting::get('site_phone', '0964918047');
    $sitePhoneDisplay = preg_replace('/(\d{4})(\d{3})(\d{3,})/', '$1.$2.$3', $sitePhone) ?: $sitePhone;
    $siteAddress = \App\Models\Setting::get('site_address', '07 Chu Van An, Buon Ho, Dak Lak');
    $siteZaloUrl = 'https://zalo.me/' . preg_replace('/\D+/', '', $sitePhone);
    $siteFacebook = \App\Models\Setting::get('site_facebook', 'https://www.facebook.com/9999NDT/');

    $faqs = [
        [
            'q' => 'Làm cộng tác viên có mất phí không?',
            'a' => 'Hoàn toàn miễn phí. Bạn chỉ cần đăng ký, được duyệt và nhận mã giới thiệu. Cửa hàng lo toàn bộ xe, thủ tục và hợp đồng với khách.',
        ],
        [
            'q' => 'Hoa hồng 10% được tính trên khoản nào?',
            'a' => 'Hoa hồng được tính trên tổng tiền thuê xe của hợp đồng, không bao gồm tiền cọc và các khoản phí phát sinh ngoài tiền thuê.',
        ],
        [
            'q' => 'Khi nào tôi được ghi nhận hoa hồng?',
            'a' => 'Hoa hồng được ghi nhận khi hợp đồng chuyển sang trạng thái “Đã trả xe”. Cửa hàng đối soát và chuyển khoản trong 3–5 ngày làm việc.',
        ],
        [
            'q' => 'Khách tự liên hệ lại cửa hàng thì sao?',
            'a' => 'Khách đã được ghi nhận là của bạn sẽ giữ nguyên nguồn theo số điện thoại/CCCD. Mọi lần thuê sau, kể cả khi khách tự gọi lại, vẫn tính hoa hồng cho bạn.',
        ],
        [
            'q' => 'Tôi cần thông báo khách trước hay sau khi khách thuê?',
            'a' => 'Bạn cần thông báo tên và số điện thoại khách trước khi khách ký hợp đồng để cửa hàng ghi nhận nguồn. Trường hợp trùng nguồn, bản ghi xác nhận đầu tiên được ưu tiên.',
        ],
        [
            'q' => 'Có giới hạn số khách hoặc số hợp đồng không?',
            'a' => 'Không giới hạn. Bạn có thể giới thiệu nhiều khách, nhiều hợp đồng và hưởng hoa hồng trên từng hợp đồng hoàn tất.',
        ],
        [
            'q' => 'Tôi nhận hoa hồng bằng cách nào?',
            'a' => 'Cửa hàng chuyển khoản theo thông tin ngân hàng bạn cung cấp khi đăng ký, hoặc trao đổi trực tiếp qua Zalo. Bạn có thể bổ sung thông tin tài khoản bất cứ lúc nào.',
        ],
        [
            'q' => 'Trường hợp nào không được tính hoa hồng?',
            'a' => 'Hợp đồng bị hủy, khách không hoàn tất thuê, khách đã thuộc nguồn của cộng tác viên khác trước đó, hoặc phát hiện gian lận/tạo khách ảo.',
        ],
    ];
@endphp

@section('content-desktop')
@include('partials.kiem-tien-content', ['v' => 'd'])
@endsection

@section('content-mobile')
@include('partials.kiem-tien-content', ['v' => 'm'])
@endsection

@push('modals')
<script>
document.addEventListener('DOMContentLoaded', function () {
    function moneyDigits(value) {
        return String(value || '').replace(/\D/g, '');
    }

    function formatMoney(digits) {
        return digits ? digits.replace(/\B(?=(\d{3})+(?!\d))/g, '.') : '';
    }

    // Máy tính hoa hồng 10%
    document.querySelectorAll('[data-referral-calc]').forEach(function (box) {
        var input = box.querySelector('.js-calc-input');
        var output = box.querySelector('.js-calc-output');
        if (!input || !output) return;

        function update() {
            var digits = moneyDigits(input.value);
            input.value = formatMoney(digits);
            var total = parseInt(digits || '0', 10) || 0;
            var amount = Math.round(total / 10);
            output.textContent = formatMoney(String(amount)) + 'đ';
        }

        input.addEventListener('input', update);
        update();
    });

    // Cuộn tới đúng khối trên cả desktop và khung cuộn mobile
    document.querySelectorAll('a[href^="#"]').forEach(function (link) {
        link.addEventListener('click', function (e) {
            var id = link.getAttribute('href');
            if (!id || id === '#') return;
            var target = document.querySelector(id);
            if (!target) return;
            e.preventDefault();
            target.scrollIntoView({ behavior: 'smooth', block: 'start' });
            if (history.replaceState) {
                history.replaceState(null, '', id);
            }
        });
    });

    // Khóa nút gửi để tránh gửi trùng; chỉ khóa khi form hợp lệ
    document.querySelectorAll('[data-referral-form]').forEach(function (form) {
        form.addEventListener('submit', function () {
            if (!form.checkValidity()) return;
            var button = form.querySelector('button[type="submit"]');
            if (!button) return;
            button.disabled = true;
            button.classList.add('opacity-70', 'cursor-not-allowed');
            button.innerHTML = 'Đang gửi đăng ký...';
        });
    });

    // Cuộn tới thông báo thành công đang hiển thị (desktop hoặc mobile)
    var success = Array.prototype.find.call(
        document.querySelectorAll('[data-referral-success]'),
        function (el) { return el.offsetWidth > 0 || el.offsetHeight > 0; }
    );
    if (success) {
        setTimeout(function () {
            success.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }, 120);
    }
});
</script>
@endpush
