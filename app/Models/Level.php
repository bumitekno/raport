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
        'key', 'slug', 'name', 'status', 'fase'
    ];

    protected $dates = ['deleted_at'];

    public function scopeActive($query)
    {
        return $query->select('key as uid', 'slug', 'name', 'fase', 'status')->where('status', 1);
    }

    public function data()
    {
        return [
            'uid' => $this->key,
            'slug' => $this->slug,
            'name' => $this->name,
            'fase' => $this->fase,
            'status' => $this->status,
        ];
    }

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
