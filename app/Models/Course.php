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
        'key',
        'slug',
        'name',
        'group',
        'code',
        'status',
        'courses',
        'sync_date'
    ];

    protected $dates = ['deleted_at'];

    public function scopeActive($query)
    {
        return $query->select('key as uid', 'slug', 'code', 'name', 'group', 'status')->where('status', 1);
    }

    public function data()
    {
        return [
            'uid' => $this->key,
            'slug' => $this->slug,
            'code' => $this->code,
            'name' => $this->name,
            'group' => $this->group,
            'status' => $this->status,
        ];
    }

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($course) {
            $course->subjectTeacher()->delete();
            $course->competenceAchievement()->delete();
            $course->assementWeights()->delete();
            $course->kkms()->delete();
            $course->scoreMerdekas()->delete();
            $course->basicCompetencies()->delete();
            $course->generalWeights()->delete();
            $course->scoreCompetencies()->delete();
            $course->scoreManuals()->delete();
        });

        static::restoring(function ($course) {
            $course->subjectTeacher()->restore();
            $course->competenceAchievement()->restore();
            $course->assementWeights()->restore();
            $course->kkms()->restore();
            $course->scoreMerdekas()->restore();
            $course->basicCompetencies()->restore();
            $course->generalWeights()->restore();
            $course->scoreCompetencies()->restore();
            $course->scoreManuals()->restore();
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