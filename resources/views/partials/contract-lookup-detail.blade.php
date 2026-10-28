@php
    $statusClasses = [
        'pending' => 'bg-amber-100 text-amber-700',
        'active' => 'bg-sky-100 text-sky-700',
        'returned' => 'bg-emerald-100 text-emerald-700',
        'cancelled' => 'bg-rose-100 text-rose-700',
    ];
    $statusClass = $statusClasses[$contract->status] ?? 'bg-stone-100 text-stone-600';

    $carMedia = $contract->images
        ->whereIn('category', ['car_before', 'car_video'])
        ->values();
    $imageExts = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
@endphp

<div class="space-y-4">

    @if(session('contract_lookup.' . $contract->id))
        <div class="no-print">
            <a href="{{ route('contract.lookup.html', $contract) }}" target="_blank" class="flex w-full items-center justify-center gap-2 rounded-md bg-[#195cc2] px-4 py-2.5 text-[13.5px] font-extrabold text-white hover:bg-[#164fa6] active:scale-[0.97] transition">
                <i class="ri-file-text-line text-base"></i>
                Xem hợp đồng
            </a>
        </div>
    @endif

    {{-- Trạng thái --}}
    <div class="print-block flex items-center justify-between gap-3 rounded-md border border-app-line bg-white px-4 py-3 shadow-card sm:px-5">
        <div>
            <p class="text-[11.5px] font-bold uppercase tracking-wide text-app-muted">Mã hợp đồng</p>
            <p class="text-[17px] font-extrabold text-[#052c61]">{{ $contract->contract_code }}</p>
        </div>
        <span class="rounded-full px-3 py-1 text-[12px] font-extrabold {{ $statusClass }}">{{ $contract->status_label }}</span>
    </div>

    <div class="grid gap-4 sm:grid-cols-2">

        {{-- Thông tin hợp đồng --}}
        <div class="print-block rounded-md border border-app-line bg-white p-4 shadow-card sm:p-5">
            <h3 class="mb-3 text-[12.5px] font-extrabold uppercase tracking-wide text-[#0b296c]">Thông tin hợp đồng</h3>
            <div class="space-y-2 text-[13px]">
                <div class="flex justify-between gap-3 border-b border-app-line pb-2">
                    <span class="text-app-muted">Ngày tạo</span>
                    <span class="text-right font-bold text-app-ink">{{ $contract->contract_date ? $contract->contract_date->format('d/m/Y H:i') : '-' }}</span>
                </div>
                <div class="flex justify-between gap-3">
                    <span class="text-app-muted">Chi nhánh / Địa điểm thuê</span>
                    <span class="text-right font-bold text-app-ink">{{ $contract->branch ?: '-' }}</span>
                </div>
            </div>
        </div>

        {{-- Thông tin khách hàng --}}
        <div class="print-block rounded-md border border-app-line bg-white p-4 shadow-card sm:p-5">
            <h3 class="mb-3 text-[12.5px] font-extrabold uppercase tracking-wide text-[#0b296c]">Thông tin khách hàng</h3>
            <div class="space-y-2 text-[13px]">
                <div class="flex justify-between gap-3 border-b border-app-line pb-2">
                    <span class="text-app-muted">Họ và tên</span>
                    <span class="text-right font-bold text-app-ink">{{ $contract->customer_name ?: '-' }}</span>
                </div>
                <div class="flex justify-between gap-3 border-b border-app-line pb-2">
                    <span class="text-app-muted">Số CCCD</span>
                    <span class="text-right font-bold text-app-ink">{{ $contract->masked_cccd ?: '-' }}</span>
                </div>
                <div class="flex justify-between gap-3 border-b border-app-line pb-2">
                    <span class="text-app-muted">Số điện thoại</span>
                    <span class="text-right font-bold text-app-ink">{{ $contract->masked_phone ?: '-' }}</span>
                </div>
                <div class="flex justify-between gap-3 border-b border-app-line pb-2">
                    <span class="text-app-muted">Ngày sinh</span>
                    <span class="text-right font-bold text-app-ink">{{ $contract->dob ? $contract->dob->format('d/m/Y') : '-' }}</span>
                </div>
                <div class="flex justify-between gap-3 border-b border-app-line pb-2">
                    <span class="text-app-muted">Giới tính</span>
                    <span class="text-right font-bold text-app-ink">{{ $contract->gender ?: '-' }}</span>
                </div>
                <div class="flex justify-between gap-3 border-b border-app-line pb-2">
                    <span class="text-app-muted">Ngày cấp CCCD</span>
                    <span class="text-right font-bold text-app-ink">{{ $contract->cccd_issue_date ? $contract->cccd_issue_date->format('d/m/Y') : '-' }}</span>
                </div>
                <div class="flex justify-between gap-3 border-b border-app-line pb-2">
                    <span class="text-app-muted">Nơi cấp CCCD</span>
                    <span class="text-right font-bold text-app-ink">{{ $contract->cccd_issue_place ?: '-' }}</span>
                </div>
                <div class="flex justify-between gap-3 border-b border-app-line pb-2">
                    <span class="text-app-muted">Địa chỉ</span>
                    <span class="text-right font-bold text-app-ink">{{ $contract->customer_address ?: '-' }}</span>
                </div>
                <div class="flex justify-between gap-3 border-b border-app-line pb-2">
                    <span class="text-app-muted">Số bằng lái</span>
                    <span class="text-right font-bold text-app-ink">{{ $contract->driver_license_no ?: '-' }}</span>
                </div>
                <div class="flex justify-between gap-3 border-b border-app-line pb-2">
                    <span class="text-app-muted">Hạng bằng</span>
                    <span class="text-right font-bold text-app-ink">{{ $contract->license_class ?: '-' }}</span>
                </div>
                <div class="flex justify-between gap-3 border-b border-app-line pb-2">
                    <span class="text-app-muted">Ngày cấp bằng</span>
                    <span class="text-right font-bold text-app-ink">{{ $contract->license_issue_date ? $contract->license_issue_date->format('d/m/Y') : '-' }}</span>
                </div>
                <div class="flex justify-between gap-3">
                    <span class="text-app-muted">Ngày hết hạn bằng</span>
                    <span class="text-right font-bold text-app-ink">{{ $contract->license_expiry_date ? $contract->license_expiry_date->format('d/m/Y') : '-' }}</span>
                </div>
            </div>
        </div>

        {{-- Thông tin xe --}}
        <div class="print-block rounded-md border border-app-line bg-white p-4 shadow-card sm:p-5">
            <h3 class="mb-3 text-[12.5px] font-extrabold uppercase tracking-wide text-[#0b296c]">Thông tin xe</h3>
            <div class="space-y-2 text-[13px]">
                <div class="flex justify-between gap-3 border-b border-app-line pb-2">
                    <span class="text-app-muted">Tên xe</span>
                    <span class="text-right font-bold text-app-ink">{{ $contract->car_name ?: '-' }}</span>
                </div>
                <div class="flex justify-between gap-3 border-b border-app-line pb-2">
                    <span class="text-app-muted">Biển số</span>
                    <span class="text-right font-bold text-app-ink">{{ $contract->car_plate ?: '-' }}</span>
                </div>
                <div class="flex justify-between gap-3 border-b border-app-line pb-2">
                    <span class="text-app-muted">Số ghế</span>
                    <span class="text-right font-bold text-app-ink">{{ $contract->car_seats ?: '-' }}</span>
                </div>
                <div class="flex justify-between gap-3 border-b border-app-line pb-2">
                    <span class="text-app-muted">Hộp số</span>
                    <span class="text-right font-bold text-app-ink">{{ $contract->car_transmission ?: '-' }}</span>
                </div>
                <div class="flex justify-between gap-3 border-b border-app-line pb-2">
                    <span class="text-app-muted">Năm sản xuất</span>
                    <span class="text-right font-bold text-app-ink">{{ $contract->car_year ?: '-' }}</span>
                </div>
                <div class="flex justify-between gap-3">
                    <span class="text-app-muted">Nhiên liệu</span>
                    <span class="text-right font-bold text-app-ink">{{ $contract->car_fuel ?: '-' }}</span>
                </div>
            </div>
        </div>

        {{-- Thời gian thuê --}}
        <div class="print-block rounded-md border border-app-line bg-white p-4 shadow-card sm:p-5">
            <h3 class="mb-3 text-[12.5px] font-extrabold uppercase tracking-wide text-[#0b296c]">Thời gian thuê</h3>
            <div class="space-y-2 text-[13px]">
                <div class="flex justify-between gap-3 border-b border-app-line pb-2">
                    <span class="text-app-muted">Ngày giờ nhận xe</span>
                    <span class="text-right font-bold text-app-ink">{{ $contract->pickup_datetime ? $contract->pickup_datetime->format('d/m/Y H:i') : '-' }}</span>
                </div>
                <div class="flex justify-between gap-3 border-b border-app-line pb-2">
                    <span class="text-app-muted">Địa điểm nhận xe</span>
                    <span class="text-right font-bold text-app-ink">{{ $contract->pickup_location ?: '-' }}</span>
                </div>
                <div class="flex justify-between gap-3 border-b border-app-line pb-2">
                    <span class="text-app-muted">Ngày giờ trả xe</span>
                    <span class="text-right font-bold text-app-ink">{{ $contract->return_datetime ? $contract->return_datetime->format('d/m/Y H:i') : '-' }}</span>
                </div>
                <div class="flex justify-between gap-3 border-b border-app-line pb-2">
                    <span class="text-app-muted">Địa điểm trả xe</span>
                    <span class="text-right font-bold text-app-ink">{{ $contract->return_location ?: '-' }}</span>
                </div>
                <div class="flex justify-between gap-3 border-b border-app-line pb-2">
                    <span class="text-app-muted">Tổng số ngày thuê</span>
                    <span class="text-right font-bold text-app-ink">{{ $contract->total_days !== null ? $contract->total_days . ' ngày' : '-' }}</span>
                </div>
                <div class="flex justify-between gap-3 border-b border-app-line pb-2">
                    <span class="text-app-muted">Tổng số giờ thêm</span>
                    <span class="text-right font-bold text-app-ink">{{ $contract->total_hours !== null ? $contract->total_hours . ' giờ' : '-' }}</span>
                </div>
                <div class="flex justify-between gap-3">
                    <span class="text-app-muted">Giới hạn km</span>
                    <span class="text-right font-bold text-app-ink">{{ $contract->km_limit ? number_format($contract->km_limit) . ' km' : '-' }}</span>
                </div>
            </div>
        </div>

    </div>

    {{-- Cọc & tiền thuê --}}
    <div class="print-block rounded-md border border-app-line bg-white p-4 shadow-card sm:p-5">
        <h3 class="mb-3 text-[12.5px] font-extrabold uppercase tracking-wide text-[#0b296c]">Cọc &amp; tiền thuê</h3>
        <div class="grid gap-x-8 gap-y-2 text-[13px] sm:grid-cols-2">
            <div class="flex justify-between gap-3 border-b border-app-line pb-2">
                <span class="text-app-muted">Loại cọc</span>
                <span class="text-right font-bold text-app-ink">{{ $contract->deposit_type_label ?: 'Không cọc' }}</span>
            </div>
            <div class="flex justify-between gap-3 border-b border-app-line pb-2">
                <span class="text-app-muted">Số tiền cọc</span>
                <span class="text-right font-bold text-app-ink">{{ $contract->deposit_amount ? number_format($contract->deposit_amount, 0, ',', '.') . 'đ' : '-' }}</span>
            </div>
            <div class="flex justify-between gap-3 border-b border-app-line pb-2">
                <span class="text-app-muted">Ghi chú cọc</span>
                <span class="text-right font-bold text-app-ink">{{ $contract->deposit_note ?: '-' }}</span>
            </div>
            <div class="flex justify-between gap-3 border-b border-app-line pb-2">
                <span class="text-app-muted">Giá thuê 1 ngày</span>
                <span class="text-right font-bold text-app-ink">{{ $contract->daily_rate ? number_format($contract->daily_rate, 0, ',', '.') . 'đ' : '-' }}</span>
            </div>
            <div class="flex justify-between gap-3 border-b border-app-line pb-2">
                <span class="text-app-muted">Số ngày thuê</span>
                <span class="text-right font-bold text-app-ink">{{ $contract->rental_days ?: '-' }}</span>
            </div>
            <div class="flex justify-between gap-3 rounded-md bg-app-accentSoft px-3 py-2">
                <span class="font-bold text-app-ink">Tổng tiền thuê</span>
                <span class="text-right font-extrabold text-[#0b296c]">{{ $contract->total_rental_fee ? number_format($contract->total_rental_fee, 0, ',', '.') . 'đ' : '-' }}</span>
            </div>
        </div>
        @if($contract->notes)
            <div class="mt-4 rounded-md bg-[#FAFBFF] border border-app-line p-3 text-[13px]">
                <p class="font-bold text-app-ink">Ghi chú chung:</p>
                <p class="mt-1 whitespace-pre-line text-app-muted">{{ $contract->notes }}</p>
            </div>
        @endif
    </div>

    {{-- Hình ảnh / Video xe --}}
    @if($carMedia->isNotEmpty())
        <div class="print-block rounded-md border border-app-line bg-white p-4 shadow-card sm:p-5">
            <h3 class="mb-3 text-[12.5px] font-extrabold uppercase tracking-wide text-[#0b296c]">Hình ảnh / Video xe</h3>
            <div class="grid grid-cols-2 gap-3 sm:grid-cols-3">
                @foreach($carMedia as $media)
                    @php $ext = strtolower(pathinfo($media->path, PATHINFO_EXTENSION)); @endphp
                    @if(in_array($ext, $imageExts, true))
                        <button type="button" data-media-item data-type="image" data-src="{{ asset($media->path) }}" data-label="Hình ảnh xe" class="group relative block overflow-hidden rounded-md border border-app-line cursor-zoom-in">
                            <img src="{{ asset($media->path) }}" alt="Hình ảnh xe" loading="lazy" class="h-32 w-full object-cover transition duration-300 group-hover:scale-105">
                        </button>
                    @else
                        <button type="button" data-media-item data-type="video" data-src="{{ asset($media->path) }}" data-label="Video xe" class="group relative block overflow-hidden rounded-md border border-app-line bg-black cursor-pointer">
                            <video preload="metadata" muted playsinline class="pointer-events-none h-32 w-full object-cover opacity-80" src="{{ asset($media->path) }}"></video>
                            <span class="pointer-events-none absolute inset-0 flex items-center justify-center">
                                <span class="flex h-10 w-10 items-center justify-center rounded-full bg-black/55 text-white transition group-hover:bg-black/70">
                                    <i class="ri-play-fill text-2xl"></i>
                                </span>
                            </span>
                        </button>
                    @endif
                @endforeach
            </div>
        </div>
    @endif

</div>
