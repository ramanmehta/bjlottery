<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RewardType extends Model
{
    use SoftDeletes;
    
    //Add extra attribute
    // protected $attributes = ['claimed'];
    
    // //Make it available in the json response
    // protected $appends = ['claimed'];
    protected $fillable = [
        'reward_type',
        'reward_title',
        'reward_description',
        'reward_points',
        'status',
    ];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s'
    ];
}
