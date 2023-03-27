<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Course extends Model
{
    use HasFactory;

    use SoftDeletes;

    protected $table = "courses";

    protected $fillable = [
        'slug', 'name', 'id_major', 'id_level', 'status'
    ];

    protected $dates = ['deleted_at'];
}
