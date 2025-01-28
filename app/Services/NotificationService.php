<?php

namespace App\Services;

use App\Models\User;
use App\Notifications\AdminActionNotification;
use Illuminate\Support\Facades\Auth;

class NotificationService
{
    public function notifyAdmins(array $actionDetails)
    {
        $admins = User::role('admin')->get();

        foreach ($admins as $admin) {
            $admin->notify(new AdminActionNotification($actionDetails));
        }
    }

    // Maybe add notification for students in the future?
}
