<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contract;
use App\Services\ContractDocumentService;
use Illuminate\Contracts\View\View;

class ContractDocumentController extends Controller
{
    public function html(Contract $contract, ContractDocumentService $service): View
    {
        $contract->load('car');

        return view('contract-document', [
            'contract' => $contract,
            'doc' => $service->data($contract),
            'backUrl' => route('admin.contracts.show', $contract),
        ]);
    }
}
