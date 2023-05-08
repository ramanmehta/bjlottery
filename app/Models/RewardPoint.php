<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RewardPoint extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'reward_type_id',
        'reward_type',
        'reward_points',
        'status'
    ];
}
