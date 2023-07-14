<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StudyClass extends Model
{
    use HasFactory;

    use SoftDeletes;

    protected $table = "study_classes";

    protected $fillable = [
        'slug', 'name', 'id_major', 'id_level', 'status'
    ];

    protected $dates = ['deleted_at'];

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($study_class) {
            $study_class->users->each(function ($user) {
                $user->studentClass->each(function ($studentClass) {                 
                    $studentClass->score_p5s()->delete();
                    $studentClass->scoreMerdekas()->delete();
                    $studentClass->scoreKds()->delete();
                    $studentClass->scoreCompetencies()->delete();
                    $studentClass->scoreManuals()->delete();
                    $studentClass->teacherNotes()->delete();
                    $studentClass->achievements()->delete();
                    $studentClass->attendanceScores()->delete();
                    $studentClass->attitudeGrades()->delete();
                    $studentClass->delete();
                });
                $user->userParent()->delete();
                $user->delete();
            });
            $study_class->teachers->each(function ($teacher) {
                $teacher->subjectTeacher->each(function ($subjectTeacher) {     
                    $subjectTeacher->p5s->each(function ($p5s) {  
                        $p5s->scoreP5s()->delete();
                        $p5s->delete();
                    });
                    $subjectTeacher->score_p5s()->delete();
                    $subjectTeacher->scoreKds()->delete();
                    $subjectTeacher->delete();
                });
                $teacher->competenceAchievement()->delete();
                $teacher->assementWeights()->delete();
                $teacher->scoreMerdekas()->delete();
                $teacher->generalWeights()->delete();
                $teacher->scoreCompetencies()->delete();
                $teacher->scoreManuals()->delete();
                $teacher->teacherNotes()->delete();
                $teacher->achievements()->delete();
                $teacher->attitudeGrades()->delete();
                $teacher->scoreExtracuriculars()->delete();
                $teacher->delete();
            });
            $study_class->studentClass->each(function ($studentClass) {                 
                $studentClass->score_p5s()->delete();
                $studentClass->scoreMerdekas()->delete();
                $studentClass->scoreKds()->delete();
                $studentClass->scoreCompetencies()->delete();
                $studentClass->scoreManuals()->delete();
                $studentClass->teacherNotes()->delete();
                $studentClass->achievements()->delete();
                $studentClass->attendanceScores()->delete();
                $studentClass->attitudeGrades()->delete();
                $studentClass->delete();
            });
            $study_class->p5s->each(function ($p5s) {  
                $p5s->scoreP5s()->delete();
                $p5s->delete();
            });
            $study_class->competenceAchievement()->delete();
            $study_class->assementWeights()->delete();
            $study_class->kkms()->delete();
            $study_class->scoreMerdekas()->delete();
            $study_class->scoreKds()->delete();
            $study_class->generalWeights()->delete();
            $study_class->scoreCompetencies()->delete();
            $study_class->scoreManuals()->delete();
            $study_class->achievements()->delete();
            $study_class->scoreExtracuriculars()->delete();
        });
    }

    public function p5s()
    {
        return $this->hasMany(P5::class, 'id_study_class');
    }

    public function users()
    {
        return $this->hasMany(User::class, 'accepted_grade');
    }

    public function studentClass()
    {
        return $this->hasMany(StudentClass::class, 'id_study_class');
    }

    public function teachers()
    {
        return $this->hasMany(Teacher::class, 'id_class');
    }

    public function competenceAchievement()
    {
        return $this->hasMany(CompetenceAchievement::class, 'id_study_class');
    }

    public function assementWeights()
    {
        return $this->hasMany(AssesmentWeighting::class, 'id_study_class');
    }

    public function kkms()
    {
        return $this->hasMany(Kkm::class, 'id_study_class');
    }

    public function scoreMerdekas()
    {
        return $this->hasMany(ScoreMerdeka::class, 'id_study_class');
    }

    public function scoreKds()
    {
        return $this->hasMany(ScoreKd::class, 'id_study_class');
    }

    public function generalWeights()
    {
        return $this->hasMany(GeneralWeighting::class, 'id_study_class');
    }

    public function scoreCompetencies()
    {
        return $this->hasMany(ScoreCompetency::class, 'id_study_class');
    }

    public function scoreManuals()
    {
        return $this->hasMany(ScoreManual::class, 'id_study_class');
    }

    public function achievements()
    {
        return $this->hasMany(Achievement::class, 'id_study_class');
    }

    public function scoreExtracuriculars()
    {
        return $this->hasMany(ScoreExtracurricular::class, 'id_study_class');
    }

    public function major()
    {
        return $this->belongsTo(Major::class, 'id_major', 'id');
    }

    public function level()
    {
        return $this->belongsTo(Level::class, 'id_level', 'id');
    }
}
