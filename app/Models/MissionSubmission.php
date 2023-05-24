<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MissionSubmission extends Model
{
    use SoftDeletes;

    protected $table = 'mission_submissions';

    protected $fillable = [
        'mission_id',
        'user_id',
        'proof',
        'created_at',
        'updated_at',
        'approval_status'
    ];

    public function mission()
    {
        return $this->belongsTo(Mission::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class)->withTrashed();
    }

    public function getTypeAttribute($val)
    {
        return 'mission';
    }

    public function getStatusAttribute($val)
    {
        $mission = MissionPrizeClaim::where('user_id', auth()->id())
            ->where('mission_id', $val)
            ->where('status','!=',4)
            ->first();

        if (is_null($mission)) {

            return ucfirst('claim');

        } else {
            
            return status($mission->status);
        }
    }
}
