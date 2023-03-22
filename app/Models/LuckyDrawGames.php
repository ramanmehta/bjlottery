<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LuckyDrawGames extends Model
{
    use HasFactory;

    protected $fillable = [
        'game_title',
        'game_description',
        'game_image',
        'winning_prize_amount',
        'min_point',
        'max_point',
        'start_date_time',
        'end_date_time',
        'status',
        'game_point',
    ];
}
