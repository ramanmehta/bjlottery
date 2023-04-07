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

        $data = $request->daterange;
        $startdate=substr($data, 0, 19);
        $enddate = substr($data, strpos($data, "-") + 1);
        // dd($enddate );

         $request->validate([
            'mission_title' => 'bail|string|required|max:255|unique:missions',
            'mission_description' => 'bail|string|required',
            'mission_proof_type' => 'bail|string|required',
            'number_of_share' => 'integer|required',
            'per_share_point' => 'integer|required',
            'daterange' => 'required',
            // 'mission_start_date' => 'required',
            // 'mission_end_date' => 'required',
            'status' => 'required'
        ]);

        // $imageName = time().'.'.$request->image->extension(); 
        // $request->image->move(public_path('images'), $imageName);

        $missionData = [
            'mission_title' => $request->mission_title,
            'mission_description'=>$request->mission_description,
            'mission_proof_type'=>$request->mission_proof_type,
            'number_of_share' => $request->number_of_share,
            'per_share_point' => $request->per_share_point,
            'mission_start_date' =>$startdate,
            'mission_end_date' => $enddate,
            'status' =>$request->status
        ];
        
        $mission = Mission::create($missionData);

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
        $startDate = $mission->start_date_time;
        $endDate = $mission->end_date_time;
        $dateRange = $startDate . ' - ' . $endDate;
    
        return view('admin.missions.edit', ['mission'=>$mission , 'dateRange' => $dateRange ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // dd($request->all());
        $data = $request->daterange;
        $startdate=substr($data, 0, 19);
        $enddate = substr($data, strpos($data, "-") + 1);
        $request->validate([
            // 'mission_title' => 'bail|string|required|max:255',
            'mission_description' => 'bail|string|required',
            'mission_proof_type' => 'bail|string|required',
            'number_of_share' => 'integer|required',
            'per_share_point' => 'integer|required',
            // 'mission_start_date' => 'required',
            // 'mission_end_date' => 'required',
            'daterange' => 'required',
            'status' => 'required'
        ]);

        $missionid = decrypt($id);
        
        $mission = Mission::findOrFail($missionid);
        // $mission->game_title = $request->game_title;
        $mission->mission_description = $request->mission_description;
        $mission->mission_proof_type = $request->mission_proof_type;
        $mission->number_of_share = $request->number_of_share ;
        $mission->per_share_point = $request->per_share_point;
        $mission->mission_start_date = $startdate;
        $mission->mission_end_date = $enddate;
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
