@extends('adminlte::page')

@section('title', 'Đơn đặt xe')
@section('plugins.Datatables', true)

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>Đơn đặt xe</h1>
        <div>
            <a href="{{ route('admin.bookings.calendar') }}" class="btn btn-outline-primary mr-2">
                <i class="fas fa-calendar-alt mr-1"></i> Lịch thuê xe
            </a>
            <a href="{{ route('admin.bookings.create') }}" class="btn btn-success">
                <i class="fas fa-plus mr-1"></i> Thêm đơn
            </a>
        </div>
    </div>
@stop

@section('content')
<div id="toast" style="position:fixed;top:20px;right:20px;z-index:9999;display:none;min-width:280px" class="alert"></div>

<div class="card">
    <div class="card-body table-responsive">
        <table id="bookings-table" class="table table-bordered table-hover text-nowrap">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Khách hàng</th>
                    <th>SDT</th>
                    <th>Xe</th>
                    <th>Loại thuê</th>
                    <th>Buổi</th>
                    <th>Ngày nhận</th>
                    <th>Ngày trả</th>
                    <th>Đơn giá</th>
                    <th>Tổng tiền</th>
                    <th>Trạng thái</th>
                    <th>Ngày tạo</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                @forelse($bookings as $b)
                <tr id="row-{{ $b->id }}">
                    <td>{{ $loop->iteration }}</td>
                    <td>
                        <a href="{{ route('admin.bookings.edit', $b) }}">{{ $b->customer_name ?: 'Khách ' . substr($b->customer_phone, -4) }}</a>
                    </td>
                    <td>{{ $b->customer_phone }}</td>
                    <td>{{ $b->car ? $b->car->name : '-' }}</td>
                    <td>
                        @if($b->rental_type == 'one-day')
                            <span class="badge badge-info">1 ngày</span>
                        @elseif($b->rental_type == 'multi-day')
                            <span class="badge badge-primary">Nhiều ngày ({{ $b->days }} ngày)</span>
                        @else
                            <span class="badge badge-secondary">Theo buổi</span>
                        @endif
                        @if($b->trip_plan_label)
                            <div class="text-muted small">{{ $b->trip_plan_label }}</div>
                        @endif
                        @if($b->pickup_type_label)
                            <div class="text-muted small">{{ $b->pickup_type_label }}</div>
                        @endif
                    </td>
                    <td>
                        @if($b->rental_type == 'hourly' && $b->session_type)
                            @if($b->session_type == 'sang')
                                <span class="badge badge-warning">{{ $b->session_label }}</span>
                            @elseif($b->session_type == 'chieu')
                                <span class="badge badge-info">{{ $b->session_label }}</span>
                            @elseif($b->session_type == 'toi')
                                <span class="badge badge-dark">{{ $b->session_label }}</span>
                            @else
                                {{ $b->session_type }}
                            @endif
                        @else
                            <span class="text-muted">-</span>
                        @endif
                    </td>
                    <td>
                        {{ $b->start_date ? $b->start_date->format('d/m/Y') : '-' }}
                        @if($b->booking_time_label)
                            <div class="text-muted small">{{ $b->booking_time_label }}</div>
                        @endif
                    </td>
                    <td>
                        {{ $b->end_date ? $b->end_date->format('d/m/Y') : '-' }}
                        @if($b->rental_type !== 'hourly' && $b->end_time)
                            <div class="text-muted small">{{ $b->end_time }}</div>
                        @endif
                    </td>
                    <td>
                        @php
                            $unitPrice = ($b->rental_type === 'multi-day' && ($b->days ?? 0) > 0)
                                ? (int) round($b->total_price / $b->days)
                                : (int) $b->total_price;
                        @endphp
                        {{ number_format($unitPrice) }}d
                        <span class="text-muted small">/{{ $b->rental_type === 'hourly' ? 'buổi' : 'ngày' }}</span>
                    </td>
                    <td><strong>{{ number_format($b->total_price) }}d</strong></td>
                    <td>
                        <select class="form-control form-control-sm status-select" data-id="{{ $b->id }}" data-url="{{ route('admin.bookings.status', $b) }}" style="min-width:130px">
                            <option value="pending" {{ $b->status == 'pending' ? 'selected' : '' }}>Chờ xử lý</option>
                            <option value="confirmed" {{ $b->status == 'confirmed' ? 'selected' : '' }}>Đã xác nhận</option>
                            <option value="delivered" {{ $b->status == 'delivered' ? 'selected' : '' }}>Đã giao</option>
                            <option value="completed" {{ $b->status == 'completed' ? 'selected' : '' }}>Hoàn thành</option>
                            <option value="cancelled" {{ $b->status == 'cancelled' ? 'selected' : '' }}>Đã hủy</option>
                        </select>
                    </td>
                    <td>{{ $b->created_at->format('d/m/Y H:i') }}</td>
                    <td>
                        <a href="{{ route('admin.bookings.edit', $b) }}" class="btn btn-sm btn-primary" title="Sửa">
                            <i class="fas fa-edit"></i>
                        </a>
                        <button class="btn btn-sm btn-danger btn-delete" data-id="{{ $b->id }}" data-url="{{ route('admin.bookings.destroy', $b) }}" title="Xóa">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>
                @empty
                <tr><td colspan="13" class="text-center text-muted py-4">Chưa có đơn đặt xe nào</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@stop

@section('js')
<script>
$(function() {
    var bookingsTable = $('#bookings-table').DataTable({
        pageLength: 10,
        order: [[11, 'desc']],
        columnDefs: [
            { orderable: false, targets: [10, 12] }
        ],
        language: {
            search: 'Tìm kiếm:',
            lengthMenu: 'Hiện _MENU_ dòng',
            info: 'Hiển thị _START_ đến _END_ / _TOTAL_ đơn',
            infoEmpty: 'Không có dữ liệu',
            zeroRecords: 'Không tìm thấy đơn đặt xe phù hợp',
            paginate: {
                first: 'Đầu',
                last: 'Cuối',
                next: 'Sau',
                previous: 'Trước'
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
        var $btn = $(this);
        var id = $btn.data('id');
        var url = $btn.data('url');
        var $row = $btn.closest('tr');
        if (!confirm('Xóa đơn #' + id + '?')) return;

        $btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i>');

        $.ajax({
            url: url,
            type: 'DELETE',
            data: { _token: '{{ csrf_token() }}' },
            success: function(res) {
                bookingsTable.row($row).remove().draw(false);
                showToast(res.message || 'Đã xóa');
            },
            error: function() {
                showToast('Lỗi khi xóa', 'error');
                $btn.prop('disabled', false).html('<i class="fas fa-trash"></i>');
            }
        });
    });

    $(document).on('change', '.status-select', function() {
        var $sel = $(this);
        var url = $sel.data('url');
        var newStatus = $sel.val();

        $.ajax({
            url: url,
            type: 'POST',
            data: { _token: '{{ csrf_token() }}', status: newStatus },
            success: function(res) {
                showToast(res.message || 'Đã cập nhật trạng thái');
            },
            error: function() {
                showToast('Lỗi khi cập nhật trạng thái', 'error');
            }
        });
    });
});
</script>
@stop
