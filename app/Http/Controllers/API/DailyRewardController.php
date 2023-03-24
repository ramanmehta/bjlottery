<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DailyReward;

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
}
