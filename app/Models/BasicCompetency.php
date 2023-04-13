<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BasicCompetency extends Model
{
    use HasFactory;

    use SoftDeletes;

    protected $table = "basic_competencies";

    protected $guarded = [];

    protected $dates = ['deleted_at'];

    public function course()
    {
        return $this->belongsTo(Course::class, 'id_course');
    }

    public function level()
    {
        return $this->belongsTo(Level::class, 'id_level');
    }
}
