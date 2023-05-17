<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Admin;

use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    //login view page

    public function index(Request $request)
    {
        if ($request->session()->has('ADMIN_LOGIN')) {
            return redirect('admin/dashboard');
        } else {
            return  view('admin.login');
        }
    }

    //function for check login details

    public function login(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'email' => 'bail|string|required|email|max:255',
            'password' => 'required'
        ]);
        $email = $request->email;
        $password = $request->password;

        $admin = Admin::where('email', $email)->first();
        if (!$admin || !Hash::check($password, $admin->password)) {
            echo 'Invalid login username or password!';
            $request->session()->flash('error', 'Please enter valid login details');
            return redirect('admin');
        } else {
            $id = $admin->id;
            $user = [$admin->id, $admin->name, $admin->phone, $admin->email, $admin->logo];
            //print_r($user);die;
            //$adminDetail = ['name' => $admin->name];
            $name = "smtekki";
            $request->session()->put('ADMIN_LOGIN', true);
            $request->session()->put('ADMIN_ID', $id);
            $request->session()->put('ADMIN_USER', $user);
            return redirect('admin/dashboard');
        }
    }

    // function for logout admin

    public function logout()
    {
        session()->forget('ADMIN_LOGIN');
        session()->forget('ADMIN_ID');
        session()->forget('ADMIN_USER');
        session()->flash('error', 'Logout Successfully');
        return redirect('admin');
    }

    // create new admin view

    public function create()
    {
        // return view();
    }

    //function for register admins
    // public function register(Request $request){

    // $request->validate([
    //     'name' => 'string|required|min:1',
    //     // 'role_id' => 'integer|required|min:1|max:20',
    //     'email' => 'string|required|email|max:100|unique:admins',
    //     'phone' => 'required|numeric|digits:10',            
    //     'password' => 'string|required|min:6',
    //     'c_password' => 'string|required|same:password'
    // ]);

    // $admin = Admin::create($request->all());

    // $success = "Admin created successfully";

    // return redirect()->route('')->with('')

    // $admin = new Admin();
    // $admin->name = "admin1";
    // $admin->email = "admin1@gmail.com";
    // $admin->phone = "9988998899";
    // $admin->password = Hash::make('12345');
    // $admin->save();

    // return("set user");

    // }

    //dashboard view page

    public function dashboard()
    {
        return  view('admin.dashboard');
    }
}
