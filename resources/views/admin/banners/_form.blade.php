<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label>Tên banner <span class="text-danger">*</span></label>
            <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $banner->title ?? '') }}" required>
            @error('title') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label>Vị trí <span class="text-danger">*</span></label>
            <select name="position" class="form-control @error('position') is-invalid @enderror" required>
                <option value="hero" {{ old('position', $banner->position ?? '') === 'hero' ? 'selected' : '' }}>Hero (Banner chính)</option>
                <option value="banner-price" {{ old('position', $banner->position ?? '') === 'banner-price' ? 'selected' : '' }}>Banner giá (Swiper)</option>
            </select>
            @error('position') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
    </div>
    <div class="col-md-1">
        <div class="form-group">
            <label>Thứ tự</label>
            <input type="number" name="sort_order" class="form-control" value="{{ old('sort_order', $banner->sort_order ?? 0) }}" min="0">
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label>Tải lên ảnh <span class="text-danger">*</span></label>
            <input type="file" name="image" id="banner-image" class="form-control-file" accept="image/*" {{ isset($banner) ? '' : 'required' }}>
            <small class="form-text text-muted">Định dạng: jpeg, png, jpg, gif, webp. Dung lượng tối đa 5MB.</small>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label>Ảnh hiện tại</label>
            <div id="image-preview-area" class="text-center p-2 rounded" style="min-height:80px;border:1px dashed #ddd;display:flex;align-items:center;justify-content:center">
                @if(isset($banner) && $banner->image)
                    <img src="{{ asset($banner->image) }}" style="max-width:200px;max-height:80px;object-fit:contain">
                @else
                    <span class="text-muted small">Chưa có</span>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <div class="custom-control custom-switch">
                <input type="checkbox" name="is_active" class="custom-control-input" id="is_active" {{ old('is_active', $banner->is_active ?? 1) ? 'checked' : '' }}>
                <label class="custom-control-label" for="is_active">Hiển thị trên trang chủ</label>
            </div>
        </div>
    </div>
</div>

@push('js')
<script>
$(function() {
    $('#banner-image').on('change', function() {
        var file = this.files[0];
        if (!file) return;
        var reader = new FileReader();
        reader.onload = function(e) {
            $('#image-preview-area').html('<img src="' + e.target.result + '" style="max-width:200px;max-height:80px;object-fit:contain">');
        };
        reader.readAsDataURL(file);
    });
});
</script>
@endpush
