<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label>Tên cộng tác viên <span class="text-danger">*</span></label>
            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $collaborator->name ?? '') }}" required>
            @error('name') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label>Số điện thoại <span class="text-danger">*</span></label>
            <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone', $collaborator->phone ?? '') }}" required>
            @error('phone') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
    </div>
    <div class="col-md-2">
        <div class="form-group">
            <label>Thứ tự</label>
            <input type="number" name="sort_order" class="form-control" value="{{ old('sort_order', $collaborator->sort_order ?? 0) }}" min="0">
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label>Địa chỉ</label>
            <input type="text" name="address" class="form-control @error('address') is-invalid @enderror" value="{{ old('address', $collaborator->address ?? '') }}">
            @error('address') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label>Avatar</label>
            <input type="file" name="avatar" id="collaborator-avatar" class="form-control-file" accept="image/*">
            <small class="form-text text-muted">Định dạng: jpeg, png, jpg, gif, webp. Dung lượng tối đa 2MB.</small>
        </div>
    </div>
    <div class="col-md-2">
        <div class="form-group">
            <label>Avatar hiện tại</label>
            <div id="avatar-preview-area" class="text-center p-2 rounded" style="min-height:80px;border:1px dashed #ddd;display:flex;align-items:center;justify-content:center">
                @if(isset($collaborator) && $collaborator->avatar)
                    <img src="{{ asset($collaborator->avatar) }}" style="width:64px;height:64px;border-radius:50%;object-fit:cover">
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
    $('#collaborator-avatar').on('change', function() {
        var file = this.files[0];
        if (!file) return;
        var reader = new FileReader();
        reader.onload = function(e) {
            $('#avatar-preview-area').html('<img src="' + e.target.result + '" style="width:64px;height:64px;border-radius:50%;object-fit:cover">');
        };
        reader.readAsDataURL(file);
    });
});
</script>
@endpush
