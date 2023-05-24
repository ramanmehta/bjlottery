<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules\Password;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = User::orderBy('id', 'DESC')
            ->when($request->has('search'), function ($q) use ($request) {
                $search = $request->search;
                $q->where('username', 'LIKE', '%' . $search . '%')
                    ->orwhere('name', 'LIKE', '%' . $search . '%')
                    ->orWhere('email', 'LIKE', '%' . $search . '%')
                    ->orWhere('phone', 'LIKE', '%' . $search . '%')
                    ->orWhere('country', 'LIKE', '%' . $search . '%');
            })
            ->paginate(10);

        return view('admin.users.index', compact('user'));
    }

    public function userStatus(Request $request, $id)
    {
        $userid = decrypt($id);
        $user = User::find($userid);
        $status = $user->status;

        if ($status == 1) {

            $deactivate = $user->status = '0';

            $user->save();

            $userStatus = User::where('id', $userid)->update([
                'status' => $deactivate
            ]);
            $success = "User deactivated successfully";
            return redirect('/admin/viewUser')->with('success', $success);
        } else {
            $activated = $user->status = '1';

            $user->save();

            $userStatus = User::where('id', $userid)->update([
                'status' => $activated
            ]);
            $success = "User activated successfully";
            return redirect('/admin/viewUser')->with('success', $success);
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
        //->join('countries', 'users.country', "=", 'countries.sortname')
        //->select('users.id','users.name','users.username','users.email','users.phone','users.country','users.address_1','users.address_2','users.city','users.state','users.country','users.zip','users.status','users.logo','users.total_point_available','users.total_cash_available','users.password','countries.countries')
        //->where('users.id', $userid)->first();

        $phone = $user->phone;

        $code = substr($phone, 0, strrpos($phone, '-'));
        $countryCode = substr($code, 1);

        $phone = substr($phone, strrpos($phone, '-') + 1);

        $country = DB::table('countries')->get();

        return view('admin.users.edit', compact('user', 'country', 'countryCode', 'phone'));
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
            'username' => 'bail|string|required|max:255|unique:users,username,' . $userid,
            'email' => 'bail|string|required|email|max:255|unique:users,email,' . $userid,
            'countryCode' => 'bail|required',
            'phone' => 'required|digits_between:6,12',
            'address_1' => 'string|required|min:1|max:200',
            'address_2' => 'string|required|min:1|max:200',
            'city' => 'string|required|min:1|max:50',
            'state' => 'string|required|min:1|max:50',
            'country' => 'string|required|min:1|max:50',
            'zip' => 'string|required|min:1|max:50'
        ];


        $validErrArr = [];
        if ($image != null) {
            $validArr['userimage'] = ['mimes:jpeg,jpg,png,gif|required'];
            $validErrArr['userimage'] = ['required' => 'upload image is required', 'mimes' => 'Only images with extension jpeg,jpg,png,gif are allowed.'];
        }

        $request->validate($validArr, $validErrArr);

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
        $success = "$user->name profile updated successfully";
        return redirect('/admin/viewUser')->with('success', $success);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $userid = (int)decrypt($id);

        User::destroy($userid);
        
        return redirect('/admin/viewUser')->with('error', "User removed successfully");
    }

    public function userAppoint(Request $request, $id)
    {
        $userid = (int)decrypt($id);
        $user = User::findOrFail($userid);

        return view('admin.users.editappoint')->with('user', $user);
    }

    public function updateAppoint(Request $request, $id)
    {
        $request->validate([
            'affilatepoint' => 'required|numeric',
        ]);
        $userid = (int)decrypt($id);
        $user = User::findOrFail($userid);

        $user = User::findOrFail($userid);
        $user->total_point_available = $request->affilatepoint;

        $user->save();
        $success = "$user->name affilate point updated successfully";
        return redirect('/admin/viewUser')->with('success', $success);
    }

    public function editWallet(Request $request, $id)
    {

        $userid = (int)decrypt($id);
        $user = User::findOrFail($userid);
        return view('admin.users.editwallet')->with('user', $user);
    }

    public function updateWallet(Request $request, $id)
    {
        $request->validate([
            'wallet' => 'required|numeric',
        ]);
        $userid = (int)decrypt($id);
        $user = User::findOrFail($userid);
        $user->total_cash_available = $request->wallet;

        $user->save();
        $success = "$user->name wallet updated successfully";
        return redirect('/admin/viewUser')->with('success', $success);
    }

    public function changePassword(Request $reques, $id)
    {
        $userid = (int)decrypt($id);
        $user = User::findOrFail($userid);

        return view('admin.users.resetpassword')->with('user', $user);
    }
    public function passwordReset(Request $request, $id)
    {
        $request->validate([
            'password' => [
                'required',
                Password::min(size: 6)
                    ->letters()
                    ->numbers()
                    ->symbols()
            ],
            'ConfirmPassword' => 'string|required|same:password',
        ]);

        $userid = (int)decrypt($id);
        $user = User::findOrFail($userid);
        $user->password = bcrypt($request->password);

        $user->save();
        $success = "$user->name password reset successfully";
        return redirect('/admin/viewUser')->with('success', $success);
    }
}