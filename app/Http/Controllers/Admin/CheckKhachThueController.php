<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;

class CheckKhachThueController extends Controller
{
    public function index(Request $request)
    {
        $query = Customer::withCount('reports')->with('latestReport');

        if ($q = trim($request->get('q'))) {
            $query->where(function ($q2) use ($q) {
                $q2->where('name', 'like', "%{$q}%")
                    ->orWhere('cccd', 'like', "%{$q}%")
                    ->orWhere('phone', 'like', "%{$q}%")
                    ->orWhere('license', 'like', "%{$q}%");
            });
        }

        $customers = $query->orderBy('created_at', 'desc')->paginate(20)->withQueryString();

        return view('admin.check-khach-thue.index', compact('customers'));
    }

    public function create()
    {
        return view('admin.check-khach-thue.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'dob' => 'nullable|string|max:20',
            'gender' => 'nullable|string|max:10',
            'address' => 'nullable|string|max:255',
            'cccd_issue_date' => 'nullable|string|max:20',
            'cccd' => 'nullable|string|max:20|unique:customers,cccd',
            'phone' => 'nullable|string|max:20',
            'license' => 'nullable|string|max:30',
            'status' => 'required|string|in:active,banned',
        ]);

        Customer::create($validated);

        return redirect()->route('admin.check-khach-thue.index')->with('success', 'Đã thêm khách hàng.');
    }

    public function edit(Customer $customer)
    {
        return view('admin.check-khach-thue.edit', compact('customer'));
    }

    public function update(Request $request, Customer $customer)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'dob' => 'nullable|string|max:20',
            'gender' => 'nullable|string|max:10',
            'address' => 'nullable|string|max:255',
            'cccd_issue_date' => 'nullable|string|max:20',
            'cccd' => 'nullable|string|max:20|unique:customers,cccd,' . $customer->id,
            'phone' => 'nullable|string|max:20',
            'license' => 'nullable|string|max:30',
            'status' => 'required|string|in:active,banned',
        ]);

        $customer->update($validated);

        return redirect()->route('admin.check-khach-thue.index')->with('success', 'Đã cập nhật khách hàng.');
    }

    public function destroy(Customer $customer)
    {
        $customer->delete();

        if (request()->ajax() || request()->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Đã xóa khách hàng ' . $customer->name]);
        }

        return redirect()->route('admin.check-khach-thue.index')->with('success', 'Đã xóa khách hàng.');
    }

    public function updateStatus(Request $request, Customer $customer)
    {
        $request->validate(['status' => 'required|in:active,banned']);

        $customer->update(['status' => $request->input('status')]);

        return response()->json(['success' => true]);
    }
}
