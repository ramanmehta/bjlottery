<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserBankDetails;
use App\Models\CashTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WithdrawalController extends Controller
{
    public function withdraw(Request $request)
    {
        $banks = UserBankDetails::select(
            'user_bank_details.id',
            'amount',
            'text',
            'user_bank_details.status as statuss',
            'name',
            'username'
        )
            ->join('users', 'users.id', '=', 'user_bank_details.user_id')
            ->when(isset($request->search), function ($q) use ($request) {
                $q->where('name', 'like', "%{$request->search}%");
                $q->OrWhere('username', 'like', "%{$request->search}%");
                $q->OrWhere('amount', 'like', "%{$request->search}%");
                $q->OrWhere('text', 'like', "%{$request->search}%");
                $q->OrWhere('user_bank_details.status', withdrawalStatus($request->search, true));
            })
            ->orderBy('id', 'desc')
            ->paginate(10);

        return view('admin.withdrawal.list', compact('banks'));
    }

    public function withdrawalStatus(Request $request)
    {
        UserBankDetails::where('id', $request->id)
            ->update([
                'status' => $request->status
            ]);

        $bank = UserBankDetails::find($request->id);

        User::where('id', $bank->user_id)
            ->update(['total_cash_available' => DB::raw('total_cash_available - ' . $bank->amount)]);

        CashTransaction::create([
            'user_id' => $bank->user_id,
            'title' => 'Withdrawal',
            'type' => 'withdrawal',
            'amount' => $bank->amount,
            'status' => 2,
        ]);

        return response()->json('ok');
    }
}
