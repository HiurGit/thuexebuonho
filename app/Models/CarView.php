<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CarView extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'visitor_id',
        'car_id',
        'visit_count',
        'first_viewed_at',
        'last_viewed_at',
    ];

    protected function casts(): array
    {
        return [
            'visit_count' => 'integer',
            'first_viewed_at' => 'datetime',
            'last_viewed_at' => 'datetime',
        ];
    }

    public function visitor(): BelongsTo
    {
        return $this->belongsTo(Visitor::class);
    }

    public function car(): BelongsTo
    {
        return $this->belongsTo(Car::class);
    }
}
