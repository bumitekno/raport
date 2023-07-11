<?php

use App\Http\Controllers\API\CourseController;
use App\Http\Controllers\API\ExtracurricularController;
use App\Http\Controllers\API\LevelController;
use App\Http\Controllers\API\MajorController;
use App\Http\Controllers\API\SchoolController;
use App\Http\Controllers\API\SchoolYearController;
use App\Http\Controllers\API\StudentClassController;
use App\Http\Controllers\API\StudyClassController;
use App\Http\Controllers\API\SubjectTeacherController;
use App\Http\Controllers\API\TeacherController;
use App\Http\Controllers\API\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::prefix('master')->name('master')->group(function (){
    Route::prefix('extracurriculars')->name('extracurriculars')->group(function (){
        Route::get('/', [ExtracurricularController::class, 'index'])->name('index');
        Route::post('/', [ExtracurricularController::class, 'store'])->name('store');
        Route::get('{key}', [ExtracurricularController::class, 'show'])->name('show');
    });

    Route::prefix('school_years')->name('school_years')->group(function (){
        Route::get('/', [SchoolYearController::class, 'index'])->name('index');
        Route::post('/', [SchoolYearController::class, 'store'])->name('store');
        Route::post('set-active/{key}', [SchoolYearController::class, 'setActive'])->name('set_active');
        Route::get('{key}', [SchoolYearController   ::class, 'show'])->name('show');
    });

    Route::prefix('majors')->name('majors')->group(function (){
        Route::get('/', [MajorController::class, 'index'])->name('index');
        Route::post('/', [MajorController::class, 'store'])->name('store');
        Route::get('{key}', [MajorController::class, 'show'])->name('show');
    });

    Route::prefix('levels')->name('levels')->group(function (){
        Route::get('/', [LevelController::class, 'index'])->name('index');
        Route::post('/', [LevelController::class, 'store'])->name('store');
        Route::get('{key}', [LevelController::class, 'show'])->name('show');
    });

    Route::prefix('study_classes')->name('study_classes')->group(function (){
        Route::get('/', [StudyClassController::class, 'index'])->name('index');
        Route::post('/', [StudyClassController::class, 'update'])->name('store');
        Route::get('{key}', [StudyClassController::class, 'show'])->name('show');
    });

    Route::prefix('courses')->name('courses')->group(function (){
        Route::get('/', [CourseController::class, 'index'])->name('index');
        Route::post('/', [CourseController::class, 'update'])->name('store');
        Route::get('{key}', [CourseController::class, 'show'])->name('show');
    });

    Route::prefix('student_classes')->name('student_classes')->group(function (){
        Route::get('/', [StudentClassController::class, 'index'])->name('index');
        Route::get('data/all', [StudentClassController::class, 'all'])->name('all');
        Route::get('{key}', [StudentClassController::class, 'show'])->name('show');
        Route::post('/', [StudentClassController::class, 'store'])->name('store');
    });

    Route::prefix('subject_teachers')->name('subject_teachers')->group(function (){
        Route::get('/', [SubjectTeacherController::class, 'index'])->name('index');
        Route::get('{key}', [SubjectTeacherController::class, 'show'])->name('show');
        Route::post('/', [SubjectTeacherController::class, 'store'])->name('store');
    });

    Route::prefix('schools')->name('schools')->group(function (){
        Route::get('/', [SchoolController::class, 'index'])->name('index');
        Route::post('/', [SchoolController::class, 'store'])->name('store');
    });
});


Route::prefix('users')->name('users')->group(function (){
    Route::prefix('students')->name('students')->group(function (){
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::get('{key}', [UserController::class, 'show'])->name('show');
        Route::post('/', [UserController::class, 'store'])->name('store');
        Route::post('{key}', [UserController::class, 'update'])->name('update');
        Route::post('update/status', [UserController::class, 'update_status'])->name('update_status');
    });

    Route::prefix('teachers')->name('teachers')->group(function (){
        Route::get('/', [TeacherController::class, 'index'])->name('index');
        Route::get('{key}', [TeacherController::class, 'show'])->name('show');
        Route::post('/', [TeacherController::class, 'store'])->name('store');
        Route::post('update/status', [TeacherController::class, 'update_status'])->name('update_status');
    });
});