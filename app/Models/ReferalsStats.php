<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReferalsStats extends Model
{
    use HasFactory;
    protected $fillable = [
        'reward_types',
        'reward_points',
        'status',
    ];

}
