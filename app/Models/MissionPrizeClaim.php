<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MissionPrizeClaim extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'address_1',
        'address_2',
        'status',
        'mission_id',
        'mission_submit_id'
    ];
}
