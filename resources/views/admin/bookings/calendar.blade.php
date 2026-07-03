@extends('adminlte::page')

@section('title', 'Lich thue xe')
@section('plugins.Datatables', true)

@section('content_header')
    <div class="d-flex justify-content-between align-items-center flex-wrap">
        <div>
            <h1 class="mb-1">Lich thue xe</h1>
            <p class="text-muted mb-0">Quan ly lich dat xe theo thang bang FullCalendar.</p>
        </div>
        <div class="d-flex mt-2 mt-md-0">
            <a href="{{ route('admin.bookings.create') }}" class="btn btn-success mr-2">
                <i class="fas fa-plus mr-1"></i> Them don
            </a>
            <a href="{{ route('admin.bookings.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-list mr-1"></i> Danh sach don
            </a>
        </div>
    </div>
@stop

@section('content')
<div class="row">
    <div class="col-lg-3 col-md-6">
        <div class="small-box bg-gradient-info">
            <div class="inner">
                <h3>{{ $stats['total_bookings'] }}</h3>
                <p>Don trong thang</p>
            </div>
            <div class="icon"><i class="fas fa-calendar-check"></i></div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="small-box bg-gradient-success">
            <div class="inner">
                <h3>{{ $stats['total_cars'] }}</h3>
                <p>{{ $selectedCar ? 'Xe dang loc' : 'Tong so xe' }}</p>
            </div>
            <div class="icon"><i class="fas fa-car-side"></i></div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="small-box bg-gradient-warning">
            <div class="inner">
                <h3>{{ $stats['occupied_days'] }}</h3>
                <p>Ngay co lich thue</p>
            </div>
            <div class="icon"><i class="fas fa-clock"></i></div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="small-box bg-gradient-secondary">
            <div class="inner">
                <h3>{{ $stats['pending_bookings'] }}</h3>
                <p>Don cho xu ly</p>
            </div>
            <div class="icon"><i class="fas fa-hourglass-half"></i></div>
        </div>
    </div>
</div>

@if($overlapWarnings->isNotEmpty())
<div class="card card-danger card-outline">
    <div class="card-header">
        <h3 class="card-title font-weight-bold">Canh bao trung lich cung xe</h3>
    </div>
    <div class="card-body">
        <div class="alert alert-danger mb-3">
            Co <strong>{{ $overlapWarnings->count() }}</strong> don dang trung lich. He thong khong chan luu, nhung ban nen goi tu van khach doi xe hoac doi ngay.
        </div>
        <div class="row">
            @foreach($overlapWarnings as $booking)
                <div class="col-lg-4 col-md-6 mb-3">
                    <a href="{{ route('admin.bookings.edit', $booking) }}" class="d-block border rounded p-3 text-dark bg-light">
                        <div class="font-weight-bold">{{ $booking->car?->name ?? '-' }}</div>
                        <div class="small text-muted">{{ $booking->customer_name ?: 'Khach ' . substr($booking->customer_phone, -4) }}</div>
                        <div class="small text-danger">
                            {{ optional($booking->start_date)->format('d/m/Y') ?: '-' }}
                            -
                            {{ optional($booking->end_date)->format('d/m/Y') ?: optional($booking->start_date)->format('d/m/Y') ?: '-' }}
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endif

