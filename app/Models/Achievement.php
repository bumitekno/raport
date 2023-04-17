<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Achievement extends Model
{
    use HasFactory;

    use SoftDeletes;

    protected $table = "achievements";

    protected $guarded = [];

    protected $dates = ['deleted_at'];

    public function student_class()
    {
        return $this->belongsTo(StudentClass::class, 'id_student_class');
    }
}
