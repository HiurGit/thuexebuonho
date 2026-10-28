@php
    $contract = $contract ?? null;
    $isEdit = !empty($contract);
    $carsData = $cars->map(fn ($car) => [
        'id' => $car->id,
        'name' => $car->name,
        'plate' => $car->plate,
        'year' => $car->year,
        'seats' => $car->seats,
        'transmission' => $car->transmission,
        'fuel' => $car->fuel,
        'brand' => $car->brand,
        'model' => $car->model,
        'color' => $car->color,
        'chassis_no' => $car->chassis_no,
        'engine_no' => $car->engine_no,
        'owner' => $car->owner,
        'price_per_day' => $car->price_per_day,
        'address' => $car->address,
    ])->values();
    $fmtDt = fn ($v) => $v ? \Illuminate\Support\Carbon::parse($v)->format('Y-m-d H:i') : '';
    $fmtDate = fn ($v) => $v ? \Illuminate\Support\Carbon::parse($v)->format('Y-m-d') : '';
@endphp

@push('css')
    <link rel="stylesheet" href="{{ asset('assets/vendor/flatpickr/flatpickr.min.css') }}">
    <style>
        .date-input-shell .input-group-text {
            background: linear-gradient(135deg, #eef6ff 0%, #dceeff 100%);
            border-color: #c8dcf5;
            color: #1565c0;
        }
        .date-input-shell .form-control {
            border-left: 0;
            border-color: #c8dcf5;
            background: #fbfdff;
            font-weight: 600;
        }
        .date-input-shell .form-control:focus,
        .date-input-shell.form-control:focus {
            border-color: #86b7fe;
            box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.12);
        }
        .flatpickr-calendar {
            border-radius: 14px;
            border: 1px solid #dbe7f3;
            box-shadow: 0 16px 40px rgba(33, 37, 41, 0.16);
        }
    </style>
@endpush

@push('js')
    <script src="{{ asset('assets/vendor/flatpickr/flatpickr.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/flatpickr/l10n/vn.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            if (typeof flatpickr === 'undefined') return;

            flatpickr.localize(flatpickr.l10ns.vn || flatpickr.l10ns.default);

            document.querySelectorAll('.js-date-picker').forEach(function (input) {
                flatpickr(input, {
                    dateFormat: 'Y-m-d',
                    altInput: true,
                    altFormat: 'd/m/Y',
                    allowInput: false,
                    disableMobile: true,
                    locale: 'vn'
                });
            });

            document.querySelectorAll('.js-datetime-picker').forEach(function (input) {
                var opts = {
                    enableTime: true,
                    dateFormat: 'Y-m-d H:i',
                    altInput: true,
                    altFormat: 'd/m/Y H:i',
                    time_24hr: true,
                    minuteIncrement: 5,
                    allowInput: false,
                    disableMobile: true,
                    locale: 'vn'
                };
                if (input.name === 'pickup_datetime') {
                    opts.defaultHour = 6;
                    opts.defaultMinute = 0;
                }
                if (input.name === 'return_datetime') {
                    opts.defaultHour = 22;
                    opts.defaultMinute = 0;
                }
                flatpickr(input, opts);
            });
        });
    </script>
@endpush

