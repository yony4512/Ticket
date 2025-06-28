<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = auth()->user()->notifications()
            ->latest()
            ->paginate(20);

        return view('notifications.index', compact('notifications'));
    }

    public function markAsRead(Notification $notification)
    {
        if ($notification->user_id !== auth()->id()) {
            abort(403);
        }

        $notification->markAsRead();

        return response()->json(['success' => true]);
    }

    public function markAllAsRead()
    {
        auth()->user()->unreadNotifications()->update(['read_at' => now()]);

        return response()->json(['success' => true]);
    }

    public function getUnreadCount(): JsonResponse
    {
        $count = auth()->user()->unreadNotifications()->count();
        
        return response()->json(['count' => $count]);
    }

    public function getRecentNotifications(): JsonResponse
    {
        $notifications = auth()->user()->notifications()
            ->latest()
            ->take(5)
            ->get();

        return response()->json(['notifications' => $notifications]);
    }

    public function destroy(Notification $notification)
    {
        if ($notification->user_id !== auth()->id()) {
            abort(403);
        }

        $notification->delete();

        return response()->json(['success' => true]);
    }
}
