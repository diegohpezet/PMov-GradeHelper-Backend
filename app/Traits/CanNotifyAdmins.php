<?php

namespace App\Traits;

use App\Services\NotificationService;

trait CanNotifyAdmins
{
    public function sendAdminNotification(array $details)
    {
        resolve(NotificationService::class)->notifyAdmins($details);
    }
}