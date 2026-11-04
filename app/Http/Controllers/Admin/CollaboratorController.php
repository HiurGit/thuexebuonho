<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Collaborator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CollaboratorController extends Controller
{
    public function index(Request $request)
    {
        $query = Collaborator::withCount(['customers', 'commissions'])
            ->withSum(['commissions as pending_commission_total' => fn ($query) => $query->where('status', 'pending')], 'commission_amount');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function ($sub) use ($q) {
                $sub->where('name', 'like', "%{$q}%")
                    ->orWhere('phone', 'like', "%{$q}%")
                    ->orWhere('code', 'like', "%{$q}%");
            });
        }

        $collaborators = $query->orderBy('sort_order')->latest('id')->paginate(20)->withQueryString();

        $stats = [
            'pending' => Collaborator::where('status', 'pending')->count(),
            'active' => Collaborator::where('status', 'active')->count(),
            'inactive' => Collaborator::where('status', 'inactive')->count(),
        ];

        return view('admin.collaborators.index', compact('collaborators', 'stats'));
    }

    public function create()
    {
        return view('admin.collaborators.create');
    }

    public function store(Request $request)
    {
        $validated = $this->validateData($request);
        $data = $this->avatarData($request, $validated);
        $data['status'] = $data['status'] ?? 'active';
        $data['commission_rate'] = $data['commission_rate'] ?? 10;

        Collaborator::create($data);

        return redirect()->route('admin.collaborators.index')->with('success', 'Đã thêm cộng tác viên.');
    }

    public function edit(Collaborator $collaborator)
    {
        return view('admin.collaborators.edit', compact('collaborator'));
    }

    public function update(Request $request, Collaborator $collaborator)
    {
        $validated = $this->validateData($request);
        $data = $this->avatarData($request, $validated);

        if ($request->hasFile('avatar') && $collaborator->avatar && Storage::disk('public')->exists(str_replace('storage/', '', $collaborator->avatar))) {
            Storage::disk('public')->delete(str_replace('storage/', '', $collaborator->avatar));
        }

        if (($data['status'] ?? null) === null) {
            unset($data['status']);
        }

        if (($data['status'] ?? null) === 'active' && ! $collaborator->approved_at) {
            $data['approved_at'] = now();
        }

        $collaborator->update($data);

        return redirect()->route('admin.collaborators.index')->with('success', 'Đã cập nhật cộng tác viên.');
    }

    public function approve(Collaborator $collaborator)
    {
        $collaborator->status = 'active';
        $collaborator->approved_at = now();

        if (empty($collaborator->code)) {
            $collaborator->code = Collaborator::buildCode((int) $collaborator->id);
        }

        $collaborator->save();

        return back()->with('success', 'Đã duyệt cộng tác viên '.$collaborator->name.'. Mã giới thiệu: '.$collaborator->code.'.');
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

    private function validateData(Request $request): array
    {
        return $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:30',
            'status' => 'nullable|in:pending,active,inactive',
            'commission_rate' => 'nullable|numeric|min:0|max:100',
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string|max:255',
            'bank_name' => 'nullable|string|max:255',
            'bank_account' => 'nullable|string|max:50',
            'bank_owner' => 'nullable|string|max:255',
            'note' => 'nullable|string',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'sort_order' => 'nullable|integer',
        ]);
    }

    private function avatarData(Request $request, array $validated): array
    {
        $data = $validated;
        unset($data['avatar']);

        if ($request->hasFile('avatar')) {
            $path = $request->file('avatar')->store('collaborators', 'public');
            $data['avatar'] = 'storage/' . $path;
        }

        return $data;
    }
}
