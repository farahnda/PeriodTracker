<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\Controller;

//Route::get( '/', action: function () {return view('welcome');});
//Route::get( '/article', action: function () {return view('article.index');});
//Route::get( '/profile', action: function () {return view('profile.index');});
Route::get( '/', action: function () {return view('home');});
Route::resource('articles', ArticleController::class);
Route::resource('profiles', ProfileController::class);
//Route::resource('calendars', CalendarController::class);
//Route::resource('histories', HistoryController::class);
