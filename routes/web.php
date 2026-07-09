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
    $cars = \App\Models\Car::with('mainImage')->orderBy('sort_order')->get();
    $defaultCar = \App\Models\Car::orderBy('sort_order')->first();
    return view('index', compact('cars', 'defaultCar'));
})->name('index');

Route::get('/xe/{slug}', function (string $slug) {
    $car = \App\Models\Car::with(['mainImage', 'images', 'amenities', 'guides'])->where('slug', $slug)->firstOrFail();
    return view('car-detail', compact('car'));
})->name('car-detail');

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

Route::get('/sitemap.xml', function () {
    $staticPages = collect([
        ['url' => route('index'), 'lastmod' => now()->toAtomString()],
        ['url' => route('services'), 'lastmod' => now()->toAtomString()],
        ['url' => route('huongdan'), 'lastmod' => now()->toAtomString()],
        ['url' => route('da-giao'), 'lastmod' => now()->toAtomString()],
        ['url' => route('terms'), 'lastmod' => now()->toAtomString()],
        ['url' => route('privacy'), 'lastmod' => now()->toAtomString()],
    ]);

    $carPages = Car::query()
        ->orderBy('sort_order')
        ->get(['slug', 'updated_at'])
        ->map(fn (Car $car) => [
            'url' => route('car-detail', $car->slug),
            'lastmod' => optional($car->updated_at)->toAtomString() ?? now()->toAtomString(),
        ]);

    $pages = $staticPages->concat($carPages);
    $xml = '<?xml version="1.0" encoding="UTF-8"?>';
    $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

    foreach ($pages as $page) {
        $xml .= '<url>';
        $xml .= '<loc>' . e($page['url']) . '</loc>';
        $xml .= '<lastmod>' . e($page['lastmod']) . '</lastmod>';
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
    Route::get('/web-info', [App\Http\Controllers\Admin\DashboardController::class, 'webInfo'])->name('web-info');
    Route::post('/web-info', [App\Http\Controllers\Admin\DashboardController::class, 'updateWebInfo'])->name('web-info.update');
    Route::get('/settings', [App\Http\Controllers\Admin\DashboardController::class, 'settings'])->name('settings');
    Route::post('/settings', [App\Http\Controllers\Admin\DashboardController::class, 'updateSettings'])->name('settings.update');
    Route::get('/users', [App\Http\Controllers\Admin\DashboardController::class, 'users'])->name('users');
});
