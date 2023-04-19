<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(
            [
                // UserSeeder::class,
                AdminSeeder::class,
                SchoolYearSeeder::class,
                DimensionSeeder::class,
                TemaSeeder::class,
                ElementSeeder::class,
                SubElementSeeder::class,
                TemaSeeder::class,
                TypeCompetenceSeeder::class,
                // StuffSeeder::class,
                // LocationSeeder::class,
            ]
        );
    }
}
