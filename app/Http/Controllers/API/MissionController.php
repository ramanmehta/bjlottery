<?php

namespace App\Http\Controllers\API;

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
        // with(['missionLevels'])
        if (auth('sanctum')->check()) {
            $userId = auth('sanctum')->user()->id;
            $mission = Mission::with(['missionSubmission' => function ($query,$userId) {
                $query->where('user_id', $userId);
            }])->where('status',1)->get();
            if($mission->count() > 0){
                return response()->json([
                    'status' => 200,
                    'mission' => $mission,
                ], 200);
            }else{
                return response()->json([
                    'status' => 404,
                    'message' => 'No record found',
                ], 404);
            }
        }else{
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
        if($mission){
            return response()->json([
                'status' => 200,
                'Mission' => $mission
            ], 200);
        }else{
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
}
