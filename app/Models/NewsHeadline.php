<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NewsHeadline extends Model
{
    protected $fillable = [
        'headline',
        'is_real',
        'source',
    ];
}
