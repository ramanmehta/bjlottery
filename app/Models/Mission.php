<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mission extends Model
{
    use HasFactory;

    protected $fillable = [
        'mission_title',
        'mission_description',
        'mission_proof_type',
        'number_of_referals_required',
        'referal_unit_point',
        'referal_code',
        'mission_start_date',
        'mission_end_date',
        'status',
    ];
}
