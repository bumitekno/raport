<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Course extends Model
{
    use HasFactory;

    use SoftDeletes;

    protected $table = "courses";

    protected $fillable = [
        'slug', 'name', 'group', 'code', 'status'
    ];

    protected $dates = ['deleted_at'];

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($course) {
            $course->subjectTeacher->each(function ($subjectTeacher) {
                $subjectTeacher->p5s->each(function ($p5) {
                    $p5->scoreP5s()->delete();
                    $p5->delete();
                });
                $subjectTeacher->scoreP5s()->delete();
                $subjectTeacher->scoreKds()->delete();
                $subjectTeacher->delete();
            });
            $course->competenceAchievement()->delete();
            $course->assementWeights()->delete();
            $course->kkms()->delete();
            $course->scoreMerdekas()->delete();
            $course->basicCompetencies()->delete();
            $course->generalWeights()->delete();
            $course->scoreCompetencies()->delete();
            $course->scoreManuals()->delete();
        });
    }

    public function subjectTeacher()
    {
        return $this->hasMany(SubjectTeacher::class, 'id_course');
    }

    public function competenceAchievement()
    {
        return $this->hasMany(CompetenceAchievement::class, 'id_course');
    }

    public function assementWeights()
    {
        return $this->hasMany(AssesmentWeighting::class, 'id_course');
    }

    public function kkms()
    {
        return $this->hasMany(Kkm::class, 'id_course');
    }

    public function scoreMerdekas()
    {
        return $this->hasMany(ScoreMerdeka::class, 'id_course');
    }

    public function basicCompetencies()
    {
        return $this->hasMany(BasicCompetency::class, 'id_course');
    }

    public function generalWeights()
    {
        return $this->hasMany(GeneralWeighting::class, 'id_course');
    }

    public function scoreCompetencies()
    {
        return $this->hasMany(ScoreCompetency::class, 'id_course');
    }

    public function scoreManuals()
    {
        return $this->hasMany(ScoreManual::class, 'id_course');
    }
}
