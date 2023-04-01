<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DimensionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('dimensions')->insert([
            [
                'id' => 1,
                'name' => 'beriman, bertakwa kepada Tuhan Yang Maha Esa, dan berakhlak mulia',
                'status' => 1,
                'slug' => str_slug('beriman, bertakwa kepada Tuhan Yang Maha Esa, dan berakhlak mulia')
            ],
            [
                'id' => 2,
                'name' => 'mandiri',
                'status' => 1,
                'slug' => str_slug('mandiri')
            ],
            [
                'id' => 3,
                'name' => 'bergotong-royong',
                'status' => 1,
                'slug' => str_slug('bergotong-royong')
            ],
            [
                'id' => 4,
                'name' => 'berkebinekaan global',
                'status' => 1,
                'slug' => str_slug('berkebinekaan global')
            ],
            [
                'id' => 5,
                'name' => 'bernalar kritis',
                'status' => 1,
                'slug' => str_slug('bernalar kritis')
            ],
            [
                'id' => 6,
                'name' => 'kreatif',
                'status' => 1,
                'slug' => str_slug('kreatif')
            ],

        ]);
    }
}
