<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class NotificationController extends Controller
{
    /**
     * Display a listing of the user's notifications.
     */
    public function index(Request $request): View
    {
        $notifications = $request->user()->notifications()
            ->orderByRaw('read_at is not null')
            ->latest()
            ->get();

        return view('notifications.index', ['notifications' => $notifications]);
    }

    /**
     * Mark a notification as read.
     */
    public function update(DatabaseNotification $notification): RedirectResponse
    {
        Gate::authorize('update', $notification);

        $notification->markAsRead();

        return redirect()->back();
    }
}
