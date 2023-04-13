<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GeneralWeighting extends Model
{
    use HasFactory;

    use SoftDeletes;

    protected $table = "general_weightings";

    protected $guarded = [];

    protected $dates = ['deleted_at'];
}
