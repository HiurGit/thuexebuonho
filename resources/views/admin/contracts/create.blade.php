@extends('adminlte::page')

@section('title', 'Tạo hợp đồng mới')

@section('content_header')
    <h1>Tạo hợp đồng thuê xe mới</h1>
@stop

@section('content')
<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.contracts.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @include('admin.contracts._form')
            <button type="submit" class="btn btn-success"><i class="fas fa-save mr-1"></i> Lưu hợp đồng</button>
            <a href="{{ route('admin.contracts.index') }}" class="btn btn-default">Hủy</a>
        </form>
    </div>
</div>
@stop