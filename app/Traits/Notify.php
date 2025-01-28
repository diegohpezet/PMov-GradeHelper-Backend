<?php

namespace App\Traits;

use App\Services\NotificationService;

trait Notify
{
    public function sendAdminNotification(array $details)
    {
        resolve(NotificationService::class)->notifyAdmins($details);
    }
}