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
            'game_title' => 'bail|string|required|max:255',
            'game_description' => 'bail|string|required',
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
        // var_dump($userid);die;
        // $user = User::where('id',1)->first();
        // dd($user);
        $luckyDraw = LuckyDrawGames::findOrFail($luckyDrawid); 
        // dd($luckyDraw);
        return view('admin.lucky_draw.edit', ['luckyDraw'=>$luckyDraw]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //dd($id);
        $request->validate([
            'game_title' => 'bail|string|required|max:255',
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
        // var_dump($luckyDrawid);die;
        $luckyDraw = LuckyDrawGames::where('id',$luckyDrawid)->first();
        dd($luckyDraw);

        $user = User::findOrFail($userid);
        $user->name = $request->name;
        $user->username = $request->username;
        $user->role_id = $request->role;
        $user->email = $request->phone;
        $user->address_1 = $request->address_1;
        $user->address_2 = $request->address_2;
        $user->city = $request->city;
        $user->state = $request->state;
        $user->country = $request->country;
        $user->zip = $request->zip;
        $user->status = $request->status;
        $user->country = $request->country;

        $user->save();
        $success = "User updated successfully";
        return redirect('/admin/viewUser')->with('success',$success);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $userid = (int)decrypt($id);
        // dd($userid);
        $deleteUser = $user = User::findOrFail($userid);;
        $deleteUser->delete();

        $error = "Role removed successfully";
        return redirect('/admin/viewUser')->with('error',$error);
    }
}