{{-- ============ 2. THÔNG TIN KHÁCH HÀNG ============ --}}
<div class="card mb-3">
    <div class="card-header bg-primary text-white"><i class="fas fa-user mr-1"></i> Thông tin khách hàng</div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                @include('admin.contracts._upload', ['doc' => 'cccd', 'label' => 'Ảnh CCCD', 'cats' => ['cccd_front', 'cccd_back']])
            </div>
            <div class="col-md-6">
                @include('admin.contracts._upload', ['doc' => 'license', 'label' => 'Ảnh bằng lái', 'cats' => ['license_front', 'license_back']])
            </div>
        </div>
        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <label>Trạng thái <span class="text-danger">*</span></label>
                    <select name="status" class="form-control @error('status') is-invalid @enderror" required>
                        @foreach(\App\Models\Contract::STATUS_LABELS as $key => $label)
                            <option value="{{ $key }}" {{ old('status', $contract->status ?? 'active') === $key ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                    @error('status') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label>Chi nhánh / Địa điểm thuê</label>
                    <input type="text" name="branch" class="form-control @error('branch') is-invalid @enderror"
                           value="{{ old('branch', $contract->branch ?? '') }}" placeholder="VD: 07 Chu Văn An, Buôn Hồ">
                    @error('branch') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <label>Số CCCD</label>
                    <input type="text" name="cccd" class="form-control @error('cccd') is-invalid @enderror"
                           value="{{ old('cccd', $contract->cccd ?? '') }}">
                    @error('cccd') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label>Họ và tên <span class="text-danger">*</span></label>
                    <input type="text" name="customer_name" class="form-control @error('customer_name') is-invalid @enderror"
                           value="{{ old('customer_name', $contract->customer_name ?? '') }}" required>
                    @error('customer_name') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label>Số điện thoại</label>
                    <input type="text" name="customer_phone" class="form-control @error('customer_phone') is-invalid @enderror"
                           value="{{ old('customer_phone', $contract->customer_phone ?? '') }}">
                    @error('customer_phone') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label>Ngày cấp CCCD</label>
                    <div class="input-group date-input-shell @error('cccd_issue_date') is-invalid @enderror">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="far fa-calendar-check"></i></span>
                        </div>
                        <input type="text" name="cccd_issue_date" class="form-control js-date-picker @error('cccd_issue_date') is-invalid @enderror"
                               value="{{ old('cccd_issue_date', $fmtDate($contract->cccd_issue_date ?? null)) }}"
                               placeholder="dd/mm/yyyy" autocomplete="off">
                    </div>
                    @error('cccd_issue_date') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label>Ngày sinh</label>
                    <div class="input-group date-input-shell @error('dob') is-invalid @enderror">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                        </div>
                        <input type="text" name="dob" class="form-control js-date-picker @error('dob') is-invalid @enderror"
                               value="{{ old('dob', $fmtDate($contract->dob ?? null)) }}"
                               placeholder="dd/mm/yyyy" autocomplete="off">
                    </div>
                    @error('dob') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label>Giới tính</label>
                    <select name="gender" class="form-control @error('gender') is-invalid @enderror">
                        <option value="">-- Chưa chọn --</option>
                        <option value="Nam" {{ old('gender', $contract->gender ?? '') === 'Nam' ? 'selected' : '' }}>Nam</option>
                        <option value="Nữ" {{ old('gender', $contract->gender ?? '') === 'Nữ' ? 'selected' : '' }}>Nữ</option>
                    </select>
                    @error('gender') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label>Nơi cấp CCCD</label>
                    <input type="text" name="cccd_issue_place" class="form-control @error('cccd_issue_place') is-invalid @enderror"
                           value="{{ old('cccd_issue_place', $contract?->cccd_issue_place ?: 'Bộ Công An') }}">
                    @error('cccd_issue_place') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </div>
            <div class="col-md-8">
                <div class="form-group">
                    <label>Địa chỉ</label>
                    <input type="text" name="customer_address" class="form-control @error('customer_address') is-invalid @enderror"
                           value="{{ old('customer_address', $contract->customer_address ?? '') }}">
                    @error('customer_address') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-2">
                <div class="form-group">
                    <label>Số bằng lái</label>
                    <input type="text" name="driver_license_no" class="form-control @error('driver_license_no') is-invalid @enderror"
                           value="{{ old('driver_license_no', $contract->driver_license_no ?? '') }}">
                    @error('driver_license_no') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label>Hạng bằng</label>
                    <input type="text" name="license_class" class="form-control @error('license_class') is-invalid @enderror"
                           value="{{ old('license_class', $contract->license_class ?? '') }}" placeholder="VD: B2, C, D...">
                    @error('license_class') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label>Ngày cấp bằng</label>
                    <div class="input-group date-input-shell @error('license_issue_date') is-invalid @enderror">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="far fa-calendar-check"></i></span>
                        </div>
                        <input type="text" name="license_issue_date" class="form-control js-date-picker @error('license_issue_date') is-invalid @enderror"
                               value="{{ old('license_issue_date', $fmtDate($contract->license_issue_date ?? null)) }}"
                               placeholder="dd/mm/yyyy" autocomplete="off">
                    </div>
                    @error('license_issue_date') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label>Ngày hết hạn bằng</label>
                    <div class="input-group date-input-shell @error('license_expiry_date') is-invalid @enderror">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="far fa-calendar-check"></i></span>
                        </div>
                        <input type="text" name="license_expiry_date" class="form-control js-date-picker @error('license_expiry_date') is-invalid @enderror"
                               value="{{ old('license_expiry_date', $fmtDate($contract->license_expiry_date ?? null)) }}"
                               placeholder="dd/mm/yyyy" autocomplete="off">
                    </div>
                    @error('license_expiry_date') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ============ 3. THÔNG TIN XE ============ --}}
