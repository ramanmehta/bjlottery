<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Role;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //dd("here role api");
        $role = Role::all();
        if ($role->count() > 0) {
            return response()->json([
                'status' => 200,
                'roles' => $role
            ], 200);
        } else {
            return response()->json([
                'status' => 404,
                'Roles' => 'No records found'
            ], 404);
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
        // $role =  Role::findOrFail($id);
        // var_dump(Role::findOrFail($id));
        $role =  Role::find($id);
        if ($role) {

            return response()->json([
                'status' => 200,
                'role' => $role
            ], 200);
        } else {

            return response()->json([
                'status' => 404,
                'message' => 'No role found',
            ], 404);
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
}
