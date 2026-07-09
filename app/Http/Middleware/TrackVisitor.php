<?php

namespace App\Http\Middleware;

use App\Models\Car;
use App\Models\CarView;
use App\Models\Visitor;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Symfony\Component\HttpFoundation\Response;

class TrackVisitor
{
    public function handle(Request $request, Closure $next): Response
    {
        return $next($request);
    }

    public function terminate(Request $request, Response $response): void
    {
        if (! $this->shouldTrack($request, $response)) {
            return;
        }

        if (! Schema::hasTable('visitors')) {
            return;
        }

        try {
            $ip = $request->ip();
            $now = now();
            $device = $this->detectDeviceInfo($request);

            $visitor = Visitor::where('ip_address', $ip)->first();

            if ($visitor) {
                $visitor->increment('visit_count');
                $visitor->update([
                    'last_visited_at' => $now,
                    'user_agent' => $device['user_agent'],
                    'browser' => $device['browser'],
                    'platform' => $device['platform'],
                    'device_type' => $device['device_type'],
                ]);
            } else {
                $visitor = Visitor::create([
                    'ip_address' => $ip,
                    'user_agent' => $device['user_agent'],
                    'browser' => $device['browser'],
                    'platform' => $device['platform'],
                    'device_type' => $device['device_type'],
                    'first_visited_at' => $now,
                    'last_visited_at' => $now,
                    'visit_count' => 1,
                ]);
            }

            $this->trackCarView($request, $visitor, $now);
        } catch (\Throwable $exception) {
            //
        }
    }

    private function trackCarView(Request $request, Visitor $visitor, $now): void
    {
        if ($request->route()?->getName() !== 'car-detail') {
            return;
        }

        $slug = $request->route()->parameter('slug');
        if (! $slug) {
            return;
        }

        $car = Car::where('slug', $slug)->first(['id']);
        if (! $car) {
            return;
        }

        $carView = CarView::where('visitor_id', $visitor->id)
            ->where('car_id', $car->id)
            ->first();

        if ($carView) {
            $carView->increment('visit_count');
            $carView->update(['last_viewed_at' => $now]);
        } else {
            CarView::create([
                'visitor_id' => $visitor->id,
                'car_id' => $car->id,
                'visit_count' => 1,
                'first_viewed_at' => $now,
                'last_viewed_at' => $now,
            ]);
        }
    }

    private function detectDeviceInfo(Request $request): array
    {
        $ua = $request->userAgent() ?? '';

        $browser = 'Unknown';
        $platform = 'Unknown';
        $deviceType = 'Desktop';

        // Detect browser
        if (preg_match('/Edg\/([\d.]+)/i', $ua)) {
            $browser = 'Edge';
        } elseif (preg_match('/OPR\/([\d.]+)/i', $ua) || preg_match('/Opera/i', $ua)) {
            $browser = 'Opera';
        } elseif (preg_match('/Chrome\/([\d.]+)/i', $ua)) {
            $browser = 'Chrome';
        } elseif (preg_match('/Firefox\/([\d.]+)/i', $ua)) {
            $browser = 'Firefox';
        } elseif (preg_match('/Safari\/([\d.]+)/i', $ua)) {
            $browser = 'Safari';
        } elseif (preg_match('/MSIE\s([\d.]+)/i', $ua) || preg_match('/Trident\/[\d.]+/i', $ua)) {
            $browser = 'IE';
        }

        // Detect platform
        if (preg_match('/Windows NT ([\d.]+)/i', $ua)) {
            $platform = 'Windows';
        } elseif (preg_match('/Mac OS X ([\d_]+)/i', $ua)) {
            $platform = 'macOS';
        } elseif (preg_match('/Android ([\d.]+)/i', $ua)) {
            $platform = 'Android';
        } elseif (preg_match('/iOS ([\d_]+)/i', $ua) || preg_match('/iPhone OS ([\d_]+)/i', $ua)) {
            $platform = 'iOS';
        } elseif (preg_match('/Linux/i', $ua)) {
            $platform = 'Linux';
        } elseif (preg_match('/CrOS/i', $ua)) {
            $platform = 'Chrome OS';
        }

        // Detect device type
        if (preg_match('/bot|crawl|spider|scraper/i', $ua)) {
            $deviceType = 'Bot';
        } elseif (preg_match('/tablet|ipad/i', $ua)) {
            $deviceType = 'Tablet';
        } elseif (preg_match('/mobile|iphone|ipod|android.*mobile|blackberry|windows phone/i', $ua)) {
            $deviceType = 'Mobile';
        }

        return [
            'user_agent' => $ua,
            'browser' => $browser,
            'platform' => $platform,
            'device_type' => $deviceType,
        ];
    }

    private function shouldTrack(Request $request, Response $response): bool
    {
        if ($request->user()?->isAdmin()) {
            return false;
        }

        if (! $request->isMethod('GET')) {
            return false;
        }

        if (! $response->isSuccessful()) {
            return false;
        }

        if ($request->expectsJson() || $request->ajax()) {
            return false;
        }

        if ($request->is('admin') || $request->is('admin/*') || $request->is('login') || $request->is('logout') || $request->is('up')) {
            return false;
        }

        return true;
    }
}
