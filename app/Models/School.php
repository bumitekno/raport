<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class School extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function data()
    {
        return [
            'uid' => $this->key,
            'name' => $this->name,
            'image' => empty($this->image) ? null : asset($this->image),
            'phone_number' => $this->phone_number,
            'email' => $this->email,
            'city' => $this->city,
            'address' => $this->address,
        ];
    }
}
