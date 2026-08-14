<?php

use App\Models\Car;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AdminAuthController;

Route::middleware('guest')->group(function () {
    Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AdminAuthController::class, 'login'])->name('login.attempt');
});

Route::post('/logout', [AdminAuthController::class, 'logout'])->middleware('auth')->name('logout');

Route::get('/', function () {
    $cars = \App\Models\Car::with(['mainImage', 'images'])->orderBy('sort_order')->get();
    $defaultCar = \App\Models\Car::orderBy('sort_order')->first();
    $heroBanner = \App\Models\Banner::active()->position('hero')->orderBy('sort_order')->first();
    $priceBanners = \App\Models\Banner::active()->position('banner-price')->orderBy('sort_order')->get();
    return view('index', compact('cars', 'defaultCar', 'heroBanner', 'priceBanners'));
})->name('index');

Route::get('/xe/{slug}', function (string $slug) {
    $car = \App\Models\Car::with(['mainImage', 'images', 'amenities', 'guides'])->where('slug', $slug)->firstOrFail();
    return view('car-detail', compact('car'));
})->name('car-detail');

Route::get('/danh-sach-xe', function () {
    $cars = \App\Models\Car::with(['mainImage', 'images'])->orderBy('sort_order')->get();
    return view('danh-sach-xe', compact('cars'));
})->name('cars.index');

Route::get('/dich-vu', function () {
    return view('services');
})->name('services');

Route::get('/huongdan', function () {
    $guides = \App\Models\GlobalGuide::orderBy('sort_order')->get()->groupBy('type');
    $cars = \App\Models\Car::has('guides')->with(['mainImage', 'guides'])->orderBy('sort_order')->get();
    return view('huongdan', compact('guides', 'cars'));
})->name('huongdan');

Route::get('/da-giao', function () {
    $deliveredProofs = \App\Models\DeliveredProof::latest()->limit(20)->get();
    return view('da-giao', compact('deliveredProofs'));
})->name('da-giao');

Route::get('/dieu-khoan', function () {
    return view('terms');
})->name('terms');

Route::get('/chinh-sach-bao-mat', function () {
    return view('privacy');
})->name('privacy');

Route::get('/lien-he', function () {
    return view('lien-he');
})->name('lien-he');

Route::get('/check-khach-thue', [App\Http\Controllers\CheckKhachThueController::class, 'index'])->name('check-khach-thue');

Route::get('/check-khach-thue/gui-bao-cao', [App\Http\Controllers\CheckKhachThueController::class, 'report'])->name('check-khach-thue.report');
Route::post('/check-khach-thue/ocr-gemini', [App\Http\Controllers\CheckKhachThueController::class, 'ocrGemini'])->middleware('throttle:60,1')->name('check-khach-thue.ocr-gemini');
Route::post('/check-khach-thue/gui-bao-cao', [App\Http\Controllers\CheckKhachThueController::class, 'storeReport'])->middleware('throttle:10,1')->middleware('throttle:60,60')->name('check-khach-thue.report.store');
Route::get('/check-khach-thue/chi-tiet/{customer}', [App\Http\Controllers\CheckKhachThueController::class, 'showCustomer'])->name('check-khach-thue.detail');

Route::get('/sitemap.xml', function () {
    $assetUrl = fn (string $path) => asset($path);
    $now = now()->toAtomString();

    $staticPages = collect([
        [
            'url' => route('index'),
            'lastmod' => $now,
            'images' => [
                ['loc' => $assetUrl('assets/image/banner-main.png'), 'title' => 'Thuê xe tự lái Buôn Hồ - Cho thuê xe tự lái'],
                ['loc' => $assetUrl('assets/image/bannerMXH.jpg'), 'title' => 'Thuê Xe Buôn Hồ - Dịch vụ cho thuê xe'],
            ],
        ],
        [
            'url' => route('services'),
            'lastmod' => $now,
            'images' => [
                ['loc' => $assetUrl('assets/image/banner-thuexe.png'), 'title' => 'Dịch vụ thuê xe tại Buôn Hồ'],
            ],
        ],
        ['url' => route('huongdan'), 'lastmod' => $now, 'images' => []],
        ['url' => route('cars.index'), 'lastmod' => $now, 'images' => []],
        ['url' => route('da-giao'), 'lastmod' => $now, 'images' => []],
        ['url' => route('terms'), 'lastmod' => $now, 'images' => []],
        ['url' => route('privacy'), 'lastmod' => $now, 'images' => []],
        ['url' => route('lien-he'), 'lastmod' => $now, 'images' => []],
    ]);

    $carPages = Car::with(['mainImage', 'images'])
        ->orderBy('sort_order')
        ->get()
        ->map(fn (Car $car) => [
            'url' => route('car-detail', $car->slug),
            'lastmod' => optional($car->updated_at)->toAtomString() ?? $now,
            'images' => collect()
                ->push([
                    'loc' => $assetUrl($car->seo_image_path),
                    'title' => $car->name . ' - Thuê Xe Buôn Hồ',
                ])
                ->merge($car->images->map(fn ($img) => [
                    'loc' => $assetUrl($img->path),
                    'title' => $car->name,
                ]))
                ->toArray(),
        ]);

    $pages = $staticPages->concat($carPages);

    $xml = '<?xml version="1.0" encoding="UTF-8"?>';
    $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:image="http://www.google.com/schemas/sitemap-image/1.1">';

    foreach ($pages as $page) {
        $xml .= '<url>';
        $xml .= '<loc>' . e($page['url']) . '</loc>';
        $xml .= '<lastmod>' . e($page['lastmod']) . '</lastmod>';

        foreach ($page['images'] as $image) {
            $xml .= '<image:image>';
            $xml .= '<image:loc>' . e($image['loc']) . '</image:loc>';
            $xml .= '<image:title>' . e($image['title']) . '</image:title>';
            $xml .= '</image:image>';
        }

        $xml .= '</url>';
    }

    $xml .= '</urlset>';

    return response()
        ->make($xml)
        ->header('Content-Type', 'application/xml');
})->name('sitemap');

