<?php

namespace App\Http\Controllers;

use App\Models\AdminNotification;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AdminController extends Controller
{

    public function dashboard()
    {
        $notificationsCount = AdminNotification::where('is_read', false)->count();

        return Inertia::render('Dashboard', [
            'notificationsCount' => $notificationsCount
        ]);
    }
    /**
     * Display admin notifications.
     */
    public function notifications()
    {
        $notifications = AdminNotification::where('is_read', false)
            ->orderBy('created_at', 'desc')
            ->get();

        return Inertia::render('Admin/Notifications', [
            'notifications' => $notifications
        ]);
    }

    /**
     * Mark a notification as read.
     */
    public function markNotificationAsRead($id)
    {
        AdminNotification::where('_id', $id)->update(['is_read' => true]);

        return back()->with('success', 'Notification marked as read.');
    }
}
