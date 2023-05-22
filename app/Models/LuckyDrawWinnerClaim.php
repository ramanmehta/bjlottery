<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LuckyDrawWinnerClaim extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'address_1',
        'address_2',
        'status',
        'lottery_id',
        'lucky_draw_id',
        'lucky_draw_winner_id',
        'ticket_no',
    ];

    public function user()
    {
        return $this->belongsTo(User::class)->withTrashed();
    }

    public function lottery()
    {
        return $this->hasOne(LuckyDrawGames::class,'id','lottery_id')->withTrashed();
    }

    public function prize()
    {
        return $this->hasOne(LuckyDrawWinner::class,'id','lucky_draw_winner_id');
    }
}