<div class="card mb-3">
    <div class="card-header bg-success text-white"><i class="fas fa-car mr-1"></i> Thông tin xe</div>
    <div class="card-body">
        <div class="row mb-3">
            <div class="col-md-4">
                <div class="form-group mb-0">
                    <label>Chọn xe từ danh sách <span class="text-muted small">(tự điền thông tin)</span></label>
                    <select id="car-select" class="form-control">
                        <option value="">-- Chọn xe --</option>
                        @foreach($cars as $car)
                            <option value="{{ $car->id }}" {{ old('car_id', $contract->car_id ?? '') == $car->id ? 'selected' : '' }}>{{ $car->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <label>Tên xe</label>
                    <input type="text" name="car_name" class="form-control @error('car_name') is-invalid @enderror"
                           value="{{ old('car_name', $contract->car_name ?? '') }}">
                    @error('car_name') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label>Biển số</label>
                    <input type="text" name="car_plate" class="form-control @error('car_plate') is-invalid @enderror"
                           value="{{ old('car_plate', $contract->car_plate ?? '') }}" placeholder="VD: 47A-123.45">
                    @error('car_plate') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label>Số ghế</label>
                    <input type="number" name="car_seats" class="form-control @error('car_seats') is-invalid @enderror"
                           value="{{ old('car_seats', $contract->car_seats ?? '') }}" min="1">
                    @error('car_seats') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label>Hộp số</label>
                    <select name="car_transmission" class="form-control @error('car_transmission') is-invalid @enderror">
                        <option value="">-- Chưa chọn --</option>
                        <option value="Tự động" {{ old('car_transmission', $contract->car_transmission ?? '') === 'Tự động' ? 'selected' : '' }}>Tự động</option>
                        <option value="Số sàn" {{ old('car_transmission', $contract->car_transmission ?? '') === 'Số sàn' ? 'selected' : '' }}>Số sàn</option>
                    </select>
                    @error('car_transmission') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label>Năm sản xuất</label>
                    <input type="number" name="car_year" class="form-control @error('car_year') is-invalid @enderror"
                           value="{{ old('car_year', $contract->car_year ?? '') }}" min="1900" max="2100">
                    @error('car_year') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <label>Nhãn hiệu</label>
                    <input type="text" name="car_brand" class="form-control @error('car_brand') is-invalid @enderror"
                           value="{{ old('car_brand', $contract->car_brand ?? '') }}" placeholder="VD: Toyota">
                    @error('car_brand') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label>Model / Phiên bản</label>
                    <input type="text" name="car_model" class="form-control @error('car_model') is-invalid @enderror"
                           value="{{ old('car_model', $contract->car_model ?? '') }}" placeholder="VD: Vios G">
                    @error('car_model') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label>Màu sơn</label>
                    <input type="text" name="car_color" class="form-control @error('car_color') is-invalid @enderror"
                           value="{{ old('car_color', $contract->car_color ?? '') }}" placeholder="VD: Trắng">
                    @error('car_color') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label>Số khung</label>
                    <input type="text" name="car_chassis" class="form-control @error('car_chassis') is-invalid @enderror"
                           value="{{ old('car_chassis', $contract->car_chassis ?? '') }}">
                    @error('car_chassis') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label>Số máy</label>
                    <input type="text" name="car_engine" class="form-control @error('car_engine') is-invalid @enderror"
                           value="{{ old('car_engine', $contract->car_engine ?? '') }}">
                    @error('car_engine') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label>Chủ xe</label>
                    <input type="text" name="car_owner" class="form-control @error('car_owner') is-invalid @enderror"
                           value="{{ old('car_owner', $contract->car_owner ?? '') }}">
                    @error('car_owner') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <label>Nhiên liệu</label>
                    <select name="car_fuel" class="form-control @error('car_fuel') is-invalid @enderror">
                        <option value="">-- Chưa chọn --</option>
                        <option value="Máy xăng" {{ old('car_fuel', $contract->car_fuel ?? '') === 'Máy xăng' ? 'selected' : '' }}>Máy xăng</option>
                        <option value="Máy dầu" {{ old('car_fuel', $contract->car_fuel ?? '') === 'Máy dầu' ? 'selected' : '' }}>Máy dầu</option>
                        <option value="Điện" {{ old('car_fuel', $contract->car_fuel ?? '') === 'Điện' ? 'selected' : '' }}>Điện</option>
                    </select>
                    @error('car_fuel') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </div>
        </div>
        <input type="hidden" name="car_id" id="car-id-hidden" value="{{ old('car_id', $contract->car_id ?? '') }}">
    </div>
</div>

{{-- ============ 4. THỜI GIAN THUÊ ============ --}}
<div class="card mb-3">
    <div class="card-header bg-warning text-dark"><i class="fas fa-clock mr-1"></i> Thông tin thuê</div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <label>Ngày giờ nhận xe</label>
                    <div class="input-group date-input-shell @error('pickup_datetime') is-invalid @enderror">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                        </div>
                        <input type="text" name="pickup_datetime" class="form-control js-datetime-picker @error('pickup_datetime') is-invalid @enderror"
                               value="{{ old('pickup_datetime', $fmtDt($contract->pickup_datetime ?? null)) }}"
                               placeholder="dd/mm/yyyy giờ:phút" autocomplete="off">
                    </div>
                    @error('pickup_datetime') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label>Ngày giờ trả xe</label>
                    <div class="input-group date-input-shell @error('return_datetime') is-invalid @enderror">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                        </div>
                        <input type="text" name="return_datetime" class="form-control js-datetime-picker @error('return_datetime') is-invalid @enderror"
                               value="{{ old('return_datetime', $fmtDt($contract->return_datetime ?? null)) }}"
                               placeholder="dd/mm/yyyy giờ:phút" autocomplete="off">
                    </div>
                    @error('return_datetime') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label>Địa điểm nhận xe</label>
                    <input type="text" name="pickup_location" class="form-control @error('pickup_location') is-invalid @enderror"
                           value="{{ old('pickup_location', $contract->pickup_location ?? '') }}">
                    @error('pickup_location') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label>Lộ trình di chuyển</label>
                    <input type="text" name="return_location" class="form-control @error('return_location') is-invalid @enderror"
                           value="{{ old('return_location', $contract->return_location ?? '') }}">
                    @error('return_location') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-2">
                <div class="form-group">
                    <label>Tổng số ngày thuê</label>
                    <input type="number" name="total_days" id="total-days" class="form-control @error('total_days') is-invalid @enderror"
                           value="{{ old('total_days', $contract->total_days ?? '') }}" min="0">
                    @error('total_days') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label>Tổng số giờ thêm</label>
                    <input type="number" name="total_hours" class="form-control @error('total_hours') is-invalid @enderror"
                           value="{{ old('total_hours', $contract->total_hours ?? '') }}" min="0">
                    @error('total_hours') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label>Giới hạn km dự kiến (nếu có)</label>
                    <input type="number" name="km_limit" class="form-control @error('km_limit') is-invalid @enderror"
                           value="{{ old('km_limit', $contract->km_limit ?? '') }}" min="0">
                    @error('km_limit') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ============ 5. CỌC ============ --}}
