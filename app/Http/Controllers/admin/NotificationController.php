<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Notification;
use App\Models\User;
use DB;

class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {   
        if($request->has('search')){

            $search = $request->search;
            $notification = DB::table('notifications')
                ->where('title' , 'LIKE' , '%'.$search.'%')
                ->orWhere('description' , 'LIKE' , '%'.$search.'%')
                ->orWhere('user_id' , 'LIKE' , '%'.$search.'%')
                ->paginate(2);

            }else{

                $notification = Notification::orderBy('id', 'DESC')->paginate(2);

            }
        
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
        // dd($request->all());
        $notification = Notification::create($request->all());

        $success = "New Notification created successfully";
        return redirect()->route('notifications')->with('success',$success);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    public function notificationStatus(Request $request , $id){
        $notification_id = decrypt($id);
        $notification = Notification::find($notification_id);
        $status = $notification->status;

        if($status == 1){
           
            $deactivate = $notification->status = '0';
           
            $notification->save();

            $notificationStatus = Notification::where('id', $notification_id)->update([
                'status' => $deactivate
            ]);
            $success = "Notification deactivated successfully";
            return redirect()->route('notifications')->with('success',$success);
            
        }else{
            $activated = $notification->status = '1';
           
            $notification->save();

            $userSnotificationStatustatus = Notification::where('id', $notification_id)->update([
                'status' => $activated
            ]);
            $success = "Notification activated successfully";
            return redirect()->route('notifications')->with('success',$success);
        }
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {   
        // dd($id);
        $notificationid = decrypt($id);
        $notification = Notification::findOrFail($notificationid);
        return view('admin.notifications.edit',compact('notification'));
    
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // dd($id);
        $request->validate([
            'user_id' => 'bail|required|exists:users,id',
            'title' => 'required',
            'description' => 'bail|required',
            'sent_at' => 'required',
        ]);
        // dd($request->all());
        $notificationid = decrypt($id);
        $notification = Notification::findOrFail($notificationid);
        $notification->user_id = $request->user_id;
        $notification->title = $request->title;
        $notification->description = $request->description;
        $notification->sent_at = $request->sent_at;

        $notification->save();
        $success = "Notification updated successfully";
        return redirect()->route('notifications')->with('success',$success);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // dd($id);
        $notificationid = decrypt($id);
        $notification = Notification::findOrFail($notificationid);
        $notification->delete();
    }
}
