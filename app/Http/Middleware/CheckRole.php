<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|string[]  $roles  (boleh satu atau array role)
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (!Auth::check()) {
            // Kalau belum login, redirect ke login
            return redirect()->route('login');
        }

        $user = Auth::user();

        // Kalau role user gak ada di list role yang diizinkan, abort 403
        if (!in_array($user->role, $roles)) {
            abort(403, 'Unauthorized');
        }

        return $next($request);
    }
}
