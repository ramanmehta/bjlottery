<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use APP\Models\User;

class ReferalPoint extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'referal_code',
        'referal_link',
        'referal_point',
        'referal_type',
        'refered_by'
    ];

    public function user()
    {
        return $this->hasOne(User::class,'id','user_id')->withTrashed();
    }
}
