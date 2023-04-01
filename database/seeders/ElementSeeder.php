<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ElementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('elements')->insert([
            [
                'name' => 'akhlak beragama',
                'id_dimension' => 1,
                'status' => 1,
                'slug' => str_slug('akhlak beragama')
            ],
            [
                'name' => 'akhlak pribadi',
                'id_dimension' => 1,
                'status' => 1,
                'slug' => str_slug('akhlak pribadi')
            ],
            [
                'name' => 'akhlak kepada manusia',
                'id_dimension' => 1,
                'status' => 1,
                'slug' => str_slug('akhlak kepada manusia')
            ],
            [
                'name' => 'akhlak kepada alam',
                'id_dimension' => 1,
                'status' => 1,
                'slug' => str_slug('akhlak kepada alam')
            ],
            [
                'name' => 'akhlak bernegara',
                'id_dimension' => 1,
                'status' => 1,
                'slug' => str_slug('akhlak bernegara')
            ],
            [
                'name' => 'Pemahaman diri dan situasi yang dihadapi',
                'id_dimension' => 2,
                'status' => 1,
                'slug' => str_slug('Pemahaman diri dan situasi yang dihadapi')
            ],
            [
                'name' => 'Regulasi diri',
                'id_dimension' => 2,
                'status' => 1,
                'slug' => str_slug('Regulasi diri')
            ],
            [
                'name' => 'kolaborasi',
                'id_dimension' => 3,
                'status' => 1,
                'slug' => str_slug('kolaborasi')
            ],
            [
                'name' => 'kepedulian',
                'id_dimension' => 3,
                'status' => 1,
                'slug' => str_slug('kepedulian')
            ],
            [
                'name' => 'berbagi',
                'id_dimension' => 3,
                'status' => 1,
                'slug' => str_slug('berbagi')
            ],
            [
                'name' => 'mengenal dan menghargai budaya',
                'id_dimension' => 4,
                'status' => 1,
                'slug' => str_slug('mengenal dan menghargai budaya')
            ],
            [
                'name' => 'Komunikasi dan interaksi antar budaya',
                'id_dimension' => 4,
                'status' => 1,
                'slug' => str_slug('Komunikasi dan interaksi antar budaya')
            ],
            [
                'name' => 'refleksi dan tanggung jawab terhadap pengalaman kebinekaan',
                'id_dimension' => 4,
                'status' => 1,
                'slug' => str_slug('refleksi dan tanggung jawab terhadap pengalaman kebinekaan')
            ],
            [
                'name' => 'Berkeadilan Sosial',
                'id_dimension' => 4,
                'status' => 1,
                'slug' => str_slug('Berkeadilan Sosial')
            ],
            [
                'name' => 'Memperoleh dan memproses informasi dan gagasan',
                'id_dimension' => 5,
                'status' => 1,
                'slug' => str_slug('Memperoleh dan memproses informasi dan gagasan')
            ],
            [
                'name' => 'Menganalisis dan mengevaluasi penalaran',
                'id_dimension' => 5,
                'status' => 1,
                'slug' => str_slug('Menganalisis dan mengevaluasi penalaran')
            ],
            [
                'name' => 'Merefleksi dan mengevaluasi pemikirannya sendiri',
                'id_dimension' => 5,
                'status' => 1,
                'slug' => str_slug('Merefleksi dan mengevaluasi pemikirannya sendiri')
            ],
            [
                'name' => 'Menghasilkan gagasan yang orisinal',
                'id_dimension' => 6,
                'status' => 1,
                'slug' => str_slug('Menghasilkan gagasan yang orisinal')
            ],
            [
                'name' => 'Menghasilkan karya dan tindakan yang orisinal',
                'id_dimension' => 6,
                'status' => 1,
                'slug' => str_slug('Menghasilkan karya dan tindakan yang orisinal')
            ],
            [
                'name' => 'Memiliki keluwesan berpikir dalam mencari alternatif solusi permasalahan',
                'id_dimension' => 6,
                'status' => 1,
                'slug' => str_slug('Memiliki keluwesan berpikir dalam mencari alternatif solusi permasalahan')
            ],
        ]);
    }
}
