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
}
