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
        'slug', 'name', 'id_major', 'id_level', 'status'
    ];

    protected $dates = ['deleted_at'];

    public function major()
    {
        return $this->belongsTo(Major::class, 'id_major', 'id');
    }

    public function level()
    {
        return $this->belongsTo(Level::class, 'id_level', 'id');
    }
}
