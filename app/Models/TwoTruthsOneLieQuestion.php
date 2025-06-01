<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TwoTruthsOneLieQuestion extends Model
{
    protected $fillable = [
        'statement_1', 'is_truth_1',
        'statement_2', 'is_truth_2',
        'statement_3', 'is_truth_3',
    ];

    protected $casts = [
        'is_truth_1' => 'boolean',
        'is_truth_2' => 'boolean',
        'is_truth_3' => 'boolean',
    ];
}