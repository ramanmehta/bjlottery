<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class LuckyDrawGames extends Model
{
    use HasFactory;

    protected $fillable = [
        'game_title',
        'game_description',
        'game_image',
        'winning_prize_amount',
        'minimum_prize_amount',
        'points_per_ticket',
        'start_date_time',
        'end_date_time',
        'status',
        // 'type'
    ];

    public function getGameImageAttribute($value)
    {
        return Storage::disk('public')->url('images'.$value);
    }
}
