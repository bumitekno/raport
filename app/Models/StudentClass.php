<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StudentClass extends Model
{
    use HasFactory;

    use SoftDeletes;

    protected $table = "student_classes";

    protected $guarded = [];

    protected $dates = ['deleted_at'];

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($student_class) {
            
            $student_class->score_p5s()->delete();
            $student_class->scoreMerdekas()->delete();
            $student_class->scoreKds()->delete();
            $student_class->scoreCompetencies()->delete();
            $student_class->scoreManuals()->delete();
            $student_class->teacherNotes()->delete();
            $student_class->achievements()->delete();
            $student_class->attendanceScores()->delete();
            $student_class->attitudeGrades()->delete();
        });
    }

    public function score_p5s()
    {
        return $this->hasMany(ScoreP5::class, 'id_student_class');
    }

    public function scoreMerdekas()
    {
        return $this->hasMany(ScoreMerdeka::class, 'id_student_class');
    }

    public function scoreKds()
    {
        return $this->hasMany(ScoreKd::class, 'id_student_class');
    }

    public function study_class()
    {
        return $this->belongsTo(StudyClass::class, 'id_study_class');
    }

    public function student()
    {
        return $this->belongsTo(User::class, 'id_student');
    }

    public function scoreCompetencies()
    {
        return $this->hasMany(ScoreCompetency::class, 'id_student_class');
    }

    public function scoreManuals()
    {
        return $this->hasMany(ScoreManual::class, 'id_student_class');
    }

    public function teacherNotes()
    {
        return $this->hasMany(TeacherNote::class, 'id_student_class');
    }

    public function achievements()
    {
        return $this->hasMany(Achievement::class, 'id_student_class');
    }

    public function attendanceScores()
    {
        return $this->hasMany(AttendanceScore::class, 'id_student_class');
    }

    public function attitudeGrades()
    {
        return $this->hasMany(AttitudeGrade::class, 'id_student_class');
    }
}
