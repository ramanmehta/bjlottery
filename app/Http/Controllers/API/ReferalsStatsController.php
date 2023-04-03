<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ReferalsStats;

class ReferalsStatsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // dd("notification here");
        $referals = ReferalsStats::all();
        if($referals->count() > 0){
            return response()->json([
                'status' => 200,
                'referals' => $referals,
            ], 200);
        }else{
            return response()->json([
                'status' => 404,
                'message' => 'No records found',
            ], 404);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // dd('notification id');
        $referals = ReferalsStats::find($id);
        if($referals){
            return response()->json([
                'status' => 200,
                'Referals' => $referals,
            ], 200);
        }else{
            return response()->json([
                'status' => 404,
                'message' => 'No records found'
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
