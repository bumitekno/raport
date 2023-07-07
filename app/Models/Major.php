<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Major extends Model
{
    use HasFactory;

    use SoftDeletes;

    protected $table = "majors";

    protected $fillable = [
        'slug', 'name', 'status'
    ];

    protected $dates = ['deleted_at'];

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($major) {
            $major->studyClass()->delete();
            $major->templateConfigurations()->delete();
        });

        static::restoring(function ($major) {
            $major->studyClass()->restore();
            $major->templateConfigurations()->restore();
        });
    }

    public function studyClass()
    {
        return $this->hasMany(StudyClass::class, 'id_major');
    }

    public function templateConfigurations()
    {
        return $this->hasMany(TemplateConfiguration::class, 'id_major');
    }
}
