<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Notification;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Notification::latest()->paginate(10);
        $unreadCount = Notification::where('is_read', false)->count();
        $title = 'Notifications';
        return view('admin.notifications.index', compact('notifications','title', 'unreadCount'));
    }

    public function show($id)
    {
        $notification = Notification::findOrFail($id);
        $notification->update(['is_read' => true]);
        return view('admin.notifications.show', compact('notification'));
    }
}
