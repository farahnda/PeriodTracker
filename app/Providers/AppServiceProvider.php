<?php

namespace App\Providers;
use Carbon\Carbon;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {   
        View::composer('layouts.nav', function ($view) {
        $unreadCount = 0;
        if (Auth::check()) {
            $unreadCount = Auth::user()->unreadNotifications()->count();
        }
        $view->with('unreadCount', $unreadCount);
    });

        Carbon::setLocale('id');
        
    }
}
