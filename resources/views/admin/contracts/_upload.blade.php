@php
    $isMedia = $doc === 'car_video';
    $isDoc = in_array($doc, ['cccd', 'license'], true);
    $hasSides = count($cats) > 1;
    $accept = $isMedia ? 'video/*,image/*' : ($isDoc ? 'image/jpeg,image/png,image/webp' : 'image/*');
    $sizeHint = $isMedia
        ? '(ảnh: jpeg/png/jpg/gif/webp - 5MB; video: mp4, mov, avi, webm - 200MB)'
        : '(jpeg, png, jpg, gif, webp - 5MB)';
    $imageExts = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
@endphp
<div class="mb-4">
    <h6 class="font-weight-bold">
        {{ $label }}
        <small class="text-muted">{{ $sizeHint }}</small>
    </h6>

    <label for="file-{{ $doc }}"
           class="d-flex flex-column align-items-center justify-content-center w-100 rounded text-center contract-dropzone"
           style="border:1.5px dashed #cbd8ea;background:#fbfdff;padding:18px 12px;color:#5b7ea6;cursor:pointer">
        <i class="fas fa-cloud-upload-alt fa-2x mb-1"></i>
        <span class="font-weight-bold" style="font-size:13px">
            {{ $isMedia ? 'Thêm ảnh / video tải lên' : 'Thêm ảnh tải lên' }}
        </span>
        @if($isDoc)
            <small class="text-muted">Ảnh đầu = mặt trước, ảnh thứ hai = mặt sau. AI ưu tiên đọc QR rồi tự điền thông tin.</small>
        @endif
    </label>

    <input type="file" id="file-{{ $doc }}" data-doc="{{ $doc }}"
           class="d-none contract-file-picker" accept="{{ $accept }}" multiple>

    @foreach($cats as $i => $cat)
        <input type="file" name="images_{{ $cat }}[]" id="file-{{ $cat }}"
               class="d-none contract-file" data-doc="{{ $doc }}" data-cat="{{ $cat }}"
               data-side="{{ count($cats) > 1 ? ($i === 0 ? 'front' : 'back') : '' }}" accept="{{ $accept }}" multiple>
    @endforeach

    @if($hasSides && !$isMedia)
        <button type="button" class="btn btn-sm btn-outline-secondary mt-1" data-swap-file="{{ $doc }}">
            <i class="fas fa-exchange-alt"></i> Đổi vị trí mặt trước/sau
        </button>
    @endif

    <div id="preview-{{ $doc }}" class="d-flex flex-wrap mt-2"></div>
    <div id="ocr-status-{{ $doc }}" class="mt-1 small text-muted"></div>

    @foreach($cats as $i => $cat)
        @if($isEdit && $contract->images->where('category', $cat)->count())
        @php $items = $contract->images->where('category', $cat); @endphp
        <div class="mt-2">
            <label class="text-muted small">
                {{ $hasSides ? ($i === 0 ? 'Mặt trước hiện tại' : 'Mặt sau hiện tại') : 'Hình hiện tại' }} (tick để xóa):
            </label>
            <div class="d-flex flex-wrap">
                @foreach($items as $img)
                <div class="mr-2 mb-2 text-center" style="width:120px">
                    <label class="mb-1">
                        <input type="checkbox" name="delete_images[]" value="{{ $img->id }}" class="mr-1">
                        <span class="small text-danger">Xóa</span>
                    </label>
                    @if(in_array(strtolower(pathinfo($img->path, PATHINFO_EXTENSION)), $imageExts, true))
                        <img src="{{ asset($img->path) }}" class="border rounded" style="width:120px;height:70px;object-fit:cover">
                    @else
                        <div class="border rounded p-2" style="height:70px;background:#f5f5f5;display:flex;align-items:center;justify-content:center">
                            <a href="{{ asset($img->path) }}" target="_blank" class="text-primary"><i class="fas fa-video fa-2x"></i><br><small>Xem video</small></a>
                        </div>
                    @endif
                </div>
                @endforeach
            </div>
        </div>
        @endif
    @endforeach
</div>