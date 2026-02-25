<?php

namespace App\Notifications;

use App\Models\Idea;
use Illuminate\Notifications\Notification;

class IdeaPublished extends Notification
{
    /**
     * Create a new notification instance.
     */
    public function __construct(public Idea $idea) {}

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'message' => 'Your idea was published',
            'description' => $this->idea->description,
        ];
    }
}