<div class="row">
    <div class="col-lg-4 col-md-6">
        <div class="card card-danger card-outline">
            <div class="card-header">
                <h3 class="card-title font-weight-bold">Xe đang bận</h3>
            </div>
            <div class="card-body p-2" style="min-height: 210px; max-height: 280px; overflow:auto;">
                @forelse($busyCars as $car)
                    <div class="border rounded px-3 py-2 mb-2 bg-light">
                        <div class="font-weight-bold">{{ $car->name }}</div>
                        <div class="small text-muted">Đang có lịch thuê hôm nay</div>
                    </div>
                @empty
                    <div class="text-muted small">Hiện không có xe nào đang bận.</div>
                @endforelse
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-6">
        <div class="card card-success card-outline">
            <div class="card-header">
                <h3 class="card-title font-weight-bold">Xe đang trống</h3>
            </div>
            <div class="card-body p-2" style="min-height: 210px; max-height: 280px; overflow:auto;">
                @forelse($freeCars as $car)
                    <div class="border rounded px-3 py-2 mb-2 bg-light">
                        <div class="font-weight-bold">{{ $car->name }}</div>
                        <div class="small text-muted">Trống trong ngày hôm nay</div>
                    </div>
                @empty
                    <div class="text-muted small">Chưa có xe trống.</div>
                @endforelse
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-6">
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h3 class="card-title font-weight-bold">Xe sắp cho thuê</h3>
            </div>
            <div class="card-body p-2" style="min-height: 210px; max-height: 280px; overflow:auto;">
                @forelse($startingSoonBookings as $booking)
                    <a href="{{ route('admin.bookings.edit', $booking) }}" class="d-block border rounded px-3 py-2 mb-2 bg-light text-dark">
                        <div class="font-weight-bold">{{ $booking->car?->name ?? '-' }}</div>
                        <div class="small text-muted">{{ $booking->customer_name ?: 'Khach' }}</div>
                        <div class="small text-primary">Bat dau: {{ optional($booking->start_date)->format('d/m/Y') ?: '-' }}</div>
                    </a>
                @empty
                    <div class="text-muted small">Không có xe nào sắp cho thuê trong 2 ngày tới.</div>
                @endforelse
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-6 col-md-6">
        <div class="card card-warning card-outline">
            <div class="card-header">
                <h3 class="card-title font-weight-bold">Xe sắp trả</h3>
            </div>
            <div class="card-body p-2" style="min-height: 210px; max-height: 280px; overflow:auto;">
                @forelse($dueSoonBookings as $booking)
                    <a href="{{ route('admin.bookings.edit', $booking) }}" class="d-block border rounded px-3 py-2 mb-2 bg-light text-dark">
                        <div class="font-weight-bold">{{ $booking->car?->name ?? '-' }}</div>
                        <div class="small text-muted">{{ $booking->customer_name ?: 'Khach' }}</div>
                        <div class="small text-warning">Tra xe: {{ optional($booking->end_date)->format('d/m/Y') ?: '-' }}</div>
                    </a>
                @empty
                    <div class="text-muted small">Không có xe nào sắp trả trong 1 ngày tới.</div>
                @endforelse
            </div>
        </div>
    </div>
    <div class="col-lg-6 col-md-6">
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h3 class="card-title font-weight-bold">Có khoảng trống</h3>
            </div>
            <div class="card-body p-2" style="min-height: 210px; max-height: 280px; overflow:auto;">
                @forelse($openCars as $item)
                    <div class="border rounded px-3 py-2 mb-2 bg-light">
                        <div class="font-weight-bold">{{ $item['car']->name }}</div>
                        @if($item['next_booking'])
                            <div class="small text-muted">Rảnh đến trước {{ optional($item['next_booking']->start_date)->format('d/m/Y') }}</div>
                        @else
                            <div class="small text-muted">Chưa có lịch kế tiếp, có thể nhận khách mới</div>
                        @endif
                    </div>
                @empty
                    <div class="text-muted small">Chưa có xe có khoảng trống phù hợp.</div>
                @endforelse
            </div>
        </div>
    </div>
</div>

