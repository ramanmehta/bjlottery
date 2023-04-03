<?php

namespace App\Http\Controllers\admin;
use App\Http\Traits\CommonTrait;
use App\Http\Controllers\Controller;
use App\Models\LuckyDrawGames;
use Illuminate\Http\Request;
use Nette\Utils\DateTime;
use Illuminate\Support\Carbon;


class LuckyDrawGamesController extends Controller
{   
    use CommonTrait;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $luckyDraw = LuckyDrawGames::all();
        $imgPath = $this->fileurl();
        return view('admin.lucky_draw.index',['luckyDraw' => $luckyDraw , 'imgPath' => $imgPath]);
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
        $data = $request->daterange; 
        $startdate=substr($data, 0, 19);
        $enddate = substr($data, strpos($data, "-" , 20) + 1);

        // $startdate1 = strtotime($startdate);
        // $enddate1 = strtotime($enddate);
    
        // dd("sdtart date new : " . $startdate1 . "       end date new : " . $enddate1);
        
        $image = $request->file('game_image');
        if($image != null){
            $randomNumber = rand();
            $imageName = $randomNumber.$image->getClientOriginalName();  
            //$image->storeAs('public/images/luckydraw',$imageName);
            $image->storeAs($this->filepath().'/luckydraw',$imageName);
           
        }

        $request->validate([
            'game_title' => 'bail|string|required|max:255|unique:lucky_draw_games',
            'game_description' => 'bail|string|required',
            'winning_prize_amount' => 'integer|required',
            'min_point' => 'integer|required',
            'max_point' => 'integer|required',
            'daterange' => 'required',
            'game_point' => 'required',
            'game_image' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048|dimensions:min_width=10,min_height=10,max_width=1000,max_height=1000',
            'status' => 'required'
        ]);

        $luckyDrawData = [
            'game_title' => $request->game_title,
            'game_description'=>$request->game_description,
            'winning_prize_amount' => $request->winning_prize_amount,
            'min_point' => $request->min_point,
            'max_point' => $request->max_point,
            'start_date_time' =>$startdate ,
            'end_date_time' => $enddate,
            'game_image' => $imageName,
            'game_point' => $request->game_point,
            'status' =>$request->status
        ];
        
        $lucyDraw = LuckyDrawGames::create($luckyDrawData);

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
        $imgPath = $this->fileurl();
        $startDate = $luckyDraw->start_date_time;
        $endDate = $luckyDraw->end_date_time;
        $dateRange = $startDate . ' - ' . $endDate;
    
        return view('admin.lucky_draw.edit', ['luckyDraw'=>$luckyDraw, 'imgPath'=>$imgPath, 'dateRange'=>$dateRange]);
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

        
        $image = $request->file('game_image');
        if($image != null){
            $randomNumber = rand();
            $imageName = $randomNumber.$image->getClientOriginalName();  
            //$image->storeAs('public/images/luckydraw',$imageName);
            $image->storeAs($this->filepath().'/luckydraw',$imageName);
           
        }

        $request->validate([
            // 'game_title' => 'bail|string|required|max:255',
            'game_description' => 'bail|string|required',
            'winning_prize_amount' => 'integer|required',
            'min_point' => 'integer|required',
            'max_point' => 'integer|required',
            'daterange' => 'required',
            'game_point' => 'required',
            'game_image' => 'image|mimes:jpg,png,jpeg,gif,svg|max:2048|dimensions:min_width=10,min_height=10,max_width=1000,max_height=1000',
            'status' => 'required'
        ]);
        $luckyDrawid = decrypt($id);
        
        $luckyDraw  = LuckyDrawGames::findOrFail($luckyDrawid);
        // $luckyDraw->game_title = $request->game_title;
        $luckyDraw->game_description = $request->game_description;
        if($request->file('game_image') != ""){
            $luckyDraw->game_image = $imageName;
        }
        $luckyDraw->winning_prize_amount = $request->winning_prize_amount ;
        $luckyDraw->min_point = $request->min_point;
        $luckyDraw->max_point = $request->max_point;
        $luckyDraw->start_date_time = $startdate;
        $luckyDraw->end_date_time = $enddate;
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