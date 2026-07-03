@extends('adminlte::page')

@section('title', 'Đã giao')

@section('plugins.Datatables', true)

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>Danh sách đã giao</h1>
        <a href="{{ route('admin.delivered-proofs.create') }}" class="btn btn-success">
            <i class="fas fa-plus mr-1"></i> Thêm ảnh đã giao
        </a>
    </div>
@stop

@section('content')
<div id="toast" style="position:fixed;top:20px;right:20px;z-index:9999;display:none;min-width:280px" class="alert"></div>

<div class="card">
    <div class="card-body table-responsive">
        <table id="delivered-proofs-table" class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Hình ảnh</th>
                    <th>Tiêu đề</th>
                    <th>Ngày tạo</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                @forelse($deliveredProofs as $proof)
                <tr id="row-{{ $proof->id }}">
                    <td>{{ $loop->iteration }}</td>
                    <td>
                        <img src="{{ asset($proof->image_path) }}" alt="{{ $proof->title }}" style="width:72px;height:72px;object-fit:cover;border-radius:10px">
                    </td>
                    <td><strong>{{ $proof->title }}</strong></td>
                    <td>{{ $proof->created_at->format('d/m/Y H:i') }}</td>
                    <td>
                        <a href="{{ route('admin.delivered-proofs.edit', $proof) }}" class="btn btn-sm btn-primary"><i class="fas fa-edit"></i></a>
                        <button class="btn btn-sm btn-danger btn-delete" data-id="{{ $proof->id }}" data-url="{{ route('admin.delivered-proofs.destroy', $proof) }}"><i class="fas fa-trash"></i></button>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="text-center text-muted py-4">Chưa có dữ liệu đã giao</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@stop

@section('js')
<script>
$(function() {
    var deliveredProofsTable = $('#delivered-proofs-table').DataTable({
        pageLength: 10,
        order: [[3, 'desc']],
        columnDefs: [
            { orderable: false, targets: [1, 4] }
        ],
        language: {
            search: 'Tim kiem:',
            lengthMenu: 'Hien _MENU_ dong',
            info: 'Hien thi _START_ den _END_ / _TOTAL_ muc da giao',
            infoEmpty: 'Khong co du lieu',
            zeroRecords: 'Khong tim thay muc da giao phu hop',
            paginate: {
                first: 'Dau',
                last: 'Cuoi',
                next: 'Sau',
                previous: 'Truoc'
            }
        }
    });

    function showToast(msg, type) {
        var bg = (type || 'success') === 'success' ? 'alert-success' : 'alert-danger';
        var $t = $('#toast').removeClass('alert-success alert-danger').addClass(bg).text(msg).fadeIn();
        clearTimeout($t.data('timer'));
        $t.data('timer', setTimeout(function(){ $t.fadeOut(); }, 3000));
    }

    $(document).on('click', '.btn-delete', function() {
        var $btn = $(this);
        var id = $btn.data('id');
        var url = $btn.data('url');
        var $row = $btn.closest('tr');
        if (!confirm('Xóa mục đã giao #' + id + '?')) return;

        $btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i>');

        $.ajax({
            url: url,
            type: 'DELETE',
            data: { _token: '{{ csrf_token() }}' },
            success: function(res) {
                deliveredProofsTable.row($row).remove().draw(false);
                showToast(res.message || 'Đã xóa');
            },
            error: function() {
                showToast('Lỗi khi xóa', 'error');
                $btn.prop('disabled', false).html('<i class="fas fa-trash"></i>');
            }
        });
    });
});
</script>
@stop
