<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LuckyDrawWinner extends Model
{
    protected $fillable = [
        'user_id',
        'lottery_id',
        'lucky_draw_id',
        'ticket_no',
        'prize_name',
        'prize_image',
        'type',
        'amount',
    ];

    public function lottery()
    {
        return $this->hasOne(LuckyDrawGames::class, 'id', 'lottery_id')->withTrashed();
    }

    public function getPrizeImageAttribute($value)
    {
        return getImage($value);
    }

    public function user()
    {
        return $this->belongsTo(User::class)->withTrashed();
    }

    public function getStatusAttribute($value)
    {
        $lottery = LuckyDrawWinnerClaim::where('id', $value)
            ->first();

        if (is_null($lottery)) {

            return ucfirst('claim');
        } else {

            return status($lottery->status);
        }
    }

    public function getTypeAttribute($val)
    {
        return 'mission';
    }
}
