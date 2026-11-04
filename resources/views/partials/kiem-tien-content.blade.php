@php
    $isMobile = $v === 'm';
    $sectionPad = $isMobile ? 'px-2' : 'px-6';
    $commission = 10;
    $examples = [
        ['label' => 'Hợp đồng 2.000.000đ', 'total' => 2000000],
        ['label' => 'Hợp đồng 5.000.000đ', 'total' => 5000000],
        ['label' => 'Hợp đồng 10.000.000đ', 'total' => 10000000],
    ];
@endphp

{{-- MARQUEE --}}
<div class="htx-marquee">
    <div class="htx-marquee-track" style="animation-duration: 15s;">
        <span class="htx-marquee-item">🎁 Không cần xe, không cần vốn! Chỉ cần tìm kiếm khách thuê xe và giới thiệu cho chúng tôi. Chi tiết liên hệ Zalo!  <span class="htx-marquee-sep">★</span></span>
        <span class="htx-marquee-item">🎁 Không cần xe, không cần vốn! Chỉ cần tìm kiếm khách thuê xe và giới thiệu cho chúng tôi. Chi tiết liên hệ Zalo!  <span class="htx-marquee-sep">★</span></span>
    </div>
</div>

{{-- HERO --}}
<section class="relative overflow-hidden">
    <div class="mx-auto max-w-5xl {{ $sectionPad }} {{ $isMobile ? 'pb-1 pt-1' : 'pb-4 pt-2' }}">
        @if(true)
            <a href="{{ $siteZaloUrl }}" target="_blank" rel="noopener" class="mb-1 block overflow-hidden rounded-2xl bg-[#f5f5f4] {{ $isMobile ? '' : 'mx-auto max-w-2xl' }}">
                <img src="{{ asset('assets/banner-kiemtien/banner-section1.webp') }}" alt="Chương trình đối tác giới thiệu" class="h-auto w-full object-cover" loading="lazy">
            </a>
        @endif
        @if(false)
        <p class="text-[11px] font-extrabold uppercase tracking-[0.22em] text-app-accent">Chương trình đối tác giới thiệu</p>

        <h1 class="mt-4 {{ $isMobile ? 'text-2xl' : 'text-3xl' }} font-extrabold leading-[1.05] text-app-ink md:text-6xl">
            Giới thiệu khách,<br>
            <span class="text-app-accent">nhận 10% mỗi hợp đồng.</span>
        </h1>

        <p class="mt-5 max-w-2xl text-base font-medium leading-7 text-app-muted md:text-lg">
            Đơn giản: bạn giới thiệu khách thuê xe, cửa hàng lo toàn bộ xe và thủ tục.
            Mỗi hợp đồng hoàn tất, bạn nhận 10% hoa hồng. Khách của bạn được giữ nguyên nguồn cho mọi lần thuê sau.
        </p>

        <div class="mt-7 flex flex-wrap items-center gap-3">
            <span class="text-6xl font-extrabold leading-none text-app-ink md:text-7xl">10%</span>
            <span class="max-w-[14rem] text-sm font-semibold leading-6 text-app-muted">
                hoa hồng trên tổng tiền thuê của mỗi hợp đồng từ khách bạn giới thiệu.
            </span>
        </div>

        @if($referrer)
            <p class="mt-6 text-sm font-medium text-app-muted">
                Bạn được giới thiệu bởi
                <span class="font-bold text-app-ink">{{ $referrer->name }}</span>
                ({{ $referrer->code }}).
            </p>
        @endif

        <div class="mt-8 flex flex-col gap-3 sm:flex-row">
            <a href="#dang-ky-{{ $v }}" class="inline-flex items-center justify-center gap-2 bg-app-ink px-6 py-3 text-sm font-bold text-white transition-colors hover:bg-app-accent {{ $isMobile ? 'w-full' : '' }}">
                Đăng ký làm cộng tác viên
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="h-4 w-4"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3"/></svg>
            </a>
            <a href="#tinh-hoa-hong-{{ $v }}" class="inline-flex items-center justify-center gap-2 border border-app-line px-6 py-3 text-sm font-bold text-app-ink transition-colors hover:border-app-ink {{ $isMobile ? 'w-full' : '' }}">
                Tính hoa hồng
            </a>
        </div>
        @endif
    </div>
</section>

