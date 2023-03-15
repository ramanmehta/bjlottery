<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\Admin as Authenticatable;
use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    use HasFactory;


    protected $fillable = [
        'email',
        'password',
    ];
}
