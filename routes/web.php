<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\NotificationController;
use Illuminate\Notifications\DatabaseNotification;
use App\Models\User;
use App\Notifications\PeriodNotification;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\HomeController;

Route::get('/', function () {
    return view('home');
})->name('/');

// Route::get('/admin/dashboard', function () {
//     return view('admin.dashboard');
// })->middleware('role:admin')->name('admin.dashboard');

// Home bisa diakses semua (guest dan user)
// Route::get('/', [HomeController::class, 'index'])->name('/');

// Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
//     Route::get('/', [AdminController::class, 'index'])->name('dashboard');
//     // route admin lainnya ...
// });

Route::resource('articles', ArticleController::class);
Route::resource('calendars', CalendarController::class);
Route::resource('histories', HistoryController::class);
Route::resource('profiles', ProfileController::class)->middleware('auth');

Route::get('/calendar', function() {
    $events = [];
    return view('index', compact('events'));
});

Route::middleware('auth')->group(function () {
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::get('/notifications/{id}', [NotificationController::class, 'detail'])->name('notifications.detail');

    Route::get('/profile', [UserProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [UserProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [UserProfileController::class, 'destroy'])->name('profile.destroy');
});

// Route::middleware(['auth', 'admin'])->group(function () {
//     Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');


//     Route::get('/admin/notifications', function () {
//         $admin = Auth::user();
//         $notifications = $admin->notifications;

//         return view('admin.notifications', compact('notifications'));
//     });

// });

require __DIR__.'/auth.php';