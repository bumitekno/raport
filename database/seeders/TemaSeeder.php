<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TemaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('temas')->insert([
            [
                'name' => 'Gaya Hidup Berkelanjutan',
                'type' => 'smp',
                'status' => 1,
                'slug' => str_slug('Gaya Hidup Berkelanjutan')
            ],
            [
                'name' => 'Kearifan Lokal',
                'type' => 'smp',
                'status' => 1,
                'slug' => str_slug('Kearifan Lokal')
            ],
            [
                'name' => 'Bhinneka Tunggal Ika',
                'type' => 'smp',
                'status' => 1,
                'slug' => str_slug('Bhinneka Tunggal Ika')
            ],
            [
                'name' => 'Bangunlah Jiwa dan Raganya',
                'type' => 'smp',
                'status' => 1,
                'slug' => str_slug('Bangunlah Jiwa dan Raganya')
            ],
            [
                'name' => 'Suara Demokrasi',
                'type' => 'smp',
                'status' => 1,
                'slug' => str_slug('Suara Demokrasi')
            ],
            [
                'name' => 'Rekayasa dan Teknologi',
                'type' => 'smp',
                'status' => 1,
                'slug' => str_slug('Rekayasa dan Teknologi')
            ],
            [
                'name' => 'Kewirausahaan',
                'type' => 'smp',
                'status' => 1,
                'slug' => str_slug('Kewirausahaan')
            ],
            [
                'name' => 'Kebekerjaan',
                'type' => 'smp',
                'status' => 1,
                'slug' => str_slug('Kebekerjaan')
            ],
            [
                'name' => 'Aku Sayang Bumi "Gaya Hidup Berkelanjutan"',
                'type' => 'paud',
                'status' => 2,
                'slug' => str_slug('Aku Sayang Bumi "Gaya Hidup Berkelanjutan"')
            ],
            [
                'name' => 'Aku Cinta Indonesia "Kearifan Lokal"',
                'type' => 'paud',
                'status' => 2,
                'slug' => str_slug('Aku Cinta Indonesia "Kearifan Lokal"')
            ],
            [
                'name' => 'Kita Semua Bersaudara "Bhinneka Tunggal Ika"',
                'type' => 'paud',
                'status' => 2,
                'slug' => str_slug('Kita Semua Bersaudara "Bhinneka Tunggal Ika"')
            ],
            [
                'name' => 'Imajinasi dan Kreativitasku "Rekayasa dan Teknologi"',
                'type' => 'paud',
                'status' => 2,
                'slug' => str_slug('Imajinasi dan Kreativitasku "Rekayasa dan Teknologi"')
            ],
        ]);
    }
}
