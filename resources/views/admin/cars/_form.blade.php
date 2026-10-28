<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label>Tên xe <span class="text-danger">*</span></label>
            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $car->name ?? '') }}" required>
            @error('name') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
            <label>Biển số</label>
            <input type="text" name="plate" class="form-control @error('plate') is-invalid @enderror" value="{{ old('plate', $car->plate ?? '') }}" placeholder="VD: 47A-123.45">
            @error('plate') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <div class="row">
            <div class="col-6">
                <div class="form-group">
                    <label>Nhãn hiệu</label>
                    <input type="text" name="brand" class="form-control @error('brand') is-invalid @enderror" value="{{ old('brand', $car->brand ?? '') }}" placeholder="VD: Toyota">
                    @error('brand') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label>Model / Phiên bản</label>
                    <input type="text" name="model" class="form-control @error('model') is-invalid @enderror" value="{{ old('model', $car->model ?? '') }}" placeholder="VD: Vios G">
                    @error('model') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-4">
                <div class="form-group">
                    <label>Màu sơn</label>
                    <input type="text" name="color" class="form-control @error('color') is-invalid @enderror" value="{{ old('color', $car->color ?? '') }}" placeholder="VD: Trắng">
                    @error('color') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </div>
            <div class="col-4">
                <div class="form-group">
                    <label>Số khung</label>
                    <input type="text" name="chassis_no" class="form-control @error('chassis_no') is-invalid @enderror" value="{{ old('chassis_no', $car->chassis_no ?? '') }}">
                    @error('chassis_no') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </div>
            <div class="col-4">
                <div class="form-group">
                    <label>Số máy</label>
                    <input type="text" name="engine_no" class="form-control @error('engine_no') is-invalid @enderror" value="{{ old('engine_no', $car->engine_no ?? '') }}">
                    @error('engine_no') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </div>
        </div>

        <div class="form-group">
            <label>Chủ xe</label>
            <input type="text" name="owner" class="form-control @error('owner') is-invalid @enderror" value="{{ old('owner', $car->owner ?? '') }}" placeholder="VD: Hộ kinh doanh Thuê Xe Buôn Hồ">
            @error('owner') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
            <label>Mô tả</label>
            <textarea name="description" class="form-control" rows="3">{{ old('description', $car->description ?? '') }}</textarea>
        </div>

        <div class="row">
            <div class="col-4">
                <div class="form-group">
                    <label>Số ghế <span class="text-danger">*</span></label>
                    <input type="number" name="seats" class="form-control" value="{{ old('seats', $car->seats ?? 5) }}" min="2" max="50" required>
                </div>
            </div>
            <div class="col-4">
                <div class="form-group">
                    <label>Hộp số <span class="text-danger">*</span></label>
                    <select name="transmission" class="form-control">
                        <option value="Tự động" {{ (old('transmission', $car->transmission ?? '') == 'Tự động') ? 'selected' : '' }}>Tự động</option>
                        <option value="Số sàn" {{ (old('transmission', $car->transmission ?? '') == 'Số sàn') ? 'selected' : '' }}>Số sàn</option>
                    </select>
                </div>
            </div>
            <div class="col-4">
                <div class="form-group">
                    <label>Năm SX</label>
                    <input type="number" name="year" class="form-control" value="{{ old('year', $car->year ?? date('Y')) }}">
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-6">
                <div class="form-group">
                    <label>Nhiên liệu <span class="text-danger">*</span></label>
                    <select name="fuel" class="form-control">
                        <option value="Máy xăng" {{ (old('fuel', $car->fuel ?? '') == 'Máy xăng') ? 'selected' : '' }}>Máy xăng</option>
                        <option value="Máy dầu" {{ (old('fuel', $car->fuel ?? '') == 'Máy dầu') ? 'selected' : '' }}>Máy dầu</option>
                        <option value="Điện" {{ (old('fuel', $car->fuel ?? '') == 'Điện') ? 'selected' : '' }}>Điện</option>
                    </select>
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label>Tiêu hao nhiên liệu</label>
                    <input type="text" name="fuel_consumption" class="form-control" value="{{ old('fuel_consumption', $car->fuel_consumption ?? '') }}" placeholder="vd: 6l/100km">
                </div>
            </div>
        </div>

        <div class="form-group">
            <label>Bảo hiểm</label>
            <input type="text" name="insurance" class="form-control" value="{{ old('insurance', $car->insurance ?? 'Đầy đủ') }}">
        </div>

        <div class="form-group">
            <label>Địa chỉ nhận xe</label>
            <input type="text" name="address" class="form-control" value="{{ old('address', $car->address ?? '07 Chu Văn An, Buôn Hồ') }}">
        </div>
    </div>

    <div class="col-md-6">
        <h5 class="font-weight-bold mb-3">Giá thuê</h5>

        <div class="row">
            <div class="col-6">
                <div class="form-group">
                    <label>Giá/ngày (VNĐ) <span class="text-danger">*</span></label>
                    <input type="number" name="price_per_day" class="form-control" value="{{ old('price_per_day', $car->price_per_day ?? 650000) }}" min="0" required>
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label>Giá/buổi (VNĐ) <span class="text-danger">*</span></label>
                    <input type="number" name="price_per_session" class="form-control" value="{{ old('price_per_session', $car->price_per_session ?? 350000) }}" min="0" required>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-6">
                <div class="form-group">
                    <label>Giá thuê 3+ ngày (VNĐ)</label>
                    <input type="number" name="price_multi_day" class="form-control" value="{{ old('price_multi_day', $car->price_multi_day ?? '') }}" min="0">
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label>Phụ phí ra tỉnh (VNĐ)</label>
                    <input type="number" name="price_out_province" class="form-control" value="{{ old('price_out_province', $car->price_out_province ?? '') }}" min="0">
                </div>
            </div>
        </div>

        <h5 class="font-weight-bold mb-3 mt-3">Tiền cọc</h5>

        <div class="row">
            <div class="col-4">
                <div class="form-group">
                    <label>Cọc tối thiểu</label>
                    <input type="number" name="deposit_min" class="form-control" value="{{ old('deposit_min', $car->deposit_min ?? 300000) }}" min="0">
                </div>
            </div>
            <div class="col-4">
                <div class="form-group">
                    <label>Cọc tối đa</label>
                    <input type="number" name="deposit_max" class="form-control" value="{{ old('deposit_max', $car->deposit_max ?? 1000000) }}" min="0">
                </div>
            </div>
            <div class="col-4">
                <div class="form-group">
                    <label>Thế chấp TS</label>
                    <input type="number" name="deposit_asset" class="form-control" value="{{ old('deposit_asset', $car->deposit_asset ?? 15000000) }}" min="0">
                </div>
            </div>
        </div>

        <div class="row mt-2">
            <div class="col-6">
                <div class="form-group">
                    <label>Trạng thái</label>
                    <select name="status" class="form-control">
                        <option value="available" {{ (old('status', $car->status ?? 'available') == 'available') ? 'selected' : '' }}>Sẵn sàng</option>
                        <option value="rented" {{ (old('status', $car->status ?? '') == 'rented') ? 'selected' : '' }}>Đang thuê</option>
                        <option value="maintenance" {{ (old('status', $car->status ?? '') == 'maintenance') ? 'selected' : '' }}>Bảo trì</option>
                    </select>
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label>Thứ tự hiển thị</label>
                    <input type="number" name="sort_order" class="form-control" value="{{ old('sort_order', $car->sort_order ?? 0) }}" min="0">
                </div>
            </div>
        </div>
    </div>

    <div class="col-12 mt-3">
        <h5 class="font-weight-bold mb-3">Ảnh xe</h5>

        <div class="form-group">
            <label>Chọn ảnh (có thể chọn nhiều)</label>
            <input type="file" name="images[]" id="car-images" class="form-control-file" multiple accept="image/*">
            <small class="form-text text-muted">Định dạng: jpeg, png, jpg, gif, webp. Dung lượng tối đa 5MB/ảnh.</small>
        </div>

        <div id="image-preview-new" class="row"></div>

        @if(isset($car))
        <div class="mt-3">
            <label class="d-block font-weight-bold">Ảnh xe (kéo thả để sắp xếp)</label>
            <small class="text-muted d-block mb-2">Kéo thanh màu xám để di chuyển. Ảnh đầu tiên là ảnh chính. Có thể kéo cả ảnh mới thêm lên đầu.</small>
            <div class="row" id="sortable-images">
                @foreach($car->images as $img)
                <div class="col-md-3 col-4 mb-3" id="existing-img-{{ $img->id }}" data-id="{{ $img->id }}" data-key="existing:{{ $img->id }}">
                    <div class="card">
                        <div class="bg-secondary text-white text-center img-handle py-1" style="cursor:move;font-size:12px;user-select:none"><i class="fas fa-grip-vertical"></i></div>
                        <div style="position:relative">
                            <img src="{{ asset($img->path) }}" class="img-fluid" style="height:120px;width:100%;object-fit:cover;display:block">
                            @if($img->is_main)
                            <span class="badge badge-success main-badge" style="position:absolute;top:4px;left:4px">Ảnh chính</span>
                            @endif
                            <button type="button" class="btn btn-sm btn-danger btn-del-img" style="position:absolute;top:4px;right:4px;padding:0 6px;font-size:14px;line-height:1" data-id="{{ $img->id }}" data-url="{{ route('admin.cars.image.destroy', $img) }}" title="Xóa">&times;</button>
                        </div>
                        <input type="hidden" name="image_order[]" value="existing:{{ $img->id }}" class="img-sort-input">
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif

    </div>

    <div class="col-12 mt-3">
        <h5 class="font-weight-bold mb-3">Tiện ích</h5>
        @php $selectedAmenities = old('amenities', isset($car) ? $car->amenities->pluck('id')->toArray() : []); @endphp
        <div class="row">
            @foreach(\App\Models\Amenity::orderBy('sort_order')->get() as $amenity)
            <div class="col-md-3 col-6">
                <div class="form-check">
                    <input type="checkbox" name="amenities[]" value="{{ $amenity->id }}" id="am-{{ $amenity->id }}" class="form-check-input" {{ in_array($amenity->id, $selectedAmenities) ? 'checked' : '' }}>
                    <label class="form-check-label" for="am-{{ $amenity->id }}">
