<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VisitorLog extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'session_id',
        'visitor_token',
        'ip_address',
        'user_agent',
        'browser',
        'platform',
        'device_type',
        'referer',
        'visited_url',
        'route_name',
        'method',
        'is_bot',
        'visited_at',
    ];

    protected function casts(): array
    {
        return [
            'is_bot' => 'boolean',
            'visited_at' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
