@extends('adminlte::page')

@section('title', 'Sửa đơn #' . $booking->id)

@section('content_header')
    <h1>Sửa đơn #{{ $booking->id }}</h1>
@stop

@section('content')
<div class="card">
    <div class="card-body">
        @if($errors->any())
            <div class="alert alert-danger">
                <div class="font-weight-bold mb-1">Không thể cập nhật đơn đặt xe:</div>
                <ul class="mb-0 pl-3">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form action="{{ route('admin.bookings.update', $booking) }}" method="POST">
            @csrf @method('PUT')
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Số điện thoại <span class="text-danger">*</span></label>
                        <input type="text" name="customer_phone" class="form-control @error('customer_phone') is-invalid @enderror" value="{{ old('customer_phone', $booking->customer_phone) }}" required>
                        @error('customer_phone') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label>Tên khách hàng</label>
                        <input type="text" name="customer_name" class="form-control" value="{{ old('customer_name', $booking->customer_name) }}">
                    </div>

                    <div class="form-group">
                        <label>Xe</label>
                        <select name="car_id" class="form-control @error('car_id') is-invalid @enderror">
                            <option value="">-- Không chọn --</option>
                            @foreach($cars as $car)
                                <option value="{{ $car->id }}" {{ old('car_id', $booking->car_id) == $car->id ? 'selected' : '' }}>{{ $car->name }}</option>
                            @endforeach
                        </select>
                        @error('car_id') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label>Loại thuê <span class="text-danger">*</span></label>
                        <select name="rental_type" class="form-control" required>
                            <option value="one-day" {{ old('rental_type', $booking->rental_type) == 'one-day' ? 'selected' : '' }}>Thuê 1 ngày</option>
                            <option value="multi-day" {{ old('rental_type', $booking->rental_type) == 'multi-day' ? 'selected' : '' }}>Thuê nhiều ngày</option>
                            <option value="hourly" {{ old('rental_type', $booking->rental_type) == 'hourly' ? 'selected' : '' }}>Thuê theo buổi</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Buổi (nếu theo buổi)</label>
                        <select name="session_type" class="form-control">
                            <option value="">-- Không --</option>
                            <option value="sang" {{ old('session_type', $booking->session_type) == 'sang' ? 'selected' : '' }}>Sáng (6h-12h)</option>
                            <option value="chieu" {{ old('session_type', $booking->session_type) == 'chieu' ? 'selected' : '' }}>Chiều (12h-18h)</option>
                            <option value="toi" {{ old('session_type', $booking->session_type) == 'toi' ? 'selected' : '' }}>Tối (18h-23h)</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Kế hoạch chuyến đi</label>
                        <select name="trip_plan" class="form-control">
                            <option value="in-province" {{ old('trip_plan', $booking->trip_plan ?: 'in-province') == 'in-province' ? 'selected' : '' }}>Di chuyển trong tỉnh</option>
                            <option value="out-province" {{ old('trip_plan', $booking->trip_plan) == 'out-province' ? 'selected' : '' }}>Di chuyển ngoài tỉnh</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Hình thức nhận xe</label>
                        <select name="pickup_type" class="form-control">
                            <option value="shop" {{ old('pickup_type', $booking->pickup_type ?: 'shop') == 'shop' ? 'selected' : '' }}>Nhận tại shop</option>
                            <option value="delivery" {{ old('pickup_type', $booking->pickup_type) == 'delivery' ? 'selected' : '' }}>Giao xe tận nơi</option>
                        </select>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label>Ngày nhận (dd/mm/yyyy)</label>
                                <div class="input-group date-input-shell">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                    </div>
                                    <input type="text" name="start_date" class="form-control js-date-picker" value="{{ old('start_date', $booking->start_date ? $booking->start_date->format('d/m/Y') : '') }}" placeholder="dd/mm/yyyy" autocomplete="off">
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label>Ngày trả (dd/mm/yyyy)</label>
                                <div class="input-group date-input-shell">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="far fa-calendar-check"></i></span>
                                    </div>
                                    <input type="text" name="end_date" class="form-control js-date-picker" value="{{ old('end_date', $booking->end_date ? $booking->end_date->format('d/m/Y') : '') }}" placeholder="dd/mm/yyyy" autocomplete="off">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label>Giờ nhận</label>
                                <div class="input-group date-input-shell">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="far fa-clock"></i></span>
                                    </div>
                                    <input type="text" name="start_time" class="form-control js-time-picker" value="{{ old('start_time', $booking->start_time) }}" placeholder="06:00" autocomplete="off">
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label>Giờ trả</label>
                                <div class="input-group date-input-shell">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="far fa-clock"></i></span>
                                    </div>
                                    <input type="text" name="end_time" class="form-control js-time-picker" value="{{ old('end_time', $booking->end_time) }}" placeholder="22:00" autocomplete="off">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label>Số ngày</label>
                                <input type="number" name="days" class="form-control" value="{{ old('days', $booking->days) }}" min="1">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label>Tổng tiền</label>
                                <input type="number" name="total_price" class="form-control" value="{{ old('total_price', $booking->total_price) }}">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Trạng thái</label>
                        <select name="status" class="form-control">
                            <option value="pending" {{ old('status', $booking->status) == 'pending' ? 'selected' : '' }}>Chờ xử lý</option>
                            <option value="confirmed" {{ old('status', $booking->status) == 'confirmed' ? 'selected' : '' }}>Đã xác nhận</option>
                            <option value="delivered" {{ old('status', $booking->status) == 'delivered' ? 'selected' : '' }}>Đã giao</option>
                            <option value="completed" {{ old('status', $booking->status) == 'completed' ? 'selected' : '' }}>Hoàn thành</option>
                            <option value="cancelled" {{ old('status', $booking->status) == 'cancelled' ? 'selected' : '' }}>Đã hủy</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Ghi chú</label>
                        <textarea name="notes" class="form-control" rows="2">{{ old('notes', $booking->notes) }}</textarea>
                    </div>
                </div>
            </div>

            <div class="mt-3">
                <button type="submit" class="btn btn-success"><i class="fas fa-save mr-1"></i> Cập nhật</button>
                <a href="{{ route('admin.bookings.index') }}" class="btn btn-default">Hủy</a>
            </div>
        </form>
    </div>
