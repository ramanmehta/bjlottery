<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Role;

use Illuminate\Http\Request;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $role = Role::get();

        return view('admin.roles.index', compact('role'));
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

        Role::create($request->all());

        return redirect()->route('viewRoles');
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

        return view('admin.roles.edit', compact('role'));
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

        return redirect()->route('viewRoles')->with('success', "Role updated successfully");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $roleId = (int) decrypt($id);

        Role::where('id', $roleId)->delete();

        return redirect('viewRoles')->with('error', "Role removed successfully");
    }
}