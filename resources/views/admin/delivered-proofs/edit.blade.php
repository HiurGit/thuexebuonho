@extends('adminlte::page')

@section('title', 'Sửa mục đã giao: ' . $deliveredProof->title)

@section('content_header')
    <h1>Sửa mục đã giao: {{ $deliveredProof->title }}</h1>
@stop

@section('content')
<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.delivered-proofs.update', $deliveredProof) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            @include('admin.delivered-proofs._form')
            <button type="submit" class="btn btn-success mt-3"><i class="fas fa-save mr-1"></i> Cập nhật</button>
            <a href="{{ route('admin.delivered-proofs.index') }}" class="btn btn-default mt-3">Hủy</a>
        </form>
    </div>
</div>
@stop
