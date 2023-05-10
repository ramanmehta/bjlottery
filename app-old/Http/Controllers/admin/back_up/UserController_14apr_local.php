<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use App\Models\Country;
use DB;
use Validator;
use App\Http\Traits\CommonTrait;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {   
        
        if($request->has('search')){

            $search = $request->search;
            $user = DB::table('users')
                ->where('username' , 'LIKE' , '%'.$search.'%')
                ->orWhere('email' , 'LIKE' , '%'.$search.'%')
                ->orWhere('phone' , 'LIKE' , '%'.$search.'%')
                ->orWhere('country' , 'LIKE' , '%'.$search.'%')
                ->paginate(2);

        }else{

            $user = User::orderBy('id', 'DESC')->paginate(10);

        }
        
       
        return view('admin.users.index')->with('user',$user);
    }


    public function userStatus(Request $request , $id){
        $userid = decrypt($id);
        $user = User::find($userid);
        $status = $user->status;

        if($status == 1){
           
            $deactivate = $user->status = '0';
           
            $user->save();

            $userStatus = User::where('id', $userid)->update([
                'status' => $deactivate
            ]);
            $success = "User deactivated successfully";
            return redirect('/admin/viewUser')->with('success',$success);
            
        }else{
            $activated = $user->status = '1';
           
            $user->save();

            $userStatus = User::where('id', $userid)->update([
                'status' => $activated
            ]);
            $success = "User activated successfully";
            return redirect('/admin/viewUser')->with('success',$success);
        }
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {   
      
        $userid = decrypt($id);
        $user = User::find($userid);     
        // $user = DB::table('users')
        //             ->join('countries', 'users.country', "=", 'countries.sortname')
        //             ->select('users.id','users.name','users.username','users.email','users.phone','users.country','users.address_1','users.address_2','users.city','users.state','users.country','users.zip','users.status','users.logo','users.total_point_available','users.total_cash_available','users.password','countries.countries')
        //             ->where('users.id', $userid)->first();
          
        $country = DB::table('countries')->get();
        
        return view('admin.users.edit')->with('user',$user)->with('country',$country);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        
        $userid = decrypt($id);  
        $getUser = DB::table('users')->find($userid);  
        $image = $request->file('userimage');
        $validArr = [
                    'name' => 'bail|string|required|max:255',
                    'username' => 'bail|string|required|max:255|unique:users,username,'.$userid,
                    'email' => 'bail|string|required|email|max:255|unique:users,email,'.$userid,
                    'phone' => 'required|numeric|digits:10',
                    
                     //'password' => 'string|min:6',
                    'appoints' => 'required|numeric',
                    'wallet' => 'required|numeric',
                    'address_1' => 'string|required|min:1|max:200',
                    'address_2' => 'string|required|min:1|max:200',
                    'city' => 'string|required|min:1|max:50',
                    'state' => 'string|required|min:1|max:50',
                    'country' => 'string|required|min:1|max:50',
                    'zip' => 'string|required|min:1|max:50'
                ];
        
                
        $validErrArr = [];                
        if($image != null){
            $validArr['userimage'] = ['mimes:jpeg,jpg,png,gif|required'];
            $validErrArr['userimage'] = ['required'=>'upload image is required','mimes'=>'Only images with extension jpeg,jpg,png,gif are allowed.'];
        }

       

         $password = $request->password;
        if($password !='')
        {

            $validArr['password'] = 'min:6';
        }
       
        
        $request->validate($validArr,$validErrArr);
       
        if($image != null){
            $randomNumber = rand();
            $imageName = $randomNumber.$image->getClientOriginalName();  
            $image->storeAs('public/images/usersimage',$imageName);
        }
        
        
        
        $user = User::findOrFail($userid);
        $user->name = $request->name;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->total_point_available = $request->appoints;
        $user->total_cash_available = $request->wallet;
        $user->address_1 = $request->address_1;
        $user->address_2 = $request->address_2;
        $user->city = $request->city;
        $user->state = $request->state;
        $user->country = $request->country;
        $user->zip = $request->zip;
        $user->country = $request->country;
        if (!empty($image)) {
            ($user->logo = '/usersimage/'.$imageName);
        }else{
            if(!empty($getUser->logo)){
                ($user->logo = $getUser->logo);
            }else{
                ($user->logo = "/usersimage/avatar.png");
            }
        }
        if(!empty($request->password)){
            $user->password = bcrypt($request->password);
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
        $deleteUser = $user = User::findOrFail($userid);;
        $deleteUser->delete();

        $error = "User removed successfully";
        return redirect('/admin/viewUser')->with('error',$error);
    }


    public function userAppoint(Request $request, $id)
    {

    }

    public function userWallet(Request $request, $id)
    {

    }

    public function passwordReset(Request $request, $id)
    {

    }

}
