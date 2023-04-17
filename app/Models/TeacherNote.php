<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TeacherNote extends Model
{
    use HasFactory;

    use SoftDeletes;

    protected $table = "teacher_notes";

    protected $guarded = [];

    protected $dates = ['deleted_at'];
}
