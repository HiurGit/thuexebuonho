<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DeliveredProof;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DeliveredProofController extends Controller
{
    public function index()
    {
        $deliveredProofs = DeliveredProof::latest()->get();
        return view('admin.delivered-proofs.index', compact('deliveredProofs'));
    }

    public function create()
    {
        return view('admin.delivered-proofs.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
        ]);

        $path = $request->file('image')->store('delivered-proofs', 'public');

        DeliveredProof::create([
            'title' => $validated['title'],
            'image_path' => 'storage/' . $path,
        ]);

        return redirect()->route('admin.delivered-proofs.index')->with('success', 'Đã thêm mục đã giao.');
    }

    public function edit(DeliveredProof $deliveredProof)
    {
        return view('admin.delivered-proofs.edit', compact('deliveredProof'));
    }

    public function update(Request $request, DeliveredProof $deliveredProof)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
        ]);

        $data = [
            'title' => $validated['title'],
        ];

        if ($request->hasFile('image')) {
            if ($deliveredProof->image_path && Storage::disk('public')->exists(str_replace('storage/', '', $deliveredProof->image_path))) {
                Storage::disk('public')->delete(str_replace('storage/', '', $deliveredProof->image_path));
            }

            $path = $request->file('image')->store('delivered-proofs', 'public');
            $data['image_path'] = 'storage/' . $path;
        }

        $deliveredProof->update($data);

        return redirect()->route('admin.delivered-proofs.index')->with('success', 'Đã cập nhật mục đã giao.');
    }

    public function destroy(DeliveredProof $deliveredProof)
    {
        if ($deliveredProof->image_path && Storage::disk('public')->exists(str_replace('storage/', '', $deliveredProof->image_path))) {
            Storage::disk('public')->delete(str_replace('storage/', '', $deliveredProof->image_path));
        }

        $deliveredProof->delete();

        if (request()->ajax() || request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Đã xóa mục đã giao #' . $deliveredProof->id,
            ]);
        }

        return redirect()->route('admin.delivered-proofs.index')->with('success', 'Đã xóa mục đã giao.');
    }
}
