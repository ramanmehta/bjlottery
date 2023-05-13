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

    public function getStatusAttribute($val)
    {
        $mission = MissionSubmission::where('user_id',auth()->id())
            ->where('mission_id',$val)
            ->first();
        
        if (is_null($mission)) {
            return 'redeem';
        }else{
            $mission->status;
        }
    }
}
