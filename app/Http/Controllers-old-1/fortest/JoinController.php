<?php

namespace App\Http\Controllers\fortest;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\ReferalPoint;
use App\Models\LuckyDraw;

class JoinController extends Controller
{
    public function referalPoints(){
        // $userPoint = User::find(4)->referal_point;
        return User::find(4)->referal_point;
    }

    public function participantUsername()
    {

        
        $participant = LuckyDraw::distinct()->get('user_id');

        $user = User::find($participant);
        return $user;

    }

    public function datetimeOnly()
    {
        return view('admin.test.date');
    }
}
