<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\HasApiTokens;
use Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\URL;
use DB;
// models 
use App\Models\User;
use App\Models\ReferalPoint;
use App\Models\ReferalsStats;
use App\Models\DailyReward;
use App\Models\RewardType;
use App\Http\Traits\CommonTrait;

class AuthController extends Controller
{
    use CommonTrait;
    public function register(Request $request, $ref = '')
    {

        $validator = Validator::make($request->all(), [
            'name' => 'string|required|min:1',
            'username' => 'nullable|string|min:1|max:20|unique:users',
            // 'role_id' => 'integer|required|min:1|max:20',
            'email' => 'string|required|email|max:100|unique:users',
            'phone' => 'required|numeric|digits:10',
            'address_1' => 'nullable|string|min:1|max:200',
            'address_2' => 'nullable|string|min:1|max:200',
            'city' => 'nullable|string|min:1|max:50',
            'state' => 'nullable|string|min:1|max:50',
            'country' => 'nullable|string|min:1|max:50',
            'zip' => 'nullable|string|min:1|max:50',
            'referal_code' => 'nullable|string|min:6|max:6',
            // 'password' => 'string|required|min:6',
            'password' => [
                'required',
                Password::min(size: 6)
                    ->letters()
                    ->numbers()
                    ->symbols()
            ],
            'c_password' => 'string|required|same:password',
            'logo' => 'nullable|image|mimes:jpg,png,jpeg,gif,svg|max:2048|dimensions:min_width=10,min_height=10,max_width=1000,max_height=1000',
        ]);

        if ($validator->fails()) {

            $response = [
                'success' => false,
                'status' => 404,
                'message' => $validator->errors()
            ];

            return response()->json($response);
        }
        
        $ref = isset($request->all()['referal_code']) && !empty($request->all()['referal_code']) ? $request->all()['referal_code'] : '';
        // referal code validation
        $refered_by = '';

        if ($ref) {
            $refralCheck = User::checkReferralCode($request->all()['referal_code']);

            if (!$refralCheck) { // no referal code exists
                $response = [
                    'success' => false,
                    'status' => 404,
                    'message' => 'Invalid referal code!'
                ];

                return response()->json($response);
            } else {
                // echo "here";
                //$refererData = User::where('referal_code', $ref)->first();
                $refered_by = $refralCheck->id;

                // $checkReferal = ReferalPoint::where('referal_code', $ref)->count();
                // dd($checkReferal);
                // if ($checkReferal == 1) {
                //     $checkReferal = ReferalPoint::where('referal_code', $ref)->first();
                //     $checkReferalPoint = $checkReferal->referal_point;
                //     $getPoint = RewardType::where('reward_type', 'referal')->first();
                //     $referalPoint = $getPoint->reward_points;
                //     $total_referal_point = $checkReferalPoint + $referalPoint;
                //     $checkReferal->update([
                //         'referal_point' => $total_referal_point
                //     ]);
                // } else {
                //     $response = [
                //         'success' => false,
                //         'message' => 'Referal code not exists'
                //     ];
                //     return response()->json($response, 400);
                // }
            }
        }

        $input = $request->all();
        // dd($input);
        $user_referal = $this->referalCode(); // Str::random(10);
        $input['password'] = bcrypt($input['password']);
        $input['logo'] = "/usersimage/avatar.png";
        $input['referal_code'] = $user_referal;
        if (isset($refered_by) && !empty($refered_by)) {
            $input['refered_by'] =  $refered_by;
        }
        $user = User::create($input);


        $user_id = $user->id;

        $url = URL::to('/');
        $referal_link = $url . '/api/referal-register/' . $user_referal;
        // RewardType
        // $getReferal = RewardType::where('reward_type' , 'referal')->first();
        // $referalPoint = $getReferal->reward_points;
        $referalPoint = 0;
        $referalType = "referal";
        $data = [
            'user_id' => $user_id,
            'referal_code' => $user_referal,
            'referal_link' => $referal_link,
            'referal_point' => $referalPoint,
            'referal_type' => $referalType
        ];

        if (isset($refered_by) && !empty($refered_by)) {
            $data['refered_by'] = $refered_by;
        }

        $referal = ReferalPoint::create($data);
        // referal status 
        // if ($user_referal != '') {
        //     $countReferal = ReferalPoint::where('referal_code', $user_referal)->count();
        //     if ($countReferal == 1) {
        //         $checkReferal = ReferalPoint::where('referal_code', $user_referal)->first();
        //         $parentReferalId = $checkReferal->id;
        //         $referalLink = $checkReferal->referal_link;
        //         $referalCode = $checkReferal->referal_code;
        //         // $getReferalType = RewardType::where('reward_type' , 'referal')->first();

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
        $success['token'] = $user->createToken('MyApp')->plainTextToken;

        $userData = User::where(['id' => $user_id])->first();
        $success['user'] = $userData;
        // $success['name'] = $user->name;

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
        $username = $request->username;
        $password = $request->password;

        $validator = Validator::make($request->all(), [
            'username' => 'string|required',
            'password' => 'string|required'
        ]);


        if (filter_var($username, FILTER_VALIDATE_EMAIL)) {

            $user1 = User::where('email', $username)->exists();

            if ($user1) {

                $user = User::where('email', $username)->first();

                if ($user->status == 1) {

                    if (Auth::attempt([
                        'email' => $request->username,
                        'password' => $request->password
                    ])) {
                        $user = Auth::user();
                        $success['token'] = $user->createToken('MyApp')->plainTextToken;
                        $success['user'] = $user;
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
                } else {
                    $response = [
                        'success' => false,
                        'status' => 400,
                        'message' => 'User is inactive. Contact Us'
                    ];

                    return response()->json($response);
                }
            } else {
                $response = [
                    'success' => false,
                    'status' => 400,
                    'message' => 'Please register first'
                ];
                return response()->json($response);
            }
        } else {

            $user1 = User::where('username', $username)->count();

            if ($user1 > 0) {
                $user = User::where('username', $username)->first();
                if ($user->status == 1) {
                    if (Auth::attempt([
                        'username' => $request->username,
                        'password' => $request->password
                    ])) {

                        $user = Auth::user();
                        $success['token'] = $user->createToken('MyApp')->plainTextToken;
                        $success['user'] = $user;
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
                } else {
                    $response = [
                        'success' => false,
                        'status' => 400,
                        'message' => 'User is inactive. Contact Us'
                    ];

                    return response()->json($response);
                }
            } else {

                $response = [
                    'success' => false,
                    'status' => 400,
                    'message' => 'Please register first'
                ];
                return response()->json($response);
            }
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

            if ($senMail) {

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
            } else {
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

    public function userwalletap()
    {
        if (auth('sanctum')->check()) {
            $userId = auth('sanctum')->user()->id;
            $user = User::select(['total_point_available as total_ap', 'total_cash_available as total_wallet'])->where('id', $userId)->first();
            if ($user) {
                $response = [
                    'suceess' => true,
                    'status' => 200,
                    'data' => $user
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

    public function redeemPoints()
    {
        if (auth('sanctum')->check()) {
            $userId = auth('sanctum')->user()->id;

            $user = User::find($userId);

            $userPoint = $user->total_point_available;
            // $userPoint = 77;
            $minimunPointRequired = 4;
            if ($userPoint >= $minimunPointRequired) {
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
            } else {
                // low balance
                // dd("here");
                $message = 'Low balance . Minimum required to redeem' . $minimunPointRequired;

                $response = [
                    'suceess' => false,
                    'status' => 404,
                    'message' => $message
                ];

                return response()->json($response);
            }
        } else {

            $response = [
                'success' => false,
                'status' => 404,
                'message' => 'Invalid user'
            ];

            return response()->json($response);
        }
    }


    public function updateUser(Request $request)
    {
        $userid = auth('sanctum')->user()->id;

        $validator = Validator::make($request->all(), [
            'name' => 'string|required|min:1',
            'username' => 'required|string|min:1|max:20|unique:users,username,' . $userid,
            'email' => 'string|required|email|max:100|unique:users,email,' . $userid,
            'phone' => 'required|numeric|digits:10',
            'address_1' => 'nullable|string|min:1|max:200',
            'address_2' => 'nullable|string|min:1|max:200',
            'city' => 'nullable|string|min:1|max:50',
            'state' => 'nullable|string|min:1|max:50',
            'country' => 'nullable|string|min:1|max:50',
            'zip' => 'nullable|string|min:1|max:50',
            'logo' => 'nullable|image|mimes:jpg,png,jpeg,gif,svg|max:2048|dimensions:min_width=10,min_height=10,max_width=1000,max_height=1000',
        ]);

        if ($validator->fails()) {
            $response = [
                'success' => false,
                'status' => 404,
                'message' => $validator->errors()
            ];

            return response()->json($response);
        }

        $getUser = DB::table('users')->find($userid);
        $image = $request->file('userimage');

        if ($image != null) {
            $randomNumber = rand();
            $imageName = $randomNumber . $image->getClientOriginalName();
            $image->storeAs('public/images/usersimage', $imageName);
        }

        $phone = '+' . $request->countryCode . '-' . $request->phone;

        $user = User::findOrFail($userid);
        $user->name = $request->name;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->phone = $phone;
        $user->address_1 = $request->address_1;
        $user->address_2 = $request->address_2;
        $user->city = $request->city;
        $user->state = $request->state;
        $user->country = $request->country;
        $user->zip = $request->zip;
        $user->country = $request->country;
        if (!empty($image)) {
            ($user->logo = '/usersimage/' . $imageName);
        } else {
            if (!empty($getUser->logo)) {
                ($user->logo = $getUser->logo);
            } else {
                ($user->logo = "/usersimage/avatar.png");
            }
        }

        $user->save();

        $response = [
            'suceess' => true,
            'status' => 200,
            'message' => 'Your profile updated successfully'
        ];

        return response()->json($response);
    }

    public function profileUpdate(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'logo' => 'nullable|image',
            'name' => 'required|max:150',
            'email' => 'required|email',
            'phone' => 'required|numeric',
            'current_password' => 'nullable',
            'new_password' => 'required_with:current_password',
        ]);

        if ($validated->fails()) {

            $response = [
                'success' => false,
                'status' => 404,
                'message' => $validated->errors()
            ];

            return response()->json($response);
        }

        $data = $validated->validated();

        if (! is_null($data['current_password']) && !\Hash::check($data['current_password'], auth()->user()->password)) {

            $response = [
                'success' => false,
                'status' => 404,
                'message' => 'Plase enter valid current password'
            ];

            return response()->json($response);
        }

        $user = auth()->user();

        if (isset($data['new_password']) && ! is_null($data['new_password'])) {
            
            $user->password = bcrypt($data['new_password']);
        }

        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->phone = $data['phone'];

        if ($request->has('logo')) {

            $image = $request->file('logo');

            $user->logo = rand() . $image->getClientOriginalName();

            $image->storeAs('public/images/usersimage', $user->logo);
        }

        $user->save();

        $success['user'] = auth()->user();

        $response = [
            'success' => true,
            'status' => 200,
            'data' => $success,
            'message' => 'User Profile Updated successfully'
        ];

        return response()->json($response);
    }
}
