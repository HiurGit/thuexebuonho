<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Collaborator;
use App\Models\CollaboratorCommission;
use Illuminate\Http\Request;

class CollaboratorCommissionController extends Controller
{
    public function index(Request $request)
    {
        $query = CollaboratorCommission::with(['collaborator', 'contract'])->latest('recognized_at');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('collaborator_id')) {
            $query->where('collaborator_id', $request->collaborator_id);
        }

        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function ($sub) use ($q) {
                $sub->where('contract_code', 'like', "%{$q}%")
                    ->orWhere('customer_name', 'like', "%{$q}%")
                    ->orWhere('customer_phone', 'like', "%{$q}%");
            });
        }

        $commissions = $query->paginate(20)->withQueryString();

        $stats = [
            'pending_count' => CollaboratorCommission::where('status', 'pending')->count(),
            'pending_amount' => (int) CollaboratorCommission::where('status', 'pending')->sum('commission_amount'),
            'paid_count' => CollaboratorCommission::where('status', 'paid')->count(),
            'paid_amount' => (int) CollaboratorCommission::where('status', 'paid')->sum('commission_amount'),
        ];

        $collaborators = Collaborator::orderBy('name')->get(['id', 'name', 'code']);

        return view('admin.commissions.index', compact('commissions', 'stats', 'collaborators'));
    }

    public function markPaid(Request $request, CollaboratorCommission $commission)
    {
        if ($commission->status === 'cancelled') {
            return back()->with('error', 'Khoản hoa hồng đã bị hủy, không thể thanh toán.');
        }

        $request->validate([
            'payment_note' => 'nullable|string|max:255',
        ]);

        $commission->update([
            'status' => 'paid',
            'paid_at' => now(),
            'paid_by' => auth()->id(),
            'payment_note' => $request->payment_note,
        ]);

        return back()->with('success', 'Đã đánh dấu thanh toán hoa hồng cho '.$commission->collaborator->name.'.');
    }

    public function markPending(CollaboratorCommission $commission)
    {
        $commission->update([
            'status' => 'pending',
            'paid_at' => null,
            'paid_by' => null,
            'payment_note' => null,
        ]);

        return back()->with('success', 'Đã chuyển khoản hoa hồng về trạng thái chờ thanh toán.');
    }

    public function cancel(CollaboratorCommission $commission)
    {
        $commission->update([
            'status' => 'cancelled',
            'note' => trim(($commission->note ? $commission->note."\n" : '').'Hủy bởi '.auth()->user()->name.' lúc '.now()->format('d/m/Y H:i')),
        ]);

        return back()->with('success', 'Đã hủy khoản hoa hồng.');
    }
}
