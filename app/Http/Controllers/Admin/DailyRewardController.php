<?php

namespace App\Http\Controllers\admin;

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
        $dailyReward = DailyReward::all();

        return view('admin.daily_rewards.index', ['dailyReward' => $dailyReward]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        return view('admin.daily_rewards.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'reward_types' => 'bail|string|required|max:255|unique:daily_rewards',
            'reward_points' => 'bail|integer|required',
            'status' => 'required'
        ]);

        $role = DailyReward::create($request->all());

        return redirect('DailyRewards')->with('success', "New reward created successfully");
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $rewardid = decrypt($id);

        $dailyReward = DailyReward::where('id', $rewardid)->first();

        return view('admin.daily_rewards.edit', ['dailyReward' => $dailyReward]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $rewardid = decrypt($id);

        $request->validate([
            'reward_types' => 'bail|string|required|max:255',
            'reward_points' => 'bail|integer|required',
            'status' => 'required'
        ]);
        $dailyReward = DailyReward::where('id', $rewardid)->first();
        $dailyReward->reward_types = $request->reward_types;
        $dailyReward->reward_points = $request->reward_points;
        $dailyReward->status = $request->status;
        $dailyReward->save();

        return redirect('DailyRewards')->with('success', "Reward updated successfully");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $dailyRewardid = (int)decrypt($id);

        $deleteRole = DailyReward::where('id', $dailyRewardid)->delete();

        return redirect('DailyRewards')->with('error', "Reward removed successfully");
    }
}
