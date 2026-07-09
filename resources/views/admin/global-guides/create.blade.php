@extends('adminlte::page')

@section('title', 'Thêm mục hướng dẫn')

@section('content_header')
<h1>Thêm mục hướng dẫn</h1>
@stop

@section('content')
<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.global-guides.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label>Loại <span class="text-danger">*</span></label>
                <select name="type" class="form-control @error('type') is-invalid @enderror" required>
                    <option value="usage" {{ old('type') == 'usage' ? 'selected' : '' }}>Hướng dẫn sử dụng xe</option>
                    <option value="accident" {{ old('type') == 'accident' ? 'selected' : '' }}>Xử lý tai nạn</option>
                    <option value="insurance" {{ old('type') == 'insurance' ? 'selected' : '' }}>Xử lý bảo hiểm</option>
                    <option value="pickup" {{ old('type') == 'pickup' ? 'selected' : '' }}>Hướng dẫn đến nhận xe</option>
                </select>
                @error('type') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
            <div class="form-group">
                <label>Tiêu đề mục <span class="text-danger">*</span></label>
                <input type="text" name="section_title" class="form-control @error('section_title') is-invalid @enderror" value="{{ old('section_title') }}" placeholder="vd: Trước khi khởi hành" required>
                @error('section_title') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
            <div class="form-group">
                <label>Nội dung <span class="text-danger">*</span></label>
                <textarea name="content" rows="8" class="form-control @error('content') is-invalid @enderror" required>{{ old('content') }}</textarea>
                <small class="text-muted">Có thể dùng HTML. Mỗi dòng có thể bắt đầu bằng <code>- </code> để tạo danh sách.</small>
                @error('content') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
            <div class="form-group">
                <label>Thứ tự</label>
                <input type="number" name="sort_order" class="form-control" value="{{ old('sort_order', 0) }}" min="0">
            </div>
            <button type="submit" class="btn btn-success"><i class="fas fa-save mr-1"></i> Lưu</button>
            <a href="{{ route('admin.global-guides.index') }}" class="btn btn-default">Hủy</a>
        </form>
    </div>
</div>
@stop
