<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BannerController extends Controller
{
    public function index()
    {
        $banners = Banner::orderBy('position')->orderBy('sort_order')->paginate(20);
        return view('admin.banners.index', compact('banners'));
    }

    public function create()
    {
        return view('admin.banners.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'position' => 'required|string|in:hero,banner-price',
            'sort_order' => 'nullable|integer',
            'is_active' => 'nullable',
        ]);

        $data = $validated;
        unset($data['image']);
        $data['is_active'] = $request->boolean('is_active');

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('banners', 'public');
            $data['image'] = 'storage/' . $path;
        }

        Banner::create($data);

        return redirect()->route('admin.banners.index')->with('success', 'Đã thêm banner.');
    }

    public function edit(Banner $banner)
    {
        return view('admin.banners.edit', compact('banner'));
    }

    public function update(Request $request, Banner $banner)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'position' => 'required|string|in:hero,banner-price',
            'sort_order' => 'nullable|integer',
            'is_active' => 'nullable',
        ]);

        $data = $validated;
        unset($data['image']);
        $data['is_active'] = $request->boolean('is_active');

        if ($request->hasFile('image')) {
            if ($banner->image && Storage::disk('public')->exists(str_replace('storage/', '', $banner->image))) {
                Storage::disk('public')->delete(str_replace('storage/', '', $banner->image));
            }
            $path = $request->file('image')->store('banners', 'public');
            $data['image'] = 'storage/' . $path;
        }

        $banner->update($data);

        return redirect()->route('admin.banners.index')->with('success', 'Đã cập nhật banner.');
    }

    public function destroy(Banner $banner)
    {
        if ($banner->image && Storage::disk('public')->exists(str_replace('storage/', '', $banner->image))) {
            Storage::disk('public')->delete(str_replace('storage/', '', $banner->image));
        }
        $banner->delete();

        if (request()->ajax() || request()->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Đã xóa banner ' . $banner->title]);
        }

        return redirect()->route('admin.banners.index')->with('success', 'Đã xóa banner.');
    }
}
