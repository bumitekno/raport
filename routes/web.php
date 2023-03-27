<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\MajorController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\UserController;
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
    ])->only([
        'index', 'create', 'edit', 'store', 'update'
    ]);
    Route::get('admins/destroy/{slug}', [AdminController::class, 'destroy'])->name('admins.destroy');

    Route::resource('teachers', TeacherController::class)->parameters([
        'teachers' => 'teachers:slug',
    ])->only([
        'index', 'create', 'edit', 'store', 'update'
    ]);
    Route::get('teachers/destroy/{slug}', [TeacherController::class, 'destroy'])->name('teachers.destroy');

    Route::resource('users', UserController::class)->parameters([
        'users' => 'users:slug',
    ])->only([
        'index', 'create', 'edit', 'store', 'update'
    ]);
    Route::get('users/destroy/{slug}', [UserController::class, 'destroy'])->name('users.destroy');

    Route::resource('majors', MajorController::class)->parameters([
        'majors' => 'majors:slug',
    ])->only([
        'index', 'create', 'edit', 'store', 'update'
    ]);
    Route::get('majors/destroy/{slug}', [MajorController::class, 'destroy'])->name('majors.destroy');

    Route::resource('levels', LevelController::class)->parameters([
        'levels' => 'levels:slug',
    ])->only([
        'index', 'create', 'edit', 'store', 'update'
    ]);
    Route::get('levels/destroy/{slug}', [LevelController::class, 'destroy'])->name('levels.destroy');
});
