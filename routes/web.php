<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ExamController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/lang/{locale}', [LanguageController::class, 'switch'])->name('lang.switch');

// Auth routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Admin routes
Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    Route::resource('exams', ExamController::class)->except(['show']);
});
