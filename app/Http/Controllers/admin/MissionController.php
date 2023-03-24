<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Mission;

class MissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $mission = Mission::all();
        return view('admin.missions.index', compact('mission'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.missions.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //  dd($request->all());
         $request->validate([
            'mission_title' => 'bail|string|required|max:255|unique:missions',
            'mission_description' => 'bail|string|required',
            'number_of_referals_required' => 'integer|required',
            'referal_unit_point' => 'integer|required',
            'referal_code' => 'integer|required|unique:missions',
            'mission_start_date' => 'required',
            'mission_end_date' => 'required',
            'status' => 'required'
        ]);

        // $imageName = time().'.'.$request->image->extension(); 
        // $request->image->move(public_path('images'), $imageName);
        
        $mission = Mission::create($request->all());

        $success = "New Mission created successfully";
        return redirect('/admin/viewMission')->with('success',$success);
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
        $missionid = decrypt($id);
    
        $mission = Mission::findOrFail($missionid); 
    
        return view('admin.missions.edit', ['mission'=>$mission]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // dd($request->all());
        $request->validate([
            // 'mission_title' => 'bail|string|required|max:255',
            'mission_description' => 'bail|string|required',
            'number_of_referals_required' => 'integer|required',
            // 'referal_unit_point' => 'integer|required',
            'referal_code' => 'integer|required',
            'mission_start_date' => 'required',
            'mission_end_date' => 'required',
            'status' => 'required'
        ]);

        $missionid = decrypt($id);
        
        $mission = Mission::findOrFail($missionid);
        // $mission->game_title = $request->game_title;
        $mission->mission_description = $request->mission_description;
        $mission->mission_proof_type = $request->mission_proof_type;
        $mission->number_of_referals_required = $request->number_of_referals_required ;
        $mission->referal_unit_point = $request->referal_unit_point;
        // $mission->referal_code = $request->referal_code;
        $mission->mission_start_date = $request->mission_start_date;
        $mission->mission_end_date = $request->mission_end_date;
        $mission->status = $request->status;

        $mission->save();
        $success = "Mission updated successfully";
        return redirect()->route('mission')->with('success',$success);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $missionid = decrypt($id);
        // dd($luckyDrawid);
        $mission = Mission::findOrFail($missionid);
        $mission->delete();

        $error = "Mission removed successfully";
        return redirect()->route('mission')->with('error',$error);
    }
}
