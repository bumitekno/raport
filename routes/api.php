<?php

use App\Http\Controllers\API\ExtracurricularController;
use App\Http\Controllers\API\MajorController;
use App\Http\Controllers\API\SchoolYearController;
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
});
