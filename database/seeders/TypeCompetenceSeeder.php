<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TypeCompetenceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('type_competence_achievements')->insert([
            [
                'name' => 'Capaian Pembelajaran ',
                'status' => 1,
                'slug' => str_slug('Capaian Pembelajaran ')
            ],
            [
                'name' => 'Tujuan Pembelajaran ',
                'status' => 1,
                'slug' => str_slug('Tujuan Pembelajaran ')
            ],
            [
                'name' => 'Alur Tujuan Pembelajaran ',
                'status' => 1,
                'slug' => str_slug('Alur Tujuan Pembelajaran ')
            ],
        ]);
    }
}
