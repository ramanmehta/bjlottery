<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CashTransaction extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'type',
        'amount',
        'status', // 1 : credit 2 : debit
    ];

    public function getCreatedAtAttribute($val)
    {
        return \Carbon\Carbon::parse($val)->format('Y-m-d H:i:s');
    }
}
