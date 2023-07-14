<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Major extends Model
{
    use HasFactory;

    use SoftDeletes;

    protected $table = "majors";

    protected $fillable = [
        'slug', 'name', 'status'
    ];

    protected $dates = ['deleted_at'];

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($major) {
            $major->studyClass->each(function ($studyClass) {
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
            $major->templateConfigurations()->delete();
        });
    }

    public function studyClass()
    {
        return $this->hasMany(StudyClass::class, 'id_major');
    }

    public function templateConfigurations()
    {
        return $this->hasMany(TemplateConfiguration::class, 'id_major');
    }
}
