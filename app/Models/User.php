<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\LuckyDraw;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $primaryKey = "id";

    protected $fillable = [
        'name',
        'username',
        'email',
        'phone',
        'address_1',
        'address_2',
        'city',
        'state',
        'country',
        'zip',
        'referal_code',
        'referal_type',
        'password',
        'logo',
        'today_gained_point',
        'today_deduct_point',
        'total_point_available',
        'total_cash_available',
        'refered_by',
        'ip_address'
    ];

    public function luckydraw()
    {
        return $this->hasMany(LuckyDraw::class);
    }

    public function role()
    {
        return $this->hasMany('App\Models\Role', 'role_id', 'role_id');
    }

    public function referal_point()
    {
        return $this->hasOne('App\Models\ReferalPoint');
    }
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    
    public static function checkReferralCode($code) 
    {
        // CHECK IF THE CODE ALREADY EXISTS IN THE DATABASE
        $existingCode = User::where('referal_code', $code)->count();
       
        if ($existingCode > 0) {

          return User::where('referal_code', $code)->first();
        }
      
        // IF ALL CHECKS PASS, THE CODE IS VALID
        return false;
    }
    
    public function getLogoAttribute($value)
    {
        return getImage($value);
    }
}
