<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Mission;
use App\Models\MissionLevel;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use App\Models\MissionSubmission;
use Illuminate\Auth\Events\Validated;

class MissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user_id = $request->input('user_id');
        if ($user_id) {
            $mission = Mission::where('missions.status', 1)->get();
            if ($mission->count() > 0) {
                $missionData = [];
                foreach ($mission as $missions) {
                    $missionsCount = MissionSubmission::where('mission_id', $missions->id)->where('user_id', $user_id)->count();
                    if ($missionsCount > 0) {
                        $approvalStatus = MissionSubmission::where('mission_id', $missions->id)->where('user_id', $user_id)->first();
                        $approval_status = $approvalStatus->approval_status;
                    } else {
                        $approval_status = "";
                    }
                    $missionData[] = [
                        'id' => $missions->id,
                        'mission_title' => $missions->mission_title,
                        'mission_description' => $missions->mission_description,
                        'mission_proof_type' => $missions->mission_proof_type,
                        'number_of_share' => $missions->number_of_share,
                        'referral_apoint' => $missions->per_share_point,
                        'approval_status' => $approval_status,
                        'created_at' => $missions->created_at,
                        'updated_at' => $missions->updated_at,
                        'banner_image' => $missions->banner_image
                    ];
                }
                return response()->json([
                    'status' => 200,
                    'mission' => $missionData,
                ], 200);
            } else {
                return response()->json([
                    'status' => 404,
                    'message' => 'No record found',
                ], 404);
            }
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'No record found',
            ], 404);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $mission = Mission::find($id);
        if ($mission) {
            return response()->json([
                'status' => 200,
                'Mission' => $mission
            ], 200);
        } else {
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

    public function list(Request $request, $id = null)
    {
        $mission = Mission::where('status', 1)
            ->select(
                'id',
                'mission_title',
                'mission_description',
                'banner_image',
                'mission_type',
                'enter_earn_affliated_points',
                'prize_name',
                'prize_image'
            )
            ->when(!is_null($id), function ($q) use ($id) {
                $q->where('id', $id);
            })
            ->orderBy('id', 'desc')
            ->get();

        return response()->json([
            'status' => 200,
            'Message' => 'Mission list',
            'data' => $mission
        ], 200);
    }

    public function missionSubmit(Request $request)
    {
        $validated = \Validator::make($request->all(), [
            'image' => 'required_without:video|image|mimes:jpeg,jpg,gif,png',
            'video' => 'required_without:image|mimes:mp4,mov,ogg,qt|max:10240',
            'mission_id' => 'required'
        ]);

        $input = $validated->validate();

        if (isset($input['image'])) {

            $data['proof'] = 'missions/' . time() . '.' . $request->image->extension();

            $request->image->storeAs('public/images', $data['proof']);
        } else {

            $fileName = $request->video->getClientOriginalName();

            $data['proof'] = 'missions/' . $fileName;

            $request->video->storeAs('public/images', $data['proof']);
        }

        MissionSubmission::create([
            'mission_id' => $input['mission_id'],
            'proof' => $data['proof'],
            'user_id' => auth()->id(),
            'approval_status' => 'submit'
        ]);

        return response()->json([
            'status' => 200,
            'Message' => 'Mission Submited successfully',
            'data' => []
        ], 200);
    }
}
