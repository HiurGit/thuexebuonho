<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Amenity extends Model
{
    protected $fillable = ['name', 'icon', 'sort_order'];

    public function cars()
    {
        return $this->belongsToMany(Car::class, 'car_amenity')->withTimestamps();
    }
}
