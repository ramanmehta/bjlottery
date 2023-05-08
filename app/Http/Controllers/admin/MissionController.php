<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Mission;
use DB;

class MissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if($request->has('search')){

            $search = $request->search;
            // $user = User::search($request->search)->get();
            $mission = DB::table('missions')
                ->where('mission_title' , 'LIKE' , '%'.$search.'%')
                ->orWhere('mission_description' , 'LIKE' , '%'.$search.'%')
                ->orWhere('mission_proof_type' , 'LIKE' , '%'.$search.'%')
                ->orWhere('number_of_share' , 'LIKE' , '%'.$search.'%')
                ->orWhere('mission_start_date' , 'LIKE' , '%'.$search.'%')
                ->paginate(10);
                
        }else{

            $mission = Mission::orderBy('id', 'DESC')->paginate(10);

        }
        
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
        $image = $request->file('banner_image');
        if($image != null){
            $validate = [
                'mission_title' => 'bail|string|required|max:255|unique:missions',
                'mission_description' => 'bail|string|required',
                'mission_proof_type' => 'bail|string|required',
                'number_of_share' => 'integer|required',
                'per_share_point' => 'integer|required',
                //'referal_code' => 'string|required|unique:missions',
                // 'daterange' => 'required',
                // 'mission_start_date' => 'required',
                // 'mission_end_date' => 'required',
                'status' => 'required',
                'banner_image' => 'mimes:jpeg,jpg,png,gif',
            ];
        }else{
            $validate = [
                'mission_title' => 'bail|string|required|max:255|unique:missions',
                'mission_description' => 'bail|string|required',
                'mission_proof_type' => 'bail|string|required',
                'number_of_share' => 'integer|required',
                'per_share_point' => 'integer|required',
                //'referal_code' => 'string|required|unique:missions',
                // 'daterange' => 'required',
                // 'mission_start_date' => 'required',
                // 'mission_end_date' => 'required',
                'status' => 'required'
            ];
        }

        $request->validate($validate);

        // $imageName = time().'.'.$request->image->extension(); 
        // $request->image->move(public_path('images'), $imageName);
        // If the validation passes, move the uploaded file to the public folder and generate a unique name for it
        if($image != null){
            $randomNumber = rand();
            $imageName = time() . '.' . $request->banner_image->extension();
            $image->storeAs('public/images/missions',$imageName);
        }
        

        // Save the image path to the database
        
        $imagePath = 'storage/images/' . $imageName;


        $missionData = [
            'mission_title' => $request->mission_title,
            'mission_description'=>$request->mission_description,
            'mission_proof_type'=>$request->mission_proof_type,
            'number_of_share' => $request->number_of_share,
            'per_share_point' => $request->per_share_point,
            //'referal_code' => $request->referal_code,
            // 'mission_start_date' =>$startdate,
            // 'mission_end_date' => $enddate,

            'status' =>$request->status
        ];
        
        $mission = Mission::create($missionData);

        if (!empty($image)) {
            $mission->banner_image = '/missions/'.$imageName;
        }else{
            if(!empty($mission->banner_image)){
                $mission->banner_image = $mission->banner_image;
            }else{
                $mission->banner_image = "/missions/mission.png";
            }
        }
        $mission->save();
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

    public function missionStatus(Request $request , $id){
        $mission_id = decrypt($id);
        $mission = Mission::find($mission_id);
        $status = $mission->status;

        if($status == 1){
           
            $deactivate = $mission->status = '0';
           
            $mission->save();

            $missionStatus = Mission::where('id', $mission_id)->update([
                'status' => $deactivate
            ]);
            $success = "Mission deactivated successfully";
            return redirect('/admin/viewMission')->with('success',$success);
            
        }else{
            $activated = $mission->status = '1';
           
            $mission->save();

            $missionStatus = Mission::where('id', $mission_id)->update([
                'status' => $activated
            ]);
            $success = "Mission activated successfully";
            return redirect('/admin/viewMission')->with('success',$success);
        }
        
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
        $image = $request->file('banner_image');
        if($image != null){
            $validate = [
                // 'mission_title' => 'bail|string|required|max:255|unique:missions',
                'mission_description' => 'bail|string|required',
                'mission_proof_type' => 'bail|string|required',
                'number_of_share' => 'integer|required',
                'per_share_point' => 'integer|required',
                //'referal_code' => 'string|required|unique:missions',
                // 'daterange' => 'required',
                // 'mission_start_date' => 'required',
                // 'mission_end_date' => 'required',
                // 'status' => 'required',
                'banner_image' => 'mimes:jpeg,jpg,png,gif',
            ];
        }else{
            $validate = [
                // 'mission_title' => 'bail|string|required|max:255|unique:missions',
                'mission_description' => 'bail|string|required',
                'mission_proof_type' => 'bail|string|required',
                'number_of_share' => 'integer|required',
                'per_share_point' => 'integer|required',
                //'referal_code' => 'string|required|unique:missions',
                // 'daterange' => 'required',
                // 'mission_start_date' => 'required',
                // 'mission_end_date' => 'required',
                // 'status' => 'required'
            ];
        }

        $request->validate($validate);

        $missionid = decrypt($id);
        
        $mission = Mission::findOrFail($missionid);
        // $mission->game_title = $request->game_title;
        $mission->mission_description = $request->mission_description;
        $mission->mission_proof_type = $request->mission_proof_type;
        $mission->number_of_share = $request->number_of_share ;
        $mission->per_share_point = $request->per_share_point;
        //$mission->referal_code = $request->referal_code;
        // $mission->mission_start_date = $startdate;
        // $mission->mission_end_date = $enddate;

        
        if($image != null){
            $randomNumber = rand();
            $imageName = time() . '.' . $request->banner_image->extension();
            $image->storeAs('public/images/missions',$imageName);
            $mission->banner_image = '/missions/'.$imageName;
        }else{
            if(!empty($mission->banner_image)){
                $mission->banner_image = $mission->banner_image;
            }else{
                $mission->banner_image = "/missions/mission.png";
            }
        }

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
