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

    protected $guarded = [];

    public function scopeActive($query)
    {
        return $query->where('status', 1)->orderBy('name', 'ASC');
    }

    protected static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            $model->created_at = now();
        });

        static::deleting(function ($user) {
            $user->userParent()->delete();
            $user->studentClass()->delete();
        });

        static::restoring(function ($user) {
            $user->userParent()->restore();
            $user->studentClass()->restore();
        });
    }

    public function userParent()
    {
        return $this->hasMany(UserParent::class, 'id_user');
    }

    public function studentClass()
    {
        return $this->hasMany(StudentClass::class, 'id_student');
    }

    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = bcrypt($password);
    }

    public function study_class()
    {
        return $this->belongsTo(StudyClass::class, 'accepted_grade');
    }

    public function families()
    {
        return $this->hasMany(UserParent::class, 'id_user');
    }
}