<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Mission;
use APp\Models\UserReward;

class MissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $mission = Mission::all();
        if($mission->count() > 0){
            return response()->json([
                'status' => 200,
                'mission' => $mission,
            ], 200);
        }else{
            return response()->json([
                'status' => 404,
                'message' => 'No record found',
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
    public function show(string $id)
    {
        $mission = Mission::find($id);
        if($mission){
            return response()->json([
                'status' => 200,
                'Mission' => $mission
            ], 200);
        }else{
            return response()->json([
                'status' => 404,
                'Message' => 'No record found',
            ], 404);
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

    public function userMission(Request $request, $id)
    {

            $checkMission = Mission::where('id', $id)->count();
            // dd($checkReferal);
            if ($checkMission == 1) {
                $getMission = Mission::where('id', $id)->first();
                $title = $getMission->mission_title;
                $totalShare = $getMission->number_of_share;
                $rewardName = $getMission->mission_title;
                $perSharepoint = $getMission->per_share_point;
                $startDate = $getMission->mission_start_date;
                $endDate = $getMission->mission_end_date;
                $userid = decrypt($id); 
                
                $validator = Validator::make($request->all(), [
                    'missionImage' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048|dimensions:min_width=10,min_height=10,max_width=1000,max_height=1000',
                ]);
        
                $image = $request->file('mission_image');
                if($image != null){
                    $randomNumber = rand();
                    $imageName = $randomNumber.$image->getClientOriginalName();  
                    //$image->storeAs('public/images/luckydraw',$imageName);
                    $image->storeAs($this->filepath().'/usermission',$imageName);
                
                }
                $level = Mission::where('id', $id)->count();
                $rewardType = 'mission';
                
                $data = [
                    'user_id' => $userid,
                    'level' => $level,
                    'reward_type' => $rewardType,
                    'reward_name' => $rewardName,
                    'reward_point' => $perSharepoint
                ];
            
                $createReward = UserReward::create($data);

                $countMission = UserReward::where('reward_name', $rewardName)->count();

                $response = [
                    'success' => true,
                    'status' => 200,
                    'data' => $rewardName
                ];

                return response()->json($response);

            } else {
                $response = [
                    'success' => false,
                    'status' => 400,
                    'message' => 'Referal code not exists'
                ];
                return response()->json($response);
            }

        
    }
}
