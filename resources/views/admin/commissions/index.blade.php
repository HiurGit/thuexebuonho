@extends('adminlte::page')

@section('title', 'Hoa hồng cộng tác viên')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>Hoa hồng cộng tác viên</h1>
        <a href="{{ route('admin.collaborators.index') }}" class="btn btn-default">
            <i class="fas fa-users mr-1"></i> Danh sách CTV
        </a>
    </div>
@stop

@section('content')
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        {{ session('error') }}
    </div>
@endif

<div class="row">
    <div class="col-md-6">
        <div class="small-box bg-warning">
            <div class="inner">
                <h3>{{ number_format($stats['pending_amount'], 0, ',', '.') }}đ</h3>
                <p>Chờ thanh toán ({{ $stats['pending_count'] }} hợp đồng)</p>
            </div>
            <div class="icon"><i class="fas fa-hourglass-half"></i></div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="small-box bg-success">
            <div class="inner">
                <h3>{{ number_format($stats['paid_amount'], 0, ',', '.') }}đ</h3>
                <p>Đã thanh toán ({{ $stats['paid_count'] }} hợp đồng)</p>
            </div>
            <div class="icon"><i class="fas fa-check-circle"></i></div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <form method="GET" class="form-inline">
            <input type="text" name="q" value="{{ request('q') }}" class="form-control mr-2 mb-1" placeholder="Mã HĐ, tên hoặc SĐT khách">
            <select name="collaborator_id" class="form-control mr-2 mb-1">
                <option value="">-- Tất cả CTV --</option>
                @foreach($collaborators as $collaborator)
                    <option value="{{ $collaborator->id }}" {{ (string) request('collaborator_id') === (string) $collaborator->id ? 'selected' : '' }}>
                        {{ $collaborator->name }} {{ $collaborator->code ? '('.$collaborator->code.')' : '' }}
                    </option>
                @endforeach
            </select>
            <select name="status" class="form-control mr-2 mb-1">
                <option value="">-- Tất cả trạng thái --</option>
                @foreach(\App\Models\CollaboratorCommission::STATUS_LABELS as $value => $label)
                    <option value="{{ $value }}" {{ request('status') === $value ? 'selected' : '' }}>{{ $label }}</option>
                @endforeach
            </select>
            <button class="btn btn-primary mb-1"><i class="fas fa-search mr-1"></i> Lọc</button>
            @if(request()->hasAny(['q', 'status', 'collaborator_id']))
                <a href="{{ route('admin.commissions.index') }}" class="btn btn-default ml-2 mb-1">Xóa lọc</a>
            @endif
        </form>
    </div>
    <div class="card-body table-responsive">
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>Ngày ghi nhận</th>
                    <th>Cộng tác viên</th>
                    <th>Hợp đồng</th>
                    <th>Khách hàng</th>
                    <th class="text-right">Tiền thuê</th>
                    <th class="text-right">Hoa hồng</th>
                    <th>Trạng thái</th>
                    <th>Thanh toán</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                @forelse($commissions as $commission)
                <tr>
                    <td>
                        {{ $commission->recognized_at ? $commission->recognized_at->format('d/m/Y H:i') : '-' }}
                        @if($commission->contract)
                            <br><small class="text-muted">Trả xe: {{ $commission->contract->status_label }}</small>
                        @endif
                    </td>
                    <td>
                        @if($commission->collaborator)
                            <a href="{{ route('admin.collaborators.edit', $commission->collaborator) }}">
                                <strong>{{ $commission->collaborator->name }}</strong>
                            </a>
                            <br><small class="text-muted">{{ $commission->collaborator->code }}</small>
                        @else
                            <span class="text-muted">Đã xóa</span>
                        @endif
                    </td>
                    <td>
                        @if($commission->contract)
                            <a href="{{ route('admin.contracts.show', $commission->contract) }}">{{ $commission->contract_code }}</a>
                        @else
                            {{ $commission->contract_code }}
                        @endif
                    </td>
                    <td>
                        {{ $commission->customer_name }}
                        @if($commission->customer_phone)
                            <br><small class="text-muted">{{ $commission->customer_phone }}</small>
                        @endif
                    </td>
                    <td class="text-right">{{ number_format($commission->contract_total, 0, ',', '.') }}đ</td>
                    <td class="text-right">
                        <strong class="text-danger">{{ number_format($commission->commission_amount, 0, ',', '.') }}đ</strong>
                        <br><small class="text-muted">{{ rtrim(rtrim(number_format((float) $commission->commission_rate, 2, ',', '.'), '0'), ',') }}%</small>
                    </td>
                    <td><span class="badge badge-{{ $commission->status_badge }}">{{ $commission->status_label }}</span></td>
                    <td>
                        @if($commission->paid_at)
                            {{ $commission->paid_at->format('d/m/Y H:i') }}
                            @if($commission->payer)
                                <br><small class="text-muted">bởi {{ $commission->payer->name }}</small>
                            @endif
                        @else
                            <span class="text-muted">-</span>
                        @endif
                    </td>
                    <td class="text-nowrap">
                        @if($commission->status === 'pending')
                            <form action="{{ route('admin.commissions.paid', $commission) }}" method="POST" class="d-inline" onsubmit="return confirm('Xác nhận đã chuyển khoản hoa hồng này?')">
                                @csrf
                                <button class="btn btn-sm btn-success" title="Đánh dấu đã thanh toán"><i class="fas fa-check"></i> Đã trả</button>
                            </form>
                            <form action="{{ route('admin.commissions.cancel', $commission) }}" method="POST" class="d-inline" onsubmit="return confirm('Hủy khoản hoa hồng này?')">
                                @csrf
                                <button class="btn btn-sm btn-outline-danger" title="Hủy"><i class="fas fa-times"></i></button>
                            </form>
                        @elseif($commission->status === 'paid')
                            <form action="{{ route('admin.commissions.pending', $commission) }}" method="POST" class="d-inline" onsubmit="return confirm('Chuyển lại trạng thái chờ thanh toán?')">
                                @csrf
                                <button class="btn btn-sm btn-outline-warning" title="Hoàn tác thanh toán"><i class="fas fa-undo"></i></button>
                            </form>
                        @endif
                    </td>
                </tr>
                @empty
                <tr><td colspan="9" class="text-center text-muted py-4">Chưa có khoản hoa hồng nào.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($commissions->hasPages())
        <div class="card-footer">{{ $commissions->links() }}</div>
    @endif
</div>
@stop
