@extends('adminlte::page')

@section('title', 'Hướng dẫn chung')

@section('content_header')
<div class="d-flex justify-content-between align-items-center">
    <h1>Hướng dẫn chung</h1>
    <a href="{{ route('admin.global-guides.create') }}" class="btn btn-success"><i class="fas fa-plus mr-1"></i> Thêm mục</a>
</div>
@stop

@section('content')
@if(session('success'))
<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert">&times;</button>{{ session('success') }}</div>
@endif

@php
$typeLabels = [
    'usage' => 'Hướng dẫn sử dụng xe',
    'accident' => 'Xử lý tai nạn',
    'insurance' => 'Xử lý bảo hiểm',
    'pickup' => 'Hướng dẫn đến nhận xe',
];
$typeColors = [
    'usage' => 'success',
    'accident' => 'warning',
    'insurance' => 'info',
    'pickup' => 'primary',
];
@endphp

@foreach(['pickup', 'usage', 'accident', 'insurance'] as $type)
<div class="card mb-4">
    <div class="card-header">
        <h3 class="card-title font-weight-bold">
            <span class="badge badge-{{ $typeColors[$type] }} p-2">{{ $typeLabels[$type] }}</span>
        </h3>
    </div>
    <div class="card-body p-0">
        @php $items = $guides->where('type', $type); @endphp
        @if($items->count() > 0)
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th style="width:40px">#</th>
                    <th>Tiêu đề</th>
                    <th>Nội dung</th>
                    <th style="width:120px">Hành động</th>
                </tr>
            </thead>
            <tbody>
                @foreach($items as $guide)
                <tr>
                    <td>{{ $guide->sort_order }}</td>
                    <td class="font-weight-bold">{{ $guide->section_title }}</td>
                    <td class="text-muted small">{!! Str::limit(strip_tags($guide->content), 120) !!}</td>
                    <td>
                        <a href="{{ route('admin.global-guides.edit', $guide) }}" class="btn btn-sm btn-primary"><i class="fas fa-edit"></i></a>
                        <form action="{{ route('admin.global-guides.destroy', $guide) }}" method="POST" class="d-inline" onsubmit="return confirm('Xóa mục này?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
        <div class="p-3 text-muted">Chưa có mục nào.</div>
        @endif
    </div>
</div>
@endforeach
@stop
