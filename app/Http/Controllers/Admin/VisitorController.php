<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CarView;
use App\Models\Visitor;
use Illuminate\Support\Facades\Schema;

class VisitorController extends Controller
{
    public function index()
    {
        if (! Schema::hasTable('visitors')) {
            return view('admin.visitors.index', [
                'total' => 0,
                'todayNew' => 0,
                'activeToday' => 0,
                'last7Days' => 0,
                'last30Days' => 0,
                'recentVisitors' => collect(),
                'topCarViews' => collect(),
            ]);
        }

        $today = now()->startOfDay();
        $last7Days = now()->subDays(6)->startOfDay();
        $last30Days = now()->subDays(29)->startOfDay();

        $total = Visitor::count();
        $todayNew = Visitor::where('first_visited_at', '>=', $today)->count();
        $activeToday = Visitor::where('last_visited_at', '>=', $today)->count();
        $last7Days = Visitor::where('first_visited_at', '>=', $last7Days)->count();
        $last30Days = Visitor::where('first_visited_at', '>=', $last30Days)->count();

        $recentVisitors = Visitor::query()
            ->latest('last_visited_at')
            ->limit(50)
            ->get();

        $topCarViews = CarView::query()
            ->selectRaw('car_id, COUNT(DISTINCT visitor_id) as unique_viewers, SUM(visit_count) as total_views')
            ->with('car:id,name,slug')
            ->groupBy('car_id')
            ->orderByDesc('total_views')
            ->limit(10)
            ->get();

        return view('admin.visitors.index', compact(
            'total',
            'todayNew',
            'activeToday',
            'last7Days',
            'last30Days',
            'recentVisitors',
            'topCarViews',
        ));
    }
}
