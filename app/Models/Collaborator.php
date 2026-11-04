<?php

namespace App\Models;

use App\Support\Phone;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Collaborator extends Model
{
    protected $fillable = [
        'name', 'phone', 'status', 'code', 'commission_rate', 'address', 'email',
        'avatar', 'bank_name', 'bank_account', 'bank_owner', 'sort_order', 'note',
        'registered_via', 'approved_at',
    ];

    protected $casts = [
        'commission_rate' => 'decimal:2',
        'approved_at' => 'datetime',
        'sort_order' => 'integer',
    ];

    public const STATUS_LABELS = [
        'pending' => 'Chờ duyệt',
        'active' => 'Đang hoạt động',
        'inactive' => 'Tạm ngưng',
    ];

    public const STATUS_BADGES = [
        'pending' => 'warning',
        'active' => 'success',
        'inactive' => 'secondary',
    ];

    protected static function booted(): void
    {
        static::created(function (self $collaborator) {
            if (empty($collaborator->code)) {
                $collaborator->code = self::buildCode((int) $collaborator->id);
                $collaborator->saveQuietly();
            }
        });
    }

    public static function buildCode(int $id): string
    {
        return 'CTV'.str_pad((string) $id, 4, '0', STR_PAD_LEFT);
    }

    public function customers(): HasMany
    {
        return $this->hasMany(CollaboratorCustomer::class);
    }

    public function commissions(): HasMany
    {
        return $this->hasMany(CollaboratorCommission::class);
    }

    public function contracts(): HasMany
    {
        return $this->hasMany(Contract::class);
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function getStatusLabelAttribute(): string
    {
        return self::STATUS_LABELS[$this->status] ?? (string) $this->status;
    }

    public function getStatusBadgeAttribute(): string
    {
        return self::STATUS_BADGES[$this->status] ?? 'secondary';
    }

    public function getCommissionRateValueAttribute(): float
    {
        return (float) ($this->commission_rate ?: 10);
    }

    public function getReferralUrlAttribute(): string
    {
        return route('kiem-tien', ['ref' => $this->code]);
    }

    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    public function normalizedPhone(): ?string
    {
        return Phone::normalize($this->phone);
    }
}
