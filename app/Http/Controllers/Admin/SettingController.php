<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $setting = Setting::all();
        return view('admin.settings.index', compact('setting'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.settings.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'key' => 'bail|string|required|max:255|unique:settings',
            'value' => 'required|string'
        ]);
        // echo "<pre>";
        // print_r($request->all());

        $setting = Setting::create($request->all());
        $success = "New setting created successfully";
        return redirect()->route('settings')->with('success', $success);
    }

    /**
     * Display the specified resource.
     */
    public function show(Setting $setting)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {

        if ($id) {
            $settingid = decrypt($id);
            // dd($settingid);
            $setting = Setting::findOrFail($settingid);
            return view('admin.settings.edit', compact('setting'));
        } else {
            return redirect()->route('admin.auth');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // dd($request->all());
        $request->validate([
            'key' => 'bail|string|required|max:255',
            'value' => 'required|string'
        ]);
        $settingid = decrypt($id);
        $setting = Setting::findOrFail($settingid);
        $setting->key = $request->key;
        $setting->value = $request->value;
        $setting->save();

        $success = "Setting successfully updated";

        return redirect()->route('settings')->with('success', $success);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // dd($id);
        $settingid = decrypt($id);
        $setting = Setting::findOrFail($settingid);

        $setting->delete();

        $error = "Setting removed successfully";

        return redirect()->route('settings')->with('error', $error);
    }
}
