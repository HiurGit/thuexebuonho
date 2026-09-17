<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Car;
use App\Models\CarGuide;
use App\Models\CarImage;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CarsController extends Controller
{
    public function index()
    {
        $cars = Car::with('mainImage')
            ->withCount('views as unique_viewers')
            ->withSum('views as total_views', 'visit_count')
            ->orderBy('sort_order')
            ->paginate(20);
        return view('admin.cars.index', compact('cars'));
    }

    public function create()
    {
        return view('admin.cars.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'seats' => 'required|integer|min:2|max:50',
            'transmission' => 'required|string|max:50',
            'fuel' => 'required|string|max:50',
            'fuel_consumption' => 'nullable|string|max:50',
            'year' => 'nullable|integer',
            'insurance' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
            'price_per_day' => 'required|numeric|min:0',
            'price_per_session' => 'required|numeric|min:0',
            'price_multi_day' => 'nullable|numeric|min:0',
            'price_out_province' => 'nullable|numeric|min:0',
            'deposit_min' => 'nullable|numeric|min:0',
            'deposit_max' => 'nullable|numeric|min:0',
            'deposit_asset' => 'nullable|numeric|min:0',
            'status' => 'required|in:available,rented,maintenance',
            'sort_order' => 'nullable|integer',
            'amenities' => 'nullable|array',
            'amenities.*' => 'exists:amenities,id',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:5120',
        ]);

        $validated['slug'] = Str::slug($validated['name']);

        $car = Car::create($validated);
        $car->amenities()->sync($request->amenities ?? []);

        if ($request->guides) {
            foreach ($request->guides as $i => $g) {
                if (!empty($g['title'])) {
                    $videoPath = null;
                    if (!empty($g['video']) && $g['video'] instanceof UploadedFile) {
                        $videoPath = 'storage/' . $g['video']->store('videos/car-guides', 'public');
                    }
                    $imagePath = null;
                    if (!empty($g['image']) && $g['image'] instanceof UploadedFile) {
                        $imagePath = 'storage/' . $g['image']->store('car-guides-images', 'public');
                    }
                    $car->guides()->create([
                        'title' => $g['title'],
                        'video_path' => $videoPath,
                        'image_path' => $imagePath,
                        'sort_order' => $i,
                    ]);
                }
            }
        }

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $i => $image) {
                $path = $image->store('cars', 'public');
                $car->images()->create([
                    'path' => 'storage/' . $path,
                    'is_main' => $i === 0 && $car->images()->count() === 0,
                    'sort_order' => $i,
                ]);
            }
        }

        return redirect()->route('admin.cars.index')->with('success', 'Đã thêm xe mới.');
    }

    public function edit(Car $car)
    {
        return view('admin.cars.edit', compact('car'));
    }

    public function update(Request $request, Car $car)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'seats' => 'required|integer|min:2|max:50',
            'transmission' => 'required|string|max:50',
            'fuel' => 'required|string|max:50',
            'fuel_consumption' => 'nullable|string|max:50',
            'year' => 'nullable|integer',
            'insurance' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
            'price_per_day' => 'required|numeric|min:0',
            'price_per_session' => 'required|numeric|min:0',
            'price_multi_day' => 'nullable|numeric|min:0',
            'price_out_province' => 'nullable|numeric|min:0',
            'deposit_min' => 'nullable|numeric|min:0',
            'deposit_max' => 'nullable|numeric|min:0',
            'deposit_asset' => 'nullable|numeric|min:0',
            'status' => 'required|in:available,rented,maintenance',
            'sort_order' => 'nullable|integer',
            'amenities' => 'nullable|array',
            'amenities.*' => 'exists:amenities,id',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'delete_images' => 'nullable|array',
            'delete_images.*' => 'integer|exists:car_images,id',
            'main_image_id' => 'nullable|integer|exists:car_images,id',
            'sort_images' => 'nullable|array',
            'sort_images.*' => 'integer|exists:car_images,id',
        ]);

        $validated['slug'] = Str::slug($validated['name']);

        $car->update($validated);
        $car->amenities()->sync($request->amenities ?? []);

        if ($request->guides) {
            $submittedIds = [];
            foreach ($request->guides as $i => $g) {
                if (empty($g['title'])) continue;
                if (!empty($g['id'])) {
                    $guide = $car->guides()->find($g['id']);
                    if ($guide) {
                        $data = ['title' => $g['title'], 'sort_order' => $i];
                        if (!empty($g['video']) && $g['video'] instanceof UploadedFile) {
                            if ($guide->video_path) {
                                Storage::disk('public')->delete(str_replace('storage/', '', $guide->video_path));
                            }
                            $data['video_path'] = 'storage/' . $g['video']->store('videos/car-guides', 'public');
                        }
                        if (!empty($g['image']) && $g['image'] instanceof UploadedFile) {
                            if ($guide->image_path) {
                                Storage::disk('public')->delete(str_replace('storage/', '', $guide->image_path));
                            }
                            $data['image_path'] = 'storage/' . $g['image']->store('car-guides-images', 'public');
                        }
                        $guide->update($data);
                        $submittedIds[] = $g['id'];
                    }
                } else {
                    $videoPath = null;
                    if (!empty($g['video']) && $g['video'] instanceof UploadedFile) {
                        $videoPath = 'storage/' . $g['video']->store('videos/car-guides', 'public');
                    }
                    $imagePath = null;
                    if (!empty($g['image']) && $g['image'] instanceof UploadedFile) {
                        $imagePath = 'storage/' . $g['image']->store('car-guides-images', 'public');
                    }
                    $guide = $car->guides()->create([
                        'title' => $g['title'],
                        'video_path' => $videoPath,
                        'image_path' => $imagePath,
                        'sort_order' => $i,
                    ]);
                    $submittedIds[] = $guide->id;
                }
            }
            // Delete removed guides and their video files
            $removed = $car->guides()->whereNotIn('id', $submittedIds)->get();
            foreach ($removed as $rg) {
                if ($rg->video_path) {
                    Storage::disk('public')->delete(str_replace('storage/', '', $rg->video_path));
                }
                if ($rg->image_path) {
                    Storage::disk('public')->delete(str_replace('storage/', '', $rg->image_path));
                }
                $rg->delete();
            }
        } else {
            foreach ($car->guides as $rg) {
                if ($rg->video_path) {
                    Storage::disk('public')->delete(str_replace('storage/', '', $rg->video_path));
                }
                if ($rg->image_path) {
                    Storage::disk('public')->delete(str_replace('storage/', '', $rg->image_path));
                }
            }
            $car->guides()->delete();
        }

        if ($request->delete_images) {
            $images = CarImage::whereIn('id', $request->delete_images)->where('car_id', $car->id)->get();
            foreach ($images as $img) {
                Storage::disk('public')->delete(str_replace('storage/', '', $img->path));
                $img->delete();
            }
        }

        if ($request->main_image_id) {
            CarImage::where('car_id', $car->id)->update(['is_main' => false]);
            CarImage::where('id', $request->main_image_id)->where('car_id', $car->id)->update(['is_main' => true]);
        }

        if ($request->sort_images) {
            $imageIds = $car->images()->pluck('id')->toArray();
            $orderedIds = array_intersect($request->sort_images, $imageIds);
            CarImage::where('car_id', $car->id)->update(['is_main' => false]);
            foreach ($orderedIds as $i => $id) {
                CarImage::where('id', $id)->where('car_id', $car->id)->update([
                    'sort_order' => $i,
                    'is_main' => $i === 0,
                ]);
            }
        }

        if ($request->hasFile('images')) {
            $lastOrder = $car->images()->max('sort_order') ?? -1;
            $hasMain = $car->images()->where('is_main', true)->exists();
            foreach ($request->file('images') as $i => $image) {
                $path = $image->store('cars', 'public');
                $car->images()->create([
                    'path' => 'storage/' . $path,
                    'is_main' => !$hasMain && $i === 0,
                    'sort_order' => $lastOrder + 1 + $i,
                ]);
            }
        }

        return redirect()->route('admin.cars.index')->with('success', 'Đã cập nhật xe.');
    }

    public function destroy(Car $car)
    {
        foreach ($car->images as $img) {
            Storage::disk('public')->delete(str_replace('storage/', '', $img->path));
        }
        $car->images()->delete();

        foreach ($car->guides as $g) {
            if ($g->video_path) {
                Storage::disk('public')->delete(str_replace('storage/', '', $g->video_path));
            }
            if ($g->image_path) {
                Storage::disk('public')->delete(str_replace('storage/', '', $g->image_path));
            }
        }

        $car->delete();

        if (request()->ajax() || request()->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Đã xóa xe ' . $car->name]);
        }

        return redirect()->route('admin.cars.index')->with('success', 'Đã xóa xe.');
    }

    public function destroyImage(CarImage $image)
    {
        Storage::disk('public')->delete(str_replace('storage/', '', $image->path));
        $carId = $image->car_id;
        $wasMain = $image->is_main;
        $image->delete();

        if ($wasMain) {
            $first = CarImage::where('car_id', $carId)->orderBy('sort_order')->first();
            if ($first) {
                $first->update(['is_main' => true]);
            }
        }

        if (request()->ajax() || request()->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Đã xóa ảnh.']);
        }

        return back()->with('success', 'Đã xóa ảnh.');
    }

    public function updateStatus(Request $request, Car $car)
    {
        $request->validate(['status' => 'required|in:available,rented,maintenance']);

        $car->update(['status' => $request->status]);

        $labels = ['available' => 'Sẵn sàng', 'rented' => 'Đang thuê', 'maintenance' => 'Bảo trì'];

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Đã đổi trạng thái thành "' . $labels[$request->status] . '"']);
        }

        return back()->with('success', 'Đã cập nhật trạng thái.');
    }
}
