<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Element extends Model
{
    use HasFactory;

    use SoftDeletes;

    protected $table = "elements";

    protected $guarded = [];

    protected $dates = ['deleted_at'];

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($element) {
            $element->subElements()->delete();
        });
    }

    public function subElements()
    {
        return $this->hasMany(Element::class, 'id_element');
    }
}
