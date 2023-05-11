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
        'prize_image'
    ];

    public function lottery()
    {
        return $this->hasOne(LuckyDrawGames::class, 'id', 'lottery_id');
    }

    public function getPrizeImageAttribute($value)
    {
        return getImage($value);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getStatusAttribute($value)
    {
        return status($value);
    }

    public function getTypeAttribute($val)
    {
        return 'mission';
    }
}
