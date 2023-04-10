<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TemplateConfiguration extends Model
{
    use HasFactory;

    use SoftDeletes;

    protected $table = "template_configurations";

    protected $guarded = [];

    protected $dates = ['deleted_at'];
}