@if(!$selectedCar)
    <div class="card card-outline card-info">
        <div class="card-header">
            <h3 class="card-title font-weight-bold">Tra cuu tinh trang tat ca xe theo khoang ngay</h3>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('admin.bookings.calendar') }}" class="row">
                <input type="hidden" name="month" value="{{ $month->format('Y-m') }}">
                @if($selectedStatus)
                    <input type="hidden" name="status" value="{{ $selectedStatus }}">
                @endif
                <input type="hidden" name="monthly_sort" value="{{ $monthlySort }}">
                <input type="hidden" name="availability_date" value="{{ $availabilityDateInput }}" id="availability-date-start">
                <input type="hidden" name="availability_end_date" value="{{ $availabilityEndDateInput ?: $availabilityDateInput }}" id="availability-date-end">

                <div class="col-md-8 form-group">
                    <label class="font-weight-bold">Chon khoang ngay</label>
                    <div class="input-group date-input-shell">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                        </div>
                        <input
                            type="text"
                            value="{{ $availabilityDateInput ? ($availabilityDateInput . ($availabilityEndDateInput && $availabilityEndDateInput !== $availabilityDateInput ? ' to ' . $availabilityEndDateInput : '')) : '' }}"
                            class="form-control js-date-range-picker"
                            data-start-target="#availability-date-start"
                            data-end-target="#availability-date-end"
                            placeholder="Chon tu ngay den ngay"
                            autocomplete="off"
                        >
                    </div>
                </div>
                <div class="col-md-2 form-group d-flex align-items-end">
                    <button type="submit" class="btn btn-info btn-block">
                        <i class="fas fa-search mr-1"></i> Xem khoang
                    </button>
                </div>
            </form>

            @if($allCarsAvailability)
                <div class="alert alert-info mb-3">
                    Dang xem tinh trang tat ca xe tu {{ $allCarsAvailability['start_date']->format('d/m/Y') }}
                    den {{ $allCarsAvailability['end_date']->format('d/m/Y') }}.
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="small-box bg-gradient-success mb-0">
                            <div class="inner">
                                <h3>{{ $allCarsAvailability['free']->count() }}</h3>
                                <p>Xe ranh hoan toan trong khoang da chon</p>
                            </div>
                            <div class="icon"><i class="fas fa-check-circle"></i></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="small-box bg-gradient-danger mb-0">
                            <div class="inner">
                                <h3>{{ $allCarsAvailability['busy']->count() }}</h3>
                                <p>Xe dang ban hoac trung lich trong khoang da chon</p>
                            </div>
                            <div class="icon"><i class="fas fa-car-crash"></i></div>
                        </div>
                    </div>
                </div>

                <div class="card card-success card-outline mb-3">
                    <div class="card-header">
                        <h3 class="card-title font-weight-bold">Danh sach xe ranh trong khoang da chon</h3>
                    </div>
                    <div class="card-body">
                        @if($allCarsAvailability['free']->isNotEmpty())
                            <div class="mb-2 text-success font-weight-bold">
                                Trong khoang {{ $allCarsAvailability['start_date']->format('d/m/Y') }} - {{ $allCarsAvailability['end_date']->format('d/m/Y') }},
                                cac xe sau dang ranh hoan toan:
                            </div>
                            <div class="row">
                                @foreach($allCarsAvailability['free'] as $item)
                                    <div class="col-lg-4 col-md-6 mb-2">
                                        <div class="border rounded px-3 py-2 bg-white h-100">
                                            <div class="font-weight-bold">{{ $item['car']->name }}</div>
                                            <div class="small text-muted">Ranh tron khoang da chon</div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-muted">Khong co xe nao ranh hoan toan trong khoang nay.</div>
                        @endif
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-6">
                        <div class="border rounded p-3 h-100">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <h4 class="h6 font-weight-bold mb-0 text-danger">Xe dang ban</h4>
                                <span class="badge badge-danger">{{ $allCarsAvailability['busy']->count() }}</span>
                            </div>
                            <div style="max-height: 320px; overflow:auto;">
                                @forelse($allCarsAvailability['busy'] as $item)
                                    <div class="border rounded px-3 py-2 mb-2 bg-light">
                                        <div class="font-weight-bold">{{ $item['car']->name }}</div>
                                        @foreach($item['conflicts'] as $conflict)
                                            <div class="small text-muted">
                                                {{ optional($conflict->start_date)->format('d/m/Y') }}
                                                -
                                                {{ optional($conflict->end_date)->format('d/m/Y') ?: optional($conflict->start_date)->format('d/m/Y') }}
                                                | {{ $conflict->customer_name ?: 'Khach ' . substr($conflict->customer_phone, -4) }}
                                            </div>
                                        @endforeach
                                    </div>
                                @empty
                                    <div class="text-muted small">Khong co xe nao dang ban trong khoang ngay nay.</div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 mt-3 mt-lg-0">
                        <div class="border rounded p-3 h-100">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <h4 class="h6 font-weight-bold mb-0 text-success">Xe dang ranh</h4>
                                <span class="badge badge-success">{{ $allCarsAvailability['free']->count() }}</span>
                            </div>
                            <div style="max-height: 320px; overflow:auto;">
                                @forelse($allCarsAvailability['free'] as $item)
                                    <div class="border rounded px-3 py-2 mb-2 bg-white">
                                        <div class="font-weight-bold">{{ $item['car']->name }}</div>
                                        <div class="small text-muted">Co the nhan khach trong toan bo khoang ngay nay.</div>
                                    </div>
                                @empty
                                    <div class="text-muted small">Khong con xe ranh trong khoang ngay nay.</div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <div class="card card-outline card-primary">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center flex-wrap w-100">
                <h3 class="card-title font-weight-bold mb-2 mb-md-0">Tinh trang tat ca xe trong thang {{ $month->format('m/Y') }}</h3>
                <form method="GET" action="{{ route('admin.bookings.calendar') }}" class="d-flex align-items-end">
                    <input type="hidden" name="month" value="{{ $month->format('Y-m') }}">
                    @if($selectedStatus)
                        <input type="hidden" name="status" value="{{ $selectedStatus }}">
                    @endif
                    @if($availabilityDateInput)
                        <input type="hidden" name="availability_date" value="{{ $availabilityDateInput }}">
                    @endif
                    @if($availabilityEndDateInput)
                        <input type="hidden" name="availability_end_date" value="{{ $availabilityEndDateInput }}">
                    @endif
                    <div class="form-group mb-0">
                        <label class="font-weight-bold small mb-1 d-block">Sap xep</label>
                        <div class="input-group input-group-sm">
                            <select name="monthly_sort" class="form-control" onchange="this.form.submit()">
                                <option value="time" {{ $monthlySort === 'time' ? 'selected' : '' }}>Theo thoi gian</option>
                                <option value="car" {{ $monthlySort === 'car' ? 'selected' : '' }}>Theo xe</option>
                            </select>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-lg-6">
                    <div class="border rounded p-3 h-100">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <h4 class="h6 font-weight-bold mb-0 text-danger">Khoang dang ban trong thang</h4>
                            <span class="badge badge-danger">{{ $allCarsBusySlots->count() }}</span>
                        </div>
                        <div style="max-height: 340px; overflow:auto;">
                            @forelse($allCarsBusySlots as $slot)
                                <a href="{{ route('admin.bookings.edit', $slot['booking']) }}" class="d-block border rounded px-3 py-2 mb-2 bg-light text-dark">
                                    <div class="font-weight-bold">{{ $slot['car']->name }}</div>
                                    <div class="small text-danger">{{ $slot['start']->format('d/m/Y') }} - {{ $slot['end']->format('d/m/Y') }}</div>
                                    <div class="small text-muted">
                                        {{ $slot['booking']->customer_name ?: 'Khach ' . substr($slot['booking']->customer_phone, -4) }}
                                        | {{ $statusLabels[$slot['booking']->status] ?? $slot['booking']->status }}
                                    </div>
                                </a>
                            @empty
                                <div class="text-muted small">Khong co khoang ban nao trong thang nay.</div>
                            @endforelse
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 mt-3 mt-lg-0">
                    <div class="border rounded p-3 h-100">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <h4 class="h6 font-weight-bold mb-0 text-success">Khoang dang ranh trong thang</h4>
                            <span class="badge badge-success">{{ $allCarsFreeSlots->count() }}</span>
                        </div>
                        <div style="max-height: 340px; overflow:auto;">
                            @forelse($allCarsFreeSlots as $slot)
                                <div class="border rounded px-3 py-2 mb-2 bg-white">
                                    <div class="font-weight-bold">{{ $slot['car']->name }}</div>
                                    <div class="small text-success">{{ $slot['start']->format('d/m/Y') }} - {{ $slot['end']->format('d/m/Y') }}</div>
                                    <div class="small text-muted">Co the nhan khach trong khoang nay.</div>
                                </div>
                            @empty
                                <div class="text-muted small">Khong co khoang ranh nao trong thang nay.</div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif

