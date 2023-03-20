<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TeacherController;
use Illuminate\Support\Facades\Route;

Route::get('/', [AuthController::class, 'login'])->name('first_page');

Route::prefix('auth')->name('auth.')->group(function () {
    Route::get('login', [AuthController::class, 'login'])->name('login');
    Route::post('verify', [AuthController::class, 'verify_login'])->name('verify');
    Route::get('logout', [AuthController::class, 'logout'])->name('logout');
});

Route::middleware('auth:user,admin,parent,teacher')->group(function () {
    Route::get('dashboard', [DashboardController::class, 'admin'])->name('dashboard');
    Route::resource('admins', AdminController::class)->parameters([
        'admins' => 'admins:slug',
    ]);
    Route::resource('teachers', TeacherController::class)->parameters([
        'teachers' => 'teachers:slug',
    ]);
});
