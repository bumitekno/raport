<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Admin extends Authenticatable
{
    use HasFactory;

    use SoftDeletes;

    protected $table = "admins";
    protected $fillable = [
        'slug','name', 'email', 'gender', 'phone', 'address', 'file', 'place_of_birth', 'date_of_birth', 'password', 'status'
    ];

    protected $dates = ['deleted_at'];

    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = bcrypt($password);
    }
}