<div class="card">
    <div class="card-header">
        <h3 class="card-title font-weight-bold">Bo loc lich thue xe</h3>
    </div>
    <div class="card-body">
        <form method="GET" action="{{ route('admin.bookings.calendar') }}" class="row">
            <div class="col-md-3 form-group">
                <label class="font-weight-bold">Chon thang</label>
                <div class="input-group date-input-shell">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="far fa-calendar"></i></span>
                    </div>
                    <input type="text" name="month" value="{{ $month->format('Y-m') }}" class="form-control js-month-picker" placeholder="Chon thang" autocomplete="off">
                </div>
            </div>
            <div class="col-md-4 form-group">
                <label class="font-weight-bold">Loc theo xe</label>
                <select name="car_id" class="form-control">
                    <option value="">Tat ca xe</option>
                    @foreach($cars as $car)
                        <option value="{{ $car->id }}" {{ (string) $selectedCarId === (string) $car->id ? 'selected' : '' }}>
                            {{ $car->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3 form-group">
                <label class="font-weight-bold">Trang thai</label>
                <select name="status" class="form-control">
                    <option value="">Tat ca trang thai</option>
                    @foreach($statusLabels as $value => $label)
                        <option value="{{ $value }}" {{ $selectedStatus === $value ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2 form-group">
                <label class="font-weight-bold">Sap xep thang</label>
                <select name="monthly_sort" class="form-control">
                    <option value="time" {{ $monthlySort === 'time' ? 'selected' : '' }}>Theo thoi gian</option>
                    <option value="car" {{ $monthlySort === 'car' ? 'selected' : '' }}>Theo xe</option>
                </select>
            </div>
            <div class="col-md-1 form-group d-flex align-items-end">
                <button type="submit" class="btn btn-primary btn-block">
                    <i class="fas fa-filter mr-1"></i> Loc
                </button>
            </div>
        </form>
    </div>
</div>

<div class="row">
    <div class="col-lg-3">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title font-weight-bold">Danh sach xe</h3>
            </div>
            <div class="card-body p-2" style="max-height: 760px; overflow:auto;">
                <a href="{{ route('admin.bookings.calendar', array_filter(['month' => $month->format('Y-m'), 'status' => $selectedStatus, 'monthly_sort' => $monthlySort])) }}"
                   class="d-block rounded px-3 py-2 mb-2 {{ !$selectedCarId ? 'bg-primary text-white' : 'bg-light text-dark' }}">
                    <div class="font-weight-bold">Tat ca xe</div>
                    <div class="small {{ !$selectedCarId ? 'text-white-50' : 'text-muted' }}">Hien thi toan bo lich thue</div>
                </a>
                @foreach($cars as $car)
                    @php
                        $carBookingsCount = $bookings->where('car_id', $car->id)->count();
                        $isActive = (string) $selectedCarId === (string) $car->id;
                    @endphp
                    <a href="{{ route('admin.bookings.calendar', array_filter(['month' => $month->format('Y-m'), 'car_id' => $car->id, 'status' => $selectedStatus, 'monthly_sort' => $monthlySort])) }}"
                       class="d-block rounded px-3 py-2 mb-2 {{ $isActive ? 'bg-primary text-white' : 'bg-light text-dark' }}">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="font-weight-bold">{{ $car->name }}</span>
                            <span class="badge badge-{{ $carBookingsCount ? 'success' : 'secondary' }}">{{ $carBookingsCount }}</span>
                        </div>
                        <div class="small {{ $isActive ? 'text-white-50' : 'text-muted' }}">
                            {{ $car->status === 'maintenance' ? 'Bao tri' : ($car->status === 'rented' ? 'Dang thue' : 'San sang') }}
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </div>

    <div class="col-lg-9">
        @if($selectedCar)
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center flex-wrap w-100">
                        <h3 class="card-title font-weight-bold mb-2 mb-md-0">Tinh trang xe: {{ $selectedCar->name }}</h3>
                        <div class="btn-group btn-group-sm">
                            <a href="{{ route('admin.bookings.calendar', array_filter([
                                'month' => $month->copy()->subMonth()->format('Y-m'),
                                'car_id' => $selectedCar->id,
                                'status' => $selectedStatus,
                                'monthly_sort' => $monthlySort,
                            ])) }}" class="btn btn-outline-secondary">
                                <i class="fas fa-chevron-left mr-1"></i> Thang truoc
                            </a>
                            <a href="{{ route('admin.bookings.calendar', array_filter([
                                'month' => now()->format('Y-m'),
                                'car_id' => $selectedCar->id,
                                'status' => $selectedStatus,
                                'monthly_sort' => $monthlySort,
                            ])) }}" class="btn btn-outline-primary">
                                Thang nay
                            </a>
                            <a href="{{ route('admin.bookings.calendar', array_filter([
                                'month' => $month->copy()->addMonth()->format('Y-m'),
                                'car_id' => $selectedCar->id,
                                'status' => $selectedStatus,
                                'monthly_sort' => $monthlySort,
                            ])) }}" class="btn btn-outline-secondary">
                                Thang sau <i class="fas fa-chevron-right ml-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form method="GET" action="{{ route('admin.bookings.calendar') }}" class="row">
                        <input type="hidden" name="month" value="{{ $month->format('Y-m') }}">
                        <input type="hidden" name="car_id" value="{{ $selectedCar->id }}">
                        @if($selectedStatus)
                            <input type="hidden" name="status" value="{{ $selectedStatus }}">
                        @endif
                        <input type="hidden" name="monthly_sort" value="{{ $monthlySort }}">
                        <input type="hidden" name="availability_date" value="{{ $availabilityDateInput }}" id="car-availability-date-start">
                        <input type="hidden" name="availability_end_date" value="{{ $availabilityEndDateInput ?: $availabilityDateInput }}" id="car-availability-date-end">

                        <div class="col-md-8 form-group">
                            <label class="font-weight-bold">Tra cuu theo khoang ngay</label>
                            <div class="input-group date-input-shell">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                </div>
                                <input
                                    type="text"
                                    value="{{ $availabilityDateInput ? ($availabilityDateInput . ($availabilityEndDateInput && $availabilityEndDateInput !== $availabilityDateInput ? ' to ' . $availabilityEndDateInput : '')) : '' }}"
                                    class="form-control js-date-range-picker"
                                    data-start-target="#car-availability-date-start"
                                    data-end-target="#car-availability-date-end"
                                    placeholder="Chon tu ngay den ngay"
                                    autocomplete="off"
                                >
                            </div>
                        </div>
                        <div class="col-md-2 form-group d-flex align-items-end">
                            <button type="submit" class="btn btn-outline-primary btn-block">
                                <i class="fas fa-search mr-1"></i> Kiem tra
                            </button>
                        </div>
                    </form>

                    @if($availabilityCheck)
                        <div class="alert {{ $availabilityCheck['is_free'] ? 'alert-success' : 'alert-danger' }}">
                            <div class="font-weight-bold">
                                {{ $selectedCar->name }}
                                {{ $availabilityCheck['is_free'] ? 'dang ranh' : 'dang ban' }}
                                tu {{ $availabilityCheck['checked_at']->format('d/m/Y') }}
                                den {{ $availabilityCheck['checked_end_at']->format('d/m/Y') }}.
                            </div>
                            @if(!$availabilityCheck['is_free'])
                                <div class="small mb-2">Dang co {{ $availabilityCheck['conflicts']->count() }} don trung trong khoang nay.</div>
                                @foreach($availabilityCheck['conflicts'] as $conflict)
                                    <div class="small">
                                        - {{ optional($conflict->start_date)->format('d/m/Y') }}
                                        den
                                        {{ optional($conflict->end_date)->format('d/m/Y') ?: optional($conflict->start_date)->format('d/m/Y') }}
                                        | {{ $conflict->customer_name ?: 'Khach ' . substr($conflict->customer_phone, -4) }}
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    @endif

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="border rounded p-3 h-100">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <h4 class="h6 font-weight-bold mb-0 text-danger">Khoang dang ban trong thang</h4>
                                    <span class="badge badge-danger">{{ $carBusySlots->count() }}</span>
                                </div>
                                <div style="max-height: 320px; overflow:auto;">
                                    @forelse($carBusySlots as $slot)
                                        <a href="{{ route('admin.bookings.edit', $slot['booking']) }}" class="d-block border rounded px-3 py-2 mb-2 bg-light text-dark">
                                            <div class="font-weight-bold">
                                                {{ $slot['start']->format('d/m/Y') }} - {{ $slot['end']->format('d/m/Y') }}
                                            </div>
                                            <div class="small text-muted">
                                                {{ $slot['booking']->customer_name ?: 'Khach ' . substr($slot['booking']->customer_phone, -4) }}
                                                | {{ $statusLabels[$slot['booking']->status] ?? $slot['booking']->status }}
                                            </div>
                                        </a>
                                    @empty
                                        <div class="text-muted small">Khong co lich ban nao trong thang nay.</div>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 mt-3 mt-lg-0">
                            <div class="border rounded p-3 h-100">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <h4 class="h6 font-weight-bold mb-0 text-success">Khoang dang ranh trong thang</h4>
                                    <span class="badge badge-success">{{ $carFreeSlots->count() }}</span>
                                </div>
                                <div style="max-height: 320px; overflow:auto;">
                                    @forelse($carFreeSlots as $slot)
                                        <div class="border rounded px-3 py-2 mb-2 bg-white">
                                            <div class="font-weight-bold">
                                                {{ $slot['start']->format('d/m/Y') }} - {{ $slot['end']->format('d/m/Y') }}
                                            </div>
                                            <div class="small text-muted">Co the nhan khach trong khoang nay.</div>
                                        </div>
                                    @empty
                                        <div class="text-muted small">Khong co khoang ranh nao trong thang nay.</div>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center flex-wrap">
                <div>
                    <h3 class="card-title font-weight-bold mb-1">Lich thang {{ $month->format('m/Y') }}</h3>
                    <div class="small text-muted">
                        {{ $selectedCar ? 'Dang xem lich cua xe: ' . $selectedCar->name : 'Dang xem lich cua tat ca xe' }}
                    </div>
                </div>
                <div class="mt-2 mt-md-0">
                    <span class="badge badge-warning mr-1">Cho xu ly</span>
                    <span class="badge badge-primary mr-1">Da xac nhan</span>
                    <span class="badge badge-info mr-1">Da giao</span>
                    <span class="badge badge-success mr-1">Hoan thanh</span>
                    <span class="badge badge-secondary">Da huy</span>
                </div>
            </div>
            <div class="card-body">
                <div id="booking-calendar"></div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h3 class="card-title font-weight-bold">Danh sach don trong thang</h3>
            </div>
            <div class="card-body table-responsive">
                <table id="monthly-bookings-table" class="table table-bordered table-hover text-nowrap mb-0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Xe</th>
                            <th>Khach</th>
                            <th>Loai thue</th>
                            <th>Tu ngay</th>
                            <th>Den ngay</th>
                            <th>Trang thai</th>
                            <th>Tong tien</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($bookings as $booking)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $booking->car?->name ?? '-' }}</td>
                                <td>
                                    <div class="font-weight-bold">{{ $booking->customer_name ?: 'Khach ' . substr($booking->customer_phone, -4) }}</div>
                                    <div class="small text-muted">{{ $booking->customer_phone }}</div>
                                </td>
                                <td>
                                    @if($booking->rental_type === 'hourly')
                                        Theo buoi
                                        <div class="small text-muted">{{ $booking->session_label }}</div>
                                    @elseif($booking->rental_type === 'multi-day')
                                        Nhieu ngay
                                        <div class="small text-muted">{{ $booking->days }} ngay</div>
                                    @else
                                        1 ngay
                                    @endif
                                </td>
                                <td>
                                    {{ optional($booking->start_date)->format('d/m/Y') ?: '-' }}
                                    @if($booking->booking_time_label)
                                        <div class="small text-muted">{{ $booking->booking_time_label }}</div>
                                    @endif
                                </td>
                                <td>
                                    {{ optional($booking->end_date)->format('d/m/Y') ?: '-' }}
                                    @if($booking->rental_type !== 'hourly' && $booking->end_time)
                                        <div class="small text-muted">{{ $booking->end_time }}</div>
                                    @endif
                                </td>
                                <td><span class="badge badge-{{ $statusClasses[$booking->status] ?? 'secondary' }}">{{ $statusLabels[$booking->status] ?? $booking->status }}</span></td>
                                <td>{{ number_format((int) $booking->total_price) }}d</td>
                                <td>
                                    <a href="{{ route('admin.bookings.edit', $booking) }}" class="btn btn-xs btn-primary">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center text-muted py-4">Khong co lich thue trong thang nay.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@stop

