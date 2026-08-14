@extends('adminlte::page')

@section('title', 'Sửa cộng tác viên')

@section('content_header')
    <h1>Sửa cộng tác viên</h1>
@stop

@section('content')
<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.collaborators.update', $collaborator) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            @include('admin.collaborators._form')
            <button type="submit" class="btn btn-success mt-3"><i class="fas fa-save mr-1"></i> Cập nhật</button>
            <a href="{{ route('admin.collaborators.index') }}" class="btn btn-default mt-3">Hủy</a>
        </form>
    </div>
</div>
@stop
