<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\SoftDeletes;

class LuckyDrawGames extends Model
{
    use SoftDeletes;

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

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s'
    ];
}
