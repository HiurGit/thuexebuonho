@extends('adminlte::page')

@section('title', 'Cộng tác viên')

@section('plugins.Datatables', true)

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>Danh sách cộng tác viên</h1>
        <a href="{{ route('admin.collaborators.create') }}" class="btn btn-success">
            <i class="fas fa-plus mr-1"></i> Thêm cộng tác viên
        </a>
    </div>
@stop

@section('content')
<div id="toast" style="position:fixed;top:20px;right:20px;z-index:9999;display:none;min-width:280px" class="alert"></div>

<div class="card">
    <div class="card-body table-responsive">
        <table id="collaborators-table" class="table table-bordered table-hover">
            <thead>
                <tr><th>#</th><th>Avatar</th><th>Tên</th><th>Số điện thoại</th><th>Địa chỉ</th><th>Thứ tự</th><th>Hành động</th></tr>
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
                    <td><a href="{{ route('admin.collaborators.edit', $c) }}"><strong>{{ $c->name }}</strong></a></td>
                    <td>{{ $c->phone }}</td>
                    <td>{{ $c->address ?: '-' }}</td>
                    <td>{{ $c->sort_order }}</td>
                    <td>
                        <a href="{{ route('admin.collaborators.edit', $c) }}" class="btn btn-sm btn-primary"><i class="fas fa-edit"></i></a>
                        <button class="btn btn-sm btn-danger btn-delete" data-id="{{ $c->id }}" data-url="{{ route('admin.collaborators.destroy', $c) }}"><i class="fas fa-trash"></i></button>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="text-center text-muted py-4">Chưa có cộng tác viên nào</td></tr>
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
        order: [[5, 'asc'], [0, 'asc']],
        columnDefs: [
            { orderable: false, targets: [1, 6] }
        ],
        language: {
            search: 'Tìm kiếm:',
            lengthMenu: 'Hiện _MENU_ dòng',
            info: 'Hiển thị _START_ đến _END_ / _TOTAL_ cộng tác viên',
            infoEmpty: 'Không có dữ liệu',
            zeroRecords: 'Không tìm thấy cộng tác viên phù hợp',
            paginate: {
                first: 'Đầu',
                last: 'Cuối',
                next: 'Sau',
                previous: 'Trước'
            }
        }
    });

    function showToast(msg, type) {
        var bg = (type||'success') === 'success' ? 'alert-success' : 'alert-danger';
        var $t = $('#toast').removeClass('alert-success alert-danger').addClass(bg).text(msg).fadeIn();
        clearTimeout($t.data('timer'));
        $t.data('timer', setTimeout(function(){ $t.fadeOut(); }, 3000));
    }
    $(document).on('click', '.btn-delete', function() {
        var $btn = $(this), id = $btn.data('id'), url = $btn.data('url');
        var $row = $btn.closest('tr');
        if (!confirm('Xóa cộng tác viên này?')) return;
        $btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i>');
        $.ajax({
            url: url, type: 'DELETE', data: { _token: '{{ csrf_token() }}' },
            success: function(res) { table.row($row).remove().draw(false); showToast(res.message); },
            error: function() { showToast('Lỗi', 'error'); $btn.prop('disabled', false).html('<i class="fas fa-trash"></i>'); }
        });
    });
});
</script>
@stop
