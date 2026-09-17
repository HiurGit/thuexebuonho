@extends('adminlte::page')

@section('title', 'Quản lý khách thuê')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>Quản lý khách thuê</h1>
        <a href="{{ route('admin.check-khach-thue.create') }}" class="btn btn-success">
            <i class="fas fa-plus mr-1"></i> Thêm khách hàng
        </a>
    </div>
@stop

@section('content')
<div id="toast" style="position:fixed;top:20px;right:20px;z-index:9999;display:none;min-width:280px" class="alert"></div>

<div class="card">
    <div class="card-body">
        <form method="GET" action="{{ route('admin.check-khach-thue.index') }}" class="mb-3">
            <div class="input-group">
                <input type="text" name="q" value="{{ request('q') }}" class="form-control" placeholder="Tìm theo tên, CCCD, SĐT, bằng lái...">
                <div class="input-group-append">
                    <button class="btn btn-primary" type="submit"><i class="fas fa-search"></i></button>
                </div>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Tên</th>
                        <th>CCCD / SĐT / Bằng lái</th>
                        <th>Số báo cáo</th>
                        <th>Báo cáo mới nhất</th>
                        <th>Trạng thái</th>
                        <th class="text-center">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($customers as $c)
                    <tr id="row-{{ $c->id }}">
                        <td>{{ $loop->iteration }}</td>
                        <td>
                            <a href="{{ route('admin.check-khach-thue.edit', $c) }}"><strong>{{ $c->name }}</strong></a>
                        </td>
                        <td>
                            <div>{{ $c->cccd ?: '-' }}</div>
                            <div>{{ $c->phone ?: '-' }}</div>
                            <div>{{ $c->license ?: '-' }}</div>
                        </td>
                        <td><span class="badge badge-info">{{ $c->reports_count }}</span></td>
                        <td>
                            @if($c->latestReport)
                                <div>{{ $c->latestReport->content }}</div>
                                <small class="text-muted">{{ $c->latestReport->date }}</small>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>
                            @if($c->status === 'banned')
                                <span class="badge badge-danger">Cấm</span>
                            @else
                                <span class="badge badge-success">Hoạt động</span>
                            @endif
                        </td>
                        <td class="text-center" style="white-space:nowrap">
                            <a href="{{ route('check.detail', $c->id) }}" class="btn btn-sm btn-info" target="_blank" title="Xem trang công khai"><i class="fas fa-eye"></i></a>
                            <a href="{{ route('admin.check-khach-thue.edit', $c) }}" class="btn btn-sm btn-primary"><i class="fas fa-edit"></i></a>
                            <button class="btn btn-sm btn-danger btn-delete" data-id="{{ $c->id }}" data-url="{{ route('admin.check-khach-thue.destroy', $c) }}"><i class="fas fa-trash"></i></button>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="7" class="text-center text-muted py-4">Chưa có khách hàng nào</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{ $customers->links() }}
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
        if (!confirm('Xóa khách hàng này?')) return;
        $btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i>');
        $.ajax({
            url: url, type: 'DELETE', data: { _token: '{{ csrf_token() }}' },
            success: function(res) { $row.fadeOut(function() { $row.remove(); }); showToast(res.message); },
            error: function() { showToast('Lỗi', 'error'); $btn.prop('disabled', false).html('<i class="fas fa-trash"></i>'); }
        });
    });
});
</script>
@stop
