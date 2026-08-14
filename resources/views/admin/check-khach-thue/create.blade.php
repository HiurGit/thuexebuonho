@extends('adminlte::page')

@section('title', 'Thêm khách hàng')

@section('content_header')
    <h1>Thêm khách hàng mới</h1>
@stop

@section('content')
<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.check-khach-thue.store') }}" method="POST">
            @csrf
            @include('admin.check-khach-thue._form')
            <button type="submit" class="btn btn-success mt-3"><i class="fas fa-save mr-1"></i> Lưu</button>
            <a href="{{ route('admin.check-khach-thue.index') }}" class="btn btn-default mt-3">Hủy</a>
        </form>
    </div>
</div>
@stop
