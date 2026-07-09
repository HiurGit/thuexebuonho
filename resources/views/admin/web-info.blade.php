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
                <form action="{{ route('admin.web-info.update') }}" method="POST">
                    @csrf
                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

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
                    </div>
                    <div class="card-footer d-flex justify-content-between align-items-center flex-wrap">
                        <p class="text-muted mb-2 mb-md-0">
                            Cap nhat so dien thoai, dia chi, link dinh vi va ma Google tag hien tren website tai day.
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
                    </ol>
                </div>
            </div>
        </div>
    </div>
@stop
