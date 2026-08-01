<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    /**
     * Fetch unread notifications for the logged-in admin.
     */
    public function fetch(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        // Fetch latest 10 notifications (both read and unread) to keep history
        $notifications = $user->notifications()->take(10)->get();
        // Count only unread for the badge
        $count = $user->unreadNotifications()->count();

        return response()->json([
            'count' => $count,
            'notifications' => $notifications
        ]);
    }

    /**
     * Mark all notifications as read.
     */
    public function markAsRead(Request $request)
    {
        $user = Auth::user();
        if ($user) {
            $user->unreadNotifications->markAsRead();
            return response()->json(['success' => true]);
        }
        return response()->json(['error' => 'Unauthorized'], 401);
    }
    
    /**
     * Mark a single notification as read.
     */
    public function markSingleAsRead(Request $request, $id)
    {
        $user = Auth::user();
        if ($user) {
            $notification = $user->unreadNotifications()->where('id', $id)->first();
            if ($notification) {
                $notification->markAsRead();
            }
            return response()->json(['success' => true]);
        }
        return response()->json(['error' => 'Unauthorized'], 401);
    }
}
