@extends('adminlte::page')

@section('title', 'Tổng quan')

@section('content_header')
    <h1>Tổng quan</h1>
@stop

@section('content')
@php
use App\Models\Car;
use App\Models\Booking;
$totalCars = Car::count();
$availableCars = Car::where('status', 'available')->count();
$rentedCars = Car::where('status', 'rented')->count();
$totalBookings = Booking::count();
$pendingBookings = Booking::where('status', 'pending')->count();
@endphp

<div class="row">
    <div class="col-lg-3 col-6">
        <div class="small-box bg-info">
            <div class="inner">
                <h3>{{ $availableCars }}</h3>
                <p>Xe sẵn sàng</p>
            </div>
            <div class="icon"><i class="fas fa-car"></i></div>
            <a href="{{ route('admin.cars.index') }}" class="small-box-footer">Xem thêm <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <div class="col-lg-3 col-6">
        <div class="small-box bg-success">
            <div class="inner">
                <h3>{{ $totalBookings }}</h3>
                <p>Tổng đơn đặt xe</p>
            </div>
            <div class="icon"><i class="fas fa-calendar-check"></i></div>
            <a href="{{ route('admin.bookings.index') }}" class="small-box-footer">Xem thêm <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <div class="col-lg-3 col-6">
        <div class="small-box bg-warning">
            <div class="inner">
                <h3>{{ $pendingBookings }}</h3>
                <p>Đơn chờ xử lý</p>
            </div>
            <div class="icon"><i class="fas fa-clock"></i></div>
            <a href="{{ route('admin.bookings.index') }}" class="small-box-footer">Xem thêm <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <div class="col-lg-3 col-6">
        <div class="small-box bg-danger">
            <div class="inner">
                <h3>{{ $rentedCars }}</h3>
                <p>Xe đang thuê</p>
            </div>
            <div class="icon"><i class="fas fa-exchange-alt"></i></div>
            <a href="{{ route('admin.cars.index') }}" class="small-box-footer">Xem thêm <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Danh sách xe</h3>
            </div>
            <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                    <thead>
                        <tr><th>Tên xe</th><th>Ghế</th><th>Giá/ngày</th><th>Trạng thái</th></tr>
                    </thead>
                    <tbody>
                        @foreach(Car::orderBy('sort_order')->get() as $car)
                        <tr>
                            <td>{{ $car->name }}</td>
                            <td>{{ $car->seats }} chỗ</td>
                            <td>{{ number_format($car->price_per_day) }}đ</td>
                            <td>
                                @if($car->status == 'available') <span class="badge badge-success">Sẵn sàng</span>
                                @elseif($car->status == 'rented') <span class="badge badge-warning">Đang thuê</span>
                                @else <span class="badge badge-danger">Bảo trì</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Thông tin hệ thống</h3>
            </div>
            <div class="card-body">
                <p><strong>Số điện thoại:</strong> {{ \App\Models\Setting::get('site_phone') }}</p>
                <p><strong>Địa chỉ:</strong> {{ \App\Models\Setting::get('site_address') }}</p>
                <p><strong>Phí giao xe:</strong> {{ number_format(\App\Models\Setting::get('delivery_fee_per_km')) }}đ/km</p>
                <p><strong>Phí trả trễ:</strong> {{ number_format(\App\Models\Setting::get('late_return_fee_per_hour')) }}đ/giờ</p>
                <p><strong>Phí vệ sinh:</strong> {{ number_format(\App\Models\Setting::get('cleaning_fee')) }}đ</p>
            </div>
        </div>
    </div>
</div>
@stop

