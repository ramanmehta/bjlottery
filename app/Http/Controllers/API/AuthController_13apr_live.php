<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\HasApiTokens;
use Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\URL;
// models 
use App\Models\User;
use App\Models\ReferalPoint;
use App\Models\ReferalsStats;
use App\Models\DailyReward;


class AuthController extends Controller
{
    public function register(Request $request, $ref = '')
    {
        // if ($ref != '') {
        //     $checkReferal = ReferalPoint::where('referal_code', $ref)->count();
        //     // dd($checkReferal);
        //     if ($checkReferal == 1) {
        //         $checkReferal = ReferalPoint::where('referal_code', $ref)->first();
        //         $checkReferalPoint = $checkReferal->referal_point;
        //         $referalTypeId = 9;
        //         $getPoint = DailyReward::find($referalTypeId);
        //         $referalPoint = $getPoint->reward_points;
        //         $total_referal_point = $checkReferalPoint + $referalPoint;
        //         $checkReferal->update([
        //             'referal_point' => $total_referal_point
        //         ]);
        //     } else {
        //         $response = [
        //             'success' => false,
        //             'message' => 'Referal code not exists'
        //         ];
        //         return response()->json($response, 400);
        //     }
        // }

        $validator = Validator::make($request->all(), [
            'name' => 'string|required|min:1',
            'username' => 'string|required|min:1|max:20|unique:users',
            // 'role_id' => 'integer|required|min:1|max:20',
            'email' => 'string|required|email|max:100|unique:users',
            'phone' => 'required|numeric|digits:10',
            'address_1' => 'string|required|min:1|max:200',
            'address_2' => 'string|required|min:1|max:200',
            'city' => 'string|required|min:1|max:50',
            'state' => 'string|required|min:1|max:50',
            'country' => 'string|required|min:1|max:50',
            'zip' => 'string|required|min:1|max:50',
            'password' => 'string|required|min:6',
            'c_password' => 'string|required|same:password',
            'logo' => 'nullable|image|mimes:jpg,png,jpeg,gif,svg|max:2048|dimensions:min_width=10,min_height=10,max_width=1000,max_height=1000',
        ]);

        if ($validator->fails()) {
            $response = [
                'success' => false,
                'status' => 400,
                'message' => $validator->errors()
            ];

            return response()->json($response);
        }

        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);

        // $user_id = $user->id;
        // $user_referal = Str::random(10);
        // $url = URL::to('/');
        // $referal_link = $url . '/api/referal-register/' . $user_referal;

        // $data = [
        //     'user_id' => $user_id,
        //     'referal_code' => $user_referal,
        //     'referal_link' => $referal_link,
        //     'referal_point' => 0
        // ];

        // $referal = ReferalPoint::create($data);

        // referal status 
        // if ($ref != '') {
        //     $checkReferal = ReferalPoint::where('referal_code', $ref)->count();
        //     if ($checkReferal == 1) {
        //         $checkReferal = ReferalPoint::where('referal_code', $ref)->first();
        //         $parentReferalId = $checkReferal->id;
        //         $referalLink = $checkReferal->referal_link;
        //         $referalCode = $checkReferal->referal_code;
        //         $referalTypeId = 9;
        //         $getReferalType = DailyReward::find($referalTypeId);
        //         $referalType = $getReferalType->reward_types;
        //         $data = [
        //             'user_id' => $user_id,
        //             'parent_user_id' => $parentReferalId,
        //             'referal_types' => $referalType,
        //             'referal_link' => $referalLink,
        //             'referal_code' => $referalCode
        //         ]; 

        //         $referalSatus = ReferalsStats::create($data);


        //     } else {
        //         $response = [
        //             'success' => false,
        //             'message' => 'Referal code not exists'
        //         ];

        //         return response()->json($response, 400);
        //     }
        // }

        //update reward points aftre register 
        // if($ref != ''){
        //     $getReferalType = DailyReward::where('referal_type', 'referal')->first();

        //     $todayPointGain = $getReferalType->point;
        //     // $todayPointGain = 20;
        //     $todayPointDeduct = 0;
        //     $totalPoint = $getReferalType->point;
        //     // $totalPoint = 20;
        //     $totalCash = 0;
            
