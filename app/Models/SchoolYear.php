<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SchoolYear extends Model
{
    use HasFactory;

    use SoftDeletes;

    protected $table = "school_years";

    protected $fillable = [
        'slug', 'name', 'status'
    ];

    protected $dates = ['deleted_at'];
}
