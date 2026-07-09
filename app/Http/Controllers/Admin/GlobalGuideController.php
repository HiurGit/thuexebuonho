<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GlobalGuide;
use Illuminate\Http\Request;

class GlobalGuideController extends Controller
{
    public function index()
    {
        $guides = GlobalGuide::orderBy('type')->orderBy('sort_order')->get();
        return view('admin.global-guides.index', compact('guides'));
    }

    public function create()
    {
        return view('admin.global-guides.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|in:usage,accident,insurance,pickup',
            'section_title' => 'required|string|max:255',
            'content' => 'required|string',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        GlobalGuide::create($request->all());

        return redirect()->route('admin.global-guides.index')->with('success', 'Đã thêm hướng dẫn.');
    }

    public function edit(GlobalGuide $globalGuide)
    {
        return view('admin.global-guides.edit', compact('globalGuide'));
    }

    public function update(Request $request, GlobalGuide $globalGuide)
    {
        $request->validate([
            'type' => 'required|in:usage,accident,insurance,pickup',
            'section_title' => 'required|string|max:255',
            'content' => 'required|string',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        $globalGuide->update($request->all());

        return redirect()->route('admin.global-guides.index')->with('success', 'Đã cập nhật hướng dẫn.');
    }

    public function destroy(GlobalGuide $globalGuide)
    {
        $globalGuide->delete();
        return redirect()->route('admin.global-guides.index')->with('success', 'Đã xoá hướng dẫn.');
    }
}
