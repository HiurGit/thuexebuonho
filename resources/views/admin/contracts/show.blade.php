@extends('adminlte::page')

@section('title', 'Chi tiết hợp đồng ' . $contract->contract_code)

@section('css')
<style>
    .contract-values td { font-weight: 700; }
</style>
@stop

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>Chi tiết hợp đồng: {{ $contract->contract_code }}</h1>
        <div>
            <a href="{{ route('admin.contracts.html', $contract) }}" target="_blank" class="btn btn-success"><i class="fas fa-file-contract mr-1"></i> Xem hợp đồng</a>
            <button class="btn btn-info btn-copy-link" data-url="{{ route('contract.lookup.shared', ['contract' => $contract->contract_code]) }}"><i class="fas fa-link mr-1"></i> Sao chép link tra cứu</button>
            <a href="{{ route('admin.contracts.edit', $contract) }}" class="btn btn-primary"><i class="fas fa-edit mr-1"></i> Sửa</a>
            <button class="btn btn-danger btn-delete" data-url="{{ route('admin.contracts.destroy', $contract) }}"><i class="fas fa-trash mr-1"></i> Xóa</button>
            <a href="{{ route('admin.contracts.index') }}" class="btn btn-default"><i class="fas fa-arrow-left mr-1"></i> Danh sách</a>
        </div>
    </div>
@stop

@section('content')
<div id="toast" style="position:fixed;top:20px;right:20px;z-index:9999;display:none;min-width:280px" class="alert"></div>

@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <i class="fas fa-check-circle mr-1"></i> {{ session('success') }}
    </div>
@endif

@if (session('error'))
    <div class="alert alert-danger alert-dismissible fade show">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <i class="fas fa-exclamation-triangle mr-1"></i> {{ session('error') }}
    </div>
