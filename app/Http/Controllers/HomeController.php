<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;  

class HomeController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            if (Auth::user()->role === 'admin') {
                return redirect()->route('admin.dashboard');
            }
        }

        // Untuk user biasa dan guest
        $unreadCount = Auth::check()
            ? Auth::user()->unreadNotifications()->count()
            : 0;

        return view('home', compact('unreadCount'));
    }
}
