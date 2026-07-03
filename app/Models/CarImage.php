<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CarImage extends Model
{
    protected $fillable = ['car_id', 'path', 'is_main', 'sort_order'];
    protected $casts = ['is_main' => 'boolean'];

    public function car()
    {
        return $this->belongsTo(Car::class);
    }
}
