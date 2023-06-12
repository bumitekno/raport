<?php

use App\Http\Controllers\AchievementController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AssesmentWeightingController;
use App\Http\Controllers\AttendanceScoreController;
use App\Http\Controllers\AttitudeController;
use App\Http\Controllers\AttitudeGradeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BasicCompetencyController;
use App\Http\Controllers\CompetenceAchievementController;
use App\Http\Controllers\ConfigController;
use App\Http\Controllers\CoverController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DescriptionCompetenceController;
use App\Http\Controllers\ExtracurricularController;
use App\Http\Controllers\GeneralWeightingController;
use App\Http\Controllers\KkmController;
use App\Http\Controllers\LegerController;
use App\Http\Controllers\LetterheadController;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\MajorController;
use App\Http\Controllers\P5Controller;
use App\Http\Controllers\ParentController;
use App\Http\Controllers\PasConfigurationController;
use App\Http\Controllers\PredicatedScoreController;
use App\Http\Controllers\PreviewController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PtsConfigurationController;
use App\Http\Controllers\RaportController;
use App\Http\Controllers\SchoolYearController;
use App\Http\Controllers\ScoreCompetencyController;
use App\Http\Controllers\ScoreExtracurricularController;
use App\Http\Controllers\ScoreKdController;
use App\Http\Controllers\ScoreManual2Controller;
use App\Http\Controllers\ScoreManualController;
use App\Http\Controllers\ScoreMerdekaController;
use App\Http\Controllers\ScoreP5Controller;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\StudentClassController;
use App\Http\Controllers\StudyClassController;
use App\Http\Controllers\SubjectTeacherController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\TeacherNoteController;
use App\Http\Controllers\TemplateConfigurationController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
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

    Route::prefix('my-profile')->name('profiles.')->group(function () {
        Route::get('/', [ProfileController::class, 'index'])->name('index');
        Route::post('updateOrCreate', [ProfileController::class, 'update'])->name('update');
        // Route::get('delete', [ParentController::class, 'destroy'])->name('destroy');
    });

    //maen session
    Route::post('set-template', function (Request $request) {
        session(['template' => $request->curriculum]);
        return response()->json(['success' => true]);
    })->name('session.template');

    Route::get('set-layout', [SessionController::class, 'layout'])->name('session.layout');

    // session menu guru
    Route::post('set-layout/teacher', [SessionController::class, 'set_layout'])->name('session.set_layout_teacher');

    // User
    Route::resource('admins', AdminController::class)->parameters([
        'admins' => 'admins:slug',
    ])->except(['show', 'destroy']);
    Route::get('admins/destroy/{slug}', [AdminController::class, 'destroy'])->name('admins.destroy');

    Route::resource('teachers', TeacherController::class)->parameters([
        'teachers' => 'teachers:slug',
    ])->except(['show', 'destroy']);
    Route::get('teachers/destroy/{slug}', [TeacherController::class, 'destroy'])->name('teachers.destroy');
    Route::get('teachers/export', [TeacherController::class, 'export'])->name('teachers.export');
    Route::post('teachers/import', [TeacherController::class, 'import'])->name('teachers.import');

    Route::resource('users', UserController::class)->parameters([
        'users' => 'users:slug',
    ])->except(['show', 'destroy']);
    Route::get('users/destroy/{slug}', [UserController::class, 'destroy'])->name('users.destroy');
    Route::get('users/export', [UserController::class, 'export'])->name('users.export');
    Route::post('users/import', [UserController::class, 'import'])->name('users.import');

    Route::prefix('family')->name('families.')->group(function () {
        Route::get('/', [ParentController::class, 'index'])->name('index');
        Route::get('create', [ParentController::class, 'create'])->name('create');
        Route::get('edit', [ParentController::class, 'edit'])->name('edit');
        Route::get('change/{slug}', [ParentController::class, 'change'])->name('change');
        Route::post('update', [ParentController::class, 'update'])->name('update');
        Route::post('updateOrCreate/{id?}', [ParentController::class, 'updateOrCreate'])->name('updateOrCreate');
        Route::get('delete', [ParentController::class, 'destroy'])->name('destroy');
        Route::get('trash/{slug}', [ParentController::class, 'trash'])->name('trash');
    });


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
    Route::get('course/download/export', [CourseController::class, 'export'])->name('courses.export');
    Route::post('course/upload/import', [CourseController::class, 'import'])->name('courses.import');


    Route::resource('school-years', SchoolYearController::class)->parameters([
        'school_years' => 'school_years:slug',
    ])->except(['show', 'destroy']);
    Route::get('school_years/destroy/{slug}', [SchoolYearController::class, 'destroy'])->name('school-years.destroy');
    Route::get('school_years/activated', [SchoolYearController::class, 'activated'])->name('school-years.activated');

    Route::prefix('subject-teacher')->name('subject_teachers.')->group(function () {
        Route::post('updateOrCreate', [SubjectTeacherController::class, 'storeOrUpdateItem'])->name('updateOrCreate');
        Route::get('show', [SubjectTeacherController::class, 'show'])->name('show');
        Route::get('destroy/{id}', [SubjectTeacherController::class, 'destroy'])->name('destroy');
        Route::get('study_class', [SubjectTeacherController::class, 'get_study_class'])->name('study_class');
        Route::get('export', [SubjectTeacherController::class, 'export'])->name('export');
        Route::post('import/{slug}', [SubjectTeacherController::class, 'import'])->name('import');
    });

    Route::prefix('student-class')->name('student_classes.')->group(function () {
        Route::get('/', [StudentClassController::class, 'index'])->name('index');
        Route::post('createOrUpdate', [StudentClassController::class, 'storeOrUpdate'])->name('storeOrUpdate');
        Route::get('export', [SubjectTeacherController::class, 'export'])->name('export');
        Route::post('import', [SubjectTeacherController::class, 'import'])->name('import');
    });

    // setelan
    Route::prefix('config')->name('configs.')->group(function () {
        Route::get('home', [ConfigController::class, 'index'])->name('index');
        Route::post('updateOrCreate', [ConfigController::class, 'updateOrCreate'])->name('updateOrCreate');
    });

    Route::prefix('setting')->name('settings.')->group(function () {
        Route::get('/', [SettingController::class, 'index'])->name('index');
        Route::post('updateOrCreate', [SettingController::class, 'updateOrCreate'])->name('updateOrCreate');
    });

    Route::prefix('template')->name('templates.')->group(function () {
        Route::get('/', [TemplateConfigurationController::class, 'index'])->name('index');
        Route::post('updateOrCreate', [TemplateConfigurationController::class, 'updateOrCreate'])->name('updateOrCreate');
    });

    Route::prefix('covers')->name('covers.')->group(function () {
        Route::get('/', [CoverController::class, 'index'])->name('index');
        Route::post('updateOrCreate', [CoverController::class, 'updateOrCreate'])->name('updateOrCreate');
    });

    Route::prefix('extracurricular')->name('extracurriculars.')->group(function () {
        Route::get('/', [ExtracurricularController::class, 'index'])->name('index');
        Route::get('create', [ExtracurricularController::class, 'create'])->name('create');
        Route::get('edit/{slug}', [ExtracurricularController::class, 'edit'])->name('edit');
        Route::post('updateOrCreate/{id?}', [ExtracurricularController::class, 'updateOrCreate'])->name('updateOrCreate');
        Route::get('delete/{slug}', [ExtracurricularController::class, 'destroy'])->name('destroy');
    });

    // Route::get('error', [CoverController::class, 'error'])->name('error');

    Route::prefix('letterhead')->name('letterheads.')->group(function () {
        Route::get('/', [LetterheadController::class, 'index'])->name('index');
        Route::post('updateOrCreate', [LetterheadController::class, 'updateOrCreate'])->name('updateOrCreate');
        Route::get('remove/{image}', [LetterheadController::class, 'removeImage'])->name('removeImage');
    });

    Route::prefix('setting-score')->name('setting_scores.')->group(function () {
        Route::get('competence', [CompetenceAchievementController::class, 'index'])->name('competence');
        Route::get('list-competence', [CompetenceAchievementController::class, 'list_competence'])->name('list_competence');
        Route::get('competence/create', [CompetenceAchievementController::class, 'create'])->name('competence.create');
        Route::get('competence/edit', [CompetenceAchievementController::class, 'edit'])->name('competence.edit');
        Route::post('competence/update/{id?}', [CompetenceAchievementController::class, 'storeOrUpdate'])->name('competence.storeOrUpdate');
        Route::get('competence/delete/{slug}', [CompetenceAchievementController::class, 'destroy'])->name('competence.destroy');
        Route::get('competence/download/export', [CompetenceAchievementController::class, 'export'])->name('competence.export');
        Route::post('competence/import', [CompetenceAchievementController::class, 'import'])->name('competence.import');

        Route::get('description', [DescriptionCompetenceController::class, 'index'])->name('description');
        Route::post('description/update', [DescriptionCompetenceController::class, 'storeOrUpdate'])->name('description.storeOrUpdate');

        Route::get('assesment-weight/{type}', [AssesmentWeightingController::class, 'index'])->name('assesment_weight');
        Route::post('assesment-weight/update', [AssesmentWeightingController::class, 'storeOrUpdate'])->name('assesment_weight.storeOrUpdate');

        Route::get('score', [ScoreMerdekaController::class, 'index'])->name('score');
        Route::get('score/create/{slug}', [ScoreMerdekaController::class, 'create'])->name('score.create');
        Route::post('score/update', [ScoreMerdekaController::class, 'storeOrUpdate'])->name('score.storeOrUpdate');

        Route::get('score-competency', [ScoreCompetencyController::class, 'index'])->name('score_competency');
        Route::post('score-competency/update', [ScoreCompetencyController::class, 'storeOrUpdate'])->name('score_competency.storeOrUpdate');
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

    Route::prefix('general-weight/{type}')->name('general_weights.')->group(function () {
        Route::get('/', [GeneralWeightingController::class, 'index'])->name('index');
        Route::post('update', [GeneralWeightingController::class, 'storeOrUpdate'])->name('storeOrUpdate');
    });

    //K13
    Route::prefix('attitude/{type}')->name('attitudes.')->group(function () {
        Route::get('/', [AttitudeController::class, 'index'])->name('index');
        Route::post('update', [AttitudeController::class, 'storeOrUpdate'])->name('storeOrUpdate');
    });

    Route::prefix('k13')->name('k13.')->group(function () {
        Route::prefix('score')->name('scores.')->group(function () {
            Route::get('/', [ScoreKdController::class, 'index'])->name('index');
            Route::get('create/{slug}', [ScoreKdController::class, 'create'])->name('create');
            Route::post('update', [ScoreKdController::class, 'update'])->name('update');
        });
    });

    // Route::prefix('k13')->name('k13.')->group(function () {
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
        Route::prefix('kkm')->name('kkm.')->group(function () {
            Route::get('/', [KkmController::class, 'index'])->name('index');
            Route::post('update', [KkmController::class, 'storeOrUpdate'])->name('storeOrUpdate');
        });
    });
    // });

    Route::prefix('basic-competency')->name('basic_competencies.')->group(function () {
        Route::get('/', [BasicCompetencyController::class, 'index'])->name('index');
        Route::get('create', [BasicCompetencyController::class, 'create'])->name('create');
        Route::get('edit/{slug}', [BasicCompetencyController::class, 'edit'])->name('edit');
        Route::post('update/{id?}', [BasicCompetencyController::class, 'storeOrUpdate'])->name('storeOrUpdate');
        Route::get('destroy/{slug}', [BasicCompetencyController::class, 'destroy'])->name('destroy');

        // Route::get('export', [SubjectTeacherController::class, 'export'])->name('export');
        // Route::post('import', [SubjectTeacherController::class, 'import'])->name('import');

        Route::get('export', [BasicCompetencyController::class, 'export'])->name('export');
        Route::post('imprt', [BasicCompetencyController::class, 'import'])->name('import');
    });

    //Score Manual
    Route::prefix('manual')->name('manuals.')->group(function () {
        Route::prefix('score')->name('scores.')->group(function () {
            Route::get('/', [ScoreManualController::class, 'index'])->name('index');
            Route::post('update', [ScoreManualController::class, 'storeOrUpdate'])->name('storeOrUpdate');
        });
    });

    //Score Manual
    Route::prefix('manual-v2')->name('manual2s.')->group(function () {
        Route::prefix('score')->name('scores.')->group(function () {
            Route::get('/', [ScoreManual2Controller::class, 'index'])->name('index');
            Route::post('update', [ScoreManual2Controller::class, 'storeOrUpdate'])->name('storeOrUpdate');
            Route::get('export', [ScoreManual2Controller::class, 'export'])->name('export');
            Route::post('imprt', [ScoreManual2Controller::class, 'import'])->name('import');
        });
    });

    //Wali kelas
    Route::prefix('teacher_note')->name('teacher_notes.')->group(function () {
        Route::get('/', [TeacherNoteController::class, 'index'])->name('index');
        Route::post('update', [TeacherNoteController::class, 'storeOrUpdate'])->name('storeOrUpdate');
    });

    Route::prefix('achievement')->name('achievements.')->group(function () {
        Route::get('/', [AchievementController::class, 'index'])->name('index');
        Route::get('create', [AchievementController::class, 'create'])->name('create');
        Route::get('edit/{slug}', [AchievementController::class, 'edit'])->name('edit');
        Route::post('update/{id?}', [AchievementController::class, 'storeOrUpdate'])->name('storeOrUpdate');
        Route::get('destroy/{slug}', [AchievementController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('attendance')->name('attendances.')->group(function () {
        Route::get('/', [AttendanceScoreController::class, 'index'])->name('index');
        Route::post('update', [AttendanceScoreController::class, 'storeOrUpdate'])->name('storeOrUpdate');
    });

    Route::prefix('attitude-grade/{type}')->name('attitude_grades.')->group(function () {
        Route::get('/', [AttitudeGradeController::class, 'index'])->name('index');
        Route::post('update', [AttitudeGradeController::class, 'storeOrUpdate'])->name('storeOrUpdate');
    });

    Route::prefix('preview')->name('previews.')->group(function () {
        Route::get('/', [PreviewController::class, 'index'])->name('index');
        Route::get('print/{year}', [PreviewController::class, 'print'])->name('print');
        Route::get('print-p5', [PreviewController::class, 'printP5'])->name('printp5');
        Route::get('sample', [PreviewController::class, 'sample'])->name('sample');
        Route::get('print-teacher', [PreviewController::class, 'print_other'])->name('print_other');
        Route::get('print-cover', [PreviewController::class, 'coverPrint'])->name('print_cover');
        Route::get('other/print/{id_student_class}', [PreviewController::class, 'otherPrint'])->name('other_print');
    });

    Route::prefix('score-extra/{slug}')->name('score_extras.')->group(function () {
        Route::get('/', [ScoreExtracurricularController::class, 'index'])->name('index');
        Route::post('update', [ScoreExtracurricularController::class, 'storeOrUpdate'])->name('storeOrUpdate');
    });

    Route::prefix('leger')->name('legers.')->group(function () {
        Route::get('prev-classes/{slug}', [LegerController::class, 'byClass'])->name('by_classes');
        Route::get('list-classes', [LegerController::class, 'listClass'])->name('list_classes');
    });

    Route::prefix('raport')->name('raports.')->group(function () {
        Route::get('prev-classes', [RaportController::class, 'byClass'])->name('by_classes');
        Route::get('list-classes', [RaportController::class, 'listClass'])->name('list_classes');
    });
});
