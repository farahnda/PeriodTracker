<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Period;
use Illuminate\Http\Request;
use App\Notifications\PeriodReminder;
use App\Notifications\NewArticleNotification;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Models\Notification;  

class NotificationController extends Controller
{
    public function index()
{
    $notifications = Auth::user()
        ->notifications()
        ->orderBy('created_at', 'desc')
        ->paginate(10);

    return view('notifications.index', compact('notifications'));
}

public function detail($id)
{
    $notif = Auth::user()->notifications()->findOrFail($id);
    return view('notifications.detail', compact('notif'));
}

}
