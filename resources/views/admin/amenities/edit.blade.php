@extends('adminlte::page')

@section('title', 'Sửa tiện ích: ' . $amenity->name)

@section('content_header')
    <h1>Sửa tiện ích: {{ $amenity->name }}</h1>
@stop

@section('content')
<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.amenities.update', $amenity) }}" method="POST" enctype="multipart/form-data">
            @csrf @method('PUT')
            @include('admin.amenities._form')
            <button type="submit" class="btn btn-success"><i class="fas fa-save mr-1"></i> Cập nhật</button>
            <a href="{{ route('admin.amenities.index') }}" class="btn btn-default">Hủy</a>
        </form>
    </div>
</div>
@stop
