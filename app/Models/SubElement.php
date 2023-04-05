<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubElement extends Model
{
    use HasFactory;

    use SoftDeletes;

    protected $table = "sub_elements";

    protected $guarded = [];

    protected $dates = ['deleted_at'];

    public function dimension()
    {
        return $this->belongsTo(Dimension::class, 'id_dimension');
    }

}
