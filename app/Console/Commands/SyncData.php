<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Symfony\Component\Console\Output\ConsoleOutput;
use DateTime;
use App\Models\Level;
use App\Models\SchoolYear;
use App\Models\Major;
use App\Models\Course;
use App\Models\StudyClass;
use App\Models\User;
use App\Models\Teacher;
use App\Models\StudentClass;
use App\Models\Extracurricular;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


class SyncData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Syncronous api data buku induk ';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        $output = new ConsoleOutput();
        $datetime = new DateTime();
        $timestamp = $datetime->format('Y-m-d H:i:s');

        //handle sync api buku induk 
        if (!empty(env('API_BUKU_INDUK'))) {

            /**
             * Api Levels Buku Induk 
             */

            $url_api_levels = env('API_BUKU_INDUK') . '/api/master/levels';
            $response_api_level = Http::get($url_api_levels);
            $resposnse_collection_levels = $response_api_level->collect();
            $collection_api_level = collect($resposnse_collection_levels);
            //$output->writeln('info:' . $collection_api_level);
            if (!empty($collection_api_level['data'])) {
                // proses input ke database 
                //check sync date if null 
                $check_level_sync = Level::whereNull('sync_date')->get()->count();

                $output->writeln('info:' . $check_level_sync);

                if ($check_level_sync == 0) {

                    foreach ($collection_api_level['data'] as $key => $data_levels) {

                        $create_level = Level::updateOrCreate([
                            'key' => $data_levels['uid'],
                        ], [
                            'key' => $data_levels['uid'],
                            'name' => $data_levels['name'],
                            'fase' => $data_levels['fase'] ?? '-',
                            'sync_date' => $timestamp,
                            'status' => $data_levels['status'],
                            'slug' => $data_levels['name'] . '-' . str::random(5)
                        ]);

                        $output->writeln('info: insert data level ' . $create_level);

                    }
                }
            }

            sleep(5);

            /** Api School Year  */
            $url_api_school_year = env('API_BUKU_INDUK') . '/api/master/school_years';
            $response_api_school_year = Http::get($url_api_school_year);
            $resposnse_collection_school_year = $response_api_school_year->collect();
            $collection_api_school_year = collect($resposnse_collection_school_year);
            $output->writeln('info:' . $collection_api_school_year);

            if (!empty($collection_api_school_year['data'])) {
                $check_school_year_sync = SchoolYear::whereNull('sync_date')->get()->count();
                if ($check_school_year_sync == 0) {
                    foreach ($collection_api_school_year['data'] as $key => $data_school_years) {
                        $create_school_years = SchoolYear::updateOrCreate([
                            'key' => $data_school_years['uid'],
                        ], [
                            'key' => $data_school_years['uid'],
                            'name' => $data_school_years['name'] . $data_school_years['semester_number'],
                            'sync_date' => $timestamp,
                            'status' => $data_school_years['status'],
                            'slug' => Str::replace('/', '', $data_school_years['name']) . $data_school_years['semester_number'] . '-' . str::random(5)
                        ]);
                        $output->writeln('info: insert data school years ' . $create_school_years);
                    }
                }
            }

            sleep(5);

            /** Api Major  */

            $url_api_major = env('API_BUKU_INDUK') . '/api/master/majors';
            $response_api_major = Http::get($url_api_major);
            $resposnse_collection_major = $response_api_major->collect();
            $collection_api_major = collect($resposnse_collection_major);
            $output->writeln('info:' . $collection_api_major);
            if (!empty($collection_api_major['data'])) {
                $check_school_major = Major::whereNull('sync_date')->get()->count();
                if ($check_school_major == 0) {
                    foreach ($collection_api_major['data'] as $key => $data_major) {
                        $create_major = Major::updateOrCreate([
                            'key' => $data_major['uid'],
                        ], [
                            'key' => $data_major['uid'],
                            'name' => $data_major['name'],
                            'sync_date' => $timestamp,
                            'status' => $data_major['status'],
                            'slug' => $data_major['name'] . '-' . str::random(5)
                        ]);
                        $output->writeln('info: insert data Major ' . $create_major);
                    }
                }
            }

            sleep(5);

            /** Api Mapels */
            $url_api_mapel = env('API_BUKU_INDUK') . '/api/master/mapels';
            $response_api_mapel = Http::get($url_api_mapel);
            $resposnse_collection_mapel = $response_api_mapel->collect();
            $collection_api_mapel = collect($resposnse_collection_mapel);
            $output->writeln('info:' . $collection_api_mapel);
            if (!empty($collection_api_mapel['data'])) {
                $check_school_mapel = Course::whereNull('sync_date')->get()->count();
                if ($check_school_mapel == 0) {
                    foreach ($collection_api_mapel['data'] as $key => $data_mapel) {
                        $create_major = Course::updateOrCreate([
                            'key' => $data_mapel['uid'],
                        ], [
                            'key' => $data_mapel['uid'],
                            'code' => $data_mapel['kode_mapel'],
                            'name' => $data_mapel['nama'],
                            'group' => $data_mapel['kelompok'],
                            'sync_date' => $timestamp,
                            'status' => $data_mapel['status'],
                            'slug' => $data_mapel['nama'] . '-' . str::random(5)
                        ]);
                        $output->writeln('info: insert data Mapel ' . $create_major);
                    }
                }
            }

            sleep(5);

            /** Api Rombel */
            $url_api_rombel = env('API_BUKU_INDUK') . '/api/master/study_classes';
            $response_api_rombel = Http::get($url_api_rombel);
            $resposnse_collection_rombel = $response_api_rombel->collect();
            $collection_api_rombel = collect($resposnse_collection_rombel);
            $output->writeln('info:' . $collection_api_rombel);

            if (!empty($collection_api_rombel['data'])) {
                $check_school_rombel = StudyClass::whereNull('sync_date')->get()->count();
                if ($check_school_rombel == 0) {
                    foreach ($collection_api_rombel['data'] as $key => $data_rombel) {
                        $create_rombel = StudyClass::updateOrCreate([
                            'key' => $data_rombel['key'],
                        ], [
                            'key' => $data_rombel['key'],
                            'name' => $data_rombel['name'],
                            'id_major' => $data_rombel['major_id'],
                            'id_level' => $data_rombel['level_id'],
                            'sync_date' => $timestamp,
                            'status' => $data_rombel['status'],
                            'slug' => $data_rombel['name'] . '-' . str::random(5)
                        ]);
                        $output->writeln('info: insert data rombel ' . $create_rombel);
                    }
                }
            }

            sleep(5);

            /** Api Student Users  */
            $url_api_student = env('API_BUKU_INDUK') . '/api/users/students/data/all';
            $response_api_student = Http::get($url_api_student);
            $resposnse_collection_student = $response_api_student->collect();
            $collection_api_student = collect($resposnse_collection_student);
            $output->writeln('info:' . $collection_api_student);
            if (!empty($collection_api_student['data'])) {
                $check_school_usert_student = User::whereNull('sync_date')->get()->count();
                if ($check_school_usert_student == 0) {
                    foreach ($collection_api_student['data'] as $key => $data_user) {
                        $create_user = User::updateOrCreate([
                            'key' => $data_user['uid'],
                        ], [
                            'key' => $data_user['uid'],
                            'name' => $data_user['name'],
                            'gender' => $data_user['gender'] == 'L' ? 'male' : 'female',
                            'email' => $data_user['email'],
                            'nis' => $data_user['nis'],
                            'nisn' => $data_user['nisn'],
                            'religion' => $data_user['religion'] == 'protestan' ? 'lainnya' : $data_user['religion'],
                            'place_of_birth' => $data_user['birth_place'],
                            'date_of_birth' => \Carbon\Carbon::parse($data_user['birth_day']),
                            'address' => $data_user['address'],
                            'accepted_date' => $data_user['date_accepted'],
                            'entry_year' => $data_user['school_year'],
                            'sync_date' => $timestamp,
                            'status' => $data_user['status'],
                            'slug' => $data_user['name'] . '-' . str::random(5),
                            'password' => Hash::make('12345678')
                        ]);
                        $output->writeln('info: insert data user student ' . $create_user);
                    }
                }
            }

            sleep(5);

            /** Api Teacher  */
            $url_api_teacher = env('API_BUKU_INDUK') . '/api/users/teachers/data/all';
            $response_api_teacher = Http::get($url_api_teacher);
            $resposnse_collection_teacher = $response_api_teacher->collect();
            $collection_api_teacher = collect($resposnse_collection_teacher);
            $output->writeln('info:' . $collection_api_teacher);
            if (!empty($collection_api_teacher['data'])) {
                $check_school_usert_teacher = Teacher::whereNull('sync_date')->get()->count();
                if ($check_school_usert_teacher == 0) {
                    foreach ($collection_api_teacher['data'] as $key => $data_user) {
                        $create_user = Teacher::updateOrCreate([
                            'key' => $data_user['uid'],
                        ], [
                            'key' => $data_user['uid'],
                            'name' => $data_user['name'],
                            'gender' => $data_user['gender'] == 'L' ? 'male' : 'female',
                            'email' => $data_user['email'],
                            'nip' => $data_user['nip'],
                            'nik' => $data_user['nik'],
                            'nuptk' => $data_user['nuptk'],
                            'place_of_birth' => $data_user['birth_place'],
                            'date_of_birth' => \Carbon\Carbon::parse($data_user['birth_day']),
                            'address' => $data_user['address'],
                            'type' => 'teacher',
                            'phone' => $data_user['contact'],
                            'sync_date' => $timestamp,
                            'status' => $data_user['status'],
                            'slug' => $data_user['name'] . '-' . str::random(5),
                            'password' => Hash::make('12345678')
                        ]);
                        $output->writeln('info: insert data user student ' . $create_user);
                    }
                }
            }

            sleep(5);

            /** Api Student Class */
            $url_api_student_class = env('API_BUKU_INDUK') . '/api/master/student_classes/data/all';
            $response_api_student_class = Http::get($url_api_student_class);
            $resposnse_collection_studentclass = $response_api_student_class->collect();
            $collection_api_studentclass = collect($resposnse_collection_studentclass);
            $output->writeln('info:' . $collection_api_studentclass);
            if (!empty($collection_api_studentclass['data'])) {
                $check_school_usert_studentclass = StudentClass::whereNull('sync_date')->get()->count();
                if ($check_school_usert_studentclass == 0) {
                    foreach ($collection_api_studentclass['data'] as $key => $data_studentclass) {

                        $create_user_student_class = StudentClass::updateOrCreate([
                            'key' => $data_studentclass['uid']
                        ], [
                            'key' => $data_studentclass['uid'],
                            'year' => $data_studentclass['tahun'],
                            'slug' => $data_studentclass['uid'] . '-' . str::random(5),
                            'id_study_class' => $data_studentclass['id_rombel'],
                            'id_student' => $data_studentclass['id_siswa'],
                            'sync_date' => $timestamp,
                        ]);

                        $output->writeln('info: insert data user student class ' . $create_user_student_class);
                    }
                }
            }

            sleep(5);

            /** Api Ekstra  */
            $url_api_ekstra = env('API_BUKU_INDUK') . '/api/master/extracurriculars';
            $response_api_ekstra = Http::get($url_api_ekstra);
            $resposnse_collection_ekstra = $response_api_ekstra->collect();
            $collection_api_ekstra = collect($resposnse_collection_ekstra);
            $output->writeln('info:' . $collection_api_ekstra);

            if (!empty($collection_api_ekstra['data'])) {
                $check_school_ekstra = Extracurricular::whereNull('sync_date')->get()->count();

                if ($check_school_ekstra == 0) {
                    foreach ($collection_api_ekstra['data'] as $key => $data_ekstra) {

                        $create_extra = Extracurricular::updateOrCreate([
                            'key' => $data_ekstra['uid']
                        ], [
                            'key' => $data_ekstra['uid'],
                            'name' => $data_ekstra['name'],
                            'status' => $data_ekstra['status'],
                            'slug' => $data_ekstra['uid'] . '-' . str::random(5),
                            'sync_date' => $timestamp,
                        ]);

                        $output->writeln('info: insert data extra ' . $create_extra);
                    }
                }
            }

            /** guru mapel */

            $url_api_gurumapel = env('API_BUKU_INDUK') . '/api/master/subject_teachers/data/all';
            $response_api_gurumapel = Http::get($url_api_gurumapel);
            $resposnse_collection_gurumapel = $response_api_gurumapel->collect();
            $collection_api_gurumapel = collect($resposnse_collection_gurumapel);
            $output->writeln('info:' . $collection_api_gurumapel);

            if (!empty($collection_api_gurumapel['data'])) {

            }

            sleep(5);
            $this->syncdatepost($output);

        } else {
            $output->writeln('error: API URL BUKU INDUK tidak di ketahui ');
        }

        return Command::SUCCESS;
    }

    /** post if sync date null  */
    public function syncdatepost($output)
    {
        $output->writeln('info: prepared post sync data .... ');

    }
}