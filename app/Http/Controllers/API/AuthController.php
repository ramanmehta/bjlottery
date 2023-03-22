<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\PasswordReset;
use Illuminate\Http\Request;
use Validator;
use App\Models\User;
use Auth;
use Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Carbon\Carbon;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        //validation
        $validator = Validator::make($request->all(), [
            'name' => 'string|required|min:1',
            'username' => 'string|required|min:1|max:20|unique:users',
            'email' => 'string|required|email|max:100|unique:users',
            'phone' => 'required|numeric|digits:10',
            'address_1' => 'string|required|min:1|max:200',
            'address_2' => 'string|required|min:1|max:200',
            'city' => 'string|required|min:1|max:50',
            'state' => 'string|required|min:1|max:50',
            'country' => 'string|required|min:1|max:50',
            'zip' => 'string|required|min:1|max:50',
            'password' => 'string|required|min:6',
            'c_password' => 'string|required|same:password'
        ]);

        if ($validator->fails()) {
            $response = [
                'success' => false,
                'message' => $validator->errors()
            ];
            return response()->json($response, 400);
        }

        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);

        $success['token'] = $user->createToken('MyApp')->plainTextToken;
        $success['name'] = $user->name;

        $response = [
            'success' => true,
            'data' => $success,
            'message' => 'User register successfully'
        ];

        return response()->json($response, 200);
    }


    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'string|required',
            'password' => 'string|required'
        ]);

        if(Auth::attempt([
            'username' => $request->username,
            'password' => $request->password
            ])){
            // var_dump($request->username);
            $user = Auth::user();
            $success['token'] = $user->createToken('MyApp')->plainTextToken;
            $success['name'] = $user->name;

            $response = [
            'success' => true,
            'data' => $success,
            'message' => 'User login successfully'
            ];
            return response()->json($response, 200);
        }else{
            $response = [
            'success' => false,
            'message' => 'username or password is incorrect'
            ];

            return response()->json($response);

        }
    }

    // forget password api method

    public function forgetPassword(Request $request){

        $validator = Validator::make($request->all(), [
            'email' => 'string|required|email'
        ]);
        $user = User::where('email', $request->email)->get();

        if(count($user) > 0){
            $newPassword = Str::random(8);
                 
            $data['email'] = $request->email;
            $data['title'] = "Password Reset";
            $data['body'] = "New password : ". $newPassword;

            $mail = Mail::send('forgetPasswordmail',['data'=>$data],function($message) use ($data){
                $message->to($data['email'])->subject($data['title']);
            });

            if($mail){

                $changePassword = bcrypt($newPassword);
                $updatePassword = User::where('email', $request->email)
                ->update([
                    'password' => $changePassword, 
                ]);

                $response = [
                    'success' => true,
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
        }else{
            $response = [
                'success' => false,
                'message' => 'User not found'
            ];
            return response()->json($response);
        }
        
    }
    // end forget password api method

}
