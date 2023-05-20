<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\DailyReward;
use App\Models\User;
use App\Models\DailyRewardPoint;

use Illuminate\Support\Carbon;

use DateTime;

class DailyRewardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $dailyreward = DailyReward::all();
        if($dailyreward->count() > 0){
            return response()->json([
                'status' => 200,
                'Daily Rewards' => $dailyreward,
            ], 200);
        }else{
            return response()->json([
                'status' => 404,
                'Daily Rewards' => 'No records found'
            ], 404);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $dailyreward = DailyReward::find($id);
        // var_dump($dailyreward);
        if($dailyreward){
            return response()->json([
                'status' => 200,
                'Daily Reward' => $dailyreward
            ],200);
        }else{
            return response()->json([
                'status' => 404,
                'message' => 'No record found'
            ],404);
        }
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    // daily reward function start

    public function dailyRewardPoints(Request $request)
    {
        $getData = $request->all();

        $users = User::find($request->user_id);
        $dailyReward = DailyReward::find($request->dailyReward_id);
        $dailyPoint = $dailyReward->reward_points;

        if($users && $dailyReward){

            $todayTime = new DateTime();
            $todayTime->format("Y-m-d");
            $rewardUser = DailyRewardPoint::where('user_id', $request->user_id)->first();
            
           
            if($rewardUser == ""){

                $data = [
                    'user_id' => $request->user_id,
                    'daily_reward_point' => $dailyPoint,
                    'daily_reward_time' => $todayTime,
                    'weekly_reward_points' => 0,
                    'bonus_reward_points' => 0,
                ];
                $creteNew = DailyRewardPoint::create($data);
                
                $response = [
                    'status' => 200,
                    'data' => $creteNew
                ];

                return response()->json($response);
            }else{
                // if user already exist in Dailyrewardpoint table 
                $dailyrewardDate = $rewardUser->daily_reward_time;
                $parsedToday = Carbon::parse($todayTime);
                $parseUserDate = Carbon::parse($dailyrewardDate);

                if($parseUserDate->isToday()){

                    $response = [
                        'satus' => 400,
                        'message' => 'Today Daily Reward already claimed'
                    ];
                    
                    return response()->json($response);
                    
                }else{
                    
                    $getRewardPint = $rewardUser->daily_reward_point;
                    $dailyPoint = $dailyReward->reward_points;
                    $updateReward = $getRewardPint + $dailyPoint;
                    $rewardUser->daily_reward_point = $updateReward;
                    $rewardUser->daily_reward_time = $todayTime;
                    $rewardUser->save();

                    $response = [
                        'status' => 200,
                        'data' => $rewardUser
                    ];

                    return response()->json($response);
                }
            }
            
        }else{

            $response = [
                'status' => 400,
                'message' => "User or Daily Reward not found"
            ];
           
            return response()->json($response);
        }
    }

    public function weeklyRewardPoints(Request $request)
    {
        $getData = $request->all();

        $users = User::find($request->user_id);
        $weeklyReward = DailyReward::find($request->dailyReward_id);
        $weeklyPoint = $weeklyReward->reward_points;

        if($users && $weeklyReward){

            $todayTime = new DateTime();
            $todayTime->format("Y-m-d");
           
            $rewardUser = DailyRewardPoint::where('user_id', $request->user_id)->first();
            
            if($rewardUser == ""){
                // $weeklyrewardDate = $rewardUser->weekly_reward_time;
                // $parseWeekDay = Carbon::parse($todayTime);
                // $demoweeked = 
                $parseWeekDay = Carbon::parse($todayTime);
                // $parsedToday = Carbon::parse($todayTime);
                // $parseUserDate = Carbon::parse($weeklyrewardDate);
                // $wekend = '2023-03-26';
                // $parseWeekDay1 = Carbon::parse($wekend);
                // dd($parseWeekDay->isWeekend());
                if($parseWeekDay->isWeekend()){
                $data = [
                    'user_id' => $request->user_id,
                    'daily_reward_point' => 0,
                    // 'daily_reward_time' => '',
                    'weekly_reward_points' => $weeklyPoint,
                    'weekly_reward_time' => $parseWeekDay,
                    'bonus_reward_points' => 0,
                ];
                $creteNew = DailyRewardPoint::create($data);
                
                $response = [
                    'status' => 200,
                    'data' => $creteNew
                ];

                return response()->json($response);
                }else{
                
                    $response = [
                        'status' => 400,
                        'message' => 'Claim this reward on weekend'
                    ];

                return response()->json($response);
                }
                
            }else{
                // if user already exist in Dailyrewardpoint table 
                // $weeklyrewardDate = $rewardUser->weekly_reward_time;
                // $parseUserDate = Carbon::parse($weeklyrewardDate);

                $parseWeekDay = Carbon::parse($todayTime);
                
                // test with old data
                // $wekend = '2023-04-01';
                // $oldWeekDay = Carbon::parse($wekend);
                if($parseWeekDay->isWeekend()){
                    // dd("is weekend");
                    $rewardUserPoints = $rewardUser->weekly_reward_points;
                    $updatePoint = $weeklyPoint + $rewardUserPoints;

                        
                    $rewardUser->weekly_reward_points = $updatePoint;
                    $rewardUser->weekly_reward_time = $parseWeekDay;
                    $rewardUser->save();

                    $response = [
                        'satus' => 200,
                        'data' => $rewardUser,
                        'message' => 'You claimed your weeked reward'
                        ];
                        
                    return response()->json($response);
                }else{
                    // dd("not weeked");
                   
                    $response = [
                        'status' => 400,
                        'message' => 'Claim reward on weekend'
                    ];

                    return response()->json($response);
                }
                
                

            }
            
        }else{

            $response = [
                'status' => 400,
                'message' => "User or Daily Reward not found"
            ];
           
            return response()->json($response);
        }

    }
}
