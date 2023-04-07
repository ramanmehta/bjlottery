<?php

namespace App\Http\Controllers\fortest;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\ReferalPoint;

class JoinController extends Controller
{
    public function referalPoints(){
        // $userPoint = User::find(4)->referal_point;
        return User::find(4)->referal_point;
    }
}
