<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tema extends Model
{
    use HasFactory;

    use SoftDeletes;

    protected $table = "temas";

    protected $guarded = [];

    protected $dates = ['deleted_at'];
}
