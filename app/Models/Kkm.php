<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Kkm extends Model
{
    use HasFactory;

    use SoftDeletes;

    protected $table = "kkms";

    protected $guarded = [];

    protected $dates = ['deleted_at'];
}
