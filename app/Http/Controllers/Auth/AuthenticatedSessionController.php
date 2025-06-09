<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Notifications\LoginActivityNotification;


class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
{
    $request->authenticate();

    // Ambil user yang sedang login
    $user = Auth::user();

    // Kirim notifikasi login berhasil
    $user->notify(new LoginActivityNotification($user->name, $user->email));

    // Regenerasi session untuk keamanan
    $request->session()->regenerate();

    // Redirect berdasarkan role
   if ($user->hasRole('admin')) {
    return redirect()->route('admin.dashboard');
}

return redirect()->route('/');
}


    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
