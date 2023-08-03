<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Level extends Model
{
    use HasFactory;

    use SoftDeletes;

    protected $table = "levels";

    protected $fillable = [
        'slug', 'name', 'status', 'fase'
    ];

    protected $dates = ['deleted_at'];

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($level) {
            $level->studyClass()->delete();
            $level->basicCompetencies()->delete();
        });

        static::restoring(function ($level) {
            $level->studyClass()->restore();
            $level->basicCompetencies()->restore();
        });
    }

    public function studyClass()
    {
        return $this->hasMany(StudyClass::class, 'id_level');
    }

    public function basicCompetencies()
    {
        return $this->hasMany(BasicCompetency::class, 'id_level');
    }
}
