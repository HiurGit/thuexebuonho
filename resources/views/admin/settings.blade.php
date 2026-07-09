@extends('adminlte::page')

@section('title', 'Tele')

@section('content_header')
    <h1>Cau hinh Tele</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title mb-0">Tele thong bao don dat xe</h3>
                </div>
                <form action="{{ route('admin.settings.update') }}" method="POST">
                    @csrf
                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        <div class="form-group">
                            <div class="custom-control custom-switch">
                                <input
                                    type="checkbox"
                                    class="custom-control-input"
                                    id="telegram_bot_enabled"
                                    name="telegram_bot_enabled"
                                    value="1"
                                    {{ old('telegram_bot_enabled', $telegramSettings['enabled']) ? 'checked' : '' }}
                                >
                                <label class="custom-control-label" for="telegram_bot_enabled">
                                    Bat gui thong bao Telegram khi co khach dat xe
                                </label>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="telegram_bot_token">Bot token</label>
                            <input
                                type="text"
                                class="form-control @error('telegram_bot_token') is-invalid @enderror"
                                id="telegram_bot_token"
                                name="telegram_bot_token"
                                value="{{ old('telegram_bot_token', $telegramSettings['bot_token']) }}"
                                placeholder="Vi du: 123456789:AA..."
                            >
                            @error('telegram_bot_token')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="telegram_chat_id">Nhom chat ID</label>
                            <input
                                type="text"
                                class="form-control @error('telegram_chat_id') is-invalid @enderror"
                                id="telegram_chat_id"
                                name="telegram_chat_id"
                                value="{{ old('telegram_chat_id', $telegramSettings['chat_id']) }}"
                                placeholder="Vi du: -1001234567890"
                            >
                            @error('telegram_chat_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="telegram_quick_message_template">Mau Tele form nhanh</label>
                            <textarea
                                class="form-control @error('telegram_quick_message_template') is-invalid @enderror"
                                id="telegram_quick_message_template"
                                name="telegram_quick_message_template"
                                rows="10"
                                placeholder="Nhap noi dung thong bao gui Telegram cho form trang chu"
                            >{{ old('telegram_quick_message_template', $telegramSettings['quick_message_template']) }}</textarea>
                            @error('telegram_quick_message_template')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">
                                Dung cho form Thue xe nhanh o trang chu. Form nay hop nhat voi: {ma_don}, {nguon_form}, {so_dien_thoai}, {loai_thue}, {ngay_thue}, {khung_gio}. Noi dung dong trong {...} se tu dong hien dam tren Telegram.
                            </small>
                        </div>

                        <div class="form-group">
                            <label for="telegram_car_detail_message_template">Mau Tele form chi tiet xe</label>
                            <textarea
                                class="form-control @error('telegram_car_detail_message_template') is-invalid @enderror"
                                id="telegram_car_detail_message_template"
                                name="telegram_car_detail_message_template"
                                rows="10"
                                placeholder="Nhap noi dung thong bao gui Telegram cho form chi tiet xe"
                            >{{ old('telegram_car_detail_message_template', $telegramSettings['car_detail_message_template']) }}</textarea>
                            @error('telegram_car_detail_message_template')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">
                                Dung cho form dat xe trong trang chi tiet tung xe. Form nay co du thong tin hon nhu {ten_xe}, {tong_tien}, {ke_hoach_chuyen_di}, {hinh_thuc_nhan_xe}, {so_ngay}, {ghi_chu}. Noi dung dong trong {...} se tu dong hien dam tren Telegram.
                            </small>
                        </div>
                    </div>
                    <div class="card-footer d-flex justify-content-between align-items-center flex-wrap">
                        <p class="text-muted mb-2 mb-md-0">
                            Khi bat, moi don moi tu website se tu dong gui vao nhom Telegram da cau hinh.
                        </p>
                        <button type="submit" class="btn btn-primary">
                            Luu cau hinh
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card card-outline card-info">
                <div class="card-header">
                    <h3 class="card-title mb-0">Cach lay thong tin</h3>
                </div>
                <div class="card-body">
                    <ol class="pl-3 mb-0">
                        <li>Tao bot bang BotFather va lay bot token.</li>
                        <li>Them bot vao nhom Telegram can nhan thong bao.</li>
                        <li>Lay chat ID cua nhom, thuong co dang -100...</li>
                        <li>Co 2 mau rieng: form nhanh va form chi tiet xe. He thong se tu chon dung mau khi gui.</li>
                    </ol>
                </div>
            </div>

            <div class="card card-outline card-secondary">
                <div class="card-header">
                    <h3 class="card-title mb-0">Bien dong form nhanh</h3>
                </div>
                <div class="card-body">
                    <div class="mb-2"><code>{ma_don}</code> ma don booking</div>
                    <div class="mb-2"><code>{nguon_form}</code> nguon gui form</div>
                    <div class="mb-2"><code>{so_dien_thoai}</code> so dien thoai</div>
                    <div class="mb-2"><code>{loai_thue}</code> loai thue</div>
                    <div class="mb-2"><code>{ngay_thue}</code> ngay hoac khoang ngay thue</div>
                    <div class="mb-0"><code>{khung_gio}</code> khung gio / ca thue</div>
                </div>
            </div>

            <div class="card card-outline card-secondary">
                <div class="card-header">
                    <h3 class="card-title mb-0">Bien dong form chi tiet xe</h3>
                </div>
                <div class="card-body">
                    <div class="mb-2"><code>{ma_don}</code> ma don booking</div>
                    <div class="mb-2"><code>{nguon_form}</code> nguon gui form</div>
                    <div class="mb-2"><code>{ten_khach}</code> ten khach</div>
                    <div class="mb-2"><code>{so_dien_thoai}</code> so dien thoai</div>
                    <div class="mb-2"><code>{ten_xe}</code> ten xe</div>
                    <div class="mb-2"><code>{loai_thue}</code> loai thue</div>
                    <div class="mb-2"><code>{ngay_thue}</code> ngay hoac khoang ngay thue</div>
                    <div class="mb-2"><code>{khung_gio}</code> khung gio / ca thue</div>
                    <div class="mb-2"><code>{ke_hoach_chuyen_di}</code> trong tinh hoac ngoai tinh</div>
                    <div class="mb-2"><code>{hinh_thuc_nhan_xe}</code> tai shop hoac giao tan noi</div>
                    <div class="mb-2"><code>{so_ngay}</code> tong so ngay</div>
                    <div class="mb-2"><code>{tong_tien}</code> tong tien booking</div>
                    <div class="mb-0"><code>{ghi_chu}</code> ghi chu booking</div>
                </div>
            </div>
        </div>
    </div>
@stop
