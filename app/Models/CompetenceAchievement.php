<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CompetenceAchievement extends Model
{
    use HasFactory;

    use SoftDeletes;

    protected $table = "competence_achievements";

    protected $guarded = [];

    protected $dates = ['deleted_at'];

    public function type()
    {
        return $this->belongsTo(TypeCompetenceAchievement::class, 'id_type_competence');
    }

    public function course()
    {
        return $this->belongsTo(Course::class, 'id_course');
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class, 'id_teacher');
    }

    public function study_class()
    {
        return $this->belongsTo(StudyClass::class, 'id_study_class');
    }
}
