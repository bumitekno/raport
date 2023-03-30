<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ConfigController;
use App\Http\Controllers\CoverController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\MajorController;
use App\Http\Controllers\SchoolYearController;
use App\Http\Controllers\StudyClassController;
use App\Http\Controllers\SubjectTeacherController;
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


    // User
    Route::resource('admins', AdminController::class)->parameters([
        'admins' => 'admins:slug',
    ])->except(['show', 'destroy']);
    Route::get('admins/destroy/{slug}', [AdminController::class, 'destroy'])->name('admins.destroy');

    Route::resource('teachers', TeacherController::class)->parameters([
        'teachers' => 'teachers:slug',
    ])->except(['show', 'destroy']);
    Route::get('teachers/destroy/{slug}', [TeacherController::class, 'destroy'])->name('teachers.destroy');

    Route::resource('users', UserController::class)->parameters([
        'users' => 'users:slug',
    ])->except(['show', 'destroy']);
    Route::get('users/destroy/{slug}', [UserController::class, 'destroy'])->name('users.destroy');


    // Master
    Route::resource('majors', MajorController::class)->parameters([
        'majors' => 'majors:slug',
    ])->except(['show', 'destroy']);
    Route::get('majors/destroy/{slug}', [MajorController::class, 'destroy'])->name('majors.destroy');

    Route::resource('levels', LevelController::class)->parameters([
        'levels' => 'levels:slug',
    ])->except(['show', 'destroy']);
    Route::get('levels/destroy/{slug}', [LevelController::class, 'destroy'])->name('levels.destroy');

    Route::resource('classes', StudyClassController::class)->parameters([
        'classes' => 'classes:slug',
    ])->except(['show', 'destroy']);
    Route::get('classes/destroy/{slug}', [StudyClassController::class, 'destroy'])->name('classes.destroy');

    Route::resource('courses', CourseController::class)->parameters([
        'courses' => 'courses:slug',
    ])->except(['destroy']);
    Route::get('courses/destroy/{slug}', [CourseController::class, 'destroy'])->name('courses.destroy');

    Route::resource('school-years', SchoolYearController::class)->parameters([
        'school_years' => 'school_years:slug',
    ])->except(['show', 'destroy']);
    Route::get('school_years/destroy/{slug}', [SchoolYearController::class, 'destroy'])->name('school-years.destroy');

    Route::prefix('subject-teacher')->name('subject_teachers.')->group(function () {
        Route::post('updateOrCreate', [SubjectTeacherController::class, 'storeOrUpdateItem'])->name('updateOrCreate');
        Route::get('show', [SubjectTeacherController::class, 'show'])->name('show');
        Route::get('destroy/{id}', [SubjectTeacherController::class, 'destroy'])->name('destroy');
    });

    // setelan
    Route::prefix('config')->name('configs.')->group(function () {
        Route::get('/', [ConfigController::class, 'index'])->name('index');
        Route::post('updateOrCreate', [ConfigController::class, 'updateOrCreate'])->name('updateOrCreate');
    });
   
    Route::prefix('cover')->name('covers.')->group(function () {
        Route::get('/', [CoverController::class, 'index'])->name('index');
        Route::post('updateOrCreate', [CoverController::class, 'updateOrCreate'])->name('updateOrCreate');
    });
});
