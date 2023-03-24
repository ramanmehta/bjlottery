<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\LuckyDrawGames;
use Illuminate\Http\Request;

class LuckyDrawGamesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       
        $luckydraw = LuckyDrawGames::all();
        if($luckydraw->count() > 0){
            return response()->json([
                'status' => 200,
                'luckydraw' => $luckydraw,
            ], 200);
        }else{
            return response()->json([
                'status' => 404,
                'message' => 'No record found'
            ],404);
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

        $luckydraw = LuckyDrawGames::find($id);
        if($luckydraw){
            return response()->json([
                'status' => 200,
                'luckydraw' => $luckydraw
            ], 200);
        }else{
            return response()->json([
                'status' => 404,
                'message' => 'No record found'
            ],404);
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
