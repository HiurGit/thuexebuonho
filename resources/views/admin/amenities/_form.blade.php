<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label>Tên tiện ích <span class="text-danger">*</span></label>
            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $amenity->name ?? '') }}" required>
            @error('name') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
    </div>
    <div class="col-md-2">
        <div class="form-group">
            <label>Thứ tự</label>
            <input type="number" name="sort_order" class="form-control" value="{{ old('sort_order', $amenity->sort_order ?? 0) }}" min="0">
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label>Tải lên icon</label>
            <input type="file" name="icon" id="amenity-icon" class="form-control-file" accept="image/*">
            <small class="form-text text-muted">Định dạng: jpeg, png, jpg, gif, webp. Dung lượng tối đa 2MB.</small>
        </div>
    </div>
    <div class="col-md-2">
        <div class="form-group">
            <label>Icon hiện tại</label>
            <div id="icon-preview-area" class="text-center p-2 rounded" style="min-height:80px;border:1px dashed #ddd;display:flex;align-items:center;justify-content:center">
                @if(isset($amenity) && $amenity->icon)
                    <img src="{{ asset(Str::startsWith($amenity->icon, 'storage/') ? $amenity->icon : 'assets/' . $amenity->icon) }}" style="width:40px;height:40px;object-fit:contain">
                @else
                    <span class="text-muted small">Chưa có</span>
                @endif
            </div>
        </div>
    </div>
</div>

@push('js')
<script>
$(function() {
    $('#amenity-icon').on('change', function() {
        var file = this.files[0];
        if (!file) return;
        var reader = new FileReader();
        reader.onload = function(e) {
            $('#icon-preview-area').html('<img src="' + e.target.result + '" style="max-width:60px;max-height:60px;object-fit:contain">');
        };
        reader.readAsDataURL(file);
    });
});
</script>
@endpush
