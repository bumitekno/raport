<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory;

    use SoftDeletes;

    protected $table = "users";

    protected $fillable = [
        'slug', 'nis', 'nisn', 'name', 'gender', 'religion', 'phone', 'email', 'address', 'place_of_birth', 'date_of_birth', 'password', 'status', 'file'
    ];

    protected $dates = ['deleted_at'];

    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = bcrypt($password);
    }
}
