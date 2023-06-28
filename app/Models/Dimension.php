<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Dimension extends Model
{
    use HasFactory;

    use SoftDeletes;

    protected $table = "dimensions";

    protected $guarded = [];

    protected $dates = ['deleted_at'];

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($dimension) {
            $dimension->elements()->delete();
            $dimension->subElements()->delete();
        });

        static::restoring(function ($dimension) {
            $dimension->elements()->restore();
            $dimension->subElements()->restore();
        });
    }

    public function elements()
    {
        return $this->hasMany(Element::class, 'id_dimension');
    }

    public function subElements()
    {
        return $this->hasMany(SubElement::class, 'id_dimension');
    }
}
