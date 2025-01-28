<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Auth::user()->notifications;

        return Inertia::render('Notifications/Index', [
            'notifications' => $notifications
        ]);
    }
}
