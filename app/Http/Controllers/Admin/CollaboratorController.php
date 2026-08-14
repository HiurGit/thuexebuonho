<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Collaborator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CollaboratorController extends Controller
{
    public function index()
    {
        $collaborators = Collaborator::orderBy('sort_order')->paginate(20);
        return view('admin.collaborators.index', compact('collaborators'));
    }

    public function create()
    {
        return view('admin.collaborators.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:30',
            'address' => 'nullable|string|max:255',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'sort_order' => 'nullable|integer',
        ]);

        $data = $validated;
        unset($data['avatar']);

        if ($request->hasFile('avatar')) {
            $path = $request->file('avatar')->store('collaborators', 'public');
            $data['avatar'] = 'storage/' . $path;
        }

        Collaborator::create($data);

        return redirect()->route('admin.collaborators.index')->with('success', 'Đã thêm cộng tác viên.');
    }

    public function edit(Collaborator $collaborator)
    {
        return view('admin.collaborators.edit', compact('collaborator'));
    }

    public function update(Request $request, Collaborator $collaborator)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:30',
            'address' => 'nullable|string|max:255',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'sort_order' => 'nullable|integer',
        ]);

        $data = $validated;
        unset($data['avatar']);

        if ($request->hasFile('avatar')) {
            if ($collaborator->avatar && Storage::disk('public')->exists(str_replace('storage/', '', $collaborator->avatar))) {
                Storage::disk('public')->delete(str_replace('storage/', '', $collaborator->avatar));
            }
            $path = $request->file('avatar')->store('collaborators', 'public');
            $data['avatar'] = 'storage/' . $path;
        }

        $collaborator->update($data);

        return redirect()->route('admin.collaborators.index')->with('success', 'Đã cập nhật cộng tác viên.');
    }

    public function destroy(Collaborator $collaborator)
    {
        if ($collaborator->avatar && Storage::disk('public')->exists(str_replace('storage/', '', $collaborator->avatar))) {
            Storage::disk('public')->delete(str_replace('storage/', '', $collaborator->avatar));
        }
        $collaborator->delete();

        if (request()->ajax() || request()->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Đã xóa cộng tác viên ' . $collaborator->name]);
        }

        return redirect()->route('admin.collaborators.index')->with('success', 'Đã xóa cộng tác viên.');
    }
}
