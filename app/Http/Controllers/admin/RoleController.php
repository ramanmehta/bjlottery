<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Validator;
use Illuminate\Http\Request;


class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $role = Role::all();
        // dd($role);
        
        return view('admin.roles.index',['role' => $role]);
        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {   

        return view('admin.roles.create');
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'role_title' => 'bail|string|required|max:255|unique:roles',
            'status' => 'required'
        ]);
 
        $role = Role::create($request->all());

        return redirect('/admin/viewRoles');
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

        $roleid = decrypt($id);
        $role = Role::where('id', $roleid)->first();

        return view('admin.roles.edit', ['role'=>$role]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {   
        $roleid = decrypt($id);
        $request->validate([
            // 'role_title' => 'bail|string|required|max:255',
            'status' => 'required'
        ]);
        $role = Role::where('id', $roleid)->first();
        // $role->role_title = $request->role_title;
        $role->status = $request->status;
        $role->save();
        $success = "Role updated successfully";
        return redirect('/admin/viewRoles')->with('success',$success);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $roleid = (int)decrypt($id);
    
        $deleteRole = Role::where('id' , $roleid)->first();
        $deleteRole->delete();

        $error = "Role removed successfully";
        return redirect('/admin/viewRoles')->with('error',$error);
    }
}
