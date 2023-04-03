<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use APP\Models\User;

class ReferalsStats extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'parent_user_id',
        'referal_types',
        'referal_link',
        'referal_code',
    ];

    public function user()
    {
        return $this->hasOne(User::class,'id','user_id');
    }

}
