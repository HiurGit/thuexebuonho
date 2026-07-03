<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GlobalGuide extends Model
{
    protected $fillable = ['type', 'section_title', 'content', 'sort_order'];

    const TYPE_USAGE = 'usage';
    const TYPE_ACCIDENT = 'accident';
    const TYPE_INSURANCE = 'insurance';
}
