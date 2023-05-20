<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\CashTransaction;
use App\Models\User;
use App\Models\UserBankDetails;

use Validator;
use Illuminate\Support\Facades\DB;

class WithdrawalController extends Controller
{
    public function cashTransaction(Request $request)
    {
        $res = CashTransaction::where('user_id', auth()->id())
            ->when(isset($request->month), function ($q) use ($request) {
                $q->whereMonth('created_at', $request->month);
            })
            ->when(isset($request->year), function ($q) use ($request) {
                $q->whereYear('created_at', $request->year);
            })
            ->select(
                'id',
                'user_id',
                'title',
                'type',
                'amount',
                'status',
                'created_at'
            )
            ->orderBy('id', 'desc')
            ->get();

        $resource = [
            'success' => true,
            'message' => 'Cash transaction history list',
            'data' => $res
        ];

        return response()->json($resource);
    }

    public function cashWithdrawal(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'amount' => 'required|numeric',
            'text' => 'required',
        ]);

        if ($validated->fails()) {

            $response = [
                'success' => false,
                'status' => 404,
                'message' => $validated->errors()
            ];

            return response()->json($response);
        }

        DB::beginTransaction();

        try {

            $validated = $validated->validated();

            if (auth()->user()->total_cash_available < $validated['amount']) {

                $response = [
                    'success' => false,
                    'status' => 404,
                    'message' => 'Insufficient Balance'
                ];

                return response()->json($response);
            }

            UserBankDetails::create([
                'user_id' => auth()->id(),
                'amount' => $validated['amount'],
                'text' => $validated['text'],
                'status' => 1,
            ]);

            \App\Models\Notification::create([
                'user_id' => auth()->id(),
                'title' => 'Cash Withdrawal Request',
                'description' => 'Your cash withdrawal request has been successfully sent, Please wait 24 hours to accept the request from the department, Thanks for your patience',
                'status' => 0,
                'sent_at' => now(),
            ]);

            DB::commit();

            $resource = [
                'success' => true,
                'message' => 'Withdrawal request successfully sent.',
                'data' => []
            ];

            return response()->json($resource);
        } catch (\Throwable $th) {

            DB::rollBack();

            throw $th;
        }
    }

    public function withdrawal(Request $request)
    {
        $res = UserBankDetails::where('user_id', auth()->id())
            ->when(isset($request->month), function ($q) use ($request) {
                $q->whereMonth('created_at', $request->month);
            })
            ->when(isset($request->year), function ($q) use ($request) {
                $q->whereYear('created_at', $request->year);
            })
            ->select(
                'id',
                'created_at',
                'amount',
                'text',
                'status',
            )
            ->orderBy('id', 'desc')
            ->get();

        $resource = [
            'success' => true,
            'message' => 'Withdrawal request list.',
            'data' => $res
        ];

        return response()->json($resource);
    }
}
