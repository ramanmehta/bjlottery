<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RewardType;
use Validator;
use DB;


class RewardTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if($request->has('search')){

            $search = $request->search;
          
            $rewardType = DB::table('reward_types')
                ->where('reward_type' , 'LIKE' , '%'.$search.'%')
                ->orWhere('reward_title' , 'LIKE' , '%'.$search.'%')
                ->orWhere('reward_description' , 'LIKE' , '%'.$search.'%')
                ->orWhere('reward_points' , 'LIKE' , '%'.$search.'%')
                ->paginate(2);           
        
            }else{
              
                // $rewardType = RewardType::all();
                $rewardType = RewardType::orderBy('id', 'DESC')->paginate(2);
            
            }
        
    
        return view('admin.reward_type.index',['rewardType' => $rewardType]);
    }

    /**
     * Show the form for creating a new resource.
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
        // dd($request->all());
        $request->validate([
            'reward_title' => 'bail|string|required|max:255',
            'reward_type' => 'bail|string|required|max:255',
            'reward_description' => 'bail|string|required',
            'reward_points' => 'bail|integer|required',
            'status' => 'required'
        ]);
        // dd($request->all());
        $newRewardType = RewardType::create($request->all());

        $success = "New reward created successfully";

        return redirect('/admin/viewRewardType')->with('success',$success);
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
        $reward_id = decrypt($id);
        $rewardType = RewardType::where('id', $reward_id)->first();

        return view('admin.reward_type.edit', ['rewardType'=>$rewardType]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
       
        $reward_id = decrypt($id);
        
        $request->validate([
            'reward_type' => 'bail|string|required|max:255',
            'reward_title' => 'bail|string|required|max:255',
            'reward_description' => 'bail|string|required',
            'reward_points' => 'bail|integer|required',
            'status' => 'required'
        ]);
        // dd($request->all());
        $rewardType = RewardType::where('id', $reward_id)->first();
        $rewardType->reward_type = $request->reward_type;
        $rewardType->reward_title = $request->reward_title;
        $rewardType->reward_description = $request->reward_description;
        $rewardType->reward_points = $request->reward_points;
        $rewardType->status = $request->status;
        $rewardType->save();
        $success = "Reward updated successfully";
        return redirect('/admin/viewRewardType')->with('success',$success);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $reward_id = (int)decrypt($id);
    
        $deleteReward = RewardType::where('id' , $reward_id)->first();
        $deleteReward->delete();

        $success = "Reward removed successfully";
        return redirect('/admin/viewRewardType')->with('success',$success);
    }
}
