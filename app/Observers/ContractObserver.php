<?php

namespace App\Observers;

use App\Models\Contract;
use App\Services\CollaboratorCommissionService;

class ContractObserver
{
    public function saved(Contract $contract): void
    {
        app(CollaboratorCommissionService::class)->syncForContract($contract);
    }

    public function deleted(Contract $contract): void
    {
        //
    }
}
