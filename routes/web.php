<?php

use App\Http\Controllers\Admin\AmenityController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\CarsController;
use App\Http\Controllers\Admin\CollaboratorController;
use App\Http\Controllers\Admin\ContractController;
use App\Http\Controllers\Admin\ContractDocumentController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DeliveredProofController;
use App\Http\Controllers\Admin\GlobalGuideController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\VisitorController;
use App\Http\Controllers\Auth\AdminAuthController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\CheckKhachThueController;
use App\Http\Controllers\ContractLookupController;
use App\Models\Banner;
use App\Models\Car;
use App\Models\DeliveredProof;
use App\Models\GlobalGuide;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AdminAuthController::class, 'login'])->name('login.attempt');
});

Route::post('/logout', [AdminAuthController::class, 'logout'])->middleware('auth')->name('logout');

Route::get('/', function () {
    $cars = Car::with(['mainImage', 'images'])->orderBy('sort_order')->get();
    $defaultCar = Car::orderBy('sort_order')->first();
    $heroBanner = Banner::active()->position('hero')->orderBy('sort_order')->first();
    $priceBanners = Banner::active()->position('banner-price')->orderBy('sort_order')->get();

    return view('index', compact('cars', 'defaultCar', 'heroBanner', 'priceBanners'));
})->name('index');

Route::get('/xe/{slug}', function (string $slug) {
    $car = Car::with(['mainImage', 'images', 'amenities', 'guides'])->where('slug', $slug)->firstOrFail();

    return view('car-detail', compact('car'));
})->name('car-detail');

Route::get('/danh-sach-xe', function () {
    $cars = Car::with(['mainImage', 'images'])->orderBy('sort_order')->get();

    return view('danh-sach-xe', compact('cars'));
})->name('cars.index');

Route::get('/dich-vu', function () {
    return view('services');
})->name('services');

Route::get('/huongdan', function () {
    $guides = GlobalGuide::orderBy('sort_order')->get()->groupBy('type');
    $cars = Car::has('guides')->with(['mainImage', 'guides'])->orderBy('sort_order')->get();

    return view('huongdan', compact('guides', 'cars'));
})->name('huongdan');

Route::get('/checklist-giao-xe', function () {
    return view('checklist-giao-xe');
})->name('checklist.giaoxe');

Route::get('/da-giao', function () {
    $deliveredProofs = DeliveredProof::latest()->limit(20)->get();

    return view('da-giao', compact('deliveredProofs'));
})->name('da-giao');

Route::get('/dieu-khoan', function () {
    return view('terms');
})->name('terms');

Route::get('/lai-xe-an-toan', function () {
    return view('lai-xe-an-toan');
})->name('lai-xe-an-toan');

Route::get('/chinh-sach-bao-mat', function () {
    return view('privacy');
})->name('privacy');

Route::get('/lien-he', function () {
    return view('lien-he');
})->name('lien-he');

Route::get('/tra-cuu', [ContractLookupController::class, 'index'])->name('contract.lookup');
Route::post('/tra-cuu', [ContractLookupController::class, 'lookup'])->middleware('throttle:10,1')->name('contract.lookup.check');
Route::get('/tra-cuu/{contract:contract_code}', [ContractLookupController::class, 'shared'])->name('contract.lookup.shared');
Route::get('/tra-cuu/{contract:contract_code}/hop-dong', [ContractLookupController::class, 'html'])->middleware('throttle:10,1')->name('contract.lookup.html');

Route::get('/check', [CheckKhachThueController::class, 'index'])->name('check');

Route::get('/check/gui-bao-cao', [CheckKhachThueController::class, 'report'])->name('check.report');
Route::post('/check/ocr-gemini', [CheckKhachThueController::class, 'ocrGemini'])->middleware('throttle:60,1')->name('check.ocr-gemini');

