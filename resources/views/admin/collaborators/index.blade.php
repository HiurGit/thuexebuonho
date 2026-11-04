@extends('adminlte::page')

@section('title', 'Cộng tác viên')

@section('plugins.Datatables', true)

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>Cộng tác viên giới thiệu</h1>
        <div>
            <a href="{{ route('admin.commissions.index') }}" class="btn btn-warning">
                <i class="fas fa-hand-holding-usd mr-1"></i> Hoa hồng CTV
            </a>
            <a href="{{ route('admin.collaborators.create') }}" class="btn btn-success">
                <i class="fas fa-plus mr-1"></i> Thêm cộng tác viên
            </a>
        </div>
    </div>
@stop

@section('content')
<div id="toast" style="position:fixed;top:20px;right:20px;z-index:9999;display:none;min-width:280px" class="alert"></div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        {{ session('success') }}
    </div>
@endif

<div class="row">
    <div class="col-md-4">
        <div class="small-box bg-warning">
            <div class="inner"><h3>{{ $stats['pending'] }}</h3><p>Chờ duyệt</p></div>
            <div class="icon"><i class="fas fa-user-clock"></i></div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="small-box bg-success">
            <div class="inner"><h3>{{ $stats['active'] }}</h3><p>Đang hoạt động</p></div>
            <div class="icon"><i class="fas fa-user-check"></i></div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="small-box bg-secondary">
            <div class="inner"><h3>{{ $stats['inactive'] }}</h3><p>Tạm ngưng</p></div>
            <div class="icon"><i class="fas fa-user-slash"></i></div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <form method="GET" class="form-inline">
            <input type="text" name="q" value="{{ request('q') }}" class="form-control mr-2 mb-1" placeholder="Tên, SĐT hoặc mã CTV">
            <select name="status" class="form-control mr-2 mb-1">
                <option value="">-- Tất cả trạng thái --</option>
                @foreach(\App\Models\Collaborator::STATUS_LABELS as $value => $label)
                    <option value="{{ $value }}" {{ request('status') === $value ? 'selected' : '' }}>{{ $label }}</option>
                @endforeach
            </select>
            <button class="btn btn-primary mb-1"><i class="fas fa-search mr-1"></i> Lọc</button>
            @if(request()->filled('q') || request()->filled('status'))
                <a href="{{ route('admin.collaborators.index') }}" class="btn btn-default ml-2 mb-1">Xóa lọc</a>
            @endif
        </form>
    </div>
    <div class="card-body table-responsive">
        <table id="collaborators-table" class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Avatar</th>
                    <th>Tên</th>
                    <th>Số điện thoại</th>
                    <th>Mã / Link</th>
                    <th>Trạng thái</th>
                    <th>Khách đã khóa</th>
                    <th>Hoa hồng chờ</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                @forelse($collaborators as $c)
                <tr id="row-{{ $c->id }}">
                    <td>{{ $loop->iteration }}</td>
                    <td>
                        @if($c->avatar)
                            <img src="{{ asset($c->avatar) }}" style="width:40px;height:40px;border-radius:50%;object-fit:cover">
                        @else
                            <div style="width:40px;height:40px;border-radius:50%;background:#fde68a;display:flex;align-items:center;justify-content:center;font-weight:800;font-size:14px;color:#ea580c">
                                {{ mb_substr($c->name, 0, 1) }}
                            </div>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('admin.collaborators.edit', $c) }}"><strong>{{ $c->name }}</strong></a>
                        @if($c->email)
                            <br><small class="text-muted">{{ $c->email }}</small>
                        @endif
                    </td>
                    <td>{{ $c->phone }}</td>
                    <td>
                        @if($c->code)
                            <code>{{ $c->code }}</code>
                            <button type="button" class="btn btn-xs btn-outline-primary btn-copy-link" data-url="{{ $c->referral_url }}" title="Sao chép link giới thiệu">
                                <i class="fas fa-copy"></i>
                            </button>
                        @else
                            <span class="text-muted">Chưa cấp</span>
                        @endif
                    </td>
                    <td><span class="badge badge-{{ $c->status_badge }}">{{ $c->status_label }}</span></td>
                    <td>{{ $c->customers_count }}</td>
                    <td>{{ number_format((int) ($c->pending_commission_total ?? 0), 0, ',', '.') }}đ</td>
                    <td class="text-nowrap">
                        @if($c->status !== 'active')
                            <form action="{{ route('admin.collaborators.approve', $c) }}" method="POST" class="d-inline">
                                @csrf
                                <button class="btn btn-sm btn-success" title="Duyệt cộng tác viên"><i class="fas fa-check"></i></button>
                            </form>
                        @endif
                        <a href="{{ route('admin.commissions.index', ['collaborator_id' => $c->id]) }}" class="btn btn-sm btn-warning" title="Xem hoa hồng"><i class="fas fa-hand-holding-usd"></i></a>
                        <a href="{{ route('admin.collaborators.edit', $c) }}" class="btn btn-sm btn-primary" title="Sửa"><i class="fas fa-edit"></i></a>
                        <button class="btn btn-sm btn-danger btn-delete" data-id="{{ $c->id }}" data-url="{{ route('admin.collaborators.destroy', $c) }}" title="Xóa"><i class="fas fa-trash"></i></button>
                    </td>
                </tr>
                @empty
                <tr><td colspan="9" class="text-center text-muted py-4">Chưa có cộng tác viên nào</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@stop

@section('js')
<script>
$(function() {
    var table = $('#collaborators-table').DataTable({
        pageLength: 10,
        paging: false,
        info: false,
        order: [],
        columnDefs: [
            { orderable: false, targets: [1, 4, 6, 7, 8] }
        ],
        language: {
            search: 'Tìm kiếm:',
            zeroRecords: 'Không tìm thấy cộng tác viên phù hợp'
        }
    });

    function showToast(msg, type) {
        var bg = (type||'success') === 'success' ? 'alert-success' : 'alert-danger';
        var $t = $('#toast').removeClass('alert-success alert-danger').addClass(bg).text(msg).fadeIn();
        clearTimeout($t.data('timer'));
        $t.data('timer', setTimeout(function(){ $t.fadeOut(); }, 3000));
    }

    $(document).on('click', '.btn-copy-link', function() {
        var btn = this;
        var url = btn.getAttribute('data-url') || '';
        var done = function() { showToast('Đã sao chép link giới thiệu: ' + url); };
        if (navigator.clipboard && window.isSecureContext) {
            navigator.clipboard.writeText(url).then(done).catch(function(){ showToast('Không sao chép được link', 'error'); });
        } else {
            var ta = document.createElement('textarea');
            ta.value = url;
            ta.style.position = 'fixed';
            ta.style.opacity = '0';
            document.body.appendChild(ta);
            ta.select();
            try { document.execCommand('copy'); done(); } catch (e) { showToast('Không sao chép được link', 'error'); }
            document.body.removeChild(ta);
        }
    });

    $(document).on('click', '.btn-delete', function() {
        var $btn = $(this), id = $btn.data('id'), url = $btn.data('url');
        var $row = $btn.closest('tr');
        if (!confirm('Xóa cộng tác viên này?')) return;
        $btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i>');
        $.ajax({
            url: url, type: 'DELETE', data: { _token: '{{ csrf_token() }}' },
            success: function(res) {
                table.row($row).remove().draw(false);
                $row.remove();
                showToast(res.message);
            },
            error: function() { showToast('Lỗi', 'error'); $btn.prop('disabled', false).html('<i class="fas fa-trash"></i>'); }
        });
    });
});
</script>
@stop
