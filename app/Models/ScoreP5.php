<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ScoreP5 extends Model
{
    use HasFactory;

    use SoftDeletes;

    protected $table = "score_p5_s";

    protected $guarded = [];

    protected $dates = ['deleted_at'];

    public function p5()
    {
        return $this->belongsTo(P5::class, 'id_p5');
    }
}