@if($amenity->icon)
    <img src="{{ asset(Str::startsWith($amenity->icon, 'storage/') ? $amenity->icon : 'assets/' . $amenity->icon) }}" style="width:20px;height:20px;object-fit:contain;vertical-align:middle" class="mr-1">
@endif
                        {{ $amenity->name }}
                    </label>
                </div>
            </div>
            @endforeach
        </div>
        @if(\App\Models\Amenity::count() == 0)
            <p class="text-muted">Chưa có tiện ích nào. <a href="{{ route('admin.amenities.create') }}" target="_blank">Thêm tiện ích mới</a></p>
        @endif
    </div>

    <div class="col-12 mt-3">
        <h5 class="font-weight-bold mb-3">Hướng dẫn xe</h5>
        <p class="text-muted small">Thêm video hoặc ảnh hướng dẫn sử dụng cho xe này (vd: Hướng dẫn khởi động, Hướng dẫn đổ xăng...)</p>
        <div id="guides-wrapper">
            @php $guideIndex = 0; @endphp
            @if(isset($car) && $car->guides->count() > 0)
                @foreach($car->guides as $guide)
                <div class="guide-item row align-items-end mb-2 p-2 border rounded bg-light">
                    <input type="hidden" name="guides[{{ $guideIndex }}][id]" value="{{ $guide->id }}">
                    <div class="col-md-4">
                        <div class="form-group mb-0">
                            <label class="small">Tiêu đề</label>
                            <input type="text" name="guides[{{ $guideIndex }}][title]" class="form-control form-control-sm" value="{{ $guide->title }}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group mb-0">
                            <label class="small">Video</label>
                            <input type="file" name="guides[{{ $guideIndex }}][video]" class="form-control-file form-control-sm guide-video-input" accept="video/mp4,video/webm,video/ogg" {{ $guide->image_path ? 'style=display:none' : '' }}>
                            @if($guide->video_path)
                            <small class="form-text text-muted">Đã có: <a href="{{ asset($guide->video_path) }}" target="_blank">{{ basename($guide->video_path) }}</a>. Chọn file mới để thay thế.</small>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group mb-0">
                            <label class="small">Ảnh</label>
                            <input type="file" name="guides[{{ $guideIndex }}][image]" class="form-control-file form-control-sm guide-image-input" accept="image/*" {{ $guide->video_path ? 'style=display:none' : '' }}>
                            @if($guide->image_path)
                            <small class="form-text text-muted">Đã có: <a href="{{ asset($guide->image_path) }}" target="_blank">{{ basename($guide->image_path) }}</a>. Chọn file mới để thay thế.</small>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-2 text-right">
                        <button type="button" class="btn btn-sm btn-outline-danger btn-remove-guide" title="Xoá"><i class="fas fa-times"></i></button>
                    </div>
                </div>
                @php $guideIndex++; @endphp
                @endforeach
            @endif
        </div>
        <div id="guide-template" class="d-none">
            <div class="guide-item row align-items-end mb-2 p-2 border rounded bg-light">
                <div class="col-md-4">
                    <div class="form-group mb-0">
                        <label class="small">Tiêu đề</label>
                        <input type="text" name="guides[__INDEX__][title]" class="form-control form-control-sm">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group mb-0">
                        <label class="small">Video</label>
                        <input type="file" name="guides[__INDEX__][video]" class="form-control-file form-control-sm guide-video-input" accept="video/mp4,video/webm,video/ogg">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group mb-0">
                        <label class="small">Ảnh</label>
                        <input type="file" name="guides[__INDEX__][image]" class="form-control-file form-control-sm guide-image-input" accept="image/*">
                    </div>
                </div>
                <div class="col-md-2 text-right">
                    <button type="button" class="btn btn-sm btn-outline-danger btn-remove-guide" title="Xoá"><i class="fas fa-times"></i></button>
                </div>
            </div>
        </div>
        <button type="button" id="btn-add-guide" class="btn btn-sm btn-outline-primary"><i class="fas fa-plus mr-1"></i>Thêm hướng dẫn</button>
    </div>
</div>

@push('js')
<script>
$(function() {
    var guideIndex = {{ $guideIndex }};
    $('#btn-add-guide').on('click', function() {
        var html = $('#guide-template').html().replace(/__INDEX__/g, guideIndex++);
        $('#guides-wrapper').append(html);
    });
    $(document).on('click', '.btn-remove-guide', function() {
        $(this).closest('.guide-item').remove();
    });
    $(document).on('change', '.guide-video-input', function() {
        if (this.files && this.files.length > 0) {
            $(this).closest('.guide-item').find('.guide-image-input').val('').hide();
        } else {
            $(this).closest('.guide-item').find('.guide-image-input').show();
        }
    });
    $(document).on('change', '.guide-image-input', function() {
        if (this.files && this.files.length > 0) {
            $(this).closest('.guide-item').find('.guide-video-input').val('').hide();
        } else {
            $(this).closest('.guide-item').find('.guide-video-input').show();
        }
    });
});
</script>
@endpush


