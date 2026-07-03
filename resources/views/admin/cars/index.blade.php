@extends('adminlte::page')

@section('title', 'Danh sach xe')
@section('plugins.Datatables', true)

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>Danh sach xe</h1>
        <div>
            <a href="{{ route('admin.bookings.calendar') }}" class="btn btn-outline-primary mr-2">
                <i class="fas fa-calendar-alt mr-1"></i> Lich thue xe
            </a>
            <a href="{{ route('admin.cars.create') }}" class="btn btn-success">
                <i class="fas fa-plus mr-1"></i> Them xe
            </a>
        </div>
    </div>
@stop

@section('content')
<div id="toast" style="position:fixed;top:20px;right:20px;z-index:9999;display:none;min-width:280px" class="alert"></div>

<div class="card">
    <div class="card-body table-responsive">
        <table id="cars-table" class="table table-bordered table-hover text-nowrap">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Xe</th>
                    <th>Ghe</th>
                    <th>Hop so</th>
                    <th>Nhien lieu</th>
                    <th>Nam</th>
                    <th>Gia/ngay</th>
                    <th>Gia/buoi</th>
                    <th>Trang thai</th>
                    <th>Hanh dong</th>
                </tr>
            </thead>
            <tbody>
                @forelse($cars as $car)
                <tr id="row-{{ $car->id }}">
                    <td>{{ $loop->iteration }}</td>
                    <td>
                        @if($car->mainImage)
                            <img src="{{ asset($car->mainImage->path) }}" class="mr-2" style="width:60px;height:40px;object-fit:cover;border-radius:4px">
                        @endif
                        <a href="{{ route('admin.cars.edit', $car) }}"><strong>{{ $car->name }}</strong></a>
                    </td>
                    <td>{{ $car->seats }} cho</td>
                    <td>{{ $car->transmission }}</td>
                    <td>{{ $car->fuel }}</td>
                    <td>{{ $car->year ?: '-' }}</td>
                    <td>{{ number_format($car->price_per_day) }}d</td>
                    <td>{{ number_format($car->price_per_session) }}d</td>
                    <td>
                        <select class="form-control form-control-sm status-select" data-id="{{ $car->id }}" data-url="{{ route('admin.cars.status', $car) }}" style="min-width:120px">
                            <option value="available" {{ $car->status == 'available' ? 'selected' : '' }}>San sang</option>
                            <option value="rented" {{ $car->status == 'rented' ? 'selected' : '' }}>Dang thue</option>
                            <option value="maintenance" {{ $car->status == 'maintenance' ? 'selected' : '' }}>Bao tri</option>
                        </select>
                    </td>
                    <td>
                        <a href="{{ route('admin.bookings.calendar', ['car_id' => $car->id]) }}" class="btn btn-sm btn-info" title="Lich thue"><i class="fas fa-calendar-day"></i></a>
                        <a href="{{ route('admin.cars.edit', $car) }}" class="btn btn-sm btn-primary" title="Sua"><i class="fas fa-edit"></i></a>
                        <button class="btn btn-sm btn-danger btn-delete" data-id="{{ $car->id }}" data-url="{{ route('admin.cars.destroy', $car) }}" title="Xoa"><i class="fas fa-trash"></i></button>
                    </td>
                </tr>
                @empty
                <tr><td colspan="10" class="text-center text-muted py-4">Chua co xe nao</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@stop

@section('js')
<script>
$(function() {
    var carsTable = $('#cars-table').DataTable({
        pageLength: 10,
        order: [[0, 'asc']],
        columnDefs: [
            { orderable: false, targets: [8, 9] }
        ],
        language: {
            search: 'Tim kiem:',
            lengthMenu: 'Hien _MENU_ dong',
            info: 'Hien thi _START_ den _END_ / _TOTAL_ xe',
            infoEmpty: 'Khong co du lieu',
            zeroRecords: 'Khong tim thay xe phu hop',
            paginate: {
                first: 'Dau',
                last: 'Cuoi',
                next: 'Sau',
                previous: 'Truoc'
            }
        }
    });

    function showToast(msg, type) {
        type = type || 'success';
        var bg = type === 'success' ? 'alert-success' : 'alert-danger';
        var $t = $('#toast').removeClass('alert-success alert-danger').addClass(bg).text(msg).fadeIn();
        clearTimeout($t.data('timer'));
        $t.data('timer', setTimeout(function(){ $t.fadeOut(); }, 3000));
    }

    $(document).on('click', '.btn-delete', function() {
        var $btn = $(this), id = $btn.data('id'), url = $btn.data('url');
        var $row = $btn.closest('tr');
        if (!confirm('Xoa xe #' + id + '?')) return;
        $btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i>');
        $.ajax({
            url: url, type: 'DELETE', data: { _token: '{{ csrf_token() }}' },
            success: function(res) {
                carsTable.row($row).remove().draw(false);
                showToast(res.message || 'Da xoa');
            },
            error: function() {
                showToast('Loi khi xoa', 'error');
                $btn.prop('disabled', false).html('<i class="fas fa-trash"></i>');
            }
        });
    });

    $(document).on('change', '.status-select', function() {
        var $sel = $(this), url = $sel.data('url');
        $.ajax({
            url: url, type: 'POST', data: { _token: '{{ csrf_token() }}', status: $sel.val() },
            success: function(res) { showToast(res.message || 'Da cap nhat'); },
            error: function() { showToast('Loi cap nhat', 'error'); }
        });
    });
});
</script>
@stop
