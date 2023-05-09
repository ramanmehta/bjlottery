<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\LuckyDrawWinner;
use App\Models\LuckyDrawWinnerClaim;
use Dotenv\Validator;
use Illuminate\Http\Request;

class LuckeyWinnerController extends Controller
{
    public function lotterPrizeWinner(Request $request, $id = null)
    {
        $winner = LuckyDrawWinner::with('lottery')
            ->select('prize_image', 'prize_name', 'lottery_id','id')
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

    public function lotterPrizeClaim(Request $request)
    {
        $validated = \Validator::make($request->all(), [
            'name' => 'required|min:3|max:150|string',
            'address_1' => 'required|min:3|max:400|string',
            'address_2' => 'nullable',
            'lucky_draw_winner_id' => 'required|exists:lucky_draw_winners,id'
        ]);


        if ($validated->fails()) {

            $response = [
                'success' => false,
                'status' => 404,
                'message' => $validated->errors()
            ];

            return response()->json($response);
        }

        $input = $validated->validated();

        $winner = LuckyDrawWinner::find($input['lucky_draw_winner_id']);

        LuckyDrawWinnerClaim::create([
            'user_id' => auth()->id(),
            'name' => $input['name'],
            'address_1' => $input['address_1'],
            'address_2' => isset($input['address_2']) ? $input['address_2'] : null,
            'status' => 1,
            'lottery_id' => $winner->lottery_id,
            'lucky_draw_id' => $winner->lucky_draw_id,
            'lucky_draw_winner_id' => $winner->id,
            'ticket_no' => $winner->ticket_no,
        ]);

        $response = [
            'success' => true,
            'status' => 200,
            'message' => 'You successfully claimed your prize'
        ];

        return response()->json($response);
    }
}