        //     $data = [
        //         'today_gained_point' => $todayPointGain,
        //         'today_deduct_point' => $todayPointDeduct,
        //         'total_point_available' => $totalPoint
        //     ];
           

        //     $updateUserPoint = $user->update($data);


        // }else{

        //     $getReferalType = DailyReward::where('referal_type', 'register')->first();

        //     $todayPointGain = $getReferalType->point;
        //     // $todayPointGain = 10; //static data
        //     $todayPointDeduct = 0;
        //     $totalPoint = $getReferalType->point;
        //     // $totalPoint = 10; //static data
        //     $totalCash = 0;

        //     $data = [
        //         'today_gained_point' => $todayPointGain,
        //         'today_deduct_point' => $todayPointDeduct,
        //         'total_point_available' => $totalPoint
        //     ];
           
        //     $updateUserPoint = $user->update($data);
        // }
        $success['token'] = $user->createToken('MyApp')->plainTextToken;
        $success['name'] = $user->name;

        $response = [
            'success' => true,
            'status' => 200,
            'data' => $success,
            'message' => 'User register successfully'
        ];

        return response()->json($response);
    }


    public function login(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'username' => 'string|required',
            'password' => 'string|required'
        ]);

        if (Auth::attempt([
            'username' => $request->username,
            'password' => $request->password
        ])) {
            // var_dump($request->username);
            $user = Auth::user();
            $success['token'] = $user->createToken('MyApp')->plainTextToken;
            $success['user'] = $user;

            // dd($user->id);
            // // $total_
            // $user_id = $user->id
            // $user_detail = DB::table('users')
            //         ->join('roles','users.role_id', "=", 'roles.id')
            //         ->join('countries', 'users.country', "=", 'countries.sortname')
            //         ->select('users.id','users.name','users.username','users.email','users.phone','users.country','users.address_1','users.address_2','users.city','users.state','users.country','users.zip','users.status','users.role_id','users.logo','roles.role_title','countries.countries')
            //         ->where('users.id', $userid)->first();

            $response = [
                'success' => true,
                'status' => 200,
                'data' => $success,
                'message' => 'User login successfully'
            ];
            return response()->json($response);
        } else {
            $response = [
                'success' => false,
                'status' => 400,
                'message' => 'username or password is incorrect'
            ];

            return response()->json($response);
        }
    }

    // login with token

    public function user(Request $request)
    {
        $response = [
            'success' => true,
            'status' => 200,
            'data' => $request->user(),
            'message' => 'User login successfully'
        ];
        return response()->json($response);
    }


    // logout with token

    public function logout(Request $request)
    {

        $request->user()->currentAccessToken()->delete();
        $response = [
            'success' => true,
            'status' => 200,
            'message' => 'User logout successfully'
        ];
        return response()->json($response);
    }

    // forget password api method

    public function forgetPassword(Request $request)
    {
        //dd("forgetPassword");
        $validator = Validator::make($request->all(), [
            'email' => 'string|required|email'
        ]);
        $user = User::where('email', $request->email)->first();
        if ($user) {
            $newPassword = Str::random(8);
            // dd($user); die;
            $data['title'] = "Password Reset : ";
            $data['password'] = $newPassword;
            $user['email'] = $request->email;
            $user['subject'] = 'Your New Password';

            $senMail = Mail::send('mail', $data, function ($message) use ($user) {
            
                $message->to($user['email']);
                $message->subject($user['subject']);
                
            });

            if($senMail){

            $changePassword = bcrypt($newPassword);
            $updatePassword = User::where('email', $request->email)
                ->update([
                    'password' => $changePassword,
                ]);

            $response = [
                'success' => true,
                'status' => 200,
                'message' => 'Please check your mail to reset your password'
            ];
            return response()->json($response);
            }else{
                $response = [
                    'success' => false,
                    'message' => 'Mail not sent, try after some time'
                ];
                return response()->json($response);
            }
        } else {
            $response = [
                'success' => false,
                'status' => 400,
                'message' => 'User not found'
            ];
            return response()->json($response);
        }
    }
    // end forget password api method


    // change password api method

    public function changePassword(Request $request)
    {
        // dd(Auth::user());
        $validator = Validator::make($request->all(), [
            'oldPassword' => 'string|required|min:6',
            'newPassword' => 'string|required|min:6'
        ]);

        if ($validator->fails()) {
            $response = [
                'success' => false,
                'status' => 400,
                'message' => $validator->errors()
            ];

            return response()->json($response);
        }

        $currentPasswordCheck = Hash::check($request->oldPassword, auth()->user()->password);

        if ($currentPasswordCheck) {
            $user = User::find(Auth::user()->id)->update([
                'password' => Hash::make($request->newPassword)
            ]);

            $response = [
                'success' => true,
                'status' => 200,
                'message' => 'Password has been changed successfully'
            ];
            return response()->json($response);
        } else {
            $response = [
                'success' => false,
                'status' => 400,
                'message' => 'Old password is incorrect'
            ];
            return response()->json($response);
        }
    }

    // change passwod from token

    public function passwordChange(Request $request)
    {
        // return("here");
        $validation = Validator::make($request->all(), [
            'oldPassword' => 'string|required|min:6',
            'newPassword' => 'string|required|min:6'
        ]);

        if ($validation->fails()) {
            $response = [
                'success' => false,
                'status' => 400,
                'message' => $validation->errors()
            ];

            return response()->json($response);
        }

        $user = $request->user();
        // dd($user);
        if (Hash::check($request->oldPassword, $user->password)) {
            $newPassword = Hash::make($request->newPassword);
            $user->update([
                'password' => $newPassword
            ]);

            $response = [
                'suceess' => true,
                'status' => 200,
                'message' => 'Password has been successfully changed'
            ];

            return response()->json($response);
        } else {
            $response = [
                'success' => false,
                'status' => 400,
                'message' => 'Old password is incorrect'
            ];

            return response()->json($response);
        }
    }
    
    public function userwalletap(){
        if(auth('sanctum')->check()){
            $userId = auth('sanctum')->user()->id;
            $user = User::select(['total_point_available as total_ap', 'total_cash_available as total_wallet'])->where('id', $userId)->first();
            if ($user) {
                $response = [
                    'suceess' => true,
                    'status' => 200,
                    'data'=>$user
                ];
    
                return response()->json($response);
            }
        }else{
            $response = [
                'success' => false,
                'status' => 400,
                'message' => 'Invalid user'
            ];

            return response()->json($response);
        }

    }

    public function redeemPoints(){
        if(auth('sanctum')->check()){
            $userId = auth('sanctum')->user()->id;

            $user = User::find($userId);
            
            $userPoint = $user->total_point_available;
            // $userPoint = 77;
            $minimunPointRequired = 4;
            if($userPoint >= $minimunPointRequired){
                // dd("here");
                 //lets 10 point = 1rs
                $conversion = (int)$userPoint / (int)$minimunPointRequired;
                $decuctPoint = (int)$conversion * (int)$minimunPointRequired;
                $balancePoint = (int)$userPoint - (int)$decuctPoint;
                $getCash = (int)$conversion;

                // user data
                $cashAvailable = $user->total_cash_available;
                $updateCash = (int)$cashAvailable + (int)$getCash;
                
                // $userPoint

                $user->total_cash_available = $updateCash;
                $user->total_point_available = $balancePoint;
                
                $updateUserData = User::where('id', $userId)->update([
                    'total_point_available' => $balancePoint,
                    'total_cash_available' => $updateCash
                ]);
                
                $response = [
                    'suceess' => true,
                    'status' => 200,
                    'message' => 'You successfully redeem your point'
                ];
    
                return response()->json($response);
            }else{
                // low balance
                // dd("here");
                $message = 'Low balance . Minimum required to redeem' . $minimunPointRequired;

                $response = [
                    'suceess' => false,
                    'status' => 404,
                    'message'=>$message
                ];
    
                return response()->json($response);
            }
        }else{
            
            $response = [
                'success' => false,
                'status' => 400,
                'message' => 'Invalid user'
            ];

            return response()->json($response);
        }

    }
}
