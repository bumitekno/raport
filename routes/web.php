<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', [DashboardController::class, 'admin'])->name('first_page');

Route::prefix('auth')->name('auth.')->group(function () {
    Route::get('login', [AuthController::class, 'login'])->name('login');
    Route::get('register', [AuthController::class, 'register'])->name('register');
    Route::post('verify', [AuthController::class, 'verify'])->name('verify_login');
    Route::post('verify-register', [AuthController::class, 'verifyRegister'])->name('verify_register');
    Route::get('logout', [AuthController::class, 'logout'])->name('logout');
});

Route::prefix('admins')->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('index');
    Route::post('/', [AdminController::class, 'store'])->name('store');
    Route::get('create', [AdminController::class, 'create'])->name('create');
});
