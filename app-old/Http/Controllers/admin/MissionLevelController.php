<?php

namespace App\Http\Controllers\admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MissionLevel;
use App\Models\Mission;
use Illuminate\Support\Facades\Validator;

class MissionLevelController extends Controller
{
    /**
     * Display a listing of the mission levels.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request,$id)
    {
        $id = decrypt($id);
        
        if($request->has('search')){

            // $search = $request->search;
            // $mission_levels = MissionLevel::with(['mission'=> function ($query,$search) {
            //     $query->where('game_title' , 'LIKE' , '%'.$search.'%')->orWhere('game_description' , 'LIKE' , '%'.$search.'%')->orWhere('level_title' , 'LIKE' , '%'.$search.'%')->orWhere('level_Sescription' , 'LIKE' , '%'.$search.'%');
            // }])->where('mission_id',$id)
            //     ->paginate(10);
            $search = $request->input('search');
            $mission_levels = MissionLevel::with('mission')
                // ->when($search, function ($query, $search) {
                //     $query->whereHas('mission', function ($query) use ($search) {
                //         $query->where('mission.game_title', 'LIKE', "%{$search}%")->orWhere('mission.game_description' , 'LIKE' , '%'.$search.'%');
                //     });
                // })
                ->where('mission_id',$id)
                ->where('level_title' , 'LIKE' , '%'.$search.'%')
                ->orWhere('level_description' , 'LIKE' , '%'.$search.'%')
                ->paginate(10);

        }else{
            $mission_levels = MissionLevel::with(['mission'])->where('mission_id',$id)->orderBy('id', 'DESC')->paginate(10);;
        }
        return view('admin.mission_level.index', compact('mission_levels'));
    }

    /**
     * Show the form for creating a new mission level.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $mission = Mission::where('status',1)->pluck('mission_title', 'id');
        
        return view('admin.mission_level.create',compact('mission'));
    }

    /**
     * Store a newly created mission level in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $requiredData['mission_id'] = 'integer|required';
        $requiredMessage['mission_id.integer'] = 'Please select a mission';

        $requiredMessage['mission_id.required'] = 'Please select a mission';
        
        $requiredData['level_title'] = 'required';
        $requiredMessage['level_title.required'] = 'Please enter level title';

        if(isset($request->all()['mission_id']) && !empty($request->all()['mission_id'])){
            $titeLEvel = MissionLevel::where('mission_id',$request->all()['mission_id'])->where('level_title',$request->all()['level_title'])->count();
            if($titeLEvel > 0){
                $requiredData['level_title'] = 'required';
                $requiredMessage['level_title.required'] = 'Level title aready exists with mission id';
            }
        }

        $requiredData['level_order'] = 'required|integer';
        $requiredMessage['level_order.required'] = 'Level Order is required';

        $requiredMessage['level_order.integer'] = 'Level Order should be only integer';

        if(isset($request->all()['level_order']) && !empty($request->all()['level_order']) ){
            $level_order = MissionLevel::where('mission_id',$request->all()['mission_id'])->where('level_order',$request->all()['level_order'])->count();
            if($level_order > 0 ){
                $requiredData['level_order'] = 'required';
                $requiredMessage['level_order.required'] = 'Level level order aready exists with mission';
            }
        }

        $requiredData['max_referals'] = 'required';
        $requiredMessage['max_referals.required'] = 'Max referrals is required';

        $requiredData['max_referals'] = 'integer';
        $requiredMessage['max_referals.integer'] = 'Max referrals should be only integer';
        
        $validator = Validator::make($requiredData, $requiredMessage);
        if($validator->fails()){
            $error = $validator->errors();
            return redirect('/admin/createLevels')->with('errors',$error);
        }else{
            try {
                $request->created_at = $request->updated_at = date('Y-m-d H:i:s',time());
                $mission_level = new MissionLevel;
                $mission_level->fill($request->all());       
                if($mission_level->save()){
                    $success = "Mission level added successfully";
                    return redirect('/admin/levels/'.encrypt($request->all()['mission_id']))->with('success',$success);
                }else{
                    $error = "Mission level not added";
                    return redirect('/admin/levels/'.encrypt($request->all()['mission_id']))->with('error',$error);
                }
            } catch (ValidationException $e) {
                $error = $e->errors();
                return redirect('/admin/levels/'.encrypt($request->all()['mission_id']))->with('error',$error);
            }
        }
        

        return redirect()->route('/admin/levels/'.encrypt($request->all()['mission_id']));
    }

    /**
     * Show the form for editing the specified mission level.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $id = decrypt($id);
        $mission_level = MissionLevel::findOrFail($id);
        $mission = Mission::where('status',1)->pluck('mission_title', 'id');
        return view('admin.mission_level.edit', compact('mission_level','mission'));
    }

    /**
     * Update the specified mission level in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        
        $id = decrypt($id);
        $mission_level = MissionLevel::findOrFail($id);
        $requiredData['mission_id'] = 'integer|required';
        $requiredMessage['mission_id.integer'] = 'Please select a mission';

        $requiredMessage['mission_id.required'] = 'Please select a mission';
        
        $requiredData['level_title'] = 'required';
        $requiredMessage['level_title.required'] = 'Please enter level title';

        if(isset($request->all()['mission_id']) && !empty($request->all()['mission_id'])){
            $titeLEvel = MissionLevel::where('mission_id',$request->all()['mission_id'])->where('level_title',$request->all()['level_title'])->count();
            if($titeLEvel > 0){
                $requiredData['level_title'] = 'required';
                $requiredMessage['level_title.required'] = 'Level title aready exists with mission id';
            }
        }

        $requiredData['level_order'] = 'required|integer';
        $requiredMessage['level_order.required'] = 'Level Order is required';

        $requiredMessage['level_order.integer'] = 'Level Order should be only integer';

        if(isset($request->all()['level_order']) && !empty($request->all()['level_order']) ){
            $level_order = MissionLevel::where('mission_id',$request->all()['mission_id'])->where('level_order',$request->all()['level_order'])->count();
            if($level_order > 0 ){
                $requiredData['level_order'] = 'required';
                $requiredMessage['level_order.required'] = 'Level level order aready exists with mission';
            }
        }

        $requiredData['max_referals'] = 'required';
        $requiredMessage['max_referals.required'] = 'Max referrals is required';

        $requiredData['max_referals'] = 'integer';
        $requiredMessage['max_referals.integer'] = 'Max referrals should be only integer';
        
        $validator = Validator::make($requiredData, $requiredMessage);
        if($validator->fails()){
            $error = $validator->errors();
            return redirect('/admin/createLevels')->with('errors',$error);
        }else{
            try {
                $request->updated_at = date('Y-m-d H:i:s',time());
                $mission_level = MissionLevel::find($id);
                $mission_level->fill($request->all());       
                if($mission_level->save()){
                    $success = "Mission level added successfully";
                    return redirect('/admin/levels/'.encrypt($request->all()['mission_id']))->with('success',$success);
                }else{
                    $error = "Mission level not added";
                    return redirect('/admin/levels/'.encrypt($request->all()['mission_id']))->with('error',$error);
                }
            } catch (ValidationException $e) {
                $error = $e->errors();
                return redirect('/admin/levels/'.encrypt($request->all()['mission_id']))->with('error',$error);
            }


            $mission_level->save();
            $success = "Mission level updated successfully";
            return redirect('/admin/levels/'.encrypt($id))->with('success',$success);
        }
       
        // return redirect()->route('admin.mission_level.index');
    }

    /**
     * Remove the specified mission level from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id,$mission_id)
    {
        $id = decrypt($id);
        $mission_level = MissionLevel::findOrFail($id);
        $mission_level->delete();
        $success = "Mission level deleted successfully";
        return redirect()->route('levels', ['id' => $mission_id])->with('success',$success);
    }
}
