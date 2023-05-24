<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Notification;

class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $notification = Notification::orderBy('id', 'DESC')
            ->when($request->has('search'), function ($q) use ($request) {
                $search = $request->search;
                $q->where('title', 'LIKE', '%' . $search . '%')
                    ->orWhere('description', 'LIKE', '%' . $search . '%')
                    ->orWhere('user_id', 'LIKE', '%' . $search . '%');
            })
            ->paginate(10);

        return view('admin.notifications.index', compact('notification'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.notifications.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'bail|required|exists:users,id',
            'title' => 'required',
            'description' => 'bail|required',
            'sent_at' => 'required',
            'status' => 'required'
        ]);

        Notification::create($request->all());
        
        return redirect()->route('notifications')->with('success', "New Notification created successfully");
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
        $notificationid = decrypt($id);

        $notification = Notification::findOrFail($notificationid);

        return view('admin.notifications.edit', compact('notification'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'user_id' => 'bail|required|exists:users,id',
            'title' => 'required',
            'description' => 'bail|required',
            'sent_at' => 'required',
            'status' => 'required'
        ]);
        
        $notificationid = decrypt($id);
        $notification = Notification::findOrFail($notificationid);
        $notification->user_id = $request->user_id;
        $notification->title = $request->title;
        $notification->description = $request->description;
        $notification->sent_at = $request->sent_at;
        $notification->status = $request->status;

        $notification->save();
        
        return redirect()->route('notifications')->with('success', "Notification updated successfully.");
    }
    
    /**
     * Remove the specified resource from storage.
    */
    public function destroy($id)
    {
        $notificationid = decrypt($id);

        Notification::destroy($notificationid);
        
        return redirect()
            ->route('notifications')
            ->with('error', "Notification deleted successfully!.");
    }
}