<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Contract extends Model
{
    use HasFactory;

    protected $fillable = [
        'contract_code', 'status', 'created_by', 'branch', 'contract_date',
        'cccd', 'customer_name', 'customer_phone', 'dob', 'gender', 'cccd_issue_date', 'cccd_issue_place',
        'customer_address', 'driver_license_no', 'license_issue_date', 'license_expiry_date', 'license_class',
        'car_id', 'car_name', 'car_brand', 'car_model', 'car_plate', 'car_color', 'car_year',
        'car_chassis', 'car_engine', 'car_owner',
        'car_seats', 'car_transmission', 'car_fuel',
        'pickup_datetime', 'pickup_location', 'return_datetime', 'return_location',
        'total_days', 'total_hours', 'km_limit',
        'deposit_type', 'deposit_amount', 'deposit_note',
        'deposit_moto_brand', 'deposit_moto_plate', 'deposit_moto_registration', 'deposit_other',
        'daily_rate', 'rental_days', 'total_rental_fee', 'notes',
    ];

    protected $casts = [
        'contract_date' => 'datetime',
        'dob' => 'date',
        'cccd_issue_date' => 'date',
        'license_issue_date' => 'date',
        'license_expiry_date' => 'date',
        'pickup_datetime' => 'datetime',
        'return_datetime' => 'datetime',
        'deposit_amount' => 'integer',
        'daily_rate' => 'integer',
        'total_rental_fee' => 'integer',
        'car_seats' => 'integer',
    ];

    public const STATUS_LABELS = [
        'pending' => 'Chờ nhận xe',
        'active' => 'Đang thuê',
        'returned' => 'Đã trả xe',
        'cancelled' => 'Đã hủy',
    ];

    public const STATUS_BADGES = [
        'pending' => 'warning',
        'active' => 'info',
        'returned' => 'success',
        'cancelled' => 'danger',
    ];

    public const DEPOSIT_TYPE_LABELS = [
        'cash' => 'Cọc tiền',
        'motorcycle' => 'Cọc xe máy',
    ];

    public const IMAGE_CATEGORIES = [
        'cccd_front' => 'Ảnh CCCD – Mặt trước',
        'cccd_back' => 'Ảnh CCCD – Mặt sau',
        'license_front' => 'Ảnh bằng lái – Mặt trước',
        'license_back' => 'Ảnh bằng lái – Mặt sau',
        'car_before' => 'Ảnh chụp trước xe',
        'car_video' => 'Hình ảnh / Video xe',
        'cccd' => 'Ảnh CCCD',
        'license' => 'Ảnh bằng lái',
    ];

    public function images(): HasMany
    {
        return $this->hasMany(ContractImage::class)->orderBy('sort_order');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function car(): BelongsTo
    {
        return $this->belongsTo(Car::class);
    }

    public function getStatusLabelAttribute(): string
    {
        return self::STATUS_LABELS[$this->status] ?? $this->status;
    }

    public function getStatusBadgeAttribute(): string
    {
        return self::STATUS_BADGES[$this->status] ?? 'secondary';
    }

    public function getDepositTypeLabelAttribute(): string
    {
        return self::DEPOSIT_TYPE_LABELS[$this->deposit_type] ?? (string) $this->deposit_type;
    }

    public function getMaskedCccdAttribute(): ?string
    {
        return $this->maskValue($this->cccd, 3, 4);
    }

    public function getMaskedPhoneAttribute(): ?string
    {
        return $this->maskValue($this->customer_phone, 3, 3);
    }

    private function maskValue(?string $value, int $prefix, int $suffix): ?string
    {
        $value = preg_replace('/\s+/', '', (string) $value);

        if ($value === '') {
            return null;
        }

        $length = strlen($value);

        if ($length <= $prefix + $suffix) {
            return str_repeat('*', $length);
        }

        return substr($value, 0, $prefix)
            .str_repeat('*', $length - $prefix - $suffix)
            .substr($value, -$suffix);
    }
}
