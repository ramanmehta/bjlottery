<?php

namespace App\Http\Controllers\admin;

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
        $luckyDraw = LuckyDrawGames::all();
        //dd($luckyDraw);
        return view('admin.lucky_draw.index',['luckyDraw' => $luckyDraw]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.lucky_draw.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //dd($request->all());
        $request->validate([
            'game_title' => 'bail|string|required|max:255|unique:lucky_draw_games',
            //'game_description' => 'bail|string|required',
            'winning_prize_amount' => 'integer|required',
            'min_point' => 'integer|required',
            'max_point' => 'integer|required',
            'start_date_time' => 'required',
            'end_date_time' => 'required',
            'game_point' => 'required',
            'status' => 'required'
        ]);

        // $imageName = time().'.'.$request->image->extension(); 
        // $request->image->move(public_path('images'), $imageName);
        
        $lucyDraw = LuckyDrawGames::create($request->all());

        $success = "New Lucky Draw created successfully";
        return redirect('/admin/viewLuckyDraw')->with('success',$success);

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
        $luckyDrawid = decrypt($id);
    
        $luckyDraw = LuckyDrawGames::findOrFail($luckyDrawid); 
    
        return view('admin.lucky_draw.edit', ['luckyDraw'=>$luckyDraw]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // dd($request->all());
        $request->validate([
            // 'game_title' => 'bail|string|required|max:255',
            'game_description' => 'bail|string|required',
            'winning_prize_amount' => 'integer|required',
            'min_point' => 'integer|required',
            'max_point' => 'integer|required',
            'start_date_time' => 'required',
            'end_date_time' => 'required',
            'game_point' => 'required',
            'status' => 'required'
        ]);
        $luckyDrawid = decrypt($id);
        
        $luckyDraw  = LuckyDrawGames::findOrFail($luckyDrawid);
        // $luckyDraw->game_title = $request->game_title;
        $luckyDraw->game_description = $request->game_description;
        $luckyDraw->game_image = $request->game_image;
        $luckyDraw->winning_prize_amount = $request->winning_prize_amount ;
        $luckyDraw->min_point = $request->min_point;
        $luckyDraw->max_point = $request->max_point;
        $luckyDraw->start_date_time = $request->start_date_time;
        $luckyDraw->end_date_time = $request->end_date_time;
        $luckyDraw->game_point = $request->game_point;
        $luckyDraw->status = $request->status;

        $luckyDraw->save();
        $success = "Lucky draw updated successfully";
        return redirect('/admin/viewLuckyDraw')->with('success',$success);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $luckyDrawid = decrypt($id);
        // dd($luckyDrawid);
        $deleteLuckyDraw  = LuckyDrawGames::findOrFail($luckyDrawid);
        $deleteLuckyDraw->delete();

        $error = "Luck Draw removed successfully";
        return redirect('/admin/viewLuckyDraw')->with('error',$error);
    }
}