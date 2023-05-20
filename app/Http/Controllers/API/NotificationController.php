<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Notification;

class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $notification = Notification::where('user_id', auth()->id())
            ->select('id', 'title', 'description', 'status', 'sent_at')
            ->orderBy('id', 'desc')
            ->get();

        $resource = [
            'success' => true,
            'message' => 'Notification List',
            'data' => $notification
        ];

        return response()->json($resource);
    }

    /**
     * Display the specified resource.
     */

    public function show($id)
    {
        $notification = Notification::select('id', 'title', 'description', 'status', 'sent_at')->find($id);

        $resource = [
            'success' => true,
            'message' => 'Notification In Details',
            'data' => $notification
        ];

        return response()->json($resource);
    }

    public function readAll()
    {
        Notification::where('user_id', auth()->id())
            ->update([
                'status' => 1
            ]);

        $resource = [
            'success' => true,
            'message' => 'All notifications marked read',
            'data' => []
        ];

        return response()->json($resource);
    }

    public function destroy()
    {
        Notification::where('user_id', auth()->id())
            ->delete();

        $resource = [
            'success' => true,
            'message' => 'All Notification successfully deleted',
            'data' => []
        ];

        return response()->json($resource);
    }
}
