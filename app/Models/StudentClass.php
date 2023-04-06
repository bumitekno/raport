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

    public function study_class()
    {
        return $this->belongsTo(StudyClass::class, 'id_study_class');
    }

    public function student()
    {
        return $this->belongsTo(User::class, 'id_student');
    }
}
