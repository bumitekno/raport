<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Teacher extends Authenticatable
{
    use HasFactory;

    use SoftDeletes;

    protected $table = "teachers";

    protected $guarded = [];

    protected $dates = ['deleted_at'];

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($teacher) {
            $teacher->subjectTeacher->each(function ($subjectTeacher) {
                $subjectTeacher->p5s->each(function ($p5) {
                    $p5->scoreP5s()->delete();
                    $p5->delete();
                });
                $subjectTeacher->scoreP5s()->delete();
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
        });
    }

    public function subjectTeacher()
    {
        return $this->hasMany(SubjectTeacher::class, 'id_teacher');
    }

    public function competenceAchievement()
    {
        return $this->hasMany(CompetenceAchievement::class, 'id_teacher');
    }

    public function assementWeights()
    {
        return $this->hasMany(AssesmentWeighting::class, 'id_teacher');
    }

    public function scoreMerdekas()
    {
        return $this->hasMany(ScoreMerdeka::class, 'id_teacher');
    }

    public function generalWeights()
    {
        return $this->hasMany(GeneralWeighting::class, 'id_teacher');
    }

    public function scoreCompetencies()
    {
        return $this->hasMany(ScoreCompetency::class, 'id_teacher');
    }

    public function scoreManuals()
    {
        return $this->hasMany(ScoreManual::class, 'id_teacher');
    }

    public function teacherNotes()
    {
        return $this->hasMany(TeacherNote::class, 'id_teacher');
    }

    public function achievements()
    {
        return $this->hasMany(Achievement::class, 'id_teacher');
    }

    public function attitudeGrades()
    {
        return $this->hasMany(AttitudeGrade::class, 'id_teacher');
    }

    public function scoreExtracuriculars()
    {
        return $this->hasMany(ScoreExtracurricular::class, 'id_teacher');
    }

    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = bcrypt($password);
    }
}
