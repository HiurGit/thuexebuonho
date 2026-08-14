<div class="row">
    <div class="col-md-4">
        <div class="form-group">
            <label>Họ tên <span class="text-danger">*</span></label>
            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $customer->name ?? '') }}" required>
            @error('name') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label>Ngày sinh</label>
            <input type="text" name="dob" class="form-control" value="{{ old('dob', $customer->dob ?? '') }}" placeholder="12/03/1995">
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label>Giới tính</label>
            <select name="gender" class="form-control">
                <option value="">-- Chọn --</option>
                <option value="Nam" {{ old('gender', $customer->gender ?? '') === 'Nam' ? 'selected' : '' }}>Nam</option>
                <option value="Nữ" {{ old('gender', $customer->gender ?? '') === 'Nữ' ? 'selected' : '' }}>Nữ</option>
            </select>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label>CCCD</label>
            <input type="text" name="cccd" class="form-control @error('cccd') is-invalid @enderror" value="{{ old('cccd', $customer->cccd ?? '') }}">
            @error('cccd') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label>Ngày cấp CCCD</label>
            <input type="text" name="cccd_issue_date" class="form-control" value="{{ old('cccd_issue_date', $customer->cccd_issue_date ?? '') }}" placeholder="15/10/2024">
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="form-group">
            <label>Địa chỉ thường trú</label>
            <input type="text" name="address" class="form-control" value="{{ old('address', $customer->address ?? '') }}">
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-4">
        <div class="form-group">
            <label>Số điện thoại</label>
            <input type="text" name="phone" class="form-control" value="{{ old('phone', $customer->phone ?? '') }}">
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label>Bằng lái</label>
            <input type="text" name="license" class="form-control" value="{{ old('license', $customer->license ?? '') }}">
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label>Trạng thái <span class="text-danger">*</span></label>
            <select name="status" class="form-control @error('status') is-invalid @enderror" required>
                <option value="active" {{ old('status', $customer->status ?? 'active') === 'active' ? 'selected' : '' }}>Hoạt động</option>
                <option value="banned" {{ old('status', $customer->status ?? '') === 'banned' ? 'selected' : '' }}>Cấm</option>
            </select>
            @error('status') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
    </div>
</div>