// ===== BOOKING =====
Route::post('/booking/submit', [App\Http\Controllers\BookingController::class, 'submit'])->name('booking.submit');

// ===== ADMIN ROUTES =====
Route::prefix('admin')->middleware('admin')->name('admin.')->group(function () {
    Route::get('/', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
    Route::get('/visitors', [App\Http\Controllers\Admin\VisitorController::class, 'index'])->name('visitors.index');
    Route::resource('cars', App\Http\Controllers\Admin\CarsController::class)->except(['show'])->parameters(['cars' => 'car']);
    Route::post('/cars/{car}/status', [App\Http\Controllers\Admin\CarsController::class, 'updateStatus'])->name('cars.status');
    Route::delete('/cars/image/{image}', [App\Http\Controllers\Admin\CarsController::class, 'destroyImage'])->name('cars.image.destroy');
    Route::resource('amenities', App\Http\Controllers\Admin\AmenityController::class)->except(['show'])->parameters(['amenities' => 'amenity']);
    Route::resource('bookings', App\Http\Controllers\Admin\BookingController::class)->except(['show'])->parameters(['bookings' => 'booking']);
    Route::get('/bookings-calendar', [App\Http\Controllers\Admin\BookingController::class, 'calendar'])->name('bookings.calendar');
    Route::post('/bookings/{booking}/status', [App\Http\Controllers\Admin\BookingController::class, 'updateStatus'])->name('bookings.status');
    Route::resource('global-guides', App\Http\Controllers\Admin\GlobalGuideController::class)->except(['show'])->parameters(['globalGuide' => 'globalGuide']);
    Route::resource('delivered-proofs', App\Http\Controllers\Admin\DeliveredProofController::class)->except(['show'])->parameters(['delivered-proofs' => 'deliveredProof']);
    Route::resource('collaborators', App\Http\Controllers\Admin\CollaboratorController::class)->except(['show'])->parameters(['collaborators' => 'collaborator']);
    Route::resource('banners', App\Http\Controllers\Admin\BannerController::class)->except(['show'])->parameters(['banners' => 'banner']);
    Route::resource('check-khach-thue', App\Http\Controllers\Admin\CheckKhachThueController::class)->except(['show'])->parameters(['check-khach-thue' => 'customer']);
    Route::post('/check-khach-thue/{customer}/status', [App\Http\Controllers\Admin\CheckKhachThueController::class, 'updateStatus'])->name('check-khach-thue.status');
    Route::resource('reports', App\Http\Controllers\Admin\ReportController::class)->only(['index', 'edit', 'update', 'destroy'])->parameters(['reports' => 'report']);
    Route::post('/reports/{report}/status', [App\Http\Controllers\Admin\ReportController::class, 'updateStatus'])->name('reports.status');
    Route::delete('/reports/image/{image}', [App\Http\Controllers\Admin\ReportController::class, 'destroyImage'])->name('reports.image.destroy');
    Route::get('/web-info', [App\Http\Controllers\Admin\DashboardController::class, 'webInfo'])->name('web-info');
    Route::post('/web-info', [App\Http\Controllers\Admin\DashboardController::class, 'updateWebInfo'])->name('web-info.update');
    Route::get('/settings', [App\Http\Controllers\Admin\DashboardController::class, 'settings'])->name('settings');
    Route::post('/settings', [App\Http\Controllers\Admin\DashboardController::class, 'updateSettings'])->name('settings.update');
    Route::get('/users', [App\Http\Controllers\Admin\DashboardController::class, 'users'])->name('users');
});

// ===== FALLBACK: đường dẫn không tồn tại => về trang chủ =====
Route::fallback(function () {
    return redirect()->route('index');
});
