<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ScoreManual extends Model
{
    use HasFactory;

    use SoftDeletes;

    protected $table = "score_manuals";

    protected $guarded = [];

    protected $dates = ['deleted_at'];

    public function course()
    {
        return $this->belongsTo(Course::class, 'id_course');
    }
}
