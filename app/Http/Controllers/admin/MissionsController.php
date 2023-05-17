<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Mission;
use App\Models\MissionSubmission;
use Illuminate\Support\Facades\DB;

class MissionsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $mission = Mission::orderBy('id', 'DESC')
            ->when(isset($request->search), function ($q) use ($request) {
                $q->where('mission_title', 'like', "%{$request->search}%");
                $q->orWhere('mission_description', 'like', "%{$request->search}%");
            })
            ->paginate(10);

        return view('admin.missions.index', compact('mission'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.missions.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'mission_title' => 'bail|string|required|max:255|unique:missions',
            'mission_description' => 'required',
            'mission_type' => 'required',
            'enter_earn_affliated_points' => 'required_without:prize_name',
            'prize_name' => 'required_without:enter_earn_affliated_points',
            'prize_image' => 'required_without:enter_earn_affliated_points|image|mimes:jpg,jpeg,png,gif',
            'status' => 'required',
            'banner_image' => 'required|image|mimes:jpg,jpeg,png,gif'
        ]);

        if ($request->file('prize_image')) {

            $validated['prize_image'] = 'missions/' . time() . '.' . $request->prize_image->extension();

            $request->prize_image->storeAs('public/images', $validated['prize_image']);
        } else {

            unset($validated['prize_image'], $validated['prize_name']);
        }

        $validated['banner_image'] = 'missions/' . time() . '.' . $request->banner_image->extension();

        $request->banner_image->storeAs('public/images', $validated['banner_image']);

        Mission::create($validated);

        return redirect()->route('mission')->with('success', 'Mission created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    public function missionStatus(Request $request, $id)
    {
        $mission_id = decrypt($id);
        $mission = Mission::find($mission_id);
        $status = $mission->status;

        if ($status == 1) {

            $deactivate = $mission->status = '0';

            $mission->save();

            $missionStatus = Mission::where('id', $mission_id)->update([
                'status' => $deactivate
            ]);
            $success = "Mission deactivated successfully";
            return redirect('/admin/viewMission')->with('success', $success);
        } else {
            $activated = $mission->status = '1';

            $mission->save();

            $missionStatus = Mission::where('id', $mission_id)->update([
                'status' => $activated
            ]);
            $success = "Mission activated successfully";
            return redirect('/admin/viewMission')->with('success', $success);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $missionid = decrypt($id);

        $mission = Mission::findOrFail($missionid);

        return view('admin.missions.edit', ['mission' => $mission]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $id = decrypt($id);

        $validated = $request->validate([
            'mission_title' => 'bail|string|required|max:255|unique:missions,mission_title,' . $id,
            'mission_description' => 'required',
            'enter_earn_affliated_points' => 'required_without:prize_name',
            'prize_name' => 'required_without:enter_earn_affliated_points',
            'prize_image' => 'required_without:enter_earn_affliated_points|image|mimes:jpg,jpeg,png,gif',
            'status' => 'required',
            'banner_image' => 'nullable|image|mimes:jpg,jpeg,png,gif'
        ]);

        if ($request->file('prize_image')) {

            $validated['prize_image'] = 'missions/' . time() . '.' . $request->prize_image->extension();

            $request->prize_image->storeAs('public/images', $validated['prize_image']);
        } else {

            unset($validated['prize_image'], $validated['prize_name']);
        }

        if ($request->file('banner_image')) {

            $validated['banner_image'] = 'missions/' . time() . '.' . $request->banner_image->extension();

            $request->banner_image->storeAs('public/images', $validated['banner_image']);
        } else {

            unset($validated['banner_image']);
        }

        Mission::where('id', $id)->update($validated);

        return redirect()->route('mission')->with('success', 'Mission updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $missionid = decrypt($id);
        // dd($luckyDrawid);
        $mission = Mission::findOrFail($missionid);
        $mission->delete();
        MissionSubmission::where('mission_id', $missionid)->delete();
        $error = "Mission removed successfully";
        return redirect()->route('mission')->with('error', $error);
    }
}
