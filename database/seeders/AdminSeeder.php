<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class AdminSeeder extends Seeder
{
    public function run()
    {
        //Admin::factory()->count(2)->create();
        Admin::create([
            'name' => 'Superadmin',
            'email' => 'superadmin@admin.com',
            'gender' => 'male',
            'phone' => '0980808018819',
            'address' => 'Temanggung',
            'date_of_birth' => now(),
            'place_of_birth' => 'Temanggung',
            'status' => 1,
            'slug' => 'superadmin-' . str::random(5),
            'password' => '12345678'
        ]);
    }
}