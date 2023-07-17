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
        'key',
        'slug',
        'name',
        'status',
        'sync_date',
        'deleted_at'
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

    public function scopeActive($query)
    {
        return $query->select('key as uid', 'slug', 'name', 'status')->where('status', 1);
    }

    public function data()
    {
        return [
            'uid' => $this->key,
            'slug' => $this->slug,
            'name' => $this->name,
            'status' => $this->status,
        ];
    }
}