@extends('adminlte::page')

@section('title', 'Sửa báo cáo')

@section('content_header')
    <h1>Sửa báo cáo</h1>
@stop

@section('content')
<div class="row">
    <div class="col-md-7">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Thông tin báo cáo</h3>
                <div class="card-tools">
                    <span class="badge badge-secondary">Khách: {{ $report->customer?->name ?? 'Đã xóa' }}</span>
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.reports.update', $report) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Người báo cáo</label>
                                <input type="text" name="reporter_name" class="form-control" value="{{ old('reporter_name', $report->reporter_name) }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>SĐT người báo cáo</label>
                                <input type="text" name="reporter_phone" class="form-control" value="{{ old('reporter_phone', $report->reporter_phone) }}">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Danh mục</label>
                                <input type="text" name="category" class="form-control" value="{{ old('category', $report->category) }}">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Lượt xem</label>
                                <input type="number" name="views" class="form-control" value="{{ old('views', $report->views) }}" min="0">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Trạng thái <span class="text-danger">*</span></label>
                                <select name="status" class="form-control" required>
                                    <option value="pending" {{ old('status', $report->status) === 'pending' ? 'selected' : '' }}>Chờ xác minh</option>
                                    <option value="approved" {{ old('status', $report->status) === 'approved' ? 'selected' : '' }}>Đã xác minh</option>
                                    <option value="rejected" {{ old('status', $report->status) === 'rejected' ? 'selected' : '' }}>Từ chối</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Nội dung <span class="text-danger">*</span></label>
                        <textarea name="content" rows="5" class="form-control @error('content') is-invalid @enderror" required>{{ old('content', $report->content) }}</textarea>
                        @error('content') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    <button type="submit" class="btn btn-success"><i class="fas fa-save mr-1"></i> Lưu</button>
                    <a href="{{ route('admin.reports.index') }}" class="btn btn-default">Hủy</a>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-5">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Hình ảnh / bằng chứng</h3>
            </div>
            <div class="card-body">
                @forelse($report->images as $img)
                <div class="mb-2 d-flex align-items-start" id="img-{{ $img->id }}">
                    <img src="{{ asset($img->path) }}" style="width:120px;height:80px;object-fit:cover;border-radius:6px">
                    <button type="button" class="btn btn-sm btn-danger ml-2 btn-del-img" data-url="{{ route('admin.reports.image.destroy', $img) }}"><i class="fas fa-trash"></i></button>
                </div>
                @empty
                <p class="text-muted mb-0">Chưa có hình ảnh nào.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@stop

@section('js')
<script>
$(function() {
    function showToast(msg, type) {
        var bg = (type || 'success') === 'success' ? 'alert-success' : 'alert-danger';
        var $t = $('#toast').removeClass('alert-success alert-danger').addClass(bg).text(msg).fadeIn();
        clearTimeout($t.data('timer'));
        $t.data('timer', setTimeout(function() { $t.fadeOut(); }, 3000));
    }
    $(document).on('click', '.btn-del-img', function() {
        var $btn = $(this), url = $btn.data('url');
        var $box = $btn.closest('.d-flex');
        if (!confirm('Xóa hình ảnh này?')) return;
        $btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i>');
        $.ajax({
            url: url, type: 'DELETE', data: { _token: '{{ csrf_token() }}' },
            success: function(res) { $box.fadeOut(function() { $box.remove(); }); showToast('Đã xóa hình ảnh.'); },
            error: function() { showToast('Lỗi', 'error'); $btn.prop('disabled', false).html('<i class="fas fa-trash"></i>'); }
        });
    });
});
</script>
@stop
