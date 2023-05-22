<?php

namespace App\Http\Controllers\admin;

use App\Http\Traits\CommonTrait;
use App\Http\Controllers\Controller;
use App\Models\LuckyDraw;
use App\Models\LuckyDrawGames;
use App\Models\LuckyDrawWinner;
use App\Models\LuckyDrawWinnerClaim;
use App\Models\MissionPrizeClaim;
use App\Models\MissionSubmission;
use App\Models\PointTransaction;
use App\Models\User;
use App\Models\CashTransaction;
use App\Models\Mission;
use Illuminate\Http\Request;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\Paginator;
use \Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class LuckyDrawGamesController extends Controller
{
    use CommonTrait;
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $luckyDraw = LuckyDrawGames::when($request->has('search'), function ($q) use ($request) {
            $search = $request->search;
            $q->where('game_title', 'LIKE', '%' . $search . '%')
                ->orWhere('game_description', 'LIKE', '%' . $search . '%')
                ->orWhere('winning_prize_amount', 'LIKE', '%' . $search . '%')
                ->orWhere('minimum_prize_amount', 'LIKE', '%' . $search . '%')
                ->orWhere('points_per_ticket', 'LIKE', '%' . $search . '%');
        })
            ->orderBy('id', 'DESC')
            ->paginate(10);

        return view('admin.lucky_draw.index', compact('luckyDraw'));
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
        $request->validate([
            'game_title' => 'bail|string|required|max:255|unique:lucky_draw_games',
            'game_description' => 'bail|string|required',
            'winning_prize_amount' => 'bail|nullable|integer|min:0',
            'minimum_prize_amount' => 'bail|nullable|integer|min:0',
            'points_per_ticket' => 'bail|integer|required|min:0',
            'daterange' => 'required',
            'game_image' => 'image|mimes:jpg,png,jpeg,gif,svg|max:5000|dimensions:min_width=10,min_height=10,max_width=3000,max_height=3000',
            'status' => 'required',
        ]);

        if ($request->has('game_image')) {

            $image = $request->file('game_image');
            $imageName = rand() . $image->getClientOriginalName();
            $image->storeAs($this->filepath() . '/luckydraw', $imageName);
        }

        $luckyDrawData = [
            'game_title' => $request->game_title,
            'game_description' => $request->game_description,
            'winning_prize_amount' => $request->winning_prize_amount,
            'minimum_prize_amount' => $request->minimum_prize_amount,
            'points_per_ticket' => $request->points_per_ticket,
            'start_date_time' => substr($request->daterange, 0, 19),
            'end_date_time' => substr($request->daterange, strpos($request->daterange, "-", 19) + 1),
            'status' => $request->status,
            'game_image' => $request->has('game_image') ? '/luckydraw/' . $imageName : null,
        ];

        LuckyDrawGames::create($luckyDrawData);

        return redirect()->route('luckyDraw')->with('success', 'New Lucky Draw created successfully');
    }

    public function lotteryStatus(Request $request, $id)
    {
        $lottery_id = decrypt($id);

        $lottery = LuckyDrawGames::find($lottery_id);

        if ($lottery->status == 1) {

            LuckyDrawGames::where('id', $lottery_id)
                ->update([
                    'status' => 0
                ]);

            return redirect()->route('luckyDraw')->with('success', "Lucky Draw game deactivated successfully");
        } else {

            LuckyDrawGames::where('id', $lottery_id)
                ->update([
                    'status' => 1
                ]);

            return redirect()->route('luckyDraw')->with('success', "Lucky Draw activated successfully");
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
            'winning_prize_amount' => 'bail|nullable|integer|min:0',
            'minimum_prize_amount' => 'bail|nullable|integer|min:0',
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

        $data  = LuckyDrawGames::withTrashed()->findOrFail($luckyDrawid);

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
            'prize_name.*' => 'required|array',
            'prize_name.*' => 'required|max:150',
            'prize_image.*' => 'required|array',
            'prize_image.*' => 'required|image|mimes:png,jpeg,gif,jpg',
            'type' => 'required|array',
            'type.*' => 'required',
        ]);

        DB::beginTransaction();

        try {

            $i = 0;
            foreach ($validated['ticket_no'] as $key => $value) {
                $data = [];
                $draw  = LuckyDraw::where('ticket_number', $value)->where('lucky_draw_games_id', $validated['lottery_id'])->first();

                $data['type'] = $validated['type'][$key];
                $data['user_id'] = $draw->user_id;
                $data['lottery_id'] = $validated['lottery_id'];
                $data['lucky_draw_id'] = $draw->id;
                $data['ticket_no'] = $value;

                if ($validated['type'][$key] == 'prize') {

                    $data['prize_name'] = $validated['prize_name'][$key];
                    $data['prize_image'] = 'luckey_winner/' . rand() . $validated['prize_image'][$i]->getClientOriginalName();
                    $validated['prize_image'][$i]->storeAs('public/images', $data['prize_image']);
                    ++$i;
                } else {

                    User::where('id', $data['user_id'])->update(['total_cash_available' => DB::raw('total_cash_available + ' . $validated['prize_name'][$key])]);

                    CashTransaction::create([
                        'user_id' => $data['user_id'],
                        'title' => 'Lottery Cash',
                        'type' => 'lottery_cash',
                        'amount' => $validated['prize_name'][$key],
                        'status' => 1,
                    ]);

                    \App\Models\Notification::create([
                        'user_id' => $data['user_id'],
                        'title' => 'Lottery Cash price Winner!',
                        'description' => 'Congratulation!, You win cash amount on ticket number ' . $data['ticket_no'] . ', You are selected as luckey cash price winner. Amount will be cresit in your wallet soon.',
                        'status' => 0,
                        'sent_at' => now(),
                    ]);

                    $data['amount'] = $validated['prize_name'][$key];
                }

                LuckyDrawWinner::create($data);
            }


            DB::commit();

            return redirect()->route('add.price', encrypt($validated['lottery_id']))->with('success', 'Ticket Added successfully');
        } catch (\Throwable $th) {

            DB::rollBack();

            throw $th;
        }
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

    public function paginate($items, $perPage = 10, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }

    public function winnerUserClaim(Request $request)
    {
        $claims = LuckyDrawWinnerClaim::with(['user', 'lottery', 'prize'])
            ->when(isset($request->search), function ($q) use ($request) {
                $q->where('ticket_no', 'like', "%{$request->search}%");
            })
            ->get();

        $mission = MissionPrizeClaim::with(['user', 'mission', 'mission_submission'])
            ->when(isset($request->search), function ($q) use ($request) {
                $q->where('mission_id', 'like', "%{$request->search}%");
            })
            ->get();

        $claims = collect($claims->merge($mission))->sortByDesc('created_at');
        $claims = $this->paginate($claims);
        $claims->setPath('/admin/winner-user/claim');

        return view('admin.lucky_draw_winners.list', compact('claims'));
    }

    public function statusUpdateWinnerUser(Request $request)
    {
        if ($request->type == 'lottery') {

            LuckyDrawWinnerClaim::where('id', $request->id)
                ->update([
                    'status' => $request->status
                ]);

            $res = LuckyDrawWinnerClaim::find($request->id);

            $prize = LuckyDrawWinner::where('id', $res->lucky_draw_winner_id)->first();

            if ($request->status == 3) {

                \App\Models\Notification::create([
                    'user_id' => $res->user_id,
                    'title' => 'Lottery Prize Approved',
                    'description' => 'Congrats , Your prize ' . $prize->prize_name . ' shipped to your address.',
                    'status' => 0,
                    'sent_at' => now(),
                ]);
            }

            if ($request->status == 4) {

                \App\Models\Notification::create([
                    'user_id' => $res->user_id,
                    'title' => 'Lottery Prize Rejected',
                    'description' => 'Better Luck Next Time, Your claim on prize ' . $prize->prize_name . ' rejected, contact our support to know more about.',
                    'status' => 0,
                    'sent_at' => now(),
                ]);
            }
        }

        if ($request->type == 'mission') {

            MissionPrizeClaim::where('id', $request->id)
                ->update([
                    'status' => $request->status
                ]);

            $m = MissionPrizeClaim::find($request->id);

            $mission = Mission::find($m->mission_id);

            if ($request->status == 3) {

                \App\Models\Notification::create([
                    'user_id' => $res->user_id,
                    'title' => 'Mission Prize Approved',
                    'description' => 'Congrats , Your prize' . $mission->prize_name . ' shipped to your address.',
                    'status' => 0,
                    'sent_at' => now(),
                ]);
            }

            if ($request->status == 4) {

                \App\Models\Notification::create([
                    'user_id' => $res->user_id,
                    'title' => 'Mission Prize Rejected',
                    'description' => 'Better Luck Next Time, Your claim on prize ' . $prize->prize_name . ' rejected, contact our support to know more about.',
                    'status' => 0,
                    'sent_at' => now(),
                ]);
            }
        }

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
        MissionSubmission::where('id', $request->id)
            ->update(['approval_status' => $request->status]);

        $mission = MissionSubmission::where('mission_submissions.id', $request->id)
            ->join('missions', 'missions.id', '=', 'mission_submissions.mission_id')
            ->first();

        if ($mission->mission_type == 'affliated_points') {

            if ($request->status == 'approved') {

                User::where('id', $mission->user_id)
                    ->update(['total_point_available' => DB::raw('total_point_available + ' . $mission->enter_earn_affliated_points)]);


                PointTransaction::create([
                    'user_id' => $mission->user_id,
                    'title' => 'Mission',
                    'type' => $mission->mission_title,
                    'points' => $mission->enter_earn_affliated_points,
                    'status' => 1,
                ]);

                \App\Models\Notification::create([
                    'user_id' => $mission->user_id,
                    'title' => 'Mission Approved',
                    'description' => 'Congrats!, Your mission ' . $mission->mission_title . ' successfully approved, you will receive ' . $mission->enter_earn_affliated_points . ' affliated points in your wallet.',
                    'status' => 0,
                    'sent_at' => now(),
                ]);
            }

            $points = PointTransaction::where('user_id', $mission->user_id)
                ->where('type', $mission->mission_title)
                ->first();

            if ($request->status == 'reject' && !is_null($points)) {

                PointTransaction::create([
                    'user_id' => $mission->user_id,
                    'title' => 'Mission',
                    'type' => $mission->mission_title,
                    'points' => $mission->enter_earn_affliated_points,
                    'status' => 2,
                ]);

                \App\Models\Notification::create([
                    'user_id' => $mission->user_id,
                    'title' => 'Mission Rejected',
                    'description' => 'Better Luck Next Time!, Your affliated points on mission ' . $mission->mission_title . ' rejected by admin.',
                    'status' => 0,
                    'sent_at' => now(),
                ]);

                User::where('id', $mission->user_id)
                    ->update(['total_point_available' => DB::raw('total_point_available - ' . $mission->enter_earn_affliated_points)]);
            }
        }

        if ($mission->mission_type == 'prize' && $request->status == 'approved') {

            \App\Models\Notification::create([
                'user_id' => $mission->user_id,
                'title' => 'Mission Approved',
                'description' => 'Congrats , Your prize on mission ' . $mission->mission_title . ' shipped to your address.',
                'status' => 0,
                'sent_at' => now(),
            ]);
        }

        if ($mission->mission_type == 'prize' && $request->status == 'reject') {

            \App\Models\Notification::create([
                'user_id' => $mission->user_id,
                'title' => 'Mission Rejected',
                'description' => 'Better Luck Next Time!, Your prize request on mission ' . $mission->mission_title . ' rejected by admin.',
                'status' => 0,
                'sent_at' => now(),
            ]);
        }

        return response()->json('ok');
    }
}
