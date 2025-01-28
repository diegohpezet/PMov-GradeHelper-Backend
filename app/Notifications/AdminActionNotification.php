<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class AdminActionNotification extends Notification
{
    use Queueable;

    public $actionDetails;

    /**
     * Create a new notification instance.
     */
    public function __construct($actionDetails)
    {
        $this->actionDetails = $actionDetails;
    }

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
     * Get the mail representation of the notification.
     */
    public function toDatabase($notifiable)
    {
        return [
            'message' => $this->actionDetails['message'],
            'action_by' => $this->actionDetails['action_by'],
            'timestamp' => now(),
        ];
    }
}
