<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CollaboratorCommission extends Model
{
    protected $fillable = [
        'collaborator_id', 'contract_id', 'contract_code', 'customer_name',
        'customer_phone', 'contract_total', 'commission_rate', 'commission_amount',
        'status', 'recognized_at', 'paid_at', 'paid_by', 'payment_note', 'note',
    ];

    protected $casts = [
        'contract_total' => 'integer',
        'commission_rate' => 'decimal:2',
        'commission_amount' => 'integer',
        'recognized_at' => 'datetime',
        'paid_at' => 'datetime',
    ];

    public const STATUS_LABELS = [
        'pending' => 'Chờ thanh toán',
        'paid' => 'Đã thanh toán',
        'cancelled' => 'Đã hủy',
    ];

    public const STATUS_BADGES = [
        'pending' => 'warning',
        'paid' => 'success',
        'cancelled' => 'secondary',
    ];

    public function collaborator(): BelongsTo
    {
        return $this->belongsTo(Collaborator::class);
    }

    public function contract(): BelongsTo
    {
        return $this->belongsTo(Contract::class);
    }

    public function payer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'paid_by');
    }

    public function getStatusLabelAttribute(): string
    {
        return self::STATUS_LABELS[$this->status] ?? (string) $this->status;
    }

    public function getStatusBadgeAttribute(): string
    {
        return self::STATUS_BADGES[$this->status] ?? 'secondary';
    }
}