<div class="card mb-3">
    <div class="card-header bg-secondary text-white"><i class="fas fa-hand-holding-usd mr-1"></i> Tiền cọc</div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <label>Loại cọc</label>
                    <select name="deposit_type" id="deposit-type" class="form-control @error('deposit_type') is-invalid @enderror">
                        <option value="">Không cọc</option>
                        <option value="cash" {{ old('deposit_type', $contract->deposit_type ?? '') === 'cash' ? 'selected' : '' }}>Cọc tiền</option>
                        <option value="motorcycle" {{ old('deposit_type', $contract->deposit_type ?? '') === 'motorcycle' ? 'selected' : '' }}>Cọc xe máy</option>
                    </select>
                    @error('deposit_type') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </div>
            <div class="col-md-3" id="deposit-amount-wrap">
                <div class="form-group">
                    <label>Số tiền cọc (đ)</label>
                    <input type="text" name="deposit_amount" inputmode="decimal" class="form-control money-input @error('deposit_amount') is-invalid @enderror"
                           value="{{ old('deposit_amount', $contract->deposit_amount ?? '') }}" placeholder="VD: 2.000.000">
                    @error('deposit_amount') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Ghi chú cọc (VD: xe máy biển số...)</label>
                    <input type="text" name="deposit_note" class="form-control @error('deposit_note') is-invalid @enderror"
                           value="{{ old('deposit_note', $contract->deposit_note ?? '') }}">
                    @error('deposit_note') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label>Xe máy hiệu (khi cọc xe máy)</label>
                    <input type="text" name="deposit_moto_brand" class="form-control @error('deposit_moto_brand') is-invalid @enderror"
                           value="{{ old('deposit_moto_brand', $contract->deposit_moto_brand ?? '') }}" placeholder="VD: Honda Wave">
                    @error('deposit_moto_brand') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>Biển số xe máy</label>
                    <input type="text" name="deposit_moto_plate" class="form-control @error('deposit_moto_plate') is-invalid @enderror"
                           value="{{ old('deposit_moto_plate', $contract->deposit_moto_plate ?? '') }}">
                    @error('deposit_moto_plate') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>Giấy ĐKXE (bản chính)</label>
                    <input type="text" name="deposit_moto_registration" class="form-control @error('deposit_moto_registration') is-invalid @enderror"
                           value="{{ old('deposit_moto_registration', $contract->deposit_moto_registration ?? '') }}">
                    @error('deposit_moto_registration') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label>Tài sản thế chấp khác</label>
                    <input type="text" name="deposit_other" class="form-control @error('deposit_other') is-invalid @enderror"
                           value="{{ old('deposit_other', $contract->deposit_other ?? '') }}">
                    @error('deposit_other') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ============ 6. TIỀN THUÊ ============ --}}
