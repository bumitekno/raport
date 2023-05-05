<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Teacher extends Authenticatable
{
    use HasFactory;

    use SoftDeletes;

    protected $table = "teachers";

    // protected $guarded = ['password_confirmation'];

    protected $guarded = [];

    // protected $fillable = [
    //     'slug', 'name', 'nik', 'nuptk', 'nip', 'email', 'phone', 'address', 'place_of_birth', 'date_of_birth', 'gender', 'religion', 'password', 'status', 'type', 'id_class'
    // ];

    protected $dates = ['deleted_at'];

    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = bcrypt($password);
    }
}
