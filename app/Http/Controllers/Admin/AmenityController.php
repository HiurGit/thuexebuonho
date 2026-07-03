<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Amenity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AmenityController extends Controller
{
    public function index()
    {
        $amenities = Amenity::orderBy('sort_order')->paginate(20);
        return view('admin.amenities.index', compact('amenities'));
    }

    public function create()
    {
        return view('admin.amenities.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:amenities',
            'icon' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'sort_order' => 'nullable|integer',
        ]);

        $data = $validated;
        unset($data['icon']);

        if ($request->hasFile('icon')) {
            $path = $request->file('icon')->store('amenities', 'public');
            $data['icon'] = 'storage/' . $path;
        }

        Amenity::create($data);

        return redirect()->route('admin.amenities.index')->with('success', 'Đã thêm tiện ích.');
    }

    public function edit(Amenity $amenity)
    {
        return view('admin.amenities.edit', compact('amenity'));
    }

    public function update(Request $request, Amenity $amenity)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:amenities,name,' . $amenity->id,
            'icon' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'sort_order' => 'nullable|integer',
        ]);

        $data = $validated;
        unset($data['icon']);

        if ($request->hasFile('icon')) {
            if ($amenity->icon && Storage::disk('public')->exists(str_replace('storage/', '', $amenity->icon))) {
                Storage::disk('public')->delete(str_replace('storage/', '', $amenity->icon));
            }
            $path = $request->file('icon')->store('amenities', 'public');
            $data['icon'] = 'storage/' . $path;
        }

        $amenity->update($data);

        return redirect()->route('admin.amenities.index')->with('success', 'Đã cập nhật tiện ích.');
    }

    public function destroy(Amenity $amenity)
    {
        if ($amenity->icon && Storage::disk('public')->exists(str_replace('storage/', '', $amenity->icon))) {
            Storage::disk('public')->delete(str_replace('storage/', '', $amenity->icon));
        }
        $amenity->delete();

        if (request()->ajax() || request()->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Đã xóa tiện ích ' . $amenity->name]);
        }

        return redirect()->route('admin.amenities.index')->with('success', 'Đã xóa tiện ích.');
    }
}
