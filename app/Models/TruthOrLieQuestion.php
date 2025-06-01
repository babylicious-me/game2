<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TruthOrLieQuestion extends Model
{
    protected $table = 'truth_or_lie_questions';

    protected $fillable = [
        'text',
        'is_truth',
        'explanation',
    ];

    protected $casts = [
        'is_truth' => 'boolean',
    ];

    public static function random()
    {
        return self::inRandomOrder()->first();
    }
}