<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Car extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name', 'slug', 'description', 'seats', 'transmission', 'fuel',
        'fuel_consumption', 'year', 'insurance', 'address',
        'price_per_day', 'price_per_session', 'price_multi_day', 'price_out_province',
        'deposit_min', 'deposit_max', 'deposit_asset',
        'status', 'sort_order',
    ];

    protected $casts = [
        'price_per_day' => 'integer',
        'price_per_session' => 'integer',
        'price_multi_day' => 'integer',
        'price_out_province' => 'integer',
        'deposit_min' => 'integer',
        'deposit_max' => 'integer',
        'deposit_asset' => 'integer',
    ];

    public function images()
    {
        return $this->hasMany(CarImage::class)->orderBy('sort_order');
    }

    public function mainImage()
    {
        return $this->hasOne(CarImage::class)->where('is_main', true);
    }

    public function getSeoImagePathAttribute(): string
    {
        return $this->mainImage?->path
            ?? $this->images->first()?->path
            ?? 'assets/image/bannerMXH.jpg';
    }

    public function guides()
    {
        return $this->hasMany(CarGuide::class)->orderBy('sort_order');
    }

    public function amenities()
    {
        return $this->belongsToMany(Amenity::class, 'car_amenity')->withTimestamps();
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