Route::post('/check/ocr-openai', [CheckKhachThueController::class, 'ocrOpenAI'])->middleware('throttle:60,1')->name('check.ocr-openai');
Route::post('/check/gui-bao-cao', [CheckKhachThueController::class, 'storeReport'])->middleware('throttle:10,1')->middleware('throttle:60,60')->name('check.report.store');
Route::get('/check/chi-tiet/{customer}', [CheckKhachThueController::class, 'showCustomer'])->name('check.detail');

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
        ['url' => route('checklist.giaoxe'), 'lastmod' => $now, 'images' => []],
        ['url' => route('cars.index'), 'lastmod' => $now, 'images' => []],
        ['url' => route('da-giao'), 'lastmod' => $now, 'images' => []],
        ['url' => route('terms'), 'lastmod' => $now, 'images' => []],
        ['url' => route('lai-xe-an-toan'), 'lastmod' => $now, 'images' => []],
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
                    'title' => $car->name.' - Thuê Xe Buôn Hồ',
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
        $xml .= '<loc>'.e($page['url']).'</loc>';
        $xml .= '<lastmod>'.e($page['lastmod']).'</lastmod>';

        foreach ($page['images'] as $image) {
            $xml .= '<image:image>';
            $xml .= '<image:loc>'.e($image['loc']).'</image:loc>';
            $xml .= '<image:title>'.e($image['title']).'</image:title>';
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
Route::post('/booking/submit', [BookingController::class, 'submit'])->name('booking.submit');

// ===== ADMIN ROUTES =====
Route::prefix('admin')->middleware('admin')->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/visitors', [VisitorController::class, 'index'])->name('visitors.index');
    Route::resource('cars', CarsController::class)->except(['show'])->parameters(['cars' => 'car']);
    Route::post('/cars/{car}/status', [CarsController::class, 'updateStatus'])->name('cars.status');
    Route::delete('/cars/image/{image}', [CarsController::class, 'destroyImage'])->name('cars.image.destroy');
    Route::resource('amenities', AmenityController::class)->except(['show'])->parameters(['amenities' => 'amenity']);
    Route::resource('bookings', App\Http\Controllers\Admin\BookingController::class)->except(['show'])->parameters(['bookings' => 'booking']);
    Route::get('/bookings-calendar', [App\Http\Controllers\Admin\BookingController::class, 'calendar'])->name('bookings.calendar');
    Route::resource('contracts', ContractController::class)->parameters(['contracts' => 'contract']);
    Route::get('/contracts/{contract}/hop-dong', [ContractDocumentController::class, 'html'])->name('contracts.html');
    Route::delete('/contracts/image/{image}', [ContractController::class, 'destroyImage'])->name('contracts.image.destroy');
    Route::post('/bookings/{booking}/status', [App\Http\Controllers\Admin\BookingController::class, 'updateStatus'])->name('bookings.status');
    Route::resource('global-guides', GlobalGuideController::class)->except(['show'])->parameters(['globalGuide' => 'globalGuide']);
    Route::resource('delivered-proofs', DeliveredProofController::class)->except(['show'])->parameters(['delivered-proofs' => 'deliveredProof']);
    Route::resource('collaborators', CollaboratorController::class)->except(['show'])->parameters(['collaborators' => 'collaborator']);
    Route::resource('banners', BannerController::class)->except(['show'])->parameters(['banners' => 'banner']);
    Route::resource('check-khach-thue', App\Http\Controllers\Admin\CheckKhachThueController::class)->except(['show'])->parameters(['check-khach-thue' => 'customer']);
    Route::post('/check-khach-thue/{customer}/status', [App\Http\Controllers\Admin\CheckKhachThueController::class, 'updateStatus'])->name('check-khach-thue.status');
    Route::resource('reports', ReportController::class)->only(['index', 'edit', 'update', 'destroy'])->parameters(['reports' => 'report']);
    Route::post('/reports/{report}/status', [ReportController::class, 'updateStatus'])->name('reports.status');
    Route::delete('/reports/image/{image}', [ReportController::class, 'destroyImage'])->name('reports.image.destroy');
    Route::get('/web-info', [DashboardController::class, 'webInfo'])->name('web-info');
    Route::post('/web-info', [DashboardController::class, 'updateWebInfo'])->name('web-info.update');
    Route::get('/settings', [DashboardController::class, 'settings'])->name('settings');
    Route::post('/settings', [DashboardController::class, 'updateSettings'])->name('settings.update');
    Route::get('/users', [DashboardController::class, 'users'])->name('users');
});

// ===== FALLBACK: đường dẫn không tồn tại => về trang chủ =====
Route::fallback(function () {
    return redirect()->route('index');
});
