<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tema extends Model
{
    use HasFactory;

    use SoftDeletes;

    protected $table = "temas";

    protected $guarded = [];

    protected $dates = ['deleted_at'];

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($tema) {
            $tema->p5s->each(function ($p5s) {  
                $p5s->scoreP5s()->delete();
                $p5s->delete();
            });
        });

        static::restoring(function ($tema) {
            $tema->p5s()->restore();
        });
    }

    public function p5s()
    {
        return $this->hasMany(P5::class, 'id_temas');
    }
}
