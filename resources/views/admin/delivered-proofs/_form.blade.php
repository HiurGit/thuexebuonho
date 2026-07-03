<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <label>Tiêu đề <span class="text-danger">*</span></label>
            <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $deliveredProof->title ?? '') }}" required>
            @error('title') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="form-group">
            <label>Hình ảnh {{ isset($deliveredProof) ? '' : '<span class="text-danger">*</span>' }}</label>
            <input type="file" name="image" id="delivered-proof-image" class="form-control-file" accept="image/*" {{ isset($deliveredProof) ? '' : 'required' }}>
            @error('image') <span class="text-danger d-block">{{ $message }}</span> @enderror
            <small class="form-text text-muted">Định dạng: jpeg, png, jpg, gif, webp. Tối đa 5MB.</small>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label>Xem trước</label>
            <div id="proof-preview-area" class="text-center p-2 rounded" style="min-height:120px;border:1px dashed #ddd;display:flex;align-items:center;justify-content:center">
                @if(isset($deliveredProof) && $deliveredProof->image_path)
                    <img src="{{ asset($deliveredProof->image_path) }}" style="max-width:100%;max-height:100px;object-fit:contain">
                @else
                    <span class="text-muted small">Chưa có hình</span>
                @endif
            </div>
        </div>
    </div>
</div>

@push('js')
<script>
$(function() {
    $('#delivered-proof-image').on('change', function() {
        var file = this.files[0];
        if (!file) return;
        var reader = new FileReader();
        reader.onload = function(e) {
            $('#proof-preview-area').html('<img src="' + e.target.result + '" style="max-width:100%;max-height:100px;object-fit:contain">');
        };
        reader.readAsDataURL(file);
    });
});
</script>
@endpush
