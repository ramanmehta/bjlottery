<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use App\Models\Country;
use DB;
use Validator;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //$user = User::all();
        // $roles = Role::all();
         $user = DB::table('users')
                    ->join('roles','users.role_id', "=", 'roles.id')
                    ->select('users.id','users.name','users.username','users.email','users.phone','users.country','users.status','users.logo','roles.role_title')->get();
        
        

         //echo "<pre>";
        // print_r($country);die;
        return view('admin.users.index')->with('user',$user);
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
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {   
        $userid = decrypt($id);
       
        $user = DB::table('users')
                    ->join('roles','users.role_id', "=", 'roles.id')
                    ->join('countries', 'users.country', "=", 'countries.sortname')
                    ->select('users.id','users.name','users.username','users.email','users.phone','users.country','users.address_1','users.address_2','users.city','users.state','users.country','users.zip','users.status','users.role_id','users.logo','roles.role_title','countries.countries')
                    ->where('users.id', $userid)->first();
                    
        $country = DB::table('countries')->get();
        $roles = Role::where('status', 1)->get();    
        return view('admin.users.edit', ['user'=>$user , 'roles' => $roles,'country'=>$country]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // dd($request->file('userimage'));
        $userid = decrypt($id);    
        $image = $request->file('userimage');
        if($image != null){
            $randomNumber = rand();
            $imageName = $randomNumber.$image->getClientOriginalName();  
            $image->storeAs('public/images/usersimage',$imageName);
        }
        $request->validate([
            'name' => 'bail|string|required|max:255',
            'username' => 'bail|string|required|max:255',
            'role' => 'required',
            'email' => 'bail|string|required|email|max:255',
            'phone' => 'required|numeric|digits:10',
            'address_1' => 'string|required|min:1|max:200',
            'address_2' => 'string|required|min:1|max:200',
            'city' => 'string|required|min:1|max:50',
            'state' => 'string|required|min:1|max:50',
            'country' => 'string|required|min:1|max:50',
            'zip' => 'string|required|min:1|max:50',
            'status' => 'required'
        ]);
        //dd($request->all());
        $user = User::findOrFail($userid);
        $user->name = $request->name;
        $user->username = $request->username;
        $user->role_id = $request->role;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->address_1 = $request->address_1;
        $user->address_2 = $request->address_2;
        $user->city = $request->city;
        $user->state = $request->state;
        $user->country = $request->country;
        $user->zip = $request->zip;
        $user->status = $request->status;
        $user->country = $request->country;
        if ($image != null) {
            $user->logo = $imageName;
        }else{
            $user->logo = "avatar.png";
        }
       

        $user->save();
        $success = "User updated successfully";
        return redirect('/admin/viewUser')->with('success',$success);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $userid = (int)decrypt($id);
        // dd($userid);
        $deleteUser = $user = User::findOrFail($userid);;
        $deleteUser->delete();

        $error = "Role removed successfully";
        return redirect('/admin/viewUser')->with('error',$error);
    }

}
