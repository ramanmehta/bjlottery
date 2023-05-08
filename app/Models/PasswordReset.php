<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;

class PasswordReset extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    public $table = 'password_reset_tokens';
    public $timestamps = false;
    protected $primaryKey = 'email';
    protected $fillable = [
        'email',
        'token',
        'created_at'
    ];
}
