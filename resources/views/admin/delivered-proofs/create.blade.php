@extends('adminlte::page')

@section('title', 'Thêm mục đã giao')

@section('content_header')
    <h1>Thêm mục đã giao</h1>
@stop

@section('content')
<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.delivered-proofs.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @include('admin.delivered-proofs._form')
            <button type="submit" class="btn btn-success mt-3"><i class="fas fa-save mr-1"></i> Lưu</button>
            <a href="{{ route('admin.delivered-proofs.index') }}" class="btn btn-default mt-3">Hủy</a>
        </form>
    </div>
</div>
@stop
