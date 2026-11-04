@php
    $collaborator = $collaborator ?? null;
@endphp

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
    <div class="col-md-3">
        <div class="form-group">
            <label>Trạng thái</label>
            <select name="status" class="form-control @error('status') is-invalid @enderror">
                @foreach(\App\Models\Collaborator::STATUS_LABELS as $value => $label)
                    <option value="{{ $value }}" {{ old('status', $collaborator->status ?? 'active') === $value ? 'selected' : '' }}>{{ $label }}</option>
                @endforeach
            </select>
            @error('status') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label>Tỷ lệ hoa hồng (%)</label>
            <input type="number" step="0.01" min="0" max="100" name="commission_rate" class="form-control @error('commission_rate') is-invalid @enderror"
                   value="{{ old('commission_rate', $collaborator->commission_rate ?? 10) }}">
            @error('commission_rate') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $collaborator->email ?? '') }}">
            @error('email') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label>Mã giới thiệu</label>
            <input type="text" class="form-control" value="{{ $collaborator->code ?? 'Tự sinh sau khi lưu' }}" readonly>
            @if(!empty($collaborator?->code))
                <small class="form-text text-muted">
                    Link: <a href="{{ $collaborator->referral_url }}" target="_blank">{{ $collaborator->referral_url }}</a>
                </small>
            @endif
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

<div class="row">
    <div class="col-md-3">
        <div class="form-group">
            <label>Ngân hàng</label>
            <input type="text" name="bank_name" class="form-control @error('bank_name') is-invalid @enderror" value="{{ old('bank_name', $collaborator->bank_name ?? '') }}" placeholder="VD: BIDV">
            @error('bank_name') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label>Số tài khoản</label>
            <input type="text" name="bank_account" class="form-control @error('bank_account') is-invalid @enderror" value="{{ old('bank_account', $collaborator->bank_account ?? '') }}">
            @error('bank_account') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label>Chủ tài khoản</label>
            <input type="text" name="bank_owner" class="form-control @error('bank_owner') is-invalid @enderror" value="{{ old('bank_owner', $collaborator->bank_owner ?? '') }}">
            @error('bank_owner') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label>Ngày duyệt</label>
            <input type="text" class="form-control" value="{{ isset($collaborator) && $collaborator->approved_at ? $collaborator->approved_at->format('d/m/Y H:i') : 'Chưa duyệt' }}" readonly>
        </div>
    </div>
</div>

<div class="form-group">
    <label>Ghi chú nội bộ</label>
    <textarea name="note" rows="3" class="form-control @error('note') is-invalid @enderror">{{ old('note', $collaborator->note ?? '') }}</textarea>
    @error('note') <span class="text-danger">{{ $message }}</span> @enderror
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
