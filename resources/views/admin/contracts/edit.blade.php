@extends('adminlte::page')

@section('title', 'Sửa hợp đồng: ' . $contract->contract_code)

@section('content_header')
    <h1>Sửa hợp đồng: {{ $contract->contract_code }}</h1>
@stop

@section('content')
<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.contracts.update', $contract) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            @include('admin.contracts._form')
            <button type="submit" class="btn btn-success"><i class="fas fa-save mr-1"></i> Cập nhật</button>
            <a href="{{ route('admin.contracts.show', $contract) }}" class="btn btn-info">Xem chi tiết</a>
            <a href="{{ route('admin.contracts.index') }}" class="btn btn-default">Hủy</a>
        </form>
    </div>
</div>
@stop