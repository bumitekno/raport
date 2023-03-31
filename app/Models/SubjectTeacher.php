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
