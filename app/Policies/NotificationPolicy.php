<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Notifications\DatabaseNotification;

class NotificationPolicy
{
    /**
     * Determine whether the user can view the notification.
     */
    public function view(User $user, DatabaseNotification $notification): Response
    {
        return $user->id === $notification->notifiable_id
            ? Response::allow()
            : Response::denyAsNotFound();
    }

    /**
     * Determine whether the user can update the notification.
     */
    public function update(User $user, DatabaseNotification $notification): Response
    {
        return $user->id === $notification->notifiable_id
            ? Response::allow()
            : Response::denyAsNotFound();
    }
}
