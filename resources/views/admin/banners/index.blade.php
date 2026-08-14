@extends('adminlte::page')

@section('title', 'Quản lý Banner')

@section('plugins.Datatables', true)

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>Quản lý Banner</h1>
        <a href="{{ route('admin.banners.create') }}" class="btn btn-success">
            <i class="fas fa-plus mr-1"></i> Thêm banner
        </a>
    </div>
@stop

@section('content')
<div id="toast" style="position:fixed;top:20px;right:20px;z-index:9999;display:none;min-width:280px" class="alert"></div>

<div class="card">
    <div class="card-body table-responsive">
        <table id="banners-table" class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Ảnh</th>
                    <th>Tên banner</th>
                    <th>Vị trí</th>
                    <th>Thứ tự</th>
                    <th>Trạng thái</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                @forelse($banners as $b)
                <tr id="row-{{ $b->id }}">
                    <td>{{ $loop->iteration }}</td>
                    <td>
                        <img src="{{ asset($b->image) }}" style="width:120px;height:60px;object-fit:cover;border-radius:6px">
                    </td>
                    <td><a href="{{ route('admin.banners.edit', $b) }}"><strong>{{ $b->title }}</strong></a></td>
                    <td>
                        @if($b->position === 'hero')
                            <span class="badge badge-primary">Hero</span>
                        @else
                            <span class="badge badge-info">Banner giá</span>
                        @endif
                    </td>
                    <td>{{ $b->sort_order }}</td>
                    <td>
                        @if($b->is_active)
                            <span class="badge badge-success">Hiện</span>
                        @else
                            <span class="badge badge-secondary">Ẩn</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('admin.banners.edit', $b) }}" class="btn btn-sm btn-primary"><i class="fas fa-edit"></i></a>
                        <button class="btn btn-sm btn-danger btn-delete" data-id="{{ $b->id }}" data-url="{{ route('admin.banners.destroy', $b) }}"><i class="fas fa-trash"></i></button>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="text-center text-muted py-4">Chưa có banner nào</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@stop

@section('js')
<script>
$(function() {
    var bannersTable = $('#banners-table').DataTable({
        pageLength: 10,
        order: [[3, 'asc'], [4, 'asc']],
        columnDefs: [
            { orderable: false, targets: [1, 6] }
        ],
        language: {
            search: 'Tìm kiếm:',
            lengthMenu: 'Hiện _MENU_ dòng',
            info: 'Hiển thị _START_ đến _END_ / _TOTAL_ banner',
            infoEmpty: 'Không có dữ liệu',
            zeroRecords: 'Không tìm thấy banner phù hợp',
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
        if (!confirm('Xóa banner này?')) return;
        $btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i>');
        $.ajax({
            url: url, type: 'DELETE', data: { _token: '{{ csrf_token() }}' },
            success: function(res) { bannersTable.row($row).remove().draw(false); showToast(res.message); },
            error: function() { showToast('Lỗi', 'error'); $btn.prop('disabled', false).html('<i class="fas fa-trash"></i>'); }
        });
    });
});
</script>
@stop