</div>
@stop

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/vendor/flatpickr/flatpickr.min.css') }}">
    <style>
        .date-input-shell .input-group-text {
            background: linear-gradient(135deg, #eef6ff 0%, #dceeff 100%);
            border-color: #c8dcf5;
            color: #1565c0;
        }
        .date-input-shell .form-control {
            border-left: 0;
            border-color: #c8dcf5;
            background: #fbfdff;
            font-weight: 600;
        }
        .date-input-shell .form-control:focus {
            border-color: #86b7fe;
            box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.12);
        }
        .flatpickr-calendar {
            border-radius: 14px;
            border: 1px solid #dbe7f3;
            box-shadow: 0 16px 40px rgba(33, 37, 41, 0.16);
        }
    </style>
@stop

@section('js')
    <script src="{{ asset('assets/vendor/flatpickr/flatpickr.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/flatpickr/l10n/vn.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            if (typeof flatpickr === 'undefined') return;

            flatpickr.localize(flatpickr.l10ns.vn || flatpickr.l10ns.default);

            document.querySelectorAll('.js-date-picker').forEach(function (input) {
                flatpickr(input, {
                    dateFormat: 'd/m/Y',
                    allowInput: false,
                    disableMobile: true,
                    locale: 'vn'
                });
            });

            document.querySelectorAll('.js-time-picker').forEach(function (input) {
                flatpickr(input, {
                    enableTime: true,
                    noCalendar: true,
                    dateFormat: 'H:i',
                    time_24hr: true,
                    minuteIncrement: 5,
                    allowInput: false,
                    disableMobile: true,
                    locale: 'vn'
                });
            });
        });
    </script>
@stop
