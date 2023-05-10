<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MissionLevel extends Model
{
    use HasFactory;
    protected $table = 'mission_level';
    protected $fillable = [
        'level_title',
        'level_description',
        'mission_id',
        'level_order',
        'max_referals',
        'created_at',
        'updated_at'
    ];

    public function mission()
    {
        return $this->belongsTo(Mission::class);
    }
}
