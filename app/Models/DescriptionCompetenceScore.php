<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DescriptionCompetenceScore extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected $dates = ['deleted_at'];
}
