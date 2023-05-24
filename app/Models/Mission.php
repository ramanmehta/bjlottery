<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Mission extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'mission_title',
        'mission_description',
        'status',
        'banner_image',
        'mission_type',
        'enter_earn_affliated_points',
        'prize_name',
        'prize_image',
    ];

    /**
     * Get the mission levels for the mission.
     */
    public function missionLevels()
    {
        return $this->hasMany(MissionLevel::class);
    }

    /**
     * Get the mission levels for the mission.
     */
    public function missionSubmission()
    {
        return $this->hasOne(MissionSubmission::class);
    }

    public function getBannerImageAttribute($value)
    {
        return getImage($value);
    }

    public function getPrizeImageAttribute($value)
    {
        return getImage($value);
    }

    public function getMissionStatusAttribute($val)
    {
        $mission = MissionSubmission::where('user_id',auth()->id())
            ->where('mission_id',$val)
            ->first();
        
        if (is_null($mission)) {
            return ucfirst('redeem');
        }else{
            return ucfirst($mission->approval_status);
        }
    }
}
