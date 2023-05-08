<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mission extends Model
{
    use HasFactory;

    protected $fillable = [
        'mission_title',
        'mission_description',
        'mission_proof_type',
        'number_of_share',
        'per_share_point',
        'mission_start_date',
        'mission_end_date',
        'status',
    ];

    /**
     * Get the mission levels for the mission.
     */
    public function missionLevels()
    {
        return $this->hasMany(MissionLevel::class);
    }
}
