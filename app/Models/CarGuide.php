<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CarGuide extends Model
{
    protected $fillable = ['car_id', 'title', 'content', 'video_path', 'sort_order'];

    public function car()
    {
        return $this->belongsTo(Car::class);
    }
}
