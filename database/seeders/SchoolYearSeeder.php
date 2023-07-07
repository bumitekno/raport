<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SchoolYearSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = now();
        $currentYear = $now->year;
        $nextYear = $now->addYear()->year;
        DB::table('school_years')->insert([
            [
                'name' => $currentYear . '/' . $nextYear . '1',
                'status' => 1,
                'slug' => str_slug($currentYear . '/' . $nextYear . '1') . '-' . str_random(5)
            ],
            [
                'name' => $currentYear . '/' . $nextYear . '2',
                'status' => 2,
                'slug' => str_slug($currentYear . '/' . $nextYear . '2') . '-' . str_random(5)
            ],

        ]);
    }
}
