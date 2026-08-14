<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Report;
use App\Models\ReportImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $query = Report::with('customer')->orderBy('created_at', 'desc');

        if ($status = $request->get('status')) {
            $query->where('status', $status);
        }

        if ($q = trim($request->get('q'))) {
            $query->where(function ($q2) use ($q) {
                $q2->where('content', 'like', "%{$q}%")
                    ->orWhere('reporter_name', 'like', "%{$q}%")
                    ->orWhereHas('customer', function ($c) use ($q) {
                        $c->where('name', 'like', "%{$q}%")
                            ->orWhere('phone', 'like', "%{$q}%")
                            ->orWhere('cccd', 'like', "%{$q}%");
                    });
            });
        }

        $reports = $query->paginate(20)->withQueryString();

        return view('admin.reports.index', compact('reports'));
    }

    public function edit(Report $report)
    {
        $report->load(['customer', 'images']);

        return view('admin.reports.edit', compact('report'));
    }

    public function update(Request $request, Report $report)
    {
        $validated = $request->validate([
            'reporter_name' => 'nullable|string|max:255',
            'reporter_phone' => 'nullable|string|max:20',
            'category' => 'nullable|string|max:255',
            'content' => 'required|string|max:5000',
            'views' => 'nullable|integer|min:0',
            'status' => 'required|string|in:pending,approved,rejected',
        ]);

        $validated['views'] = (int) ($validated['views'] ?? 0);

        $report->update($validated);

        return redirect()->route('admin.reports.index')->with('success', 'Đã cập nhật báo cáo.');
    }

    public function destroy(Report $report)
    {
        foreach ($report->images as $image) {
            if ($image->path && Storage::disk('public')->exists(str_replace('storage/', '', $image->path))) {
                Storage::disk('public')->delete(str_replace('storage/', '', $image->path));
            }
        }
        $report->images()->delete();
        $report->delete();

        if (request()->ajax() || request()->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Đã xóa báo cáo.']);
        }

        return redirect()->route('admin.reports.index')->with('success', 'Đã xóa báo cáo.');
    }

    public function destroyImage(ReportImage $image)
    {
        if ($image->path && Storage::disk('public')->exists(str_replace('storage/', '', $image->path))) {
            Storage::disk('public')->delete(str_replace('storage/', '', $image->path));
        }
        $image->delete();

        return response()->json(['success' => true]);
    }

    public function updateStatus(Request $request, Report $report)
    {
        $request->validate(['status' => 'required|in:pending,approved,rejected']);

        $report->update(['status' => $request->input('status')]);

        return response()->json(['success' => true, 'message' => 'Đã cập nhật trạng thái báo cáo.']);
    }
}