<div class="mx-auto max-w-5xl {{ $sectionPad }} py-1">
    <div class="mb-1 overflow-hidden rounded-2xl bg-[#f5f5f4] {{ $isMobile ? '' : 'mx-auto max-w-2xl' }}">
        <img src="{{ asset('assets/banner-kiemtien/banner-section1.5.webp') }}" alt="Đối tác giới thiệu" class="h-auto w-full object-cover" loading="lazy">
    </div>
</div>

<div class="mx-auto max-w-4xl {{ $sectionPad }} {{ $isMobile ? 'pb-8' : 'pb-6' }}">

    {{-- ĐIỂM CỐT LÕI --}}
    <section class=" {{ $isMobile ? 'py-1' : 'py-1' }}">
        @if(true)
            <div class="mb-1 overflow-hidden rounded-2xl bg-[#f5f5f4] {{ $isMobile ? '' : 'mx-auto max-w-2xl' }}">
                <img src="{{ asset('assets/banner-kiemtien/banner-section2.webp') }}" alt="Điểm cốt lõi" class="h-auto w-full object-cover" loading="lazy">
            </div>
        @endif
        @if(false)
        <div class="grid grid-cols-1 gap-8 md:grid-cols-3">
            <div>
                <p class="text-[11px] font-extrabold uppercase tracking-[0.18em] text-app-muted">01</p>
                <h3 class="mt-2 text-lg font-extrabold text-app-ink">Không cần bỏ vốn</h3>
                <p class="mt-2 text-sm font-medium leading-6 text-app-muted">Chỉ giới thiệu khách có nhu cầu. Xe, thủ tục và hợp đồng do cửa hàng lo.</p>
            </div>
            <div>
                <p class="text-[11px] font-extrabold uppercase tracking-[0.18em] text-app-muted">02</p>
                <h3 class="mt-2 text-lg font-extrabold text-app-ink">Hoa hồng 10%</h3>
                <p class="mt-2 text-sm font-medium leading-6 text-app-muted">Trên mỗi hợp đồng từ khách bạn giới thiệu, tính theo tổng tiền thuê xe.</p>
            </div>
            <div>
                <p class="text-[11px] font-extrabold uppercase tracking-[0.18em] text-app-muted">03</p>
                <h3 class="mt-2 text-lg font-extrabold text-app-ink">Khách thuê lại vẫn tính</h3>
                <p class="mt-2 text-sm font-medium leading-6 text-app-muted">Nguồn khách được khóa theo SĐT/CCCD, giữ cho mọi lần thuê sau.</p>
            </div>
        </div>
        @endif
    </section>

    {{-- CÁCH HOẠT ĐỘNG --}}
    <section class=" {{ $isMobile ? 'py-1' : 'py-1' }}">
        @if(true)
            <div class="mb-1 overflow-hidden rounded-2xl bg-[#f5f5f4] {{ $isMobile ? '' : 'mx-auto max-w-2xl' }}">
                <img src="{{ asset('assets/banner-kiemtien/banner-section3.webp') }}" alt="Cách hoạt động" class="h-auto w-full object-cover" loading="lazy">
            </div>
        @endif
        @if(false)
        <h2 class="text-2xl font-extrabold text-app-ink">Cách hoạt động</h2>
        <ol class="mt-6 space-y-5">
            <li class="flex gap-4">
                <span class="w-8 shrink-0 text-2xl font-extrabold text-app-accent">1.</span>
                <div>
                    <p class="font-bold text-app-ink">Đăng ký</p>
                    <p class="mt-1 text-sm font-medium leading-6 text-app-muted">Điền form bên dưới. Admin liên hệ Zalo xác nhận và cấp mã giới thiệu.</p>
                </div>
            </li>
            <li class="flex gap-4">
                <span class="w-8 shrink-0 text-2xl font-extrabold text-app-accent">2.</span>
                <div>
                    <p class="font-bold text-app-ink">Giới thiệu khách</p>
                    <p class="mt-1 text-sm font-medium leading-6 text-app-muted">Báo tên và số điện thoại khách trước khi khách ký hợp đồng.</p>
                </div>
            </li>
            <li class="flex gap-4">
                <span class="w-8 shrink-0 text-2xl font-extrabold text-app-accent">3.</span>
                <div>
                    <p class="font-bold text-app-ink">Nhận 10%</p>
                    <p class="mt-1 text-sm font-medium leading-6 text-app-muted">Hợp đồng hoàn tất, hoa hồng được ghi nhận và chuyển khoản trong 3–5 ngày làm việc.</p>
                </div>
            </li>
        </ol>
        @endif
    </section>

    {{-- FORM --}}
    <section id="dang-ky-{{ $v }}" class=" {{ $isMobile ? 'py-1' : 'py-1' }} scroll-mt-24">
        @if(true)
            <div class="mb-1 overflow-hidden rounded-2xl bg-[#f5f5f4] {{ $isMobile ? '' : 'mx-auto max-w-2xl' }}">
                <img src="{{ asset('assets/banner-kiemtien/banner-section4.webp') }}" alt="Đăng ký cộng tác viên" class="h-auto w-full object-cover" loading="lazy">
            </div>
        @endif
        @if(false)
        <h2 class="text-2xl font-extrabold text-app-ink">Đăng ký cộng tác viên</h2>
        <p class="mt-2 text-sm font-medium leading-6 text-app-muted">Điền thông tin. Admin sẽ liên hệ Zalo để xác nhận và cấp mã giới thiệu.</p>

        @if(session('referral_success'))
            <div class="mt-6 border-l-2 border-green-600 pl-4" data-referral-success>
                <p class="text-sm font-bold text-green-800">Đăng ký thành công!</p>
                <p class="mt-1 text-[13px] font-medium leading-5 text-green-700">
                    Thông tin đã được lưu. Nhắn Zalo cho cửa hàng để được duyệt nhanh.
                </p>
                <a href="{{ $siteZaloUrl }}" target="_blank" rel="noopener" class="mt-2 inline-flex items-center gap-1.5 text-sm font-bold text-[#0068ff] hover:underline">
                    Nhắn Zalo ngay
                </a>
            </div>
        @endif

        @if($errors->any())
            <div class="mt-6 border-l-2 border-red-500 pl-4">
                <p class="text-sm font-bold text-red-700">Vui lòng kiểm tra lại thông tin:</p>
                <ul class="mt-2 list-disc space-y-1 pl-5 text-[13px] font-medium text-red-600">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('kiem-tien.register') }}" method="POST" class="mt-8 space-y-5" data-referral-form>
            @csrf
            <input type="hidden" name="ref_code" value="{{ old('ref_code', $refCode) }}">
            <div class="hidden" aria-hidden="true">
                <label>Website<input type="text" name="website" tabindex="-1" autocomplete="off"></label>
            </div>

            <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
                <div>
                    <label class="text-[12px] font-bold text-app-ink">Họ và tên <span class="text-red-500">*</span></label>
                    <input type="text" name="name" value="{{ old('name') }}" required maxlength="255"
                           class="mt-1.5 w-full border-b border-app-line bg-transparent px-0 py-2 text-sm font-medium text-app-ink outline-none transition-colors placeholder:text-app-muted/60 focus:border-app-ink @error('name') border-red-400 @enderror"
                           placeholder="Nguyễn Văn A">
                    @error('name') <p class="mt-1 text-xs font-medium text-red-500">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="text-[12px] font-bold text-app-ink">Số điện thoại <span class="text-red-500">*</span></label>
                    <input type="tel" name="phone" value="{{ old('phone') }}" required inputmode="numeric" maxlength="10" pattern="0[0-9]{9}"
                           class="mt-1.5 w-full border-b border-app-line bg-transparent px-0 py-2 text-sm font-medium text-app-ink outline-none transition-colors placeholder:text-app-muted/60 focus:border-app-ink @error('phone') border-red-400 @enderror"
                           placeholder="0964918047">
                    @error('phone') <p class="mt-1 text-xs font-medium text-red-500">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="text-[12px] font-bold text-app-ink">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" maxlength="255"
                           class="mt-1.5 w-full border-b border-app-line bg-transparent px-0 py-2 text-sm font-medium text-app-ink outline-none transition-colors placeholder:text-app-muted/60 focus:border-app-ink @error('email') border-red-400 @enderror"
                           placeholder="email@example.com">
                    @error('email') <p class="mt-1 text-xs font-medium text-red-500">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="text-[12px] font-bold text-app-ink">Địa chỉ / khu vực</label>
                    <input type="text" name="address" value="{{ old('address') }}" maxlength="255"
                           class="mt-1.5 w-full border-b border-app-line bg-transparent px-0 py-2 text-sm font-medium text-app-ink outline-none transition-colors placeholder:text-app-muted/60 focus:border-app-ink @error('address') border-red-400 @enderror"
                           placeholder="Buôn Hồ, Đăk Lăk">
                    @error('address') <p class="mt-1 text-xs font-medium text-red-500">{{ $message }}</p> @enderror
                </div>
            </div>

            <details class=" pt-4">
                <summary class="cursor-pointer text-sm font-bold text-app-ink">Thông tin nhận hoa hồng (không bắt buộc)</summary>
                <div class="mt-4 grid grid-cols-1 gap-5 md:grid-cols-3">
                    <div>
                        <label class="text-[11px] font-bold text-app-muted">Ngân hàng</label>
                        <input type="text" name="bank_name" value="{{ old('bank_name') }}" maxlength="255"
                               class="mt-1.5 w-full border-b border-app-line bg-transparent px-0 py-2 text-sm font-medium text-app-ink outline-none focus:border-app-ink"
                               placeholder="VD: BIDV">
                    </div>
                    <div>
                        <label class="text-[11px] font-bold text-app-muted">Số tài khoản</label>
                        <input type="text" name="bank_account" value="{{ old('bank_account') }}" maxlength="50"
                               class="mt-1.5 w-full border-b border-app-line bg-transparent px-0 py-2 text-sm font-medium text-app-ink outline-none focus:border-app-ink"
                               placeholder="Số tài khoản">
                    </div>
                    <div>
                        <label class="text-[11px] font-bold text-app-muted">Chủ tài khoản</label>
                        <input type="text" name="bank_owner" value="{{ old('bank_owner') }}" maxlength="255"
                               class="mt-1.5 w-full border-b border-app-line bg-transparent px-0 py-2 text-sm font-medium text-app-ink outline-none focus:border-app-ink"
                               placeholder="Họ tên chủ tài khoản">
                    </div>
                </div>
            </details>

            <div>
                <label class="text-[12px] font-bold text-app-ink">Kinh nghiệm / khu vực / kênh giới thiệu</label>
                <textarea name="note" rows="3" maxlength="1000"
                          class="mt-1.5 w-full border-b border-app-line bg-transparent px-0 py-2 text-sm font-medium text-app-ink outline-none transition-colors placeholder:text-app-muted/60 focus:border-app-ink @error('note') border-red-400 @enderror"
                          placeholder="Ví dụ: chạy xe, khách sạn, quán ăn, nhiều khách du lịch...">{{ old('note') }}</textarea>
                @error('note') <p class="mt-1 text-xs font-medium text-red-500">{{ $message }}</p> @enderror
            </div>

            <label class="flex items-start gap-2.5 pt-2">
                <input type="checkbox" name="agree" value="1" {{ old('agree') ? 'checked' : '' }} required class="mt-1 h-4 w-4 shrink-0 accent-app-accent">
                <span class="text-[12px] font-medium leading-5 text-app-muted">
                    Tôi đồng ý với chính sách cộng tác viên và mức hoa hồng 10% của Thuê Xe Buôn Hồ.
                </span>
            </label>
            @error('agree') <p class="text-xs font-medium text-red-500">{{ $message }}</p> @enderror

            <button type="submit" class="inline-flex items-center justify-center gap-2 bg-app-ink px-6 py-3 text-sm font-bold text-white transition-colors hover:bg-app-accent {{ $isMobile ? 'w-full' : '' }}">
                Gửi đăng ký
            </button>
            <p class="text-[11px] font-medium leading-5 text-app-muted">
                Sau khi gửi, admin sẽ liên hệ Zalo để xác nhận.
            </p>
        </form>
        @endif
    </section>

    {{-- MÁY TÍNH --}}
    <section id="tinh-hoa-hong-{{ $v }}" class=" {{ $isMobile ? 'py-1' : 'py-1' }} scroll-mt-24">
        @if(true)
            <a href="{{ $siteZaloUrl }}" target="_blank" rel="noopener" class="mb-1 block overflow-hidden rounded-2xl bg-[#f5f5f4] {{ $isMobile ? '' : 'mx-auto max-w-2xl' }}">
                <img src="{{ asset('assets/banner-kiemtien/banner-section5.webp') }}" alt="Tính hoa hồng" class="h-auto w-full object-cover" loading="lazy">
            </a>
        @endif
        @if(false)
        <h2 class="text-2xl font-extrabold text-app-ink">Tính hoa hồng 10%</h2>
        <p class="mt-2 text-sm font-medium leading-6 text-app-muted">Nhập tổng tiền thuê (không gồm cọc) để xem hoa hồng dự kiến.</p>

        <div class="mt-6" data-referral-calc>
            <label for="calc-input-{{ $v }}" class="text-[11px] font-bold uppercase tracking-wider text-app-muted">Tổng tiền thuê (đ)</label>
            <input id="calc-input-{{ $v }}" type="text" inputmode="numeric" autocomplete="off"
                   class="js-calc-input mt-2 w-full border-b border-app-line bg-transparent px-0 py-3 text-2xl font-extrabold text-app-ink placeholder:text-app-muted/40 outline-none focus:border-app-ink"
                   placeholder="VD: 6.000.000">
            <div class="mt-4 flex items-end justify-between  pt-4">
                <div>
                    <p class="text-[11px] font-bold uppercase tracking-wider text-app-muted">Hoa hồng dự kiến</p>
                    <p class="js-calc-output mt-1 text-3xl font-extrabold text-app-accent">0đ</p>
                </div>
                <span class="text-sm font-bold text-app-muted">10%</span>
            </div>
        </div>

        <div class="mt-8 overflow-x-auto ">
            <table class="w-full border-collapse text-left">
                <thead>
                    <tr class="border-b border-app-line">
                        <th class="py-3 text-[11px] font-bold uppercase tracking-wide text-app-muted">Hợp đồng</th>
                        <th class="py-3 text-right text-[11px] font-bold uppercase tracking-wide text-app-muted">Hoa hồng 10%</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($examples as $example)
                        <tr class="border-b border-app-line">
                            <td class="py-3 text-sm font-medium text-app-ink">{{ $example['label'] }}</td>
                            <td class="py-3 text-right text-sm font-extrabold text-app-accent">{{ number_format($example['total'] * $commission / 100, 0, ',', '.') }}đ</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif
    </section>

    {{-- LIÊN HỆ --}}
    <section class=" {{ $isMobile ? 'py-1' : 'py-1' }}">
        @if(true)
            <div class="mb-1 overflow-hidden rounded-2xl bg-[#f5f5f4] {{ $isMobile ? '' : 'mx-auto max-w-2xl' }}">
                <img src="{{ asset('assets/banner-kiemtien/banner-section6.webp') }}" alt="Liên hệ xác nhận" class="h-auto w-full object-cover" loading="lazy">
            </div>
        @endif
        @if(false)
        <h2 class="text-2xl font-extrabold text-app-ink">Liên hệ xác nhận</h2>
        <p class="mt-2 text-sm font-medium leading-6 text-app-muted">Duyệt cộng tác viên, cấp mã giới thiệu và đối soát hoa hồng qua Zalo/hotline chính thức.</p>

        <div class="mt-6 divide-y divide-app-line ">
            <a href="tel:{{ $sitePhone }}" class="flex items-center justify-between gap-3 py-4 transition-colors hover:text-app-accent">
                <span>
                    <span class="block text-[11px] font-bold uppercase tracking-wider text-app-muted">Hotline</span>
                    <span class="block text-base font-extrabold text-app-ink">{{ $sitePhoneDisplay }}</span>
                </span>
                <span class="text-sm font-bold text-app-muted">Gọi</span>
            </a>
            <a href="{{ $siteZaloUrl }}" target="_blank" rel="noopener" class="flex items-center justify-between gap-3 py-4 transition-colors hover:text-app-accent">
                <span>
                    <span class="block text-[11px] font-bold uppercase tracking-wider text-app-muted">Zalo chính thức</span>
                    <span class="block text-base font-extrabold text-app-ink">Nhắn Zalo để được duyệt</span>
                </span>
                <span class="text-sm font-bold text-app-muted">Mở</span>
            </a>
        </div>
        @endif
    </section>

    {{-- FAQ --}}
    <section class="py-1">
        <div class="w-full max-w-5xl">
                         <h2 class="text-2xl font-semibold text-neutral-900 text-center md:text-start pt-6 mb-2">CÂU HỎI THƯỜNG GẶP CTV</h2>


         


      

            <div id="faqs-{{ $v }}" class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-2">
                @foreach([
    ['q' => 'Làm cộng tác viên có mất phí không?', 'a' => 'Hoàn toàn miễn phí. Cửa hàng lo xe, thủ tục và hợp đồng.'],
    ['q' => 'Hoa hồng tính trên khoản nào?', 'a' => 'Tổng tiền thuê xe, không gồm cọc và phí phát sinh.'],
    ['q' => 'Khi nào được ghi nhận hoa hồng?', 'a' => 'Khi hợp đồng chuyển sang “Đã trả xe”.'],
    ['q' => 'Khách tự liên hệ lại cửa hàng thì sao?', 'a' => 'Khách đã ghi nhận cho bạn giữ nguyên nguồn, mọi lần thuê sau vẫn tính hoa hồng cho bạn.'],
                      ['q' => 'Tôi nhận hoa hồng bằng cách nào?', 'a' => 'Cửa hàng chuyển khoản theo thông tin ngân hàng bạn trao đổi trực tiếp qua Zalo.'],
    ['q' => 'Có giới hạn số khách hoặc số hợp đồng không?', 'a' => 'Không giới hạn. Bạn có thể giới thiệu nhiều khách, nhiều hợp đồng và hưởng hoa hồng trên từng hợp đồng hoàn tất.'],
 ] as $faqIndex => $faq)
                    <div class="bg-slate-50 p-3.5 rounded-lg cursor-pointer transition-all duration-300 border border-slate-200 hover:bg-slate-100 faq-item-{{ $v }}" data-index="{{ $faqIndex }}">
                        <div class="flex items-center justify-between">
                            <span class="text-base font-medium text-neutral-800">{{ $faq['q'] }}</span>
                            <div class="text-slate-400 p-1 rounded transition-colors icon-{{ $v }}">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="M12 5v14"/></svg>
                            </div>
                        </div>
                        <div class="grid grid-rows-[0fr] opacity-0 transition-all duration-300 answer-{{ $v }}">
                            <div class="overflow-hidden">
                                <p class="text-base text-neutral-600 leading-relaxed mt-4">{{ $faq['a'] }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <script>
        (function () {
            const container = document.getElementById('faqs-{{ $v }}');
            if (!container) return;
            let openIndex = null;
            container.querySelectorAll('.faq-item-{{ $v }}').forEach((item) => {
                item.addEventListener('click', () => {
                    const i = item.dataset.index;
                    const answer = item.querySelector('.answer-{{ $v }}');
                    const icon = item.querySelector('.icon-{{ $v }}');
                    if (openIndex === i) {
                        answer.classList.remove('grid-rows-[1fr]', 'opacity-100');
                        answer.classList.add('grid-rows-[0fr]', 'opacity-0');
                        icon.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="M12 5v14"/></svg>';
                        icon.classList.remove('bg-slate-200', 'text-slate-500');
                        item.classList.remove('row-span-2');
                        openIndex = null;
                    } else {
                        if (openIndex !== null) {
                            const prev = container.querySelector(`[data-index="${openIndex}"]`);
                            if (prev) {
                                const prevAnswer = prev.querySelector('.answer-{{ $v }}');
                                const prevIcon = prev.querySelector('.icon-{{ $v }}');
                                prevAnswer.classList.remove('grid-rows-[1fr]', 'opacity-100');
                                prevAnswer.classList.add('grid-rows-[0fr]', 'opacity-0');
                                prevIcon.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="M12 5v14"/></svg>';
                                prevIcon.classList.remove('bg-slate-200', 'text-slate-500');
                                prev.classList.remove('row-span-2');
                            }
                        }
                        answer.classList.add('grid-rows-[1fr]', 'opacity-100');
                        answer.classList.remove('grid-rows-[0fr]', 'opacity-0');
                        icon.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/></svg>';
                        icon.classList.add('bg-slate-200', 'text-slate-500');
                        item.classList.add('row-span-2');
                        openIndex = i;

                        if ('{{ $v }}' === 'm') {
                            // Chờ câu trả lời mở xong rồi cuộn lên khỏi bottom nav cố định.
                            window.setTimeout(() => {
                                const scrollContainer = document.getElementById('mobile-content');
                                const bottomNav = document.getElementById('bottom-nav')?.parentElement;
                                if (!scrollContainer || !bottomNav) return;

                                const itemBottom = item.getBoundingClientRect().bottom;
                                const visibleBottom = bottomNav.getBoundingClientRect().top - 12;
                                const overflow = itemBottom - visibleBottom;

                                if (overflow > 0) {
                                    scrollContainer.scrollBy({ top: overflow, behavior: 'smooth' });
                                }
                            }, 320);
                        }
                    }
                });
            });
        })();
    </script>
</div>
