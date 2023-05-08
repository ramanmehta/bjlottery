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
                ->paginate(10);           
        
            }else{
              
                // $rewardType = RewardType::all();
                $rewardType = RewardType::orderBy('id', 'DESC')->paginate(10);
            
            }
        
    
        return view('admin.reward_type.index',['rewardType' => $rewardType]);
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

        $data = [
            'reward_title' => $reward_title,    
            'reward_type' => $reward_type,
            'reward_description' => $request->reward_description,
            'reward_points' => $request->reward_points,
            'status' => $request->status
        ];

        $newRewardType = RewardType::create($data);

        $success = "New reward created successfully";

        return redirect('/admin/viewRewardType')->with('success',$success);
    }

    public function rewardStatus(Request $request , $id){
        $reward_id = decrypt($id);
        $reward = RewardType::find($reward_id);
        $status = $reward->status;

        if($status == 1){
           
            $deactivate = $reward->status = '0';
           
            $reward->save();

            $rewardStatus = RewardType::where('id', $reward_id)->update([
                'status' => $deactivate
            ]);
            $success = "Rewad deactivated successfully";
            return redirect('/admin/viewRewardType')->with('success',$success);
            
        }else{
            $activated = $reward->status = '1';
           
            $reward->save();

            $rewardStatus = RewardType::where('id', $reward_id)->update([
                'status' => $activated
            ]);
            $success = "Reward activated successfully";
            return redirect('/admin/viewRewardType')->with('success',$success);
        }
        
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
            'reward_type' => 'bail|string|required|max:255|unique:reward_types,reward_type,'.$reward_id,
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
