<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubElementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('sub_elements')->insert([
            [
                'name' => 'Mengenal dan Mencintai Tuhan Yang Maha Esa',
                'id_dimension' => 1,
                'status' => 1,
                'slug' => str_slug('Mengenal dan Mencintai Tuhan Yang Maha Esa')
            ],
            [
                'name' => 'Pemahaman Agama/ Kepercayaan',
                'id_dimension' => 1,
                'status' => 1,
                'slug' => str_slug('Pemahaman Agama/ Kepercayaan')
            ],
            [
                'name' => 'Pelaksanaan Ritual Ibadah',
                'id_dimension' => 1,
                'status' => 1,
                'slug' => str_slug('Pelaksanaan Ritual Ibadah')
            ],
            [
                'name' => 'Integritas',
                'id_dimension' => 1,
                'status' => 1,
                'slug' => str_slug('Integritas')
            ],
            [
                'name' => 'Merawat Diri secara Fisik, Mental, dan Spiritual',
                'id_dimension' => 1,
                'status' => 1,
                'slug' => str_slug('Merawat Diri secara Fisik, Mental, dan Spiritual')
            ],
            [
                'name' => 'Mengutamakan persamaan dengan orang lain dan menghargai perbedaan',
                'id_dimension' => 1,
                'status' => 1,
                'slug' => str_slug('Mengutamakan persamaan dengan orang lain dan menghargai perbedaan')
            ],
            [
                'name' => 'Berempati kepada orang lain',
                'id_dimension' => 1,
                'status' => 1,
                'slug' => str_slug('Berempati kepada orang lain')
            ],
            [
                'name' => 'Memahami Keterhu-bungan Ekosistem Bumi',
                'id_dimension' => 1,
                'status' => 1,
                'slug' => str_slug('Memahami Keterhu-bungan Ekosistem Bumi')
            ],
            [
                'name' => 'Menjaga Lingkungan Alam Sekitar',
                'id_dimension' => 1,
                'status' => 1,
                'slug' => str_slug('Menjaga Lingkungan Alam Sekitar')
            ],
            [
                'name' => 'Melaksanakan Hak dan Kewajiban sebagai Warga Negara Indonesia',
                'id_dimension' => 1,
                'status' => 1,
                'slug' => str_slug('Melaksanakan Hak dan Kewajiban sebagai Warga Negara Indonesia')
            ],
            [
                'name' => 'Mengenali kualitas dan minat diri serta tantangan yang dihadapi',
                'id_dimension' => 2,
                'status' => 1,
                'slug' => str_slug('Mengenali kualitas dan minat diri serta tantangan yang dihadapi')
            ],
            [
                'name' => 'Mengembangkan refleksi diri',
                'id_dimension' => 2,
                'status' => 1,
                'slug' => str_slug('Mengembangkan refleksi diri')
            ],
            [
                'name' => 'Regulasi emosi',
                'id_dimension' => 2,
                'status' => 1,
                'slug' => str_slug('Regulasi emosi')
            ],
            [
                'name' => 'Penetapan tujuan belajar, prestasi, dan pengembangan diri serta rencana strategis untuk mencapainya',
                'id_dimension' => 2,
                'status' => 1,
                'slug' => str_slug('Penetapan tujuan belajar, prestasi, dan pengembangan diri serta rencana strategis untuk mencapainya')
            ],
            [
                'name' => 'Menunjukkan inisiatif dan bekerja secara mandiri',
                'id_dimension' => 2,
                'status' => 1,
                'slug' => str_slug('Menunjukkan inisiatif dan bekerja secara mandiri')
            ],
            [
                'name' => 'Mengembangkan pengendalian dan disiplin diri',
                'id_dimension' => 2,
                'status' => 1,
                'slug' => str_slug('Mengembangkan pengendalian dan disiplin diri')
            ],
            [
                'name' => 'Percaya diri, tangguh (resilient), dan adaptif',
                'id_dimension' => 2,
                'status' => 1,
                'slug' => str_slug('Percaya diri, tangguh (resilient), dan adaptif')
            ],
            [
                'name' => 'Kerja sama',
                'id_dimension' => 3,
                'status' => 1,
                'slug' => str_slug('Kerja sama')
            ],
            [
                'name' => 'Komunikasi untuk mencapai tujuan bersama',
                'id_dimension' => 3,
                'status' => 1,
                'slug' => str_slug('Komunikasi untuk mencapai tujuan bersama')
            ],
            [
                'name' => 'Saling ketergantungan positif',
                'id_dimension' => 3,
                'status' => 1,
                'slug' => str_slug('Saling ketergantungan positif')
            ],
            [
                'name' => 'Koordinasi Sosial',
                'id_dimension' => 3,
                'status' => 1,
                'slug' => str_slug('Koordinasi Sosial')
            ],
            [
                'name' => 'Tanggap terhadap lingkungan Sosial',
                'id_dimension' => 3,
                'status' => 1,
                'slug' => str_slug('Tanggap terhadap lingkungan Sosial')
            ],
            [
                'name' => 'Persepsi sosial',
                'id_dimension' => 3,
                'status' => 1,
                'slug' => str_slug('Persepsi sosial')
            ],
            [
                'name' => 'Mendalami budaya dan identitas budaya',
                'id_dimension' => 4,
                'status' => 1,
                'slug' => str_slug('Mendalami budaya dan identitas budaya')
            ],
            [
                'name' => 'mengeksplorasi dan membandingkan pengetahuan budaya, kepercayaan, serta praktiknya',
                'id_dimension' => 4,
                'status' => 1,
                'slug' => str_slug('mengeksplorasi dan membandingkan pengetahuan budaya, kepercayaan, serta praktiknya')
            ],
            [
                'name' => 'Menumbuhkan rasa menghormati terhadap keanekaragaman budaya',
                'id_dimension' => 4,
                'status' => 1,
                'slug' => str_slug('Menumbuhkan rasa menghormati terhadap keanekaragaman budaya')
            ],
            [
                'name' => 'Berkomunikasi antar budaya',
                'id_dimension' => 4,
                'status' => 1,
                'slug' => str_slug('Berkomunikasi antar budaya')
            ],
            [
                'name' => 'Mempertimbangkan dan menumbuhkan berbagai perspektif',
                'id_dimension' => 4,
                'status' => 1,
                'slug' => str_slug('Mempertimbangkan dan menumbuhkan berbagai perspektif')
            ],
            [
                'name' => 'Refleksi terhadap pengalaman kebinekaan',
                'id_dimension' => 4,
                'status' => 1,
                'slug' => str_slug('Refleksi terhadap pengalaman kebinekaan')
            ],
            [
                'name' => 'Menghilangkan stereotip dan prasangka',
                'id_dimension' => 4,
                'status' => 1,
                'slug' => str_slug('Menghilangkan stereotip dan prasangka')
            ],
            [
                'name' => 'Menyelaraskan perbedaan budaya Aktif membangun masyarakat yang inklusif, adil, dan berkelanjutan',
                'id_dimension' => 4,
                'status' => 1,
                'slug' => str_slug('Menyelaraskan perbedaan budaya Aktif membangun masyarakat yang inklusif, adil, dan berkelanjutan')
            ],
            [
                'name' => 'Berpartisipasi dalam proses pengambilan keputusan bersama',
                'id_dimension' => 4,
                'status' => 1,
                'slug' => str_slug('Berpartisipasi dalam proses pengambilan keputusan bersama')
            ],
            [
                'name' => 'Memahami peran individu dalam demokrasi ',
                'id_dimension' => 4,
                'status' => 1,
                'slug' => str_slug('Memahami peran individu dalam demokrasi ')
            ],
            [
                'name' => 'Mengajukan pertanyaan',
                'id_dimension' => 5,
                'status' => 1,
                'slug' => str_slug('Mengajukan pertanyaan')
            ],
            [
                'name' => 'Mengidentifikasi, mengklarifikasi, dan mengolah informasi dan gagasan',
                'id_dimension' => 5,
                'status' => 1,
                'slug' => str_slug('Mengidentifikasi, mengklarifikasi, dan mengolah informasi dan gagasan')
            ],
            [
                'name' => 'Elemen menganalisis dan mengevaluasi penalaran dan prosedurnya',
                'id_dimension' => 5,
                'status' => 1,
                'slug' => str_slug('Elemen menganalisis dan mengevaluasi penalaran dan prosedurnya')
            ],
            [
                'name' => 'Merefleksi dan mengevaluasi pemikirannya sendiri',
                'id_dimension' => 5,
                'status' => 1,
                'slug' => str_slug('Merefleksi dan mengevaluasi pemikirannya sendiri')
            ],
            [
                'name' => 'pelajar kreatif mampu bereksperimen dengan berbagai pilihan secara kreatif Ketika menghadapi perubahan situasi dan kondisi',
                'id_dimension' => 6,
                'status' => 1,
                'slug' => str_slug('pelajar kreatif mampu bereksperimen dengan berbagai pilihan secara kreatif Ketika menghadapi perubahan situasi dan kondisi')
            ],

        ]);
    }
}
