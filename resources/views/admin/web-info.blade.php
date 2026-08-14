@extends('adminlte::page')

@section('title', 'Thong tin Web')

@section('content_header')
    <h1>Thong tin Web</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title mb-0">Thong tin lien he website</h3>
                </div>
                <form action="{{ route('admin.web-info.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        <div class="form-group">
                            <label for="site_owner_name">Tên chủ cửa hàng</label>
                            <input
                                type="text"
                                class="form-control @error('site_owner_name') is-invalid @enderror"
                                id="site_owner_name"
                                name="site_owner_name"
                                value="{{ old('site_owner_name', $settings['site_owner_name']) }}"
                                placeholder="Thuê Xe Tự Lái Buôn Hồ"
                            >
                            @error('site_owner_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="site_owner_avatar">Avatar chủ cửa hàng</label>
                            <div class="d-flex align-items-center gap-3">
                                <div>
                                    <input
                                        type="file"
                                        class="form-control-file @error('site_owner_avatar') is-invalid @enderror"
                                        id="site_owner_avatar"
                                        name="site_owner_avatar"
                                        accept="image/*"
                                    >
                                    <small class="form-text text-muted">Định dạng: jpeg, png, jpg, gif, webp. Dung lượng tối đa 2MB.</small>
                                </div>
                                <div id="owner-avatar-preview" style="width:80px;height:80px;border-radius:50%;overflow:hidden;border:2px dashed #ddd;flex-shrink:0;display:flex;align-items:center;justify-content:center">
                                    @if($settings['site_owner_avatar'])
                                        <img src="{{ asset($settings['site_owner_avatar']) }}" style="width:100%;height:100%;object-fit:cover">
                                    @else
                                        <span class="text-muted small text-center">Chưa có</span>
                                    @endif
                                </div>
                            </div>
                            @error('site_owner_avatar')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <hr>

                        <div class="form-group">
                            <label for="site_phone">So dien thoai</label>
                            <input
                                type="text"
                                class="form-control @error('site_phone') is-invalid @enderror"
                                id="site_phone"
                                name="site_phone"
                                value="{{ old('site_phone', $settings['site_phone']) }}"
                                placeholder="Vi du: 0964918047"
                            >
                            @error('site_phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="site_address">Dia chi</label>
                            <input
                                type="text"
                                class="form-control @error('site_address') is-invalid @enderror"
                                id="site_address"
                                name="site_address"
                                value="{{ old('site_address', $settings['site_address']) }}"
                                placeholder="Vi du: 07 Chu Van An, Buon Ho, Dak Lak"
                            >
                            @error('site_address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="site_map_url">Link dinh vi / Google Maps</label>
                            <input
                                type="url"
                                class="form-control @error('site_map_url') is-invalid @enderror"
                                id="site_map_url"
                                name="site_map_url"
                                value="{{ old('site_map_url', $settings['site_map_url']) }}"
                                placeholder="https://maps.app.goo.gl/..."
                            >
                            @error('site_map_url')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="google_tag_id">Ma Google tag</label>
                            <input
                                type="text"
                                class="form-control @error('google_tag_id') is-invalid @enderror"
                                id="google_tag_id"
                                name="google_tag_id"
                                value="{{ old('google_tag_id', $settings['google_tag_id']) }}"
                                placeholder="Vi du: G-LL0TX603RY hoac AW-123456789"
                            >
                            @error('google_tag_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">
                                Dan ma tu Google Ads hoac Google Analytics. He thong se tu dong chen the Google vao truoc dong dong cua &lt;head&gt; tren toan bo website.
                            </small>
                        </div>

                        <div class="form-group">
                            <label for="site_facebook">Link Facebook</label>
                            <input
                                type="url"
                                class="form-control @error('site_facebook') is-invalid @enderror"
                                id="site_facebook"
                                name="site_facebook"
                                value="{{ old('site_facebook', $settings['site_facebook']) }}"
                                placeholder="https://www.facebook.com/..."
                            >
                            @error('site_facebook')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <hr>

                        <div class="form-group">
                            <label for="site_description">Meta Description (SEO)</label>
                            <textarea
                                class="form-control @error('site_description') is-invalid @enderror"
                                id="site_description"
                                name="site_description"
                                rows="3"
                                placeholder="Dịch vụ cho thuê xe tự lái, có tài xế tại Buôn Hồ, Đăk Lăk. Giá rẻ, uy tín, thủ tục nhanh gọn."
                            >{{ old('site_description', $settings['site_description']) }}</textarea>
                            @error('site_description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">
                                Mô tả ngắn gọn hiển thị trong kết quả tìm kiếm Google. Nên dưới 160 ký tự. Xuất hiện trong thẻ &lt;meta name=&quot;description&quot;&gt; trên toàn bộ website.
                            </small>
                        </div>

                        <div class="form-group">
                            <label for="site_keywords">Từ khoá SEO (meta keywords)</label>
                            <textarea
                                class="form-control @error('site_keywords') is-invalid @enderror"
                                id="site_keywords"
                                name="site_keywords"
                                rows="3"
                                placeholder="thuê xe tự lái Buôn Hồ, cho thuê xe ô tô Đăk Lăk, thuê xe giá rẻ, ..."
                            >{{ old('site_keywords', $settings['site_keywords']) }}</textarea>
                            @error('site_keywords')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">
                                Nhập các từ khoá chính, cách nhau bằng dấu phẩy (,). Xuất hiện trong thẻ &lt;meta name=&quot;keywords&quot;&gt; trên toàn bộ website.
                            </small>
                        </div>

                        <hr>

                        <h5 class="mb-3"><i class="fas fa-search mr-1"></i> SEO Trang Chủ</h5>

                        <div class="form-group">
                            <label for="home_meta_description">Meta Description trang chủ</label>
                            <textarea
                                class="form-control @error('home_meta_description') is-invalid @enderror"
                                id="home_meta_description"
                                name="home_meta_description"
                                rows="3"
                                placeholder="Dịch vụ cho thuê xe tự lái, có tài xế tại Buôn Hồ, Đăk Lăk. Giá rẻ, uy tín, thủ tục nhanh gọn."
                            >{{ old('home_meta_description', $settings['home_meta_description']) }}</textarea>
                            @error('home_meta_description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">
                                Mô tả hiển thị trong kết quả tìm kiếm Google cho trang chủ. Nên dưới 160 ký tự.
                            </small>
                        </div>

                        <div class="form-group">
                            <label for="home_og_title">OG Title (tiêu đề khi chia sẻ MXH)</label>
                            <input
                                type="text"
                                class="form-control @error('home_og_title') is-invalid @enderror"
                                id="home_og_title"
                                name="home_og_title"
                                value="{{ old('home_og_title', $settings['home_og_title']) }}"
                                placeholder="Thuê Xe Buôn Hồ - Cho thuê xe tự lái"
                            >
                            @error('home_og_title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="home_og_description">OG Description (mô tả khi chia sẻ MXH)</label>
                            <textarea
                                class="form-control @error('home_og_description') is-invalid @enderror"
                                id="home_og_description"
                                name="home_og_description"
                                rows="3"
                                placeholder="Dịch vụ cho thuê xe tự lái, có tài xế tại Buôn Hồ, Đăk Lăk. Giá rẻ, uy tín, thủ tục nhanh gọn."
                            >{{ old('home_og_description', $settings['home_og_description']) }}</textarea>
                            @error('home_og_description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="home_og_image">OG Image (ảnh khi chia sẻ MXH)</label>
                            <div class="d-flex align-items-center gap-3">
                                <div>
                                    <input
                                        type="file"
                                        class="form-control-file @error('home_og_image') is-invalid @enderror"
                                        id="home_og_image"
                                        name="home_og_image"
                                        accept="image/*"
                                    >
                                    <small class="form-text text-muted">Kích thước khuyến nghị: 1200x630px. Định dạng: jpeg, png, jpg, webp. Tối đa 2MB.</small>
                                </div>
                                <div id="og-image-preview" style="width:120px;height:63px;border-radius:6px;overflow:hidden;border:2px dashed #ddd;flex-shrink:0;display:flex;align-items:center;justify-content:center">
                                    @if($settings['home_og_image'])
                                        <img src="{{ asset($settings['home_og_image']) }}" style="width:100%;height:100%;object-fit:cover">
                                    @else
                                        <span class="text-muted small text-center">Chưa có</span>
                                    @endif
                                </div>
                            </div>
                            @error('home_og_image')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="card-footer d-flex justify-content-between align-items-center flex-wrap">
                        <p class="text-muted mb-2 mb-md-0">
                            Cap nhat so dien thoai, dia chi, link dinh vi, ma Google tag va link Facebook hien tren website tai day.
                        </p>
                        <button type="submit" class="btn btn-primary">
                            Luu thong tin
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card card-outline card-info">
                <div class="card-header">
                    <h3 class="card-title mb-0">Goi y</h3>
                </div>
                <div class="card-body">
                    <ol class="pl-3 mb-0">
                        <li>So dien thoai nay duoc dung cho nut goi va lien he nhanh.</li>
                        <li>Dia chi se hien o cac khu vuc thong tin website.</li>
                        <li>Link dinh vi nen dan den Google Maps hoac link chia se ban do.</li>
                        <li>Ma Google tag co the la dang <code>G-...</code> hoac <code>AW-...</code>.</li>
                        <li>Link Facebook duoc dung cho nut chia se va footer website.</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
@stop

@push('js')
<script>
$(function() {
    $('#site_owner_avatar').on('change', function() {
        var file = this.files[0];
        if (!file) return;
        var reader = new FileReader();
        reader.onload = function(e) {
            $('#owner-avatar-preview').html('<img src="' + e.target.result + '" style="width:100%;height:100%;object-fit:cover">');
        };
        reader.readAsDataURL(file);
    });

    $('#home_og_image').on('change', function() {
        var file = this.files[0];
        if (!file) return;
        var reader = new FileReader();
        reader.onload = function(e) {
            $('#og-image-preview').html('<img src="' + e.target.result + '" style="width:100%;height:100%;object-fit:cover">');
        };
        reader.readAsDataURL(file);
    });
});
</script>
@endpush
