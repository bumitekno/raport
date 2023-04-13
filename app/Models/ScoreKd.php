<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ScoreKd extends Model
{
    use HasFactory;

    use SoftDeletes;

    protected $table = "score_kds";

    protected $guarded = [];

    protected $dates = ['deleted_at'];
}
