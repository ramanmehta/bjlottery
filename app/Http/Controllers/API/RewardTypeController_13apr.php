<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RewardType;
use App\Models\User;
use App\Models\RewardTypePoint;
use App\Models\RewardPoint;
// use Carbon;
use Illuminate\Support\Carbon;
use Carbon\CarbonPeriod;
use DateTime;
use Illuminate\Support\Facades\DB;

class RewardTypeController extends Controller
{
    public function index()
    {   
        // $userId = auth('sanctum')->user()->id;
        // dd($userId);
    //     $today=date('Y-m-d');
    //     $todatStartDateTime = date('Y-m-d 00:00:00'); 
    //     $rewardType = RewardType::all();
    //     $getReward = DB::table('reward_points')
    //     ->where('user_id',$userId)
    //     ->whereDate('created_at','>=', $todatStartDateTime)
    //     ->get();
    //   // print_r($getReward);
    //     foreach($getReward as $value)
    //     {
    //         //echo '<pre>';
    //       // print_r($value);
    //         $reward_type_id=$value->reward_type_id;
    //         $getRewardTypeData=DB::table('reward_types')
    //         ->where('id',$reward_type_id)
    //         ->get();

    //         $getUnclaimedData=
    //         DB::table('reward_types')
    //         ->where('id','!=',$reward_type_id)
    //         ->get();
            
    //     echo '<pre>';
    //         print_r($getUnclaimedData);
                
    //         if($getRewardTypeData)
    //         {
    //                     echo '<pre>';
    //       //  print_r($getRewardTypeData);
    //         // return 'claimed';   
    //         }
    //         if($getUnclaimedData)
    //         {
    //         echo '<pre>';
    //       // print_r($getUnclaimedData);
    //         }
            
    //     }
    //     die;
        
        
        
        
        
        
        $rewardType = RewardType::all();
        if($rewardType->count() > 0){
            // dd($rewardType->count());
            $listReward = RewardType::all();
            
            // $rewardId = $rewardType->id;
            // $checkClaim = RewardPoint::find($rewardId,);
            // $today = $todayTime = Carbon::now()->timestamp;
            // foreach($checkClaim as $$checkClaimed){
            //     // if()
            // }
            $listReward = RewardType::all();
            $response = [
                'success' => true,
                'status' => 200,
                // 'claimed' : 'true'
                'data' => $listReward,
            ];
            return response()->json($response);
        }else{
            
            $response = [
                'success' => false,
                'status' => 404,
                'message' => 'No records found'
            ];

            return response()->json($response);
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
        $rewardType = RewardType::find($id);
        // var_dump($dailyreward);
        if($rewardType){
            $response = [
                'success' => true,
                'status' => 200,
                'data' => $rewardType
            ];
            return response()->json($response);
        }else{
            $response = [
                'success' => false,
                'status' => 404,
                'message' => 'No record found'
            ];
            return response()->json($response);
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
        if(auth('sanctum')->check()){
            $user_id = auth('sanctum')->user()->id;
            // dd($user_id);
            // $user = User::find($userId);

            // $user_id = $request->user_id;
            $rewardType_id = $request->reward_type_id;
            $users = User::find($user_id);
            $reward = RewardType::find($rewardType_id);
            $rewardPoint = $reward->reward_points;
            $rewardType = $reward->reward_type;
            $todayTime = Carbon::now()->timestamp;
            $yesterday = Carbon::yesterday()->timestamp;
            $tomorrow = Carbon::tomorrow()->timestamp;
            
            if($users && $reward){
                
                $todatStartDateTime = date('Y-m-d 00:00:00'); 
                $todatEndDateTime = date('Y-m-d 23:59:59'); 
                $todaydate = date('Y-m-d'); // '2023-04-08';
                $dayOfWeek = date('w', strtotime($todaydate));
                
                switch($reward->reward_type){
                    case 'weeklyreward' : 
                                if ($dayOfWeek != 6) {
                                $response = [
                                                'success' =>false,
                                                'satus' => 400,
                                                'message' => 'Today is not weekend.'
                                            ];
                                    return response()->json($response);
                                
                                }
                        break;
                }
                
                $rewardUser = RewardPoint::where('user_id', $request->user_id)->where('reward_type_id', $rewardType_id)->whereDate('created_at', '>=', $todatStartDateTime)->whereDate('created_at', '<=', $todatEndDateTime)->first();
                
                if(empty($rewardUser)){
                    $data = [
                        'user_id' => $user_id,
                        'reward_type_id' => $rewardType_id,
                        'reward_type' => $rewardType,
                        'reward_points' => $rewardPoint,
                    ];

                    $creteNew = RewardPoint::create($data);

                    $userPoints = $users->total_point_available;
                    $addTotal = $userPoints + $rewardPoint;
                    $users->total_point_available = $addTotal;
                    $updateUserPoint = $users->save();
                    
                    $response = [
                        'success' => true,
                        'status' => 200,
                        'data' => $creteNew
                    ];
                    return response()->json($response);
                }
                else{
                    $response = [
                        'success' =>false,
                        'satus' => 404,
                        'message' => $reward->reward_title.' already claimed'
                    ];
                    return response()->json($response);
                }
            }else{

                $response = [
                    'success' =>false,
                    'status' => 400,
                    'message' => "User or Daily Reward not found"
                ];
            
                return response()->json($response);
            }
        }else{
            $response = [
                'success' => false,
                'status' => 404,
                'message' => 'Invalid user'
            ];

            return response()->json($response);
        }
    }


    public function weeklyRewardPoints(Request $request){
        $getData = $request->all();

        $user_id = $request->user_id;
        $rewardType_id = $request->reward_type_id;
        $users = User::find($user_id);
        $reward = RewardType::find($rewardType_id);
        $rewardPoint = $reward->reward_points;
        $rewardType = $reward->reward_type;

        $todayTime = Carbon::now()->timestamp;
        $yesterday = Carbon::yesterday()->timestamp;
        $tomorrow = Carbon::tomorrow()->timestamp;

        if($users && $reward){

            $todayDate = new DateTime();
            $todayDate->format("Y-m-d");
           
            $rewardUser = RewardPoint::where('user_id', $request->user_id)->first();
            
            if($rewardUser == ""){
                // $weeklyrewardDate = $rewardUser->weekly_reward_time;
                // $parseWeekDay = Carbon::parse($todayTime);
                // $demoweeked = 
                $parseWeekDay = Carbon::parse($todayDate);
                // $parsedToday = Carbon::parse($todayTime);
                // $parseUserDate = Carbon::parse($weeklyrewardDate);
                // $wekend = '2023-03-26';
                // $parseWeekDay1 = Carbon::parse($wekend);
                // dd($parseWeekDay->isWeekend());
                if($parseWeekDay->isWeekend() && ((int)$yesterday < (int)$todayTime) && ((int)$tomorrow > (int)$todayTime)){

                    $data = [
                        'user_id' => $user_id,
                        'reward_type_id' => $rewardType_id,
                        'reward_type' => $rewardType,
                        'reward_points' => $rewardPoint,
                    ];
    
                    $creteNew = RewardPoint::create($data);
    
                    $userPoints = $users->total_point_available;
                    $addTotal = $userPoints + $rewardPoint;
                    $users->total_point_available = $addTotal;
                    $updateUserPoint = $users->save();
                    
                    $response = [
                        'success' => true,
                        'status' => 200,
                        'data' => $creteNew
                    ];
    
                    return response()->json($response);

                }else{
                
                    $response = [
                        'success' => false,
                        'status' => 404,
                        'message' => 'Claim this reward on weekend'
                    ];

                return response()->json($response);
                }
                
            }else{
                // if user already exist in Dailyrewardpoint table 
                // $weeklyrewardDate = $rewardUser->weekly_reward_time;
                // $parseUserDate = Carbon::parse($weeklyrewardDate);

                $parseWeekDay = Carbon::parse($todayDate);
                
                // test with old data
                // $wekend = '2023-04-01';
                // $oldWeekDay = Carbon::parse($wekend);
                if($parseWeekDay->isWeekend()){
                    // dd("is weekend");

                    $data = [
                        'user_id' => $user_id,
                        'reward_type_id' => $rewardType_id,
                        'reward_type' => $rewardType,
                        'reward_points' => $rewardPoint,
                    ];
    
                    $creteNew = RewardPoint::create($data);

                    $userPoints = $users->total_point_available;
                    $addTotal = $userPoints + $rewardPoint;
                    $users->total_point_available = $addTotal;
                    $updateUserPoint = $users->save();

                    $response = [
                        'success' => true,
                        'status' => 200,
                        'data' => $creteNew
                    ];
    
                    return response()->json($response);
                }else{
                    // dd("not weeked");
                   
                    $response = [
                        'success' => false,
                        'status' => 404,
                        'message' => 'Claim reward on weekend'
                    ];

                    return response()->json($response);
                }
                
                

            }
            
        }else{

            $response = [
                'success' => false,
                'status' => 404,
                'message' => "User or Daily Reward not found"
            ];
           
            return response()->json($response);
        }

    }
}
