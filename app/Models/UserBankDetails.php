<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserBankDetails extends Model
{
    protected $fillable = [
        'user_id',
        'amount',
        'text',
        'status',
    ];

    public function getCreatedAtAttribute($val)
    {
        return \Carbon\Carbon::parse($val)->format('Y-m-d H:i:s');
    }

    public function user()
    {
        return $this->hasOne(User::class,'id','user_id')->withTrashed();
    }

    public function getStatusAttribute($val)
    {
        return withdrawalStatus($val);
    }
}