<div class="card mb-3">
    <div class="card-header bg-danger text-white"><i class="fas fa-money-bill-wave mr-1"></i> Tiền thuê</div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <label>Giá thuê 1 ngày (đ)</label>
                    <input type="text" name="daily_rate" id="daily-rate" inputmode="decimal" class="form-control money-input @error('daily_rate') is-invalid @enderror"
                           value="{{ old('daily_rate', $contract->daily_rate ?? '') }}" placeholder="VD: 700.000">
                    @error('daily_rate') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label>Số ngày thuê</label>
                    <input type="number" name="rental_days" id="rental-days" class="form-control @error('rental_days') is-invalid @enderror"
                           value="{{ old('rental_days', $contract->rental_days ?? '') }}" min="0">
                    @error('rental_days') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label>Tổng tiền thuê (đ)</label>
                    <input type="text" name="total_rental_fee" id="total-fee" inputmode="decimal" class="form-control money-input @error('total_rental_fee') is-invalid @enderror"
                           value="{{ old('total_rental_fee', $contract->total_rental_fee ?? '') }}" placeholder="VD: 6.000.000">
                    @error('total_rental_fee') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </div>
        </div>
        <div class="form-group mt-2">
            <label>Ghi chú chung</label>
            <textarea name="notes" rows="3" class="form-control @error('notes') is-invalid @enderror">{{ old('notes', $contract->notes ?? '') }}</textarea>
            @error('notes') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
    </div>
</div>

{{-- ============ 7. HÌNH ẢNH & VIDEO ============ --}}
<div class="card mb-3">
    <div class="card-header bg-dark text-white"><i class="fas fa-images mr-1"></i> Hình ảnh & Video</div>
    <div class="card-body">
        @include('admin.contracts._upload', ['doc' => 'car_before', 'label' => 'Ảnh chụp trước xe', 'cats' => ['car_before']])
        <hr class="my-2">
        @include('admin.contracts._upload', ['doc' => 'car_video', 'label' => 'Hình ảnh / Video xe', 'cats' => ['car_video']])
    </div>
</div>

