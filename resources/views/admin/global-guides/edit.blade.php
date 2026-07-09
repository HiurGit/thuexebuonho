@extends('adminlte::page')

@section('title', 'Sửa mục hướng dẫn')

@section('content_header')
<h1>Sửa mục hướng dẫn</h1>
@stop

@section('content')
<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.global-guides.update', $globalGuide) }}" method="POST">
            @csrf @method('PUT')
            <div class="form-group">
                <label>Loại <span class="text-danger">*</span></label>
                <select name="type" class="form-control @error('type') is-invalid @enderror" required>
                    <option value="usage" {{ old('type', $globalGuide->type) == 'usage' ? 'selected' : '' }}>Hướng dẫn sử dụng xe</option>
                    <option value="accident" {{ old('type', $globalGuide->type) == 'accident' ? 'selected' : '' }}>Xử lý tai nạn</option>
                    <option value="insurance" {{ old('type', $globalGuide->type) == 'insurance' ? 'selected' : '' }}>Xử lý bảo hiểm</option>
                    <option value="pickup" {{ old('type', $globalGuide->type) == 'pickup' ? 'selected' : '' }}>Hướng dẫn đến nhận xe</option>
                </select>
                @error('type') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
            <div class="form-group">
                <label>Tiêu đề mục <span class="text-danger">*</span></label>
                <input type="text" name="section_title" class="form-control @error('section_title') is-invalid @enderror" value="{{ old('section_title', $globalGuide->section_title) }}" required>
                @error('section_title') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
            <div class="form-group">
                <label>Nội dung <span class="text-danger">*</span></label>
                <textarea name="content" rows="8" class="form-control @error('content') is-invalid @enderror" required>{{ old('content', $globalGuide->content) }}</textarea>
                @error('content') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
            <div class="form-group">
                <label>Thứ tự</label>
                <input type="number" name="sort_order" class="form-control" value="{{ old('sort_order', $globalGuide->sort_order) }}" min="0">
            </div>
            <button type="submit" class="btn btn-success"><i class="fas fa-save mr-1"></i> Cập nhật</button>
            <a href="{{ route('admin.global-guides.index') }}" class="btn btn-default">Hủy</a>
        </form>
    </div>
</div>
@stop
