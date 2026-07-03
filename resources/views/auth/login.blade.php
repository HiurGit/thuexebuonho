<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Đăng nhập Admin - Thuê Xe Buôn Hồ</title>
    <link rel="icon" href="{{ asset('assets/image/logo.png') }}">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-[linear-gradient(180deg,#f6fbf8_0%,#eef5f0_100%)] text-slate-900">
    <div class="mx-auto flex min-h-screen max-w-6xl items-center justify-center px-4 py-10">
        <div class="grid w-full max-w-5xl overflow-hidden rounded-[28px] bg-white shadow-[0_30px_80px_rgba(18,38,27,0.12)] lg:grid-cols-[1.05fr_0.95fr]">
            <div class="hidden bg-[radial-gradient(circle_at_top_left,#7ee0a2,transparent_38%),linear-gradient(135deg,#0f5132_0%,#1f7a4c_100%)] p-10 text-white lg:block">
                <div class="flex items-center gap-4">
                    <div class="flex h-16 w-16 items-center justify-center rounded-2xl bg-white/15 backdrop-blur">
                        <img src="{{ asset('assets/image/logo.png') }}" alt="Logo" class="h-12 w-12 object-contain">
                    </div>
                    <div>
                        <p class="text-sm font-bold uppercase tracking-[0.24em] text-white/70">Admin Panel</p>
                        <h1 class="text-3xl font-black">Thuê Xe Buôn Hồ</h1>
                    </div>
                </div>

                <div class="mt-16 max-w-md">
                    <p class="text-sm font-semibold uppercase tracking-[0.22em] text-white/60">Khu vực quản trị</p>
                    <h2 class="mt-3 text-4xl font-black leading-tight">Chỉ tài khoản admin mới có thể đăng nhập.</h2>
                    <p class="mt-5 text-base leading-7 text-white/80">
                        Quản lý xe, đơn đặt xe, ảnh đã giao và toàn bộ nội dung vận hành trong một nơi duy nhất.
                    </p>
                </div>
            </div>

            <div class="p-6 sm:p-10">
                <div class="mx-auto w-full max-w-md">
                    <div class="lg:hidden">
                        <div class="flex items-center gap-3">
                            <img src="{{ asset('assets/image/logo.png') }}" alt="Logo" class="h-12 w-12 rounded-2xl bg-[#eef8f1] p-2 object-contain">
                            <div>
                                <p class="text-xs font-bold uppercase tracking-[0.22em] text-slate-400">Admin Panel</p>
                                <h1 class="text-2xl font-black text-slate-900">Thuê Xe Buôn Hồ</h1>
                            </div>
                        </div>
                    </div>

                    <div class="mt-6 lg:mt-2">
                        <p class="text-sm font-bold uppercase tracking-[0.2em] text-emerald-600">Đăng nhập</p>
                        <h2 class="mt-2 text-3xl font-black text-slate-900">Chào mừng bạn quay lại</h2>
                        <p class="mt-2 text-sm text-slate-500">Nhập tài khoản admin để vào khu vực quản trị.</p>
                    </div>

                    @if ($errors->any())
                        <div class="mt-6 rounded-2xl border border-red-200 bg-red-50 px-4 py-3 text-sm font-semibold text-red-700">
                            {{ $errors->first() }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login.attempt') }}" class="mt-6 space-y-4">
                        @csrf
                        <div>
                            <label for="email" class="mb-2 block text-sm font-bold text-slate-700">Email</label>
                            <input
                                id="email"
                                type="email"
                                name="email"
                                value="{{ old('email') }}"
                                required
                                autofocus
                                class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm font-semibold text-slate-900 outline-none transition focus:border-emerald-500 focus:bg-white focus:ring-4 focus:ring-emerald-100"
                                placeholder="admin@thuexebuonho.com"
                            >
                        </div>

                        <div>
                            <label for="password" class="mb-2 block text-sm font-bold text-slate-700">Mật khẩu</label>
                            <input
                                id="password"
                                type="password"
                                name="password"
                                required
                                class="w-full rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm font-semibold text-slate-900 outline-none transition focus:border-emerald-500 focus:bg-white focus:ring-4 focus:ring-emerald-100"
                                placeholder="Nhập mật khẩu"
                            >
                        </div>

                        <label class="flex items-center gap-3 text-sm font-semibold text-slate-600">
                            <input type="checkbox" name="remember" value="1" class="h-4 w-4 rounded border-slate-300 text-emerald-600 focus:ring-emerald-500">
                            Ghi nhớ đăng nhập
                        </label>

                        <button type="submit" class="w-full rounded-2xl bg-emerald-600 px-4 py-3 text-sm font-extrabold uppercase tracking-[0.16em] text-white transition hover:bg-emerald-700">
                            Đăng nhập admin
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
