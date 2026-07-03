@extends('adminlte::page')

@section('title', 'Thêm tiện ích')

@section('content_header')
    <h1>Thêm tiện ích mới</h1>
@stop

@section('content')
<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.amenities.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @include('admin.amenities._form')
            <button type="submit" class="btn btn-success mt-3"><i class="fas fa-save mr-1"></i> Lưu</button>
            <a href="{{ route('admin.amenities.index') }}" class="btn btn-default mt-3">Hủy</a>
        </form>
    </div>
</div>
@stop
