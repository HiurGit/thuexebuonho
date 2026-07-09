<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Booking extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'car_id', 'customer_name', 'customer_phone',
        'rental_type', 'start_date', 'end_date', 'start_time', 'end_time',
        'session_type', 'pickup_type', 'trip_plan', 'days', 'total_price', 'deposit',
        'status', 'notes',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'total_price' => 'integer',
        'deposit' => 'integer',
        'days' => 'integer',
    ];

    public function car()
    {
        return $this->belongsTo(Car::class);
    }

    public function getSessionLabelAttribute(): ?string
    {
        return match ($this->session_type) {
            'sang' => 'Sang (6h-12h)',
            'chieu' => 'Chieu (12h-18h)',
            'toi' => 'Toi (18h-23h)',
            default => $this->session_type,
        };
    }

    public function getBookingTimeLabelAttribute(): ?string
    {
        if ($this->rental_type === 'hourly' && $this->session_label) {
            return $this->session_label;
        }

        if ($this->start_time && $this->end_time) {
            return $this->start_time . ' - ' . $this->end_time;
        }

        return null;
    }

    public function getTripPlanLabelAttribute(): ?string
    {
        return match ($this->trip_plan) {
            'out-province' => 'Di chuyen ngoai tinh',
            'in-province' => 'Di chuyen trong tinh',
            default => null,
        };
    }

    public function getPickupTypeLabelAttribute(): ?string
    {
        return match ($this->pickup_type) {
            'delivery' => 'Giao xe tan noi',
            'shop' => 'Nhan tai shop',
            default => null,
        };
    }

    public static function boot()
    {
        parent::boot();

        static::creating(function ($booking) {
            if (empty($booking->customer_name) && !empty($booking->customer_phone)) {
                $booking->customer_name = 'Khách ' . substr($booking->customer_phone, -4);
            }
        });
    }
}
