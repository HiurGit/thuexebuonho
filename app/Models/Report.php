<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Report extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'customer_id', 'reporter_name', 'reporter_phone', 'category',
        'content', 'views', 'status',
    ];

    protected $casts = [
        'views' => 'integer',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function images()
    {
        return $this->hasMany(ReportImage::class);
    }

    public function getDateAttribute(): string
    {
        return $this->created_at?->format('d/m/Y') ?? '';
    }
}
