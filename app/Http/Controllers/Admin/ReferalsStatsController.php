<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ReferalsStats;

class ReferalsStatsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $referalstatus = ReferalsStats::all();

        return view('admin.referals_stats.index', compact('referalstatus'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.referals_stats.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'reward_types' => 'bail|required|unique:referals_stats',
            'reward_points' => 'integer|required',
            'status' => 'required'
        ]);

        ReferalsStats::create($request->all());

        return redirect()->route('referalstatus')->with('success', "New Referal Created successfully.");
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
    public function edit(Request $request, $id)
    {
        $referalstatusid = decrypt($id);

        $referalstatus = ReferalsStats::findOrFail($referalstatusid);

        return view('admin.referals_stats.edit', compact('referalstatus'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'reward_points' => 'integer|required',
            'status' => 'required'
        ]);

        $referalstatusid = decrypt($id);

        $referalstatus = ReferalsStats::findOrFail($referalstatusid);

        $referalstatus->reward_points = $request->reward_points;
        $referalstatus->status = $request->status;
        $referalstatus->save();
        
        return redirect()->route('referalstatus')->with('success', "Referal Status updated successfully");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $referalstatusid = decrypt($id);

        ReferalsStats::destroy($referalstatusid);
        
        return redirect()->route('referalstatus')->with('error', "Referal removed successfully");
    }
}