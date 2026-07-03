@extends('adminlte::page')

@section('title', 'Tiện ích')

@section('plugins.Datatables', true)

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>Danh sách tiện ích</h1>
        <a href="{{ route('admin.amenities.create') }}" class="btn btn-success">
            <i class="fas fa-plus mr-1"></i> Thêm tiện ích
        </a>
    </div>
@stop

@section('content')
<div id="toast" style="position:fixed;top:20px;right:20px;z-index:9999;display:none;min-width:280px" class="alert"></div>

<div class="card">
    <div class="card-body table-responsive">
        <table id="amenities-table" class="table table-bordered table-hover">
            <thead>
                <tr><th>#</th><th>Tên tiện ích</th><th>Icon</th><th>Thứ tự</th><th>Số xe dùng</th><th>Hành động</th></tr>
            </thead>
            <tbody>
                @forelse($amenities as $a)
                <tr id="row-{{ $a->id }}">
                    <td>{{ $loop->iteration }}</td>
                    <td>
                        @if($a->icon)
                            <img src="{{ asset(Str::startsWith($a->icon, 'storage/') ? $a->icon : 'assets/' . $a->icon) }}" style="width:32px;height:32px;object-fit:contain" class="mr-2">
                        @endif
                        <a href="{{ route('admin.amenities.edit', $a) }}"><strong>{{ $a->name }}</strong></a>
                    </td>
                    <td>{{ $a->icon ?: '-' }}</td>
                    <td>{{ $a->sort_order }}</td>
                    <td><span class="badge badge-info">{{ $a->cars->count() }} xe</span></td>
                    <td>
                        <a href="{{ route('admin.amenities.edit', $a) }}" class="btn btn-sm btn-primary"><i class="fas fa-edit"></i></a>
                        <button class="btn btn-sm btn-danger btn-delete" data-id="{{ $a->id }}" data-url="{{ route('admin.amenities.destroy', $a) }}"><i class="fas fa-trash"></i></button>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="text-center text-muted py-4">Chưa có tiện ích nào</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@stop

@section('js')
<script>
$(function() {
    var amenitiesTable = $('#amenities-table').DataTable({
        pageLength: 10,
        order: [[3, 'asc'], [0, 'asc']],
        columnDefs: [
            { orderable: false, targets: [2, 5] }
        ],
        language: {
            search: 'Tim kiem:',
            lengthMenu: 'Hien _MENU_ dong',
            info: 'Hien thi _START_ den _END_ / _TOTAL_ tien ich',
            infoEmpty: 'Khong co du lieu',
            zeroRecords: 'Khong tim thay tien ich phu hop',
            paginate: {
                first: 'Dau',
                last: 'Cuoi',
                next: 'Sau',
                previous: 'Truoc'
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
        if (!confirm('Xóa tiện ích này?')) return;
        $btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i>');
        $.ajax({
            url: url, type: 'DELETE', data: { _token: '{{ csrf_token() }}' },
            success: function(res) { amenitiesTable.row($row).remove().draw(false); showToast(res.message); },
            error: function() { showToast('Lỗi', 'error'); $btn.prop('disabled', false).html('<i class="fas fa-trash"></i>'); }
        });
    });
});
</script>
@stop
