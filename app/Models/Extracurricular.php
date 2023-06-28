<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Extracurricular extends Model
{
    use HasFactory;

    use SoftDeletes;

    protected $table = "extracurriculars";

    protected $guarded = [];

    protected $dates = ['deleted_at'];

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($dimension) {
            $dimension->scoreExtracuriculars()->delete();
        });

        static::restoring(function ($dimension) {
            $dimension->scoreExtracuriculars()->restore();
        });
    }

    public function scoreExtracuriculars()
    {
        return $this->hasMany(ScoreExtracurricular::class, 'id_extra');
    }
}
