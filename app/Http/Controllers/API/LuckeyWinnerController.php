<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\LuckyDrawWinner;
use Illuminate\Http\Request;

class LuckeyWinnerController extends Controller
{
    public function lotterPrizeWinner(Request $request, $id = null)
    {
        $winner = LuckyDrawWinner::with('lottery')
            ->select('prize_image', 'prize_name', 'lottery_id')
            ->when(!is_null($id), function ($q) use ($id) {
                $q->where('lottery_id', $id);
            })
            ->when($request->has('ticket_no'), function ($q) use ($request) {
                $q->where('ticket_no', 'like', "%{$request->ticket_no}%");
            })
            ->where('user_id', auth()->id())
            ->get();

        if ($winner->isEmpty()) {

            $response = [
                'success' => true,
                'status' => 200,
                'message' => 'Better luck next time'
            ];

            return response()->json($response);
        }

        return response()->json($winner);
    }
}
