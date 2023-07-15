<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Level extends Model
{
    use HasFactory;

    use SoftDeletes;

    protected $table = "levels";

    protected $fillable = [
        'key',
        'slug',
        'name',
        'status',
        'fase',
        'sync_date'
    ];

    protected $dates = ['deleted_at'];

    public function scopeActive($query)
    {
        return $query->select('key as uid', 'slug', 'name', 'fase', 'status')->where('status', 1);
    }

    public function data()
    {
        return [
            'uid' => $this->key,
            'slug' => $this->slug,
            'name' => $this->name,
            'fase' => $this->fase,
            'status' => $this->status,
        ];
    }

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($level) {
            $level->studyClass->each(function ($studyClass) {
                $studyClass->users->each(function ($user) {
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
                $studyClass->teachers->each(function ($teacher) {
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
                $studyClass->studentClass->each(function ($studentClass) {                 
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
                $studyClass->p5s->each(function ($p5s) {  
                    $p5s->scoreP5s()->delete();
                    $p5s->delete();
                });
                $studyClass->delete();
            });
            $level->basicCompetencies()->delete();
        });
    }

    public function studyClass()
    {
        return $this->hasMany(StudyClass::class, 'id_level');
    }

    public function basicCompetencies()
    {
        return $this->hasMany(BasicCompetency::class, 'id_level');
    }
}