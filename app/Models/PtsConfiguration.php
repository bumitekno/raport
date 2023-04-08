<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PtsConfiguration extends Model
{
    use HasFactory;

    use SoftDeletes;

    protected $table = "pts_configurations";

    protected $guarded = [];

    protected $dates = ['deleted_at'];
}