@section('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.19/index.global.min.css">
    <link rel="stylesheet" href="{{ asset('assets/vendor/flatpickr/flatpickr.min.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/plugins/monthSelect/style.css">
    <style>
        #booking-calendar {
            min-height: 760px;
        }
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
        .flatpickr-day.selected,
        .flatpickr-day.startRange,
        .flatpickr-day.endRange,
        .flatpickr-day.selected.inRange,
        .flatpickr-day.startRange.inRange,
        .flatpickr-day.endRange.inRange {
            background: #007bff;
            border-color: #007bff;
        }
        .flatpickr-day.inRange {
            background: #e7f1ff;
            border-color: #e7f1ff;
            box-shadow: -5px 0 0 #e7f1ff, 5px 0 0 #e7f1ff;
        }
        .fc .fc-toolbar-title {
            font-size: 1.15rem;
            font-weight: 700;
        }
        .fc .fc-button {
            text-transform: capitalize;
        }
        .fc .fc-daygrid-event {
            border-radius: 6px;
            padding: 2px 4px;
            font-size: 0.75rem;
        }
        .fc .fc-daygrid-event.fc-event-overlap-warning {
            box-shadow: 0 0 0 2px rgba(220, 53, 69, 0.18);
        }
        .fc .fc-daygrid-day-number {
            color: #343a40;
            font-weight: 600;
        }
    </style>