@endif

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-info text-white">
                <i class="fas fa-file-contract mr-1"></i> Thông tin hợp đồng
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3"><strong>Mã hợp đồng:</strong><br>{{ $contract->contract_code }}</div>
                    <div class="col-md-3"><strong>Ngày tạo:</strong><br>{{ $contract->contract_date ? $contract->contract_date->format('d/m/Y H:i') : '-' }}</div>
                    <div class="col-md-3"><strong>Trạng thái:</strong><br><span class="badge badge-{{ $contract->status_badge }}">{{ $contract->status_label }}</span></div>
                    <div class="col-md-3"><strong>Nhân viên tạo:</strong><br>{{ $contract->creator->name ?? '-' }}</div>
                    <div class="col-md-3 mt-3"><strong>Chi nhánh / Địa điểm thuê:</strong><br>{{ $contract->branch ?: '-' }}</div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-primary text-white"><i class="fas fa-user mr-1"></i> Thông tin khách hàng</div>
            <div class="card-body p-0">
                <table class="table table-bordered mb-0 contract-values">
                    <tr><th style="width:40%">Số CCCD</th><td>{{ $contract->cccd ?: '-' }}</td></tr>
                    <tr><th>Họ và tên</th><td>{{ $contract->customer_name }}</td></tr>
                    <tr><th>Số điện thoại</th><td>{{ $contract->customer_phone ?: '-' }}</td></tr>
                    <tr><th>Ngày sinh</th><td>{{ $contract->dob ? $contract->dob->format('d/m/Y') : '-' }}</td></tr>
                    <tr><th>Giới tính</th><td>{{ $contract->gender ?: '-' }}</td></tr>
                    <tr><th>Ngày cấp CCCD</th><td>{{ $contract->cccd_issue_date ? $contract->cccd_issue_date->format('d/m/Y') : '-' }}</td></tr>
                    <tr><th>Nơi cấp CCCD</th><td>{{ $contract->cccd_issue_place ?: '-' }}</td></tr>
                    <tr><th>Địa chỉ</th><td>{{ $contract->customer_address ?: '-' }}</td></tr>
                    <tr><th>Số bằng lái</th><td>{{ $contract->driver_license_no ?: '-' }}</td></tr>
                    <tr><th>Hạng bằng</th><td>{{ $contract->license_class ?: '-' }}</td></tr>
                    <tr><th>Ngày cấp bằng</th><td>{{ $contract->license_issue_date ? $contract->license_issue_date->format('d/m/Y') : '-' }}</td></tr>
                    <tr><th>Ngày hết hạn bằng</th><td>{{ $contract->license_expiry_date ? $contract->license_expiry_date->format('d/m/Y') : '-' }}</td></tr>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-success text-white"><i class="fas fa-car mr-1"></i> Thông tin xe</div>
            <div class="card-body p-0">
                <table class="table table-bordered mb-0 contract-values">
                    <tr><th style="width:40%">Tên xe</th><td>{{ $contract->car_name ?: '-' }}</td></tr>
                    <tr><th>Số ghế</th><td>{{ $contract->car_seats ?: '-' }}</td></tr>
                    <tr><th>Hộp số</th><td>{{ $contract->car_transmission ?: '-' }}</td></tr>
                    <tr><th>Năm sản xuất</th><td>{{ $contract->car_year ?: '-' }}</td></tr>
                    <tr><th>Nhiên liệu</th><td>{{ $contract->car_fuel ?: '-' }}</td></tr>
                    <tr><th>Biển số</th><td>{{ $contract->car_plate ?: '-' }}</td></tr>
                    @if($contract->car)
                        <tr><th>Xe trong hệ thống</th><td><a href="{{ route('admin.cars.edit', $contract->car) }}" target="_blank">{{ $contract->car->name }}</a></td></tr>
                    @endif
                </table>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-warning text-dark"><i class="fas fa-clock mr-1"></i> Thời gian thuê</div>
            <div class="card-body p-0">
                <table class="table table-bordered mb-0 contract-values">
                    <tr><th style="width:40%">Ngày giờ nhận xe</th><td>{{ $contract->pickup_datetime ? $contract->pickup_datetime->format('d/m/Y H:i') : '-' }}</td></tr>
                    <tr><th>Địa điểm nhận xe</th><td>{{ $contract->pickup_location ?: '-' }}</td></tr>
                    <tr><th>Ngày giờ trả xe</th><td>{{ $contract->return_datetime ? $contract->return_datetime->format('d/m/Y H:i') : '-' }}</td></tr>
                    <tr><th>Địa điểm trả xe</th><td>{{ $contract->return_location ?: '-' }}</td></tr>
                    <tr><th>Tổng số ngày thuê</th><td>{{ $contract->total_days !== null ? $contract->total_days . ' ngày' : '-' }}</td></tr>
                    <tr><th>Tổng số giờ thêm</th><td>{{ $contract->total_hours !== null ? $contract->total_hours . ' giờ' : '-' }}</td></tr>
                    <tr><th>Giới hạn km</th><td>{{ $contract->km_limit ? number_format($contract->km_limit) . ' km' : '-' }}</td></tr>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-danger text-white"><i class="fas fa-money-bill-wave mr-1"></i> Cọc & Tiền thuê</div>
            <div class="card-body p-0">
                <table class="table table-bordered mb-0 contract-values">
                    <tr><th style="width:40%">Loại cọc</th><td>{{ $contract->deposit_type_label ?: 'Không cọc' }}</td></tr>
                    <tr><th>Số tiền cọc</th><td>{{ $contract->deposit_amount ? number_format($contract->deposit_amount, 0, ',', '.') . 'đ' : '-' }}</td></tr>
                    <tr><th>Ghi chú cọc</th><td>{{ $contract->deposit_note ?: '-' }}</td></tr>
                    <tr><th>Giá thuê 1 ngày</th><td>{{ $contract->daily_rate ? number_format($contract->daily_rate, 0, ',', '.') . 'đ' : '-' }}</td></tr>
                    <tr><th>Số ngày thuê</th><td>{{ $contract->rental_days ?: '-' }}</td></tr>
                    <tr class="table-secondary"><th>Tổng tiền thuê</th><td><strong>{{ $contract->total_rental_fee ? number_format($contract->total_rental_fee, 0, ',', '.') . 'đ' : '-' }}</strong></td></tr>
                </table>
                @if($contract->notes)
                <div class="p-3">
                    <strong>Ghi chú chung:</strong><br>
                    {{ $contract->notes }}
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header bg-dark text-white"><i class="fas fa-images mr-1"></i> Hình ảnh & Video</div>
    <div class="card-body">
        @if($contract->images->isEmpty())
            <p class="text-muted mb-0">Chưa có hình ảnh / video nào.</p>
        @else
            @foreach(\App\Models\Contract::IMAGE_CATEGORIES as $cat => $label)
                @php $items = $contract->images->where('category', $cat); @endphp
                @if($items->count())
                    <h6 class="font-weight-bold mt-3">{{ $label }} ({{ $items->count() }})</h6>
                    <div class="d-flex flex-wrap">
                        @foreach($items as $img)
                            @php $isImg = in_array(strtolower(pathinfo($img->path, PATHINFO_EXTENSION)), ['jpg', 'jpeg', 'png', 'gif', 'webp'], true); @endphp
                            @if($isImg)
                                <div class="mr-2 mb-2">
                                    <a href="{{ asset($img->path) }}" data-lightbox="{{ $cat }}" data-title="{{ $label }}">
                                        <img src="{{ asset($img->path) }}" style="width:140px;height:100px;object-fit:cover" class="border rounded">
                                    </a>
                                </div>
                            @else
                                <div class="mr-2 mb-2">
                                    <video controls style="width:220px;height:140px;object-fit:cover" src="{{ asset($img->path) }}"></video>
                                </div>
                            @endif
                        @endforeach
                    </div>
                @endif
            @endforeach
        @endif
    </div>
</div>
@stop

@section('js')
<script>
$(function() {
    function showToast(msg, type) {
        var bg = (type||'success') === 'success' ? 'alert-success' : 'alert-danger';
        var $t = $('#toast').removeClass('alert-success alert-danger').addClass(bg).text(msg).fadeIn();
        clearTimeout($t.data('timer'));
        $t.data('timer', setTimeout(function(){ $t.fadeOut(); }, 3000));
    }

    function copyText(text) {
        if (navigator.clipboard && window.isSecureContext) {
            navigator.clipboard.writeText(text).then(
                function() { showToast('Đã sao chép link tra cứu'); },
                function() { showToast('Không sao chép được link', 'error'); }
            );
            return;
        }
        var $tmp = $('<textarea>').val(text).css({ position: 'fixed', opacity: 0 }).appendTo('body').select();
        try {
            document.execCommand('copy');
            showToast('Đã sao chép link tra cứu');
        } catch (e) {
            showToast('Không sao chép được link', 'error');
        }
        $tmp.remove();
    }

    $(document).on('click', '.btn-copy-link', function() {
        copyText($(this).data('url'));
    });

    $('.btn-delete').on('click', function() {
        var $btn = $(this), url = $btn.data('url');
        if (!confirm('Xóa hợp đồng này? Toàn bộ ảnh đính kèm cũng sẽ bị xóa.')) return;
        $btn.prop('disabled', true);
        $.ajax({
            url: url, type: 'DELETE', data: { _token: '{{ csrf_token() }}' },
            success: function(res) { window.location.href = '{{ route('admin.contracts.index') }}'; },
            error: function() { showToast('Lỗi khi xóa', 'error'); $btn.prop('disabled', false); }
        });
    });
});
</script>
@stop