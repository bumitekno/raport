<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserParent extends Authenticatable
{
    use HasFactory;

    use SoftDeletes;

    protected $table = "parents";

    protected $dates = ['deleted_at'];

    protected $guarded = [];

    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = bcrypt($password);
    }
}
