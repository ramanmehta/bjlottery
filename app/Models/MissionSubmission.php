<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MissionSubmission extends Model
{
    use HasFactory;
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
        return $this->belongsTo(User::class);
    }
}
