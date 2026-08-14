@extends('adminlte::page')

@section('title', 'Thêm cộng tác viên')

@section('content_header')
    <h1>Thêm cộng tác viên mới</h1>
@stop

@section('content')
<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.collaborators.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @include('admin.collaborators._form')
            <button type="submit" class="btn btn-success mt-3"><i class="fas fa-save mr-1"></i> Lưu</button>
            <a href="{{ route('admin.collaborators.index') }}" class="btn btn-default mt-3">Hủy</a>
        </form>
    </div>
</div>
@stop
