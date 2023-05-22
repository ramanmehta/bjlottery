<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LuckyDraw extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'lucky_draw_games_id',
        'ticket_number',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class)->withTrashed();
    }
}