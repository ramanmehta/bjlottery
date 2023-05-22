<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\RewardPoint;
use Illuminate\Http\Request;
use App\Models\RewardType;

class RewardTypesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $rewardType = RewardType::orderBy('id', 'DESC')
            ->when($request->has('search'), function ($q) use ($request) {
                $search = $request->search;
                $q->where('reward_type', 'LIKE', '%' . $search . '%')
                    ->orWhere('reward_title', 'LIKE', '%' . $search . '%')
                    ->orWhere('reward_description', 'LIKE', '%' . $search . '%')
                    ->orWhere('reward_points', 'LIKE', '%' . $search . '%');
            })
            ->paginate(10);

        return view('admin.reward_type.index', compact('rewardType'));
    }

    /**
     * Created new resource.
     */

    public function create()
    {
        return view('admin.reward_type.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'reward_title' => 'bail|string|required|max:255',
            'reward_type' => 'bail|string|required|max:255|unique:reward_types',
            'reward_description' => 'bail|string|required',
            'reward_points' => 'bail|integer|required|min:1',
            'status' => 'required'
        ]);

        $reward_title = ucwords(trim($request->reward_title));

        $reward = strtolower(trim($request->reward_type));
        $reward_type = str_replace(' ', '', $reward);

        RewardType::create([
            'reward_title' => $reward_title,
            'reward_type' => $reward_type,
            'reward_description' => $request->reward_description,
            'reward_points' => $request->reward_points,
            'status' => $request->status
        ]);

        return redirect()->route('RewardType')->with('success', "New reward created successfully");
    }

    public function rewardStatus(Request $request, $id)
    {
        $reward_id = decrypt($id);

        $reward = RewardType::find($reward_id);

        if ($reward->status == 1) {

            RewardType::where('id', $reward_id)
                ->update([
                    'status' => 0
                ]);

            return redirect()->route('RewardType')->with('success', 'Rewad deactivated successfully');
        } else {

            RewardType::where('id', $reward_id)
                ->update([
                    'status' => 1
                ]);

            return redirect()->route('RewardType')->with('success', 'Reward activated successfully');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $reward_id = decrypt($id);

        $rewardType = RewardType::where('id', $reward_id)->first();

        return view('admin.reward_type.edit', ['rewardType' => $rewardType]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $reward_id = decrypt($id);

        $request->validate([
            'reward_type' => 'bail|string|required|max:255|unique:reward_types,reward_type,' . $reward_id,
            'reward_title' => 'bail|string|required|max:255',
            'reward_description' => 'bail|string|required',
            'reward_points' => 'bail|integer|required|min:1',
        ]);

        $rewardType = RewardType::where('id', $reward_id)->first();
        $rewardType->reward_type = $request->reward_type;
        $rewardType->reward_title = $request->reward_title;
        $rewardType->reward_description = $request->reward_description;
        $rewardType->reward_points = $request->reward_points;
        $rewardType->save();

        return redirect()->route('RewardType')->with('success', "Reward updated successfully");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $reward_id = (int) decrypt($id);

        if (RewardPoint::where('reward_type_id', $reward_id)->exists()) {

            return redirect()->route('RewardType')->with('error', "Reward can't remove");
        }

        RewardType::where('id', $reward_id)->delete();

        return redirect()->route('RewardType')->with('success', "Reward removed successfully");
    }
}
