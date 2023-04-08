<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AssesmentWeightingController;
use App\Http\Controllers\AttitudeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CompetenceAchievementController;
use App\Http\Controllers\ConfigController;
use App\Http\Controllers\CoverController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DescriptionCompetenceController;
use App\Http\Controllers\ExtracurricularController;
use App\Http\Controllers\LetterheadController;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\MajorController;
use App\Http\Controllers\P5Controller;
use App\Http\Controllers\PasConfigurationController;
use App\Http\Controllers\PredicatedScoreController;
use App\Http\Controllers\PtsConfigurationController;
use App\Http\Controllers\SchoolYearController;
use App\Http\Controllers\ScoreP5Controller;
use App\Http\Controllers\StudentClassController;
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
    Route::get('home', [DashboardController::class, 'user'])->name('user.dashboard');
    Route::get('statistic', [DashboardController::class, 'teacher'])->name('teacher.dashboard');


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
        Route::get('study_class', [SubjectTeacherController::class, 'get_study_class'])->name('study_class');
    });

    Route::prefix('student-class')->name('student_classes.')->group(function () {
        Route::get('/', [StudentClassController::class, 'index'])->name('index');
        Route::post('createOrUpdate', [StudentClassController::class, 'storeOrUpdate'])->name('storeOrUpdate');
        // Route::get('destroy/{id}', [SubjectTeacherController::class, 'destroy'])->name('destroy');
    });

    // setelan
    Route::prefix('config')->name('configs.')->group(function () {
        Route::get('/', [ConfigController::class, 'index'])->name('index');
        Route::post('updateOrCreate', [ConfigController::class, 'updateOrCreate'])->name('updateOrCreate');
    });

    Route::prefix('covers')->name('covers.')->group(function () {
        Route::get('/', [CoverController::class, 'index'])->name('index');
        Route::post('updateOrCreate', [CoverController::class, 'updateOrCreate'])->name('updateOrCreate');
    });

    Route::prefix('extracurricular')->name('extracurriculars.')->group(function () {
        Route::get('/', [ExtracurricularController::class, 'index'])->name('index');
        Route::get('create', [ExtracurricularController::class, 'create'])->name('create');
        Route::post('updateOrCreate', [CoverController::class, 'updateOrCreate'])->name('updateOrCreate');
    });

    // Route::get('error', [CoverController::class, 'error'])->name('error');

    Route::prefix('letterhead')->name('letterheads.')->group(function () {
        Route::get('/', [LetterheadController::class, 'index'])->name('index');
        Route::post('updateOrCreate', [LetterheadController::class, 'updateOrCreate'])->name('updateOrCreate');
    });

    Route::prefix('setting-score')->name('setting_scores.')->group(function () {
        Route::get('competence', [CompetenceAchievementController::class, 'index'])->name('competence');
        Route::get('competence/create', [CompetenceAchievementController::class, 'create'])->name('competence.create');
        Route::get('competence/edit', [CompetenceAchievementController::class, 'edit'])->name('competence.edit');
        Route::post('competence/update/{id?}', [CompetenceAchievementController::class, 'storeOrUpdate'])->name('competence.storeOrUpdate');
        Route::get('competence/delete/{slug}', [CompetenceAchievementController::class, 'destroy'])->name('competence.destroy');

        Route::get('description', [DescriptionCompetenceController::class, 'index'])->name('description');
        Route::post('description/update', [DescriptionCompetenceController::class, 'storeOrUpdate'])->name('description.storeOrUpdate');

        Route::get('assesment-weight', [AssesmentWeightingController::class, 'index'])->name('assesment_weight');
        Route::post('assesment-weight/update', [AssesmentWeightingController::class, 'storeOrUpdate'])->name('assesment_weight.storeOrUpdate');
    });

    //P5
    Route::prefix('manage-p5')->name('manages.')->group(function () {
        Route::get('/', [P5Controller::class, 'index'])->name('index');
        Route::get('create', [P5Controller::class, 'create'])->name('create');
        Route::get('edit/{slug}', [P5Controller::class, 'edit'])->name('edit');
        Route::get('detail/{slug}', [P5Controller::class, 'detail'])->name('detail');
        Route::get('delete/{slug}', [P5Controller::class, 'destroy'])->name('destroy');
        Route::post('updateOrCreate/{id?}', [P5Controller::class, 'updateOrCreate'])->name('updateOrCreate');
    });
    Route::prefix('score-p5')->name('score_p5.')->group(function () {
        Route::post('update', [ScoreP5Controller::class, 'storeOrUpdate'])->name('storeOrUpdate');
    });

    //K13
    Route::prefix('attitude/{type}')->name('attitudes.')->group(function () {
        Route::get('/', [AttitudeController::class, 'index'])->name('index');
        Route::post('update', [AttitudeController::class, 'storeOrUpdate'])->name('storeOrUpdate');
    });

    Route::prefix('setting-score')->name('setting_scores.')->group(function () {
        Route::prefix('predicated-score')->name('predicated_scores.')->group(function () {
            Route::get('/', [PredicatedScoreController::class, 'index'])->name('index');
            Route::get('create', [PredicatedScoreController::class, 'create'])->name('create');
            Route::get('edit/{slug}', [PredicatedScoreController::class, 'edit'])->name('edit');
            Route::get('delete/{slug}', [PredicatedScoreController::class, 'destroy'])->name('delete');
            Route::post('update/{id?}', [PredicatedScoreController::class, 'storeOrUpdate'])->name('storeOrUpdate');
        });
        Route::prefix('pts-configuration')->name('pts_configurations.')->group(function () {
            Route::get('/', [PtsConfigurationController::class, 'index'])->name('index');
            Route::post('update', [PtsConfigurationController::class, 'storeOrUpdate'])->name('storeOrUpdate');
        });
        Route::prefix('pas-configuration')->name('pas_configurations.')->group(function () {
            Route::get('/', [PasConfigurationController::class, 'index'])->name('index');
            Route::post('update', [PasConfigurationController::class, 'storeOrUpdate'])->name('storeOrUpdate');
        });
    });
});
