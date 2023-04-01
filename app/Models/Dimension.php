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

    public function elements()
    {
        return $this->hasMany(Element::class, 'id_dimension');
    }
}