@push('js')
@vite(['resources/js/contract-card-reader.js'])
<script>
(function($) {
    var carsData = @json($carsData);
    window.__CONTRACT_OCR = {
        gemini: @json(route('check.ocr-gemini')),
        openai: @json(route('check.ocr-openai')),
        csrf: @json(csrf_token())
    };
    function findCar(id) {
        return carsData.find(function(c) { return c.id == id; });
    }

    $('#car-select').on('change', function() {
        var car = findCar(this.value);
        $('#car-id-hidden').val(this.value);
        if (car) {
            $('input[name="car_name"]').val(car.name);
            $('input[name="car_plate"]').val(car.plate || '');
            $('input[name="car_year"]').val(car.year || '');
            $('input[name="car_seats"]').val(car.seats || '');
            $('select[name="car_transmission"]').val(car.transmission || '');
            $('select[name="car_fuel"]').val(car.fuel || '');
            $('input[name="car_brand"]').val(car.brand || '');
            $('input[name="car_model"]').val(car.model || '');
            $('input[name="car_color"]').val(car.color || '');
            $('input[name="car_chassis"]').val(car.chassis_no || '');
            $('input[name="car_engine"]').val(car.engine_no || '');
            $('input[name="car_owner"]').val(car.owner || '');
            if (!$('input[name="pickup_location"]').val() && car.address) {
                $('input[name="pickup_location"]').val(car.address);
            }
            if (!$('input[name="daily_rate"]').val()) {
                $('input[name="daily_rate"]').val(formatMoney(String(car.price_per_day || '')));
                calcTotal();
            }
        } else {
            $('#car-id-hidden').val('');
        }
    });

    function calcTotal() {
        var rate = parseFloat(moneyDigits($('#daily-rate').val())) || 0;
        var days = parseFloat($('#rental-days').val()) || parseFloat($('#total-days').val()) || 0;
        var total = rate * days;
        $('#total-fee').val(total > 0 ? formatMoney(String(Math.round(total))) : '');
    }
    $('#daily-rate, #rental-days, #total-days').on('input', calcTotal);

    function moneyDigits(v) {
        return String(v || '').replace(/\D/g, '');
    }

    function formatMoney(v) {
        var d = moneyDigits(v);
        return d ? d.replace(/\B(?=(\d{3})+(?!\d))/g, '.') : '';
    }

    $('.money-input').on('input', function() {
        var d = moneyDigits(this.value);
        $(this).val(d ? d.replace(/\B(?=(\d{3})+(?!\d))/g, '.') : '');
    });

    $('.money-input').val(function() {
        var d = moneyDigits(this.value);
        return d ? d.replace(/\B(?=(\d{3})+(?!\d))/g, '.') : '';
    });

    $('form').on('submit', function() {
        $('.money-input').each(function() {
            $(this).val(moneyDigits(this.value));
        });
    });

    function parseDateInput(v) {
        if (!v) return null;
        var d = new Date(String(v).replace(' ', 'T'));
        return isNaN(d.getTime()) ? null : d;
    }

    function calcDays() {
        var pick = parseDateInput($('input[name="pickup_datetime"]').val());
        var ret = parseDateInput($('input[name="return_datetime"]').val());
        if (!pick || !ret || ret <= pick) return;
        var days = Math.ceil((ret - pick) / 86400000);
        days = Math.max(1, days);
        $('#total-days').val(days);
        $('#rental-days').val(days);
        calcTotal();
    }
    $('input[name="pickup_datetime"], input[name="return_datetime"]').on('change', calcDays);

    $('#deposit-type').on('change', function() {
        $('#deposit-amount-wrap').toggle(this.value === 'cash');
    });
    if ($('#deposit-type').val() !== 'cash') {
        $('#deposit-amount-wrap').hide();
    }

    function pad2(n) {
        return String(n).length === 1 ? '0' + n : String(n);
    }

    function toYmd(v) {
        var m = String(v || '').match(/^(\d{1,2})\/(\d{1,2})\/(\d{4})$/);
        return m ? m[3] + '-' + pad2(m[2]) + '-' + pad2(m[1]) : String(v || '');
    }

    function setIfEmpty(name, val) {
        if (!val) return;
        var el = document.querySelector('[name="' + name + '"]');
        if (!el) return;
        if (el._flatpickr) {
            if (!el.value) el._flatpickr.setDate(toYmd(val), true);
            return;
        }
        if (!el.value.trim()) el.value = val;
    }

    function ocrStatus(cat, msg, isError) {
        var el = document.getElementById('ocr-status-' + cat);
        if (!el) return;
        el.textContent = msg || '';
        el.className = 'mt-1 small ' + (isError ? 'text-danger' : 'text-muted');
    }

    function setInputFiles(input, files) {
        if (!input || !window.DataTransfer) return;
        var dt = new DataTransfer();
        (files || []).forEach(function(f) { if (f) dt.items.add(f); });
        input.files = dt.files;
    }

    function inputsOf(doc) {
        return Array.prototype.slice.call(document.querySelectorAll('.contract-file[data-doc="' + doc + '"]'));
    }

    function sideInput(doc, side) {
        var q = '.contract-file[data-doc="' + doc + '"]';
        if (side) q += '[data-side="' + side + '"]';
        return document.querySelector(q);
    }

    function sideTitle(side) {
        return side === 'front' ? 'Mặt trước' : side === 'back' ? 'Mặt sau' : '';
    }

    function buildThumbBox(file, doc, side, idx) {
        var $box = $('<div class="mr-2 mb-2 text-center position-relative" style="width:120px"></div>');
        if (side) {
            $box.append('<span class="badge badge-info position-absolute" style="top:-8px;left:2px;font-size:10px;z-index:5">' + sideTitle(side) + '</span>');
        }
        $box.append('<button type="button" data-remove-file="' + doc + '" data-side="' + side + '" data-idx="' + idx + '" class="btn btn-danger btn-sm position-absolute" style="top:-8px;right:-8px;padding:1px 8px;font-size:12px;line-height:1.2">&times;</button>');
        if (side) {
            $box.append('<button type="button" data-swap-file="' + doc + '" class="btn btn-outline-secondary btn-sm position-absolute" title="Đổi vị trí trước/sau" style="bottom:-8px;right:-8px;padding:1px 6px;font-size:11px;line-height:1.2"><i class="fas fa-exchange-alt"></i></button>');
        }
        if (String(file.type).indexOf('video/') === 0) {
            $box.append('<div class="border rounded d-flex align-items-center justify-content-center text-muted" style="height:70px"><i class="fas fa-video fa-2x"></i></div>');
        } else {
            var url = URL.createObjectURL(file);
            $box.append('<img src="' + url + '" style="width:120px;height:70px;object-fit:cover" class="border rounded">');
        }
        $box.append('<small class="text-muted" style="display:block;overflow:hidden;white-space:nowrap;text-overflow:ellipsis">' + file.name + '</small>');
        return $box;
    }

    function renderContractPreviews(doc) {
        var $preview = $('#preview-' + doc).empty();
        var inputs = inputsOf(doc);
        if (!inputs.length) return;
        inputs.forEach(function(input) {
            var side = input.getAttribute('data-side') || '';
            var files = Array.prototype.slice.call(input.files || []);
            files.forEach(function(file, idx) {
                $preview.append(buildThumbBox(file, doc, side, idx));
            });
        });
    }

    $('.contract-file-picker').on('change', function() {
        var doc = this.getAttribute('data-doc');
        var inputs = inputsOf(doc);
        if (!inputs.length) return;
        var files = Array.prototype.slice.call(this.files || []);
        if (inputs.length === 1) {
            setInputFiles(inputs[0], files);
        } else {
            setInputFiles(inputs[0], files.slice(0, 1));
            setInputFiles(inputs[1], files.slice(1));
        }
        this.value = '';
        renderContractPreviews(doc);
        processCardImages(doc);
    });

    $(document).on('click', '[data-remove-file]', function() {
        var doc = this.getAttribute('data-remove-file');
        var side = this.getAttribute('data-side') || '';
        var idx = parseInt(this.getAttribute('data-idx'), 10);
        var input = sideInput(doc, side);
        if (!input || !window.DataTransfer) return;
        var files = Array.prototype.slice.call(input.files || []);
        files.splice(idx, 1);
        setInputFiles(input, files);
        renderContractPreviews(doc);
    });

    $(document).on('click', '[data-swap-file]', function() {
        var doc = this.getAttribute('data-swap-file');
        var f = sideInput(doc, 'front');
        var b = sideInput(doc, 'back');
        if (!f || !b || !window.DataTransfer) return;
        var ff = Array.prototype.slice.call(f.files || []);
        var bf = Array.prototype.slice.call(b.files || []);
        setInputFiles(f, bf);
        setInputFiles(b, ff);
        renderContractPreviews(doc);
        processCardImages(doc);
    });

    function normalizeGenderJs(v) {
        var s = String(v || '').trim();
        if (!s) return '';
        if (/^(m|male|nam|1)$/i.test(s)) return 'Nam';
        if (/^(f|female|nữ|nu|0)$/i.test(s)) return 'Nữ';
        return s;
    }

    function fillContractFields(doc, f) {
        f = f || {};
        if (doc === 'cccd') {
            setIfEmpty('cccd', String(f.cccd || '').trim());
            setIfEmpty('customer_name', String(f.name || '').trim());
            setIfEmpty('customer_phone', String(f.phone || '').trim());
            setIfEmpty('customer_address', String(f.address || '').trim());
            setIfEmpty('cccd_issue_date', String(f.issue_date || '').trim());
            setIfEmpty('dob', String(f.dob || '').trim());
            setIfEmpty('gender', normalizeGenderJs(f.gender));
        } else if (doc === 'license') {
            setIfEmpty('driver_license_no', String(f.license || f.cccd || '').trim());
            setIfEmpty('license_class', String(f.license_class || '').trim());
            setIfEmpty('license_issue_date', String(f.license_issue_date || f.issue_date || '').trim());
            setIfEmpty('license_expiry_date', String(f.license_expiry_date || '').trim());
        }
    }

    function fillCardQrFields(info) {
        setIfEmpty('cccd', String(info.cccd || '').trim());
        setIfEmpty('customer_name', String(info.name || '').trim());
        setIfEmpty('customer_address', String(info.address || '').trim());
        setIfEmpty('cccd_issue_date', String(info.issueDate || '').trim());
        setIfEmpty('dob', String(info.dob || '').trim());
        setIfEmpty('gender', normalizeGenderJs(info.gender));
    }

    async function callCardAI(doc, frontFile, backFile) {
        var cfg = window.__CONTRACT_OCR || {};
        var endpoints = [];
        if (cfg.openai) endpoints.push(cfg.openai);
        if (cfg.gemini) endpoints.push(cfg.gemini);
        if (!endpoints.length) {
            ocrStatus(doc, 'Chưa cấu hình AI (thiếu API key), vui lòng nhập tay.', true);
            return;
        }

        ocrStatus(doc, 'Đang đọc 2 ảnh bằng AI...', false);
        var fd = new FormData();
        if (frontFile) fd.append('image', frontFile);
        if (backFile) fd.append('image_back', backFile);
        var lastMsg = '';

        for (var i = 0; i < endpoints.length; i++) {
            try {
                var res = await fetch(endpoints[i], {
                    method: 'POST',
                    headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': cfg.csrf || '' },
                    body: fd
                });
                var data = await res.json().catch(function() { return {}; });
                if (res.status === 429) {
                    lastMsg = 'Bạn thao tác quá nhanh, vui lòng thử lại sau 1 phút.';
                    continue;
                }
                if (!res.ok || !data.success) {
                    lastMsg = data.message || 'Không đọc được thông tin, vui lòng nhập tay.';
                    continue;
                }
                fillContractFields(doc, data.fields || {});
                ocrStatus(doc, 'Đã đọc xong thông tin từ ảnh.', false);
                return;
            } catch (e) {
                lastMsg = 'Lỗi kết nối, vui lòng thử lại hoặc nhập tay.';
            }
        }
        ocrStatus(doc, lastMsg || 'Không đọc được thông tin, vui lòng nhập tay.', true);
    }

    function processCardImages(doc) {
        if (doc !== 'cccd' && doc !== 'license') return;
        var frontInput = sideInput(doc, 'front');
        var backInput = sideInput(doc, 'back');
        var frontFile = (frontInput && frontInput.files && frontInput.files[0]) || null;
        var backFile = (backInput && backInput.files && backInput.files[0]) || null;
        if (!frontFile && !backFile) {
            ocrStatus(doc, '', false);
            return;
        }

        var reader = window.__ContractCardReader;
        if (reader && typeof reader.decode === 'function') {
            ocrStatus(doc, 'Đang tìm mã QR...', false);
            var candidates = [frontFile, backFile].filter(Boolean);
            Promise.all(candidates.map(function(f) {
                return reader.decode(f).catch(function() { return null; });
            })).then(function(results) {
                var info = null;
                for (var i = 0; i < results.length; i++) {
                    if (results[i] && (results[i].cccd || results[i].name)) {
                        info = results[i];
                        break;
                    }
                }
                if (info) {
                    fillCardQrFields(info);
                    ocrStatus(doc, 'Đã đọc mã QR từ ảnh thẻ.', false);
                    if (doc === 'license') {
                        callCardAI(doc, frontFile, backFile);
                    }
                    return;
                }
                callCardAI(doc, frontFile, backFile);
            });
            return;
        }

        callCardAI(doc, frontFile, backFile);
    }
})(jQuery);
</script>
@endpush