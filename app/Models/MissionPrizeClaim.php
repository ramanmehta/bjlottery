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

    public function mission()
    {
        return $this->belongsTo(Mission::class, 'mission_id', 'id')->withTrashed();
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id')->withTrashed();
    }

    public function mission_submission()
    {
        return $this->belongsTo(MissionSubmission::class, 'mission_submit_id', 'id');
    }

    public function getStatusAttribute($val)
    {
        return ucfirst($val);
    }
}
