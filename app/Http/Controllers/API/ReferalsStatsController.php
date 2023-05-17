<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\ReferalsStats;
use App\Models\User;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ReferalsStatsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // dd("notification here");
        $referals = ReferalsStats::all();
        if ($referals->count() > 0) {
            return response()->json([
                'status' => 200,
                'referals' => $referals,
            ], 200);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'No records found',
            ], 404);
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
        // dd('notification id');
        $referals = ReferalsStats::find($id);
        if ($referals) {
            return response()->json([
                'status' => 200,
                'Referals' => $referals,
            ], 200);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'No records found'
            ], 404);
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

    // Get referal history 
    public function getYourHIstory(Request $request)
    {
        $monthName = $request->all()['month_name'];
        $year = $request->all()['year'];

        // $firstDayOfMonth = Carbon::create($year, $month, 1)->startOfDay();


        $validator = Validator::make($request->all(), [
            'month_name' => 'required',
            'year' => 'required'
        ]);

        $monthName = $monthName; //'May';
        $year = $year; //2023;
        $startDate = Carbon::createFromFormat('Y F', $year . ' ' . $monthName)->startOfMonth();
        $start_date = $startDate->format('Y-m-d');
        $endDate = Carbon::createFromFormat('Y F', $year . ' ' . $monthName)->endOfMonth();
        $end_date = $endDate->format('Y-m-d');


        if ($validator->fails()) {
            $response = [
                'success' => false,
                'status' => 404,
                'message' => $validator->errors()
            ];

            return response()->json($response);
        }

        if (auth('sanctum')->check()) {
            $userId = auth('sanctum')->user()->id;
            $user = User::where('id', $userId)->first();
            if ($user) {
                // $referral_points = DB::table('referal_points')
                //                     ->whereBetween('created_at', [$start_date, $end_date])
                //                     ->get();
                // \DB::enableQueryLog(); // Enable query log
                $results = DB::table('referal_points')
                    ->selectRaw('user_id, SUM(referal_point) as total_referal_points')
                    ->whereBetween('created_at', [$start_date, $end_date])
                    ->where('user_id', $userId)
                    ->groupBy('user_id')
                    ->first();
                // dd(\DB::getQueryLog()); // Show results of log
                // dd($results);
                $data['referal_points_earned'] = $results->total_referal_points ? $results->total_referal_points : 0;
                $data['mission_points_earned'] = 0;

                $response = [
                    'suceess' => true,
                    'status' => 200,
                    'data' => $data
                ];

                return response()->json($response);
            }
        } else {
            $response = [
                'success' => false,
                'status' => 400,
                'message' => 'Invalid user'
            ];

            return response()->json($response);
        }
    }
}
