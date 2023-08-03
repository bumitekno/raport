<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SchoolYear extends Model
{
    use HasFactory;

    use SoftDeletes;

    protected $table = "school_years";

    protected $fillable = [
        'slug', 'name', 'status'
    ];

    protected $dates = ['deleted_at'];

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($school_year) {
            $school_year->subjectTeacher->each(function ($subjectTeacher) {
                $subjectTeacher->p5s->each(function ($p5) {
                    $p5->scoreP5s()->delete();
                    $p5->delete();
                });
                $subjectTeacher->scoreP5s()->delete();
                $subjectTeacher->scoreKds()->delete();
                $subjectTeacher->delete();
            });
            $school_year->configs()->delete();
            $school_year->covers()->delete();
            $school_year->scoreP5s()->delete();
            $school_year->competence_achievement()->delete();
            $school_year->assementWeights()->delete();
            $school_year->ptsConfigurations()->delete();
            $school_year->pasConfigurations()->delete();
            $school_year->kkms()->delete();
            $school_year->templateConfigurations()->delete();
            $school_year->scoreMerdekas()->delete();
            $school_year->scoreKds()->delete();
            $school_year->generalWeights()->delete();
            $school_year->scoreCompetencies()->delete();
            $school_year->scoreManuals()->delete();
            $school_year->teacherNotes()->delete();
            $school_year->achievements()->delete();
            $school_year->attendanceScores()->delete();
            $school_year->attitudeGrades()->delete();
            $school_year->scoreExtracuriculars()->delete();
        });
    }

    public function subjectTeacher()
    {
        return $this->hasMany(SubjectTeacher::class, 'id_school_year');
    }

    public function configs()
    {
        return $this->hasMany(Config::class, 'id_school_year');
    }

    public function covers()
    {
        return $this->hasMany(Cover::class, 'id_school_year');
    }

    public function scoreP5s()
    {
        return $this->hasMany(ScoreP5::class, 'id_school_year');
    }

    public function competence_achievement()
    {
        return $this->hasMany(CompetenceAchievement::class, 'id_school_year');
    }

    public function assementWeights()
    {
        return $this->hasMany(AssesmentWeighting::class, 'id_school_year');
    }

    public function ptsConfigurations()
    {
        return $this->hasMany(PtsConfiguration::class, 'id_school_year');
    }

    public function pasConfigurations()
    {
        return $this->hasMany(PasConfiguration::class, 'id_school_year');
    }

    public function kkms()
    {
        return $this->hasMany(Kkm::class, 'id_school_year');
    }

    public function templateConfigurations()
    {
        return $this->hasMany(TemplateConfiguration::class, 'id_school_year');
    }

    public function scoreMerdekas()
    {
        return $this->hasMany(ScoreMerdeka::class, 'id_school_year');
    }

    public function scoreKds()
    {
        return $this->hasMany(ScoreKd::class, 'id_school_year');
    }

    public function generalWeights()
    {
        return $this->hasMany(GeneralWeighting::class, 'id_school_year');
    }

    public function scoreCompetencies()
    {
        return $this->hasMany(ScoreCompetency::class, 'id_school_year');
    }

    public function scoreManuals()
    {
        return $this->hasMany(ScoreManual::class, 'id_school_year');
    }

    public function teacherNotes()
    {
        return $this->hasMany(TeacherNote::class, 'id_school_year');
    }

    public function achievements()
    {
        return $this->hasMany(Achievement::class, 'id_school_year');
    }


    public function attendanceScores()
    {
        return $this->hasMany(AttendanceScore::class, 'id_school_year');
    }

    public function attitudeGrades()
    {
        return $this->hasMany(AttitudeGrade::class, 'id_school_year');
    }

    public function scoreExtracuriculars()
    {
        return $this->hasMany(ScoreExtracurricular::class, 'id_school_year');
    }
}
