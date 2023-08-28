<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DefaultTemplate extends Model
{
    use HasFactory;
    protected $table = "default_template";

    protected $guarded = [];
}