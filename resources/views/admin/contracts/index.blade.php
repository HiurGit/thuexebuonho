@extends('adminlte::page')

@section('title', 'Hợp đồng thuê xe')

@section('plugins.Datatables', true)

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>Danh sách hợp đồng</h1>
        <a href="{{ route('admin.contracts.create') }}" class="btn btn-success">
            <i class="fas fa-plus mr-1"></i> Tạo hợp đồng mới
        </a>
    </div>
@stop

@section('content')
<div id="toast" style="position:fixed;top:20px;right:20px;z-index:9999;display:none;min-width:280px" class="alert"></div>

<div class="card">
    <div class="card-body">
        <form method="GET" action="{{ route('admin.contracts.index') }}" class="mb-3">
            <div class="row">
                <div class="col-md-4">
                    <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Tìm mã, tên KH, SĐT, CCCD, biển số...">
                </div>
                <div class="col-md-3">
                    <select name="status" class="form-control">
                        <option value="">Tất cả trạng thái</option>
                        @foreach(\App\Models\Contract::STATUS_LABELS as $key => $label)
                            <option value="{{ $key }}" {{ request('status') === $key ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-search mr-1"></i> Lọc</button>
                    <a href="{{ route('admin.contracts.index') }}" class="btn btn-default">Xóa lọc</a>
                </div>
            </div>
        </form>

        <div class="table-responsive">
            <table id="contracts-table" class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>Mã hợp đồng</th>
                        <th>Khách hàng</th>
                        <th>Số điện thoại</th>
                        <th>Xe</th>
                        <th>Ngày thuê</th>
                        <th>Ngày trả</th>
                        <th>Tổng tiền</th>
                        <th>Trạng thái</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($contracts as $c)
                    <tr>
                        <td>
                            <a href="{{ route('admin.contracts.show', $c) }}"><strong>{{ $c->contract_code }}</strong></a>
                            @if($c->contract_date)
                                <br><small class="text-muted">{{ $c->contract_date->format('d/m/Y') }}</small>
                            @endif
                        </td>
                        <td>{{ $c->customer_name }}</td>
                        <td>{{ $c->customer_phone ?: '-' }}</td>
                        <td>
                            @if($c->car_name)
                                {{ $c->car_name }}
                                @if($c->car_plate)
                                    <br><small class="text-muted">{{ $c->car_plate }}</small>
                                @endif
                            @else
                                -
                            @endif
                        </td>
                        <td>{{ $c->pickup_datetime ? $c->pickup_datetime->format('d/m/Y H:i') : '-' }}</td>
                        <td>{{ $c->return_datetime ? $c->return_datetime->format('d/m/Y H:i') : '-' }}</td>
                        <td class="text-right">{{ $c->total_rental_fee ? number_format($c->total_rental_fee, 0, ',', '.') . 'đ' : '-' }}</td>
                        <td><span class="badge badge-{{ $c->status_badge }}">{{ $c->status_label }}</span></td>
                        <td>
                            <a href="{{ route('admin.contracts.show', $c) }}" class="btn btn-sm btn-info" title="Xem chi tiết"><i class="fas fa-eye"></i></a>
                            <a href="{{ route('admin.contracts.edit', $c) }}" class="btn btn-sm btn-primary" title="Sửa"><i class="fas fa-edit"></i></a>
                            <button class="btn btn-sm btn-secondary btn-copy-link" data-url="{{ route('contract.lookup.shared', ['contract' => $c->contract_code]) }}" title="Sao chép link tra cứu"><i class="fas fa-link"></i></button>
                            <button class="btn btn-sm btn-danger btn-delete" data-id="{{ $c->id }}" data-url="{{ route('admin.contracts.destroy', $c) }}" title="Xóa"><i class="fas fa-trash"></i></button>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="9" class="text-center text-muted py-4">Chưa có hợp đồng nào</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            {{ $contracts->links() }}
        </div>
    </div>
</div>
@stop

@section('js')
<script>
$(function() {
    var table = $('#contracts-table').DataTable({
        pageLength: 10,
        ordering: false,
        searching: false,
        paging: false,
        info: false,
        language: {
            zeroRecords: 'Không tìm thấy hợp đồng phù hợp'
        }
    });

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

    $(document).on('click', '.btn-delete', function() {
        var $btn = $(this), url = $btn.data('url');
        var $row = $btn.closest('tr');
        if (!confirm('Xóa hợp đồng này? Toàn bộ ảnh đính kèm cũng sẽ bị xóa.')) return;
        $btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i>');
        $.ajax({
            url: url, type: 'DELETE', data: { _token: '{{ csrf_token() }}' },
            success: function(res) { table.row($row).remove().draw(false); showToast(res.message); },
            error: function() { showToast('Lỗi khi xóa', 'error'); $btn.prop('disabled', false).html('<i class="fas fa-trash"></i>'); }
        });
    });
});
</script>
@stop