@stop

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.19/index.global.min.js"></script>
    <script src="{{ asset('assets/vendor/flatpickr/flatpickr.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/flatpickr/l10n/vn.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/plugins/monthSelect/index.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            $('#monthly-bookings-table').DataTable({
                pageLength: 10,
                order: [[4, 'asc']],
                columnDefs: [
                    { orderable: false, targets: [8] }
                ],
                language: {
                    search: 'Tim kiem:',
                    lengthMenu: 'Hien _MENU_ dong',
                    info: 'Hien thi _START_ den _END_ / _TOTAL_ don trong thang',
                    infoEmpty: 'Khong co du lieu',
                    zeroRecords: 'Khong tim thay don phu hop',
                    paginate: {
                        first: 'Dau',
                        last: 'Cuoi',
                        next: 'Sau',
                        previous: 'Truoc'
                    }
                }
            });

            if (typeof flatpickr !== 'undefined') {
                flatpickr.localize(flatpickr.l10ns.vn || flatpickr.l10ns.default);

                document.querySelectorAll('.js-month-picker').forEach(function (input) {
                    flatpickr(input, {
                        dateFormat: 'Y-m',
                        altInput: true,
                        altFormat: 'm/Y',
                        allowInput: false,
                        disableMobile: true,
                        locale: 'vn',
                        plugins: [
                            new monthSelectPlugin({
                                shorthand: true,
                                dateFormat: 'Y-m',
                                altFormat: 'm/Y'
                            })
                        ]
                    });
                });

                document.querySelectorAll('.js-date-picker').forEach(function (input) {
                    flatpickr(input, {
                        dateFormat: 'Y-m-d',
                        altInput: true,
                        altFormat: 'd/m/Y',
                        allowInput: false,
                        disableMobile: true,
                        locale: 'vn'
                    });
                });

                document.querySelectorAll('.js-date-range-picker').forEach(function (input) {
                    flatpickr(input, {
                        mode: 'range',
                        dateFormat: 'Y-m-d',
                        altInput: true,
                        altFormat: 'd/m/Y',
                        conjunction: ' den ',
                        allowInput: false,
                        disableMobile: true,
                        locale: 'vn',
                        defaultDate: [
                            @json($availabilityDateInput ?: null),
                            @json(($availabilityEndDateInput && $availabilityEndDateInput !== $availabilityDateInput) ? $availabilityEndDateInput : null)
                        ].filter(Boolean),
                        onChange: function (selectedDates) {
                            var startSelector = input.dataset.startTarget;
                            var endSelector = input.dataset.endTarget;
                            var startInput = startSelector ? document.querySelector(startSelector) : null;
                            var endInput = endSelector ? document.querySelector(endSelector) : null;

                            if (!startInput || !endInput) {
                                return;
                            }

                            startInput.value = '';
                            endInput.value = '';

                            if (selectedDates[0]) {
                                startInput.value = flatpickr.formatDate(selectedDates[0], 'Y-m-d');
                                endInput.value = flatpickr.formatDate(selectedDates[selectedDates.length - 1], 'Y-m-d');
                            }
                        }
                    });
                });
            }

            var calendarEl = document.getElementById('booking-calendar');
            if (!calendarEl) return;

            var events = @json($calendarEvents);
            var initialDate = @json($month->format('Y-m-d'));

            var calendar = new FullCalendar.Calendar(calendarEl, {
                locale: 'vi',
                initialView: 'dayGridMonth',
                initialDate: initialDate,
                height: 'auto',
                firstDay: 1,
                events: events,
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'multiMonthYear,dayGridMonth,timeGridWeek,listWeek'
                },
                buttonText: {
                    today: 'Hom nay',
                    multiMonthYear: 'Nam',
                    month: 'Thang',
                    week: 'Tuan',
                    list: 'Danh sach'
                },
                views: {
                    multiMonthYear: {
                        type: 'multiMonthYear',
                        multiMonthMaxColumns: 3
                    }
                },
                eventTimeFormat: {
                    hour: '2-digit',
                    minute: '2-digit',
                    meridiem: false
                },
                eventClick: function(info) {
                    if (info.event.url) {
                        info.jsEvent.preventDefault();
                        window.location.href = info.event.url;
                    }
                },
                eventDidMount: function(info) {
                    var props = info.event.extendedProps || {};
                    if (props.hasOverlap) {
                        info.el.classList.add('fc-event-overlap-warning');
                    }
                    var tip = [
                        info.event.title,
                        props.statusLabel ? 'Trang thai: ' + props.statusLabel : null,
                        props.hasOverlap ? 'Canh bao: Trung lich cung xe' : null,
                        props.customerPhone ? 'SDT: ' + props.customerPhone : null,
                        props.totalPrice ? 'Tong tien: ' + props.totalPrice : null
                    ].filter(Boolean).join('\n');
                    info.el.setAttribute('title', tip);
                }
            });

            calendar.render();
        });
    </script>
@stop
