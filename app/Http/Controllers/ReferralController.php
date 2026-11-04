<?php

namespace App\Http\Controllers;

use App\Models\Collaborator;
use App\Support\Phone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class ReferralController extends Controller
{
    public function index(Request $request)
    {
        $refCode = trim((string) $request->query('ref', ''));
        $referrer = $refCode !== ''
            ? Collaborator::where('code', $refCode)->where('status', 'active')->first()
            : null;

        return view('kiem-tien', compact('referrer', 'refCode'));
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|regex:/^0[0-9]{9}$/',
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string|max:255',
            'bank_name' => 'nullable|string|max:255',
            'bank_account' => 'nullable|string|max:50',
            'bank_owner' => 'nullable|string|max:255',
            'note' => 'nullable|string|max:1000',
            'agree' => 'accepted',
            'website' => 'nullable|max:0',
        ], [
            'name.required' => 'Vui lòng nhập họ và tên.',
            'phone.required' => 'Vui lòng nhập số điện thoại.',
            'phone.regex' => 'Số điện thoại phải gồm 10 số và bắt đầu bằng 0.',
            'email.email' => 'Email không hợp lệ.',
            'agree.accepted' => 'Vui lòng xác nhận bạn đã đọc chính sách cộng tác viên.',
            'website.max' => 'Yêu cầu không hợp lệ.',
        ]);

        $normalizedPhone = Phone::normalize($validated['phone']);

        $existing = Collaborator::query()
            ->get(['id', 'name', 'phone', 'status'])
            ->first(fn (Collaborator $collaborator) => $collaborator->normalizedPhone() === $normalizedPhone);

        if ($existing) {
            $message = $existing->status === 'pending'
                ? 'Số điện thoại này đã đăng ký và đang chờ duyệt. Vui lòng liên hệ Zalo để được hỗ trợ.'
                : 'Số điện thoại này đã có trong danh sách cộng tác viên. Vui lòng liên hệ Zalo để được hỗ trợ.';

            throw ValidationException::withMessages(['phone' => $message]);
        }

        $refCode = trim((string) $request->input('ref_code', ''));
        $referrer = $refCode !== ''
            ? Collaborator::where('code', $refCode)->where('status', 'active')->first()
            : null;

        DB::transaction(function () use ($validated, $normalizedPhone, $referrer) {
            Collaborator::create([
                'name' => $validated['name'],
                'phone' => $normalizedPhone,
                'status' => 'pending',
                'commission_rate' => 10,
                'email' => $validated['email'] ?? null,
                'address' => $validated['address'] ?? null,
                'bank_name' => $validated['bank_name'] ?? null,
                'bank_account' => $validated['bank_account'] ?? null,
                'bank_owner' => $validated['bank_owner'] ?? null,
                'note' => trim(($validated['note'] ?? '').($referrer ? "\nNguồn giới thiệu: {$referrer->name} ({$referrer->code})" : '')),
                'registered_via' => 'public',
                'sort_order' => 0,
            ]);
        });

        return redirect()
            ->route('kiem-tien')
            ->with('referral_success', true);
    }
}
