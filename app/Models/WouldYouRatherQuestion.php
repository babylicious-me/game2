<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WouldYouRatherQuestion extends Model
{
    protected $fillable = ['option_a', 'option_b', 'votes_a', 'votes_b'];
}
