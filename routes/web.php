<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArticleController;
use App\Models\Article;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\UserProfileController;


Route::get('/', function () {
    return view('home');
})->middleware(['auth']);

Route::resource('articles', ArticleController::class);
Route::resource('calendars', CalendarController::class);
Route::resource('histories', HistoryController::class);
// Route::get('/calendars', [CalendarController::class, 'index'])->name('calendars.index');
// Route::post('/histories', [HistoryController::class, 'store']);

Route::resource('profiles', ProfileController::class)->middleware('auth');

Route::get('/profiles/{profile}', [ProfileController::class, 'show'])->name('profiles.show');

Route::get('/', function () {
    $articles = Article::all(); // ambil semua artikel dari database
    return view('home', compact('articles')); // kirim ke view
});

Route::get('/calendar', function() {
    $events = [];
    return view('index', compact('events'));
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [UserProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [UserProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [UserProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
