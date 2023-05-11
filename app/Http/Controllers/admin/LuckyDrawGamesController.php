<?php

namespace App\Http\Controllers\admin;

use App\Http\Traits\CommonTrait;
use App\Http\Controllers\Controller;
use App\Models\LuckyDraw;
use App\Models\LuckyDrawGames;
use App\Models\LuckyDrawWinner;
use App\Models\LuckyDrawWinnerClaim;
use App\Models\MissionSubmission;
use Illuminate\Http\Request;
use Nette\Utils\DateTime;
use Illuminate\Support\Carbon;
use DB;


class LuckyDrawGamesController extends Controller
{
    use CommonTrait;
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->has('search')) {

            $search = $request->search;
            $luckyDraw = DB::table('lucky_draw_games')
                ->where('game_title', 'LIKE', '%' . $search . '%')
                ->orWhere('game_description', 'LIKE', '%' . $search . '%')
                ->orWhere('winning_prize_amount', 'LIKE', '%' . $search . '%')
                ->orWhere('minimum_prize_amount', 'LIKE', '%' . $search . '%')
                ->orWhere('points_per_ticket', 'LIKE', '%' . $search . '%')
                ->paginate(10);
        } else {
            $luckyDraw = LuckyDrawGames::orderBy('id', 'DESC')->paginate(10);;
        }
        $imgPath = $this->fileurl();

        return view('admin.lucky_draw.index', ['luckyDraw' => $luckyDraw, 'imgPath' => $imgPath]);
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
        //   dd($request->all());
        $data = $request->daterange;
        $startdate = substr($data, 0, 19);
        $enddate = substr($data, strpos($data, "-", 19) + 1);

        // $startdate1 = strtotime($startdate);
        // $enddate1 = strtotime($enddate);

        // dd("sdtart date new : " . $startdate1 . "       end date new : " . $enddate1);

        $image = $request->file('game_image');
        if ($image != null) {
            $randomNumber = rand();
            $imageName = $randomNumber . $image->getClientOriginalName();
            //$image->storeAs('public/images/luckydraw',$imageName);
            $image->storeAs($this->filepath() . '/luckydraw', $imageName);
        }

        $request->validate([
            'game_title' => 'bail|string|required|max:255|unique:lucky_draw_games',
            'game_description' => 'bail|string|required',
            'winning_prize_amount' => 'bail|integer|required|min:0',
            'minimum_prize_amount' => 'bail|integer|required|min:0',
            'points_per_ticket' => 'bail|integer|required|min:0',
            'daterange' => 'required',
            'game_image' => 'image|mimes:jpg,png,jpeg,gif,svg|max:5000|dimensions:min_width=10,min_height=10,max_width=3000,max_height=3000',
            'status' => 'required'
        ]);
        $luckyDrawData = [
            'game_title' => $request->game_title,
            'game_description' => $request->game_description,
            'winning_prize_amount' => $request->winning_prize_amount,
            'minimum_prize_amount' => $request->minimum_prize_amount,
            'points_per_ticket' => $request->points_per_ticket,
            'start_date_time' => $startdate,
            'end_date_time' => $enddate,
            'status' => $request->status,
            // if($request->file('game_image') != ""){
            // $luckyDraw->game_image = $imageName;
            // 'game_image' => '/luckydraw/'.$imageName;
            'game_image' => $request->file('game_image') != "" ? '/luckydraw/' . $imageName : "",
            //  $user->status == 1 ? "selected" : ""
            // }
        ];
        // dd($luckyDrawData);
        $lucyDraw = LuckyDrawGames::create($luckyDrawData);

        $success = "New Lucky Draw created successfully";
        return redirect('/admin/viewLuckyDraw')->with('success', $success);
    }

    public function lotteryStatus(Request $request, $id)
    {
        $lottery_id = decrypt($id);
        $lottery = LuckyDrawGames::find($lottery_id);
        $status = $lottery->status;

        if ($status == 1) {

            $deactivate = $lottery->status = '0';

            $lottery->save();

            $lotteryStatus = LuckyDrawGames::where('id', $lottery_id)->update([
                'status' => $deactivate
            ]);
            $success = "Lucky Draw game deactivated successfully";
            return redirect('/admin/viewLuckyDraw')->with('success', $success);
        } else {
            $activated = $lottery->status = '1';

            $lottery->save();

            $lotteryStatus = LuckyDrawGames::where('id', $lottery_id)->update([
                'status' => $activated
            ]);
            $success = "Lucky Draw activated successfully";
            return redirect('/admin/viewLuckyDraw')->with('success', $success);
        }
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

        return view('admin.lucky_draw.edit', ['luckyDraw' => $luckyDraw, 'imgPath' => $imgPath, 'dateRange' => $dateRange]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // dd($request->all());
        $data = $request->daterange;
        $startdate = substr($data, 0, 19);
        $enddate = substr($data, strpos($data, "-", 19) + 1);

        $luckyDrawid = decrypt($id);
        $luckyDraw = DB::table('lucky_draw_games')->find($luckyDrawid);
        $image = $request->file('game_image');

        // unique:users,username,'.$userid

        $validArr = [
            'game_title' => 'bail|string|required|max:255|unique:lucky_draw_games,game_title,' . $luckyDrawid,
            'game_description' => 'bail|string|required',
            'winning_prize_amount' => 'integer|required',
            'minimum_prize_amount' => 'integer|required',
            'points_per_ticket' => 'integer|required',
            'daterange' => 'required',
        ];

        $validErrArr = [];
        if ($image != null) {
            $validArr['game_image'] = ['mimes:jpeg,jpg,png,gif|required|max:5000|dimensions:min_width=10,min_height=10,max_width=3000,max_height=3000'];
            $validErrArr['game_image'] = ['required' => 'upload image is required', 'mimes' => 'Only images with extension jpeg,jpg,png,gif are allowed.', 'max' => 'Maximaun image size 5 MB', 'dimensions' => 'The image has invalid dimension'];
        }

        // $request->validate([
        //     'game_title' => 'bail|string|required|max:255',
        //     'game_description' => 'bail|string|required',
        //     'winning_prize_amount' => 'integer|required',
        //     'minimum_prize_amount' => 'integer|required',
        //     'points_per_ticket' => 'integer|required',
        //     'daterange' => 'required',
        //     'game_image' => 'image|mimes:jpg,png,jpeg,gif,svg|max:2048|dimensions:min_width=10,min_height=10,max_width=1000,max_height=1000',
        // ]);

        if ($image != null) {
            $randomNumber = rand();
            $imageName = $randomNumber . $image->getClientOriginalName();
            //$image->storeAs('public/images/luckydraw',$imageName);
            $image->storeAs($this->filepath() . '/luckydraw', $imageName);
        }


        // $luckyDraw->game_title = $request->game_title;

        if ($request->file('game_image') != "") {
            $luckyDraw->game_image = $imageName;
        }

        $request->validate($validArr, $validErrArr);

        $luckyDraw  = LuckyDrawGames::findOrFail($luckyDrawid);
        $luckyDraw->game_title = $request->game_title;
        $luckyDraw->game_description = $request->game_description;
        $luckyDraw->winning_prize_amount = $request->winning_prize_amount;
        $luckyDraw->minimum_prize_amount = $request->minimum_prize_amount;
        $luckyDraw->points_per_ticket = $request->points_per_ticket;
        $luckyDraw->start_date_time = $startdate;
        $luckyDraw->end_date_time = $enddate;
        if ($image != null) {
            $luckyDraw->game_image = '/luckydraw/' . $imageName;
        }

        $luckyDraw->save();
        $success = "Lucky draw updated successfully";
        return redirect('/admin/viewLuckyDraw')->with('success', $success);
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
        return redirect('/admin/viewLuckyDraw')->with('error', $error);
    }

    public function luckyWinnerList(Request $request, $id)
    {
        $luckyDrawid = decrypt($id);

        $data  = LuckyDrawGames::findOrFail($luckyDrawid);

        // LuckyDrawWinner::truncate();
        // dd('ok');
        $claims = LuckyDrawWinner::with('user')
            ->where('lottery_id', $data->id)
            ->when(isset($request->search), function ($q) use ($request) {
                $q->where('ticket_no', 'like', "%{$request->search}%");
            })
            ->get();
            
        return view('admin.lucky_draw.lucky_winner_list', compact('data', 'claims'));
    }

    public function addPrice($id)
    {
        $luckyDrawid = decrypt($id);

        $data  = LuckyDrawGames::findOrFail($luckyDrawid);

        $claims = LuckyDraw::with('user')->where('lucky_draw_games_id', $data->id)->get();

        return view('admin.lucky_draw.add_price', compact('data', 'claims'));
    }

    public function addPriceStore(Request $request)
    {
        $validated = $request->validate([
            'lottery_id' => 'required',
            'ticket_no' => 'required|array',
            'ticket_no.*' => 'required',
            'ticket_no.*' => 'required',
            'prize_name.*' => 'required|array',
            'prize_name.*' => 'required|min:3|max:150|string',
            'prize_image.*' => 'required|array',
            'prize_image.*' => 'required|image|mimes:png,jpeg,gif,jpg',
        ]);

        foreach ($validated['ticket_no'] as $key => $value) {

            $draw  = LuckyDraw::where('ticket_number', $value)->where('lucky_draw_games_id', $validated['lottery_id'])->first();

            $data['user_id'] = $draw->user_id;
            $data['lottery_id'] = $validated['lottery_id'];
            $data['lucky_draw_id'] = $draw->id;
            $data['ticket_no'] = $value;
            $data['prize_name'] = $validated['prize_name'][$key];

            $data['prize_image'] = 'luckey_winner/' . rand() . $validated['prize_image'][$key]->getClientOriginalName();

            $validated['prize_image'][$key]->storeAs('public/images', $data['prize_image']);

            LuckyDrawWinner::create($data);
        }
        
        return redirect()->route('add.price', encrypt($validated['lottery_id']))->with('success', 'Ticket Added successfully');
    }

    public function addPriceEdit($id)
    {
        $id = decrypt($id);

        $winners = LuckyDrawWinner::with('lottery')->where('id', $id)->first();

        return view('admin.lucky_draw.edit_price', compact('winners'));
    }

    public function addPriceDestroy($lId, $id)
    {
        $id = decrypt($id);

        if (LuckyDrawWinnerClaim::where('lucky_draw_winner_id', $id)->exists()) {

            return redirect()->route('add.price', encrypt($lId))->with('error', 'You can not delete this ticket, Claimed');
        }

        LuckyDrawWinner::destroy($id);

        return redirect()->route('add.price', encrypt($lId))->with('error', 'Ticket Deleted successfully');
    }

    public function winnerUserClaim(Request $request)
    {
        $claims = LuckyDrawWinnerClaim::with(['user', 'lottery', 'prize'])
            ->when(isset($request->search), function ($q) use ($request) {
                $q->where('ticket_no', 'like', "%{$request->search}%");
            })
            ->get();

        return view('admin.lucky_draw_winners.list', compact('claims'));
    }

    public function statusUpdateWinnerUser(Request $request)
    {
        LuckyDrawWinnerClaim::where('id', $request->id)
            ->update([
                'status' => $request->status
            ]);

        return response()->json('ok');
    }

    public function editPrizeUpdate(Request $request, $id)
    {
        if ($request->has('prize_image') && $request->file('prize_image')) {

            $data['prize_image'] = 'luckey_winner/' . rand() . $request->prize_image->getClientOriginalName();

            $request->prize_image->storeAs('public/images', $data['prize_image']);
        }

        $data['prize_name'] = $request->prize_name;

        LuckyDrawWinner::where('id', $id)->update($data);

        $res = LuckyDrawWinner::where('id', $id)->first();

        return redirect()->route('add.price', encrypt($res->lottery_id))->with('succes', 'Ticket updated successfully');
    }

    public function missionSubmitStatusUpdate(Request $request)
    {
        MissionSubmission::where('id',$request->id)->update(['approval_status' => $request->status]);
        
        $user = User::select(['total_point_available as total_ap', 'total_cash_available as total_wallet'])->where('id', $userId)->first();
        
        return response()->json('ok');
    }
}
