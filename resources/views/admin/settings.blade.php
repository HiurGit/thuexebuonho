@extends('adminlte::page')

@section('title', 'Tele')

@section('content_header')
    <h1>Tele</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title mb-0">Cấu hình Telegram</h3>
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
                                    {{ old('telegram_bot_enabled', $settings['enabled']) ? 'checked' : '' }}
                                >
                                <label class="custom-control-label" for="telegram_bot_enabled">
                                    Bật gửi thông báo Telegram khi có khách đặt xe
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
                                value="{{ old('telegram_bot_token', $settings['bot_token']) }}"
                                placeholder="Ví dụ: 123456789:AA..."
                            >
                            @error('telegram_bot_token')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="telegram_chat_id">Nhóm chat ID</label>
                            <input
                                type="text"
                                class="form-control @error('telegram_chat_id') is-invalid @enderror"
                                id="telegram_chat_id"
                                name="telegram_chat_id"
                                value="{{ old('telegram_chat_id', $settings['chat_id']) }}"
                                placeholder="Ví dụ: -1001234567890"
                            >
                            @error('telegram_chat_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="telegram_quick_message_template">Mẫu Tele form nhanh</label>
                            <textarea
                                class="form-control @error('telegram_quick_message_template') is-invalid @enderror"
                                id="telegram_quick_message_template"
                                name="telegram_quick_message_template"
                                rows="10"
                                placeholder="Nhập nội dung thông báo gửi Telegram cho form trang chủ"
                            >{{ old('telegram_quick_message_template', $settings['quick_message_template']) }}</textarea>
                            @error('telegram_quick_message_template')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">
                                Dùng cho form Thuê xe nhanh ở trang chủ. Form này hợp nhất với: {ma_don}, {nguon_form}, {so_dien_thoai}, {loai_thue}, {ngay_thue}, {khung_gio}. Nội dung dòng trong {...} sẽ tự động hiện đậm trên Telegram.
                            </small>
                        </div>

                        <div class="form-group">
                            <label for="telegram_car_detail_message_template">Mẫu Tele form chi tiết xe</label>
                            <textarea
                                class="form-control @error('telegram_car_detail_message_template') is-invalid @enderror"
                                id="telegram_car_detail_message_template"
                                name="telegram_car_detail_message_template"
                                rows="10"
                                placeholder="Nhập nội dung thông báo gửi Telegram cho form chi tiết xe"
                            >{{ old('telegram_car_detail_message_template', $settings['car_detail_message_template']) }}</textarea>
                            @error('telegram_car_detail_message_template')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">
                                Dùng cho form đặt xe trong trang chi tiết từng xe. Form này có đủ thông tin hơn như {ten_xe}, {tong_tien}, {ke_hoach_chuyen_di}, {hinh_thuc_nhan_xe}, {so_ngay}, {ghi_chu}. Nội dung dòng trong {...} sẽ tự động hiện đậm trên Telegram.
                            </small>
                        </div>
                    </div>
                    <div class="card-footer d-flex justify-content-between align-items-center flex-wrap">
                        <p class="text-muted mb-2 mb-md-0">
                            Trang này chỉ dùng để cấu hình bot Telegram và nội dung thông báo.
                        </p>
                        <button type="submit" class="btn btn-primary">
                            Lưu cấu hình
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card card-outline card-info">
                <div class="card-header">
                    <h3 class="card-title mb-0">Cách lấy thông tin</h3>
                </div>
                <div class="card-body">
                    <ol class="pl-3 mb-0">
                        <li>Tạo bot bằng BotFather và lấy bot token.</li>
                        <li>Thêm bot vào nhóm Telegram cần nhận thông báo.</li>
                        <li>Lấy chat ID của nhóm, thường có dạng -100...</li>
                        <li>Có 2 mẫu riêng: form nhanh và form chi tiết xe. Hệ thống sẽ tự chọn đúng mẫu khi gửi.</li>
                    </ol>
                </div>
            </div>

            <div class="card card-outline card-secondary">
                <div class="card-header">
                    <h3 class="card-title mb-0">Biến động form nhanh</h3>
                </div>
                <div class="card-body">
                    <div class="mb-2"><code>{ma_don}</code> mã đơn booking</div>
                    <div class="mb-2"><code>{nguon_form}</code> nguồn gửi form</div>
                    <div class="mb-2"><code>{so_dien_thoai}</code> số điện thoại</div>
                    <div class="mb-2"><code>{loai_thue}</code> loại thuê</div>
                    <div class="mb-2"><code>{ngay_thue}</code> ngày hoặc khoảng ngày thuê</div>
                    <div class="mb-0"><code>{khung_gio}</code> khung giờ / ca thuê</div>
                </div>
            </div>

            <div class="card card-outline card-secondary">
                <div class="card-header">
                    <h3 class="card-title mb-0">Biến động form chi tiết xe</h3>
                </div>
                <div class="card-body">
                    <div class="mb-2"><code>{ma_don}</code> mã đơn booking</div>
                    <div class="mb-2"><code>{nguon_form}</code> nguồn gửi form</div>
                    <div class="mb-2"><code>{ten_khach}</code> tên khách</div>
                    <div class="mb-2"><code>{so_dien_thoai}</code> số điện thoại</div>
                    <div class="mb-2"><code>{ten_xe}</code> tên xe</div>
                    <div class="mb-2"><code>{loai_thue}</code> loại thuê</div>
                    <div class="mb-2"><code>{ngay_thue}</code> ngày hoặc khoảng ngày thuê</div>
                    <div class="mb-2"><code>{khung_gio}</code> khung giờ / ca thuê</div>
                    <div class="mb-2"><code>{ke_hoach_chuyen_di}</code> trong tỉnh hoặc ngoài tỉnh</div>
                    <div class="mb-2"><code>{hinh_thuc_nhan_xe}</code> tại shop hoặc giao tận nơi</div>
                    <div class="mb-2"><code>{so_ngay}</code> tổng số ngày</div>
                    <div class="mb-2"><code>{tong_tien}</code> tổng tiền booking</div>
                    <div class="mb-0"><code>{ghi_chu}</code> ghi chú booking</div>
                </div>
            </div>
        </div>
    </div>
@stop
