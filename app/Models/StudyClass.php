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
            $study_class->users()->delete();
            $study_class->teachers()->delete();
            $study_class->p5s()->delete();
            $study_class->studentClass()->delete();
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

        static::restoring(function ($study_class) {
            $study_class->users()->restore();
            $study_class->teachers()->restore();
            $study_class->p5s()->restore();
            $study_class->studentClass()->restore();
            $study_class->competenceAchievement()->restore();
            $study_class->assementWeights()->restore();
            $study_class->kkms()->restore();
            $study_class->scoreMerdekas()->restore();
            $study_class->scoreKds()->restore();
            $study_class->generalWeights()->restore();
            $study_class->scoreCompetencies()->restore();
            $study_class->scoreManuals()->restore();
            $study_class->achievements()->restore();
            $study_class->scoreExtracuriculars()->restore();
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
