<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name', 'dob', 'gender', 'cccd', 'phone', 'license', 'address', 'cccd_issue_date', 'status',
    ];

    protected $casts = [
        'dob' => 'string',
    ];

    public function reports()
    {
        return $this->hasMany(Report::class)->orderBy('created_at', 'desc');
    }

    public function latestReport()
    {
        return $this->hasOne(Report::class)->latestOfMany();
    }

    public function getTotalViewsAttribute(): int
    {
        return (int) $this->reports()->sum('views');
    }
}
