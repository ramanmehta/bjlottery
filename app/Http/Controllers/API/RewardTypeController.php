<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\CashTransaction;
use App\Models\PointTransaction;
use Illuminate\Http\Request;
use App\Models\RewardType;
use App\Models\User;
use App\Models\RewardPoint;
use App\Models\UserBankDetails;
use Illuminate\Support\Carbon;
use DateTime;
use Illuminate\Support\Facades\DB;

class RewardTypeController extends Controller
{
    public function index()
    {
        $userId = auth('sanctum')->user()->id;

        $rewardType = RewardType::where('status', 1)->get();

        $rewardTypesArr = [];

        foreach ($rewardType as $value) {

            $reward_type_id = $value->id;

            if ($value->reward_type == 'weeklyreward') {

                $exists = RewardPoint::where('user_id', $userId)
                    ->where('reward_type_id', $reward_type_id)
                    ->whereDate('created_at', date('Y-m-d', strtotime("last Saturday")))
                    ->exists();

                if (date('l', time()) == 'Saturday' && !$exists) {

                    $value->claimed = 0;
                } else {

                    $value->claimed = 1;
                }
            } else if ($value->reward_type == 'dailyreward') {

                $getReward  = DB::table('reward_points')
                    ->where('user_id', $userId)
                    ->where('reward_type_id', $reward_type_id)
                    ->whereBetween('created_at', [date('Y-m-d 00:00:00'), date('Y-m-d 23:59:59')])
                    ->exists();

                $extraPoints = User::where('refered_by', $userId)->count();

                $value->reward_points = $value->reward_points + $extraPoints;
                
                if ($getReward) {

                    // $start = \Carbon\Carbon::now()->addDays(-1)->format('Y-m-d 00:00:00');
                    // $end = \Carbon\Carbon::now()->addDays(-1)->format('Y-m-d 23:59:59');

                    //$userIds = User::where('refered_by', $userId)->pluck('id')->toArray();

                    
                    // $extraPoints = RewardPoint::whereIn('user_id', $userIds)
                    //     ->where('reward_type', 'dailyreward')
                    //     ->whereBetween('created_at', [$start, $end])
                    //     ->count();


                    $value->claimed = 1;
                } else {

                    $value->claimed = 0;
                }
            } else {

                $bool = RewardPoint::where('user_id', $userId)
                    ->where('reward_type_id', $reward_type_id)
                    ->exists();

                if ($bool) {
                    $value->claimed = 1;
                } else {
                    $value->claimed = 0;
                }
            }

            $rewardTypesArr[] = $value;
        }

        if (isset($rewardTypesArr) && !empty($rewardTypesArr)) {

            $response = [
                'success' => true,
                'status' => 200,
                'data' => $rewardTypesArr,
            ];

            return response()->json($response);
        } else {

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
        if ($rewardType) {
            $response = [
                'success' => true,
                'status' => 200,
                'data' => $rewardType
            ];
            return response()->json($response);
        } else {
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
        $user_id = $request->user_id;
        $rewardType_id = $request->reward_type_id;
        $users = User::find($user_id);

        $reward = RewardType::find($rewardType_id);
        $rewardPoint = $reward->reward_points;
        $rewardType = $reward->reward_type;
        $todayTime = Carbon::now()->timestamp;
        $yesterday = Carbon::yesterday()->timestamp;
        $tomorrow = Carbon::tomorrow()->timestamp;

        $extraPoints = 0;

        if ($reward->reward_type == 'dailyreward') {

            // $start = \Carbon\Carbon::now()->addDays(-1)->format('Y-m-d 00:00:00');
            // $end = \Carbon\Carbon::now()->addDays(-1)->format('Y-m-d 23:59:59');

            // $userIds = User::where('refered_by', $user_id)->pluck('id')->toArray();

            $extraPoints = User::where('refered_by', $user_id)->count();

            // $extraPoints = RewardPoint::whereIn('user_id', $userIds)
            //     ->where('reward_type', 'dailyreward')
            //     ->whereBetween('created_at', [$start, $end])
            //     ->count();
        }

        if ($users && $reward) {

            $todatStartDateTime = date('Y-m-d 00:00:00');
            $todatEndDateTime = date('Y-m-d 23:59:59');
            $todaydate = date('Y-m-d'); // '2023-04-08';
            $dayOfWeek = date('w', strtotime($todaydate));
            switch ($reward->reward_type) {
                case 'weeklyreward':
                    if ($dayOfWeek != 6) {
                        $response = [
                            'success' => false,
                            'satus' => 400,
                            'message' => 'Today is not weekend.'
                        ];
                        return response()->json($response);
                    }
                    break;
            }

            $rewardUser = RewardPoint::where('user_id', $request->user_id)
                ->where('reward_type_id', $rewardType_id)
                ->whereDate('created_at', '>=', $todatStartDateTime)
                ->whereDate('created_at', '<=', $todatEndDateTime)
                ->first();

            if (empty($rewardUser)) {

                PointTransaction::create([
                    'user_id' => $user_id,
                    'title' => $reward->reward_title,
                    'type' => $reward->reward_type,
                    'points' => $rewardPoint + $extraPoints,
                    'status' => 1,
                ]);

                $data = [
                    'user_id' => $user_id,
                    'reward_type_id' => $rewardType_id,
                    'reward_type' => $rewardType,
                    'reward_points' => $rewardPoint + $extraPoints,
                ];

                $creteNew = RewardPoint::create($data);

                $userPoints = $users->total_point_available;
                $addTotal = $userPoints + ($rewardPoint + $extraPoints);
                $users->total_point_available = $addTotal;
                $updateUserPoint = $users->save();

                $response = [
                    'success' => true,
                    'status' => 200,
                    'data' => $creteNew
                ];
                return response()->json($response);
            } else {
                $response = [
                    'success' => false,
                    'satus' => 400,
                    'message' => $reward->reward_title . ' already claimed'
                ];
                return response()->json($response);
            }
        } else {

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

        $user_id = $request->user_id;
        $rewardType_id = $request->reward_type_id;
        $users = User::find($user_id);
        $reward = RewardType::find($rewardType_id);
        $rewardPoint = $reward->reward_points;
        $rewardType = $reward->reward_type;

        $todayTime = Carbon::now()->timestamp;
        $yesterday = Carbon::yesterday()->timestamp;
        $tomorrow = Carbon::tomorrow()->timestamp;

        if ($users && $reward) {

            $todayDate = new DateTime();
            $todayDate->format("Y-m-d");

            $rewardUser = RewardPoint::where('user_id', $request->user_id)->first();

            if ($rewardUser == "") {
                // $weeklyrewardDate = $rewardUser->weekly_reward_time;
                // $parseWeekDay = Carbon::parse($todayTime);
                // $demoweeked = 
                $parseWeekDay = Carbon::parse($todayDate);
                // $parsedToday = Carbon::parse($todayTime);
                // $parseUserDate = Carbon::parse($weeklyrewardDate);
                // $wekend = '2023-03-26';
                // $parseWeekDay1 = Carbon::parse($wekend);
                // dd($parseWeekDay->isWeekend());
                if ($parseWeekDay->isWeekend() && ((int)$yesterday < (int)$todayTime) && ((int)$tomorrow > (int)$todayTime)) {

                    PointTransaction::create([
                        'user_id' => $user_id,
                        'title' => 'Weekly Reward',
                        'type' => 'weekly_reward',
                        'points' => $rewardPoint,
                        'status' => 1,
                    ]);

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
                } else {

                    $response = [
                        'success' => false,
                        'status' => 404,
                        'message' => 'Claim this reward on weekend'
                    ];

                    return response()->json($response);
                }
            } else {
                // if user already exist in Dailyrewardpoint table 
                // $weeklyrewardDate = $rewardUser->weekly_reward_time;
                // $parseUserDate = Carbon::parse($weeklyrewardDate);

                $parseWeekDay = Carbon::parse($todayDate);

                // test with old data
                // $wekend = '2023-04-01';
                // $oldWeekDay = Carbon::parse($wekend);
                if ($parseWeekDay->isWeekend()) {
                    // dd("is weekend");

                    PointTransaction::create([
                        'user_id' => $user_id,
                        'title' => 'Weekly Reward',
                        'type' => 'weekly_reward',
                        'points' => $rewardPoint,
                        'status' => 1,
                    ]);

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
                } else {
                    // dd("not weeked");

                    $response = [
                        'success' => false,
                        'status' => 404,
                        'message' => 'Claim reward on weekend'
                    ];

                    return response()->json($response);
                }
            }
        } else {

            $response = [
                'success' => false,
                'status' => 404,
                'message' => "User or Daily Reward not found"
            ];

            return response()->json($response);
        }
    }

    public function rewardTransaction(Request $request)
    {
        $res = PointTransaction::where('user_id', auth()->id())
            ->when(isset($request->month), function ($q) use ($request) {
                $q->whereMonth('created_at', $request->month);
            })
            ->when(isset($request->year), function ($q) use ($request) {
                $q->whereYear('created_at', $request->year);
            })
            ->select(
                'id',
                'user_id',
                'title',
                'type',
                'points',
                'status',
                'created_at'
            )
            ->orderBy('id', 'desc')
            ->get();

        $resource = [
            'success' => true,
            'message' => 'Reward point transaction history list',
            'data' => $res
        ];

        return response()->json($resource);
    }
}
