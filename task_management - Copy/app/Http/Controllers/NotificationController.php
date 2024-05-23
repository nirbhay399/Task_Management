<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $notifications = $user->notifications()->paginate(10);
        $unreadNotifications = $user->unreadNotifications;

        return view('notifications.index', compact('notifications', 'unreadNotifications'));
    }

    public function markAsRead($id)
    {
        $notification = Auth::user()->notifications()->find($id);

        if ($notification) {
            $notification->markAsRead();
        }

        return redirect()->back();
    }    

    public function getUnreadNotifications()
    {
        $user = Auth::user();
        $notifications = $user->unreadNotifications;

        return response()->json([
            'notifications' => $notifications,
            'unread_count' => $notifications->count(),
        ]);
    }

    public function getUnreadCount()
    {
        $user = Auth::user();
        $unreadCount = $user->unreadNotifications->count();

        return response()->json([
            'unread_count' => $unreadCount,
        ]);
    }
}
