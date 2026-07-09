@extends('adminlte::page')

@section('title', 'Truy cập website')

@section('content_header')
    <h1>Truy cập website</h1>
@stop

@section('content')
<div class="row">
    <div class="col-lg-2 col-6">
        <div class="small-box bg-info">
            <div class="inner">
                <h3>{{ number_format($total) }}</h3>
                <p>Tổng khách</p>
            </div>
            <div class="icon"><i class="fas fa-users"></i></div>
        </div>
    </div>
    <div class="col-lg-2 col-6">
        <div class="small-box bg-success">
            <div class="inner">
                <h3>{{ number_format($todayNew) }}</h3>
                <p>Khách mới hôm nay</p>
            </div>
            <div class="icon"><i class="fas fa-user-plus"></i></div>
        </div>
    </div>
    <div class="col-lg-2 col-6">
        <div class="small-box bg-warning">
            <div class="inner">
                <h3>{{ number_format($activeToday) }}</h3>
                <p>Hoạt động hôm nay</p>
            </div>
            <div class="icon"><i class="fas fa-chart-line"></i></div>
        </div>
    </div>
    <div class="col-lg-3 col-6">
        <div class="small-box bg-primary">
            <div class="inner">
                <h3>{{ number_format($last7Days) }}</h3>
                <p>Khách mới 7 ngày</p>
            </div>
            <div class="icon"><i class="fas fa-calendar-week"></i></div>
        </div>
    </div>
    <div class="col-lg-3 col-6">
        <div class="small-box bg-danger">
            <div class="inner">
                <h3>{{ number_format($last30Days) }}</h3>
                <p>Khách mới 30 ngày</p>
            </div>
            <div class="icon"><i class="fas fa-calendar-alt"></i></div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Khách gần đây</h3>
            </div>
            <div class="card-body table-responsive p-0">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>IP</th>
                            <th>Thiết bị</th>
                            <th>Lần đầu</th>
                            <th>Lần cuối</th>
                            <th>Số lần</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentVisitors as $visitor)
                            <tr>
                                <td class="text-nowrap">{{ $visitor->ip_address ? preg_replace('/\.\d+$/', '.***', $visitor->ip_address) : 'Không rõ' }}</td>
                                <td>
                                    @if($visitor->device_type)
                                        @switch($visitor->device_type)
                                            @case('Mobile')<i class="fas fa-mobile-alt text-primary mr-1"></i>@break
                                            @case('Tablet')<i class="fas fa-tablet-alt text-info mr-1"></i>@break
                                            @case('Bot')<i class="fas fa-robot text-secondary mr-1"></i>@break
                                            @default<i class="fas fa-desktop text-success mr-1"></i>
                                        @endswitch
                                        <span class="badge badge-{{ $visitor->device_type === 'Bot' ? 'secondary' : ($visitor->device_type === 'Mobile' ? 'primary' : ($visitor->device_type === 'Tablet' ? 'info' : 'success')) }} mr-1">{{ $visitor->device_type }}</span>
                                    @endif
                                    <small class="text-muted">
                                        {{ $visitor->browser ?: '' }}{{ $visitor->browser && $visitor->platform ? ' / ' : '' }}{{ $visitor->platform ?: '' }}
                                    </small>
                                </td>
                                <td class="text-nowrap">{{ $visitor->first_visited_at?->format('d/m H:i') }}</td>
                                <td class="text-nowrap">{{ $visitor->last_visited_at?->format('d/m H:i') }}</td>
                                <td>{{ number_format($visitor->visit_count) }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted">Chưa có dữ liệu.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Xe được xem nhiều</h3>
            </div>
            <div class="card-body p-0">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Xe</th>
                            <th class="text-center">Khách xem</th>
                            <th class="text-center">Lượt xem</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($topCarViews as $cv)
                            <tr>
                                <td>
                                    <a href="{{ route('admin.cars.edit', $cv->car) }}" target="_blank">
                                        {{ $cv->car?->name ?? '#' . $cv->car_id }}
                                    </a>
                                </td>
                                <td class="text-center"><span class="badge badge-info">{{ number_format($cv->unique_viewers) }}</span></td>
                                <td class="text-center">{{ number_format($cv->total_views) }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center text-muted">Chưa có dữ liệu.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="card-footer text-muted">
                <small>Top 10 xe có lượt xem nhiều nhất</small>
            </div>
        </div>
    </div>
</div>
@stop
