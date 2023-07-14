<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubjectTeacher extends Model
{
    use HasFactory;

    use SoftDeletes;

    protected $table = "subject_teachers";

    protected $fillable = [
        'slug', 'id_teacher', 'id_course', 'id_school_year', 'id_study_class', 'status'
    ];

    protected $dates = ['deleted_at'];

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($subject_teacher) {
            $subject_teacher->p5s->each(function ($p5s) {  
                $p5s->scoreP5s()->delete();
                $p5s->delete();
            });
            $subject_teacher->scoreP5s()->delete();
            $subject_teacher->scoreKds()->delete();
        });
    }

    public function p5s()
    {
        return $this->hasMany(P5::class, 'id_subject_teacher');
    }

    public function scoreP5s()
    {
        return $this->hasMany(ScoreP5::class, 'id_subject_teacher');
    }

    public function scoreKds()
    {
        return $this->hasMany(ScoreKd::class, 'id_subject_teacher');
    }

    public function classes()
    {
        return $this->belongsToMany(StudyClass::class, 'subject_teachers', 'id_study_class', 'id');
    }

    public function course()
    {
        return $this->belongsTo(Course::class, 'id_course');
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class, 'id_teacher');
    }

    public function oneClass()
    {
        return $this->belongsTo(StudyClass::class, 'id_class');
    }
}
