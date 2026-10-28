<?php

namespace App\Http\Controllers;

use App\Models\Contract;
use App\Services\ContractDocumentService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class ContractLookupController extends Controller
{
    public function index()
    {
        return view('tra-cuu');
    }

    public function shared(Contract $contract)
    {
        return view('tra-cuu', [
            'prefillCode' => $contract->contract_code,
        ]);
    }

    public function lookup(Request $request)
    {
        $data = $request->validate([
            'contract_code' => ['required', 'string', 'max:50'],
            'phone' => ['required', 'string', 'max:30'],
        ], [
            'contract_code.required' => 'Vui lòng nhập mã hợp đồng.',
            'phone.required' => 'Vui lòng nhập số điện thoại của hợp đồng.',
            'contract_code.max' => 'Mã hợp đồng không được vượt quá 50 ký tự.',
            'phone.max' => 'Số điện thoại không được vượt quá 30 ký tự.',
        ], [
            'contract_code' => 'mã hợp đồng',
            'phone' => 'số điện thoại',
        ]);

        $code = strtoupper(trim($data['contract_code']));
        $phone = $this->normalizePhone($data['phone']);

        $contract = Contract::with(['car', 'images'])
            ->where('contract_code', $code)
            ->first();

        if (
            ! $contract
            || $phone === ''
            || $this->normalizePhone($contract->customer_phone) !== $phone
        ) {
            return back()
                ->withInput()
                ->withErrors(['lookup' => 'Số điện thoại không đúng với hợp đồng. Vui lòng kiểm tra lại mã hợp đồng và số điện thoại.']);
        }

        session()->put('contract_lookup.'.$contract->id, true);

        return view('tra-cuu', compact('contract'));
    }

    public function html(Contract $contract, ContractDocumentService $service): View
    {
        abort_unless(session('contract_lookup.'.$contract->id), 403);

        $contract->load('car');

        return view('contract-document', [
            'contract' => $contract,
            'doc' => $service->data($contract),
            'backUrl' => route('contract.lookup.shared', ['contract' => $contract->contract_code]),
        ]);
    }

    private function normalizePhone(?string $phone): string
    {
        $digits = preg_replace('/\D+/', '', (string) $phone);

        if (str_starts_with($digits, '84') && strlen($digits) > 9) {
            $digits = '0'.substr($digits, 2);
        }

        return $digits;
    }
}
