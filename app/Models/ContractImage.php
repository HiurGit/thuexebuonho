<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ContractImage extends Model
{
    protected $fillable = ['contract_id', 'category', 'path', 'sort_order'];

    public function contract(): BelongsTo
    {
        return $this->belongsTo(Contract::class);
    }
}