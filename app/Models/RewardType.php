<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RewardType extends Model
{
    use HasFactory;
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
}
