<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\LuckyDrawGames;
use App\Models\LuckyDraw;
use App\Models\User;
use Illuminate\Http\Request;
use DB;

class LuckyDrawGamesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       
        $luckydraw = LuckyDrawGames::all();
        if($luckydraw->count() > 0){
            $imagePath = asset('storage/app/public/images/luckydraw/');
            $response = [
                'success' => true,
                'status' => 200,
                'imagePath' => $imagePath,
                'luckydraw' => $luckydraw, 
            ];
            return response()->json($response);
        }else{
            return response()->json([
                'status' => 404,
                'message' => 'No record found'
            ],404);
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

        $luckydraw = LuckyDrawGames::find($id);
        $imagePath = asset('storage/app/public/images/');
        $response = [
            'success' => true,
            'status' => 200,
            'imagePath' => $imagePath,
            'luckydraw' => $luckydraw, 
        ];
        if($luckydraw){
            return response()->json($response);
        }else{
            return response()->json([
                'status' => 404,
                'message' => 'No record found'
            ],404);
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

    public function getNumber(Request $request){
        $data = $request->all();
        $user_id = $request->user_id;
        $game_id = $request->game_id;

        $user = User::find($user_id);
       

        $game = LuckyDrawGames::find($game_id);
        
        if($user && $game){
            $user_points = $user->total_point_available;
            $pointRequired = $game->points_per_ticket;
            if($user_points >= $pointRequired){
                $randomNumber = rand(100 , 9999);
                $balancePoint = $user_points - $pointRequired;
                $updateUserPoint = User::where('id', $user_id)->update([
                    'total_point_available' => $balancePoint
                ]);

                $data = [
                    'user_id' => $user_id,
                    'lucky_draw_games_id' => $game_id,
                    'ticket_number' => $randomNumber,
                ];

                $getNumber  = LuckyDraw::create($data);
                
                $response = [
                    'success' => true,
                    'status' => 200,
                    'data' => $getNumber,

                ];
                return response()->json($response);

            }else{
                $response = [
                    'success' => false,
                    'status' => 404,
                    'message' => "Low Balance"
                ];

                return response()->json($response);
            }
        }else{
            $response = [
                'success' => false,
                'status' => 404,
                'message' => "User or Game not found"
            ];

            return response()->json($response);
        }      
    }

    public function userNumber(Request $request){
        // dd("here");
        $user_id = $request->user_id;
        $game_id = $request->game_id;


        $allNumber = LuckyDraw::where('lucky_draw_games_id', '=', $game_id)->where('user_id', '=', $user_id)->get();
        // $allNumber = LuckyDraw::where('lucky_draw_games_id', '=', $game_id)->where('user_id', '=', $user_id)->paginate(10);
        // $allNumber = LuckyDraw::where('lucky_draw_games_id',$game_id)->where('user_id',$user_id)->get();
        $countNumber = LuckyDraw::where('lucky_draw_games_id',$game_id)->where('user_id',$user_id)->count();
       
        if($countNumber > 0){
        $resource = [
            'success' => true,
            'status' => 200,
            'data' => $allNumber
        ];

        return response()->json($resource);
    }else{
        $resource = [
            'success' => false,
            'status' => 404,
            'message' => 'no record found'
        ];

        return response()->json($resource);
    }

    }

    public function totalParticipant(){

        $participant = LuckyDraw::distinct()->get(['user_id']);
        $totalParticipant = $participant->count();

        $response = [
            'success' => true,
            'status' => 200,
            'data' => $totalParticipant
        ];
        
        return response()->json($response);
    }

    public function participantUsername(Request $request)
    {
        $lotteryId = $request->lottery_id;
       // dd($lotteryId);
        $participant = LuckyDraw::where('id',$lotteryId)->distinct()->get('user_id');
        
        $totalParticipant = $participant->count();
        if($totalParticipant > 0){
            // $user = User::with(['luckydraw'])->find($participant)   ;
            $userLottery = DB::table('users')
            ->select('users.username','users.logo')
            ->join('lucky_draws','lucky_draws.user_id','=','users.id')
            ->where('lucky_draws.lucky_draw_games_id',$lotteryId)
            ->distinct()
            // ->groupBy('lucky_draws.user_id')
            ->get('user_id'); // 

            // dd($userLottery);
            $username = [];
            foreach ($userLottery as $data) {
                $user_name = $data->username;
                $length = strlen($user_name); // Calculate length of email
                if($length > 5){
                    $first_two = substr($user_name, 0, 2); // Get first two characters
                    $last_six = substr($user_name, -3); // Get last six characters
                }else{
                    $first_two = substr($user_name, 0, 1);
                    $last_six = substr($user_name, -1); 
                }
                $midCharacter = "*******";
                $fullname = $first_two. $midCharacter . $last_six;
                $user_image_url = asset('storage/app/public/images');

                $username[] = ['user_image'=>$user_image_url.$data->logo,'username'=>$fullname];  
            }

            $response = [
                'success' => true,
                'status' => 200,
                'data' => $username
            ];
            return response()->json($response);
        }else{
            $response = [
                'success' => false,
                'status' => 404,
                'message' => 'No record found'
            ];
            return response()->json($response);
        }
    }
    
}
