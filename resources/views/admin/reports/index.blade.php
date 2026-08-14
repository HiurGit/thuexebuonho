@extends('adminlte::page')

@section('title', 'Quản lý báo cáo')

@section('content_header')
    <h1>Quản lý báo cáo khách thuê</h1>
@stop

@section('content')
<div id="toast" style="position:fixed;top:20px;right:20px;z-index:9999;display:none;min-width:280px" class="alert"></div>

<div class="card">
    <div class="card-body">
        <form method="GET" action="{{ route('admin.reports.index') }}" class="mb-3">
            <div class="row">
                <div class="col-md-5">
                    <input type="text" name="q" value="{{ request('q') }}" class="form-control" placeholder="Tìm theo nội dung, tên khách, SĐT, CCCD...">
                </div>
                <div class="col-md-3">
                    <select name="status" class="form-control">
                        <option value="">-- Trạng thái --</option>
                        <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Chờ xác minh</option>
                        <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>Đã xác minh</option>
                        <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Từ chối</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <button class="btn btn-primary" type="submit"><i class="fas fa-search mr-1"></i>Lọc</button>
                    <a href="{{ route('admin.reports.index') }}" class="btn btn-default">Bỏ lọc</a>
                </div>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Khách hàng</th>
                        <th>Nội dung</th>
                        <th>Người báo cáo</th>
                        <th>Ngày</th>
                        <th>Lượt xem</th>
                        <th>Trạng thái</th>
                        <th class="text-center">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($reports as $r)
                    <tr id="row-{{ $r->id }}">
                        <td>{{ $loop->iteration }}</td>
                        <td>
                            <a href="{{ $r->customer ? route('admin.check-khach-thue.edit', $r->customer) : '#' }}">
                                <strong>{{ $r->customer?->name ?? 'Đã xóa' }}</strong>
                            </a>
                            @if($r->customer)
                                <div><small class="text-muted">{{ $r->customer->phone }}</small></div>
                            @endif
                        </td>
                        <td style="max-width:280px">
                            <div>{{ \Illuminate\Support\Str::limit($r->content, 60) }}</div>
                            @if($r->category)
                                <small class="text-muted">{{ $r->category }}</small>
                            @endif
                        </td>
                        <td>
                            <div>{{ $r->reporter_name ?: '-' }}</div>
                            <small class="text-muted">{{ $r->reporter_phone }}</small>
                        </td>
                        <td class="whitespace-nowrap">{{ $r->date }}</td>
                        <td>{{ $r->views }}</td>
                        <td>
                            <span id="status-badge-{{ $r->id }}">
                                @if($r->status === 'approved')
                                    <span class="badge badge-success">Đã xác minh</span>
                                @elseif($r->status === 'rejected')
                                    <span class="badge badge-danger">Từ chối</span>
                                @else
                                    <span class="badge badge-warning">Chờ xác minh</span>
                                @endif
                            </span>
                        </td>
                        <td class="text-center" style="white-space:nowrap">
                            <span id="status-actions-{{ $r->id }}" class="d-inline-flex align-items-center mr-1">
                                @if($r->status === 'pending')
                                    <button class="btn btn-sm btn-success btn-status mr-1" data-url="{{ route('admin.reports.status', $r) }}" data-status="approved" title="Xác nhận ngay"><i class="fas fa-check"></i></button>
                                    <button class="btn btn-sm btn-danger btn-status mr-1" data-url="{{ route('admin.reports.status', $r) }}" data-status="rejected" title="Từ chối"><i class="fas fa-times"></i></button>
                                @else
                                    <button class="btn btn-sm btn-warning btn-status mr-1" data-url="{{ route('admin.reports.status', $r) }}" data-status="pending" title="Đưa về chờ xác minh"><i class="fas fa-undo"></i></button>
                                @endif
                            </span>
                            <a href="{{ route('admin.reports.edit', $r) }}" class="btn btn-sm btn-primary"><i class="fas fa-edit"></i></a>
                            <button class="btn btn-sm btn-danger btn-delete" data-url="{{ route('admin.reports.destroy', $r) }}"><i class="fas fa-trash"></i></button>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="8" class="text-center text-muted py-4">Chưa có báo cáo nào</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{ $reports->links() }}
    </div>
</div>
@stop

@section('js')
<script>
$(function() {
    function showToast(msg, type) {
        var bg = (type || 'success') === 'success' ? 'alert-success' : 'alert-danger';
        var $t = $('#toast').removeClass('alert-success alert-danger').addClass(bg).text(msg).fadeIn();
        clearTimeout($t.data('timer'));
        $t.data('timer', setTimeout(function() { $t.fadeOut(); }, 3000));
    }
    $(document).on('click', '.btn-delete', function() {
        var $btn = $(this), url = $btn.data('url');
        var $row = $btn.closest('tr');
        if (!confirm('Xóa báo cáo này?')) return;
        $btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i>');
        $.ajax({
            url: url, type: 'DELETE', data: { _token: '{{ csrf_token() }}' },
            success: function(res) { $row.fadeOut(function() { $row.remove(); }); showToast(res.message); },
            error: function() { showToast('Lỗi', 'error'); $btn.prop('disabled', false).html('<i class="fas fa-trash"></i>'); }
        });
    });

    function badgeHtml(status) {
        if (status === 'approved') return '<span class="badge badge-success">Đã xác minh</span>';
        if (status === 'rejected') return '<span class="badge badge-danger">Từ chối</span>';
        return '<span class="badge badge-warning">Chờ xác minh</span>';
    }

    function actionsHtml(id, status, url) {
        var b = '';
        if (status === 'pending') {
            b += '<button class="btn btn-sm btn-success btn-status mr-1" data-url="' + url + '" data-status="approved" title="Xác nhận ngay"><i class="fas fa-check"></i></button>';
            b += '<button class="btn btn-sm btn-danger btn-status mr-1" data-url="' + url + '" data-status="rejected" title="Từ chối"><i class="fas fa-times"></i></button>';
        } else {
            b += '<button class="btn btn-sm btn-warning btn-status mr-1" data-url="' + url + '" data-status="pending" title="Đưa về chờ xác minh"><i class="fas fa-undo"></i></button>';
        }
        return b;
    }

    $(document).on('click', '.btn-status', function() {
        var $btn = $(this), url = $btn.data('url'), status = $btn.data('status');
        var $row = $btn.closest('tr');
        var id = $row.attr('id') ? $row.attr('id').replace('row-', '') : '';
        var icon = $btn.find('i').attr('class');
        $btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i>');
        $.ajax({
            url: url, type: 'POST', data: { _token: '{{ csrf_token() }}', status: status },
            success: function(res) {
                if (id) {
                    $('#status-badge-' + id).html(badgeHtml(status));
                    $('#status-actions-' + id).html(actionsHtml(id, status, url));
                }
                showToast(res.message || 'Đã cập nhật trạng thái.');
            },
            error: function() {
                showToast('Lỗi, vui lòng thử lại.', 'error');
                $btn.prop('disabled', false).html('<i class="' + icon + '"></i>');
            }
        });
    });
});
</script>
@stop
