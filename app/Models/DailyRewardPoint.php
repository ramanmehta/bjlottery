<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DailyRewardPoint extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'daily_reward_point',
        'daily_reward_time',
        'weekly_reward_points',
        'weekly_reward_time',
        'bonus_reward_points',
    ];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s'
    ];
}
