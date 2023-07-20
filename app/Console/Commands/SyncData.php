<?php

namespace App\Console\Commands;

use App\Models\SubjectTeacher;
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

            $output->writeln('info: prepared get sync data .... ');

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

                        $create_level = Level::withoutGlobalScopes()->updateOrCreate([
                            'key' => $data_levels['uid'],
                            'slug' => $data_levels['name'] . '-' . $data_levels['uid'],
                        ], [
                            'key' => $data_levels['uid'],
                            'name' => $data_levels['name'],
                            'fase' => $data_levels['fase'] ?? '-',
                            'sync_date' => $timestamp,
                            'status' => $data_levels['status'],
                            'slug' => $data_levels['name'] . '-' . $data_levels['uid'],
                            'deleted_at' => isset($data_levels['deleted_at']) ? $data_levels['deleted_at'] == null ? null : \Carbon\Carbon::parse($data_levels['deleted_at']) : null
                        ]);

                        $output->writeln('info: insert data level ' . $create_level);

                        if ($key > 0 && $key % 10 == 0) {
                            sleep(5);
                            $output->writeln('info:  jeda 5 detik level ');
                        }

                    }
                }
            }

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
                        $create_school_years = SchoolYear::withoutGlobalScopes()->updateOrCreate([
                            'key' => $data_school_years['uid'],
                            'slug' => Str::replace('/', '', $data_school_years['name']) . $data_school_years['semester_number'] . '-' . $data_school_years['uid'],
                        ], [
                            'key' => $data_school_years['uid'],
                            'name' => $data_school_years['name'] . $data_school_years['semester_number'],
                            'status' => $data_school_years['status'],
                            'slug' => Str::replace('/', '', $data_school_years['name']) . $data_school_years['semester_number'] . '-' . $data_school_years['uid'],
                            'sync_date' => $timestamp,
                            'deleted_at' => isset($data_school_years['deleted_at']) ? $data_school_years['deleted_at'] == null ? null : \Carbon\Carbon::parse($data_school_years['deleted_at']) : null
                        ]);
                        $output->writeln('info: insert data school years ' . $create_school_years);
                        if ($key > 0 && $key % 10 == 0) {
                            sleep(5);
                            $output->writeln('info:  jeda 5 detik school years ');
                        }
                    }
                }
            }

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
                        $create_major = Major::withoutGlobalScopes()->updateOrCreate([
                            'key' => $data_major['uid'],
                            'slug' => $data_major['name'] . '-' . $data_major['uid'],
                        ], [
                            'key' => $data_major['uid'],
                            'name' => $data_major['name'],
                            'sync_date' => $timestamp,
                            'status' => $data_major['status'],
                            'slug' => $data_major['name'] . '-' . $data_major['uid'],
                            'deleted_at' => isset($data_major['deleted_at']) ? $data_major['deleted_at'] == null ? null : \Carbon\Carbon::parse($data_major['deleted_at']) : null
                        ]);
                        $output->writeln('info: insert data Major ' . $create_major);
                        if ($key > 0 && $key % 10 == 0) {
                            sleep(5);
                            $output->writeln('info:  jeda 5 detik major ');
                        }
                    }
                }
            }

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
                        $create_major = Course::withoutGlobalScopes()->updateOrCreate([
                            'key' => $data_mapel['uid'],
                            'slug' => $data_mapel['nama'] . '-' . $data_mapel['uid'],
                        ], [
                            'key' => $data_mapel['uid'],
                            'code' => $data_mapel['kode_mapel'],
                            'name' => $data_mapel['nama'],
                            'group' => $data_mapel['kelompok'],
                            'sync_date' => $timestamp,
                            'status' => $data_mapel['status'],
                            'slug' => $data_mapel['nama'] . '-' . $data_mapel['uid'],
                            'deleted_at' => isset($data_rombel['deleted_at']) ? $data_mapel['deleted_at'] == null ? null : \Carbon\Carbon::parse($data_mapel['deleted_at']) : null
                        ]);
                        $output->writeln('info: insert data Mapel ' . $create_major);
                        if ($key > 0 && $key % 10 == 0) {
                            sleep(5);
                            $output->writeln('info:  jeda 5 detik mapel ');
                        }
                    }
                }
            }


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
                        $create_rombel = StudyClass::withoutGlobalScopes()->updateOrCreate([
                            'key' => $data_rombel['key'],
                            'slug' => $data_rombel['name'] . '-' . $data_rombel['key'],
                        ], [
                            'key' => $data_rombel['key'],
                            'name' => $data_rombel['name'],
                            'id_major' => $data_rombel['major_id'] == null ? 0 : $data_rombel['major_id'],
                            'id_level' => $data_rombel['level_id'] == null ? 0 : $data_rombel['level_id'],
                            'sync_date' => $timestamp,
                            'status' => $data_rombel['status'],
                            'slug' => $data_rombel['name'] . '-' . $data_rombel['key'],
                            'deleted_at' => isset($data_rombel['deleted_at']) ? $data_rombel['deleted_at'] == null ? null : \Carbon\Carbon::parse($data_rombel['deleted_at']) : null
                        ]);
                        $output->writeln('info: insert data rombel ' . $create_rombel);
                        if ($key > 0 && $key % 10 == 0) {
                            sleep(5);
                            $output->writeln('info:  jeda 5 detik rombel ');
                        }
                    }
                }
            }


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

                        $check_password = User::where('key', $data_user['uid'])->first();

                        if (empty($check_password) && empty($check_password->password)) {

                            $create_user = User::withoutGlobalScopes()->updateOrCreate([
                                'id' => $data_user['id'],
                                'key' => $data_user['uid'],
                                'slug' => $data_user['name'] . '-' . $data_user['uid'],
                            ], [
                                'id' => $data_user['id'],
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
                                'slug' => $data_user['name'] . '-' . $data_user['uid'],
                                'password' => '12345678',
                                'phone' => $data_user['phone'],
                                'deleted_at' => isset($data_user['deleted_at']) ? $data_user['deleted_at'] == null ? null : \Carbon\Carbon::parse($data_user['deleted_at']) : null,
                                'note' => $data_user['note'],
                                'class_accepted' => $data_user['class_accepted']
                            ]);

                        } else {
                            $create_user = User::withoutGlobalScopes()->updateOrCreate([
                                'id' => $data_user['id'],
                                'key' => $data_user['uid'],
                                'slug' => $data_user['name'] . '-' . $data_user['uid'],
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
                                'slug' => $data_user['name'] . '-' . $data_user['uid'],
                                'phone' => $data_user['phone'],
                                'deleted_at' => isset($data_user['deleted_at']) ? $data_user['deleted_at'] == null ? null : \Carbon\Carbon::parse($data_user['deleted_at']) : null,
                                'note' => $data_user['note'],
                                'class_accepted' => $data_user['class_accepted']
                            ]);
                        }

                        $output->writeln('info: insert data user student ' . $create_user);
                        if ($key > 0 && $key % 10 == 0) {
                            sleep(5);
                            $output->writeln('info:  jeda 5 detik student ');
                        }
                    }
                }
            }


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

                        $check_password = Teacher::where('key', $data_user['uid'])->first();

                        if (!empty($check_password) && !empty($check_password->password)) {

                            $create_user = Teacher::withoutGlobalScopes()->updateOrCreate([
                                'id' => $data_user['id'],
                                'key' => $data_user['uid'],
                                'slug' => $data_user['name'] . '-' . $data_user['uid'],
                            ], [
                                'id' => $data_user['id'],
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
                                'slug' => $data_user['name'] . '-' . $data_user['uid'],
                                'deleted_at' => isset($data_user['deleted_at']) ? $data_user['deleted_at'] == null ? null : \Carbon\Carbon::parse($data_user['deleted_at']) : null
                            ]);

                        } else {
                            $create_user = Teacher::withoutGlobalScopes()->updateOrCreate([
                                'id' => $data_user['id'],
                                'key' => $data_user['uid'],
                                'slug' => $data_user['name'] . '-' . $data_user['uid'],
                            ], [
                                'id' => $data_user['id'],
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
                                'slug' => $data_user['name'] . '-' . $data_user['uid'],
                                'password' => '12345678',
                                'deleted_at' => isset($data_user['deleted_at']) ? $data_user['deleted_at'] == null ? null : \Carbon\Carbon::parse($data_user['deleted_at']) : null
                            ]);
                        }


                        $output->writeln('info: insert data user teacher ' . $create_user);
                        if ($key > 0 && $key % 10 == 0) {
                            sleep(5);
                            $output->writeln('info:  jeda 5 detik user teacher ');
                        }
                    }
                }
            }

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

                        $create_user_student_class = StudentClass::withoutGlobalScopes()->updateOrCreate([
                            'key' => $data_studentclass['uid'],
                            'slug' => $data_studentclass['uid'] . '-' . $data_studentclass['uid'],
                        ], [
                            'key' => $data_studentclass['uid'],
                            'year' => $data_studentclass['tahun'],
                            'slug' => $data_studentclass['uid'] . '-' . $data_studentclass['uid'],
                            'id_study_class' => $data_studentclass['id_rombel'],
                            'id_student' => $data_studentclass['id_siswa'],
                            'sync_date' => $timestamp,
                            'deleted_at' => isset($data_studentclass['deleted_at']) ? $data_studentclass['deleted_at'] == null ? null : \Carbon\Carbon::parse($data_studentclass['deleted_at']) : null
                        ]);

                        $output->writeln('info: insert data user student class ' . $create_user_student_class);
                        if ($key > 0 && $key % 10 == 0) {
                            sleep(5);
                            $output->writeln('info:  jeda 5 detik student class ');
                        }
                    }
                }
            }


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

                        $create_extra = Extracurricular::withoutGlobalScopes()->updateOrCreate([
                            'key' => $data_ekstra['uid'],
                            'slug' => $data_ekstra['uid'] . '-' . $data_ekstra['uid'],
                        ], [
                            'key' => $data_ekstra['uid'],
                            'name' => $data_ekstra['name'],
                            'status' => $data_ekstra['status'],
                            'slug' => $data_ekstra['uid'] . '-' . $data_ekstra['uid'],
                            'sync_date' => $timestamp,
                            'deleted_at' => isset($data_ekstra['deleted_at']) ? $data_ekstra['deleted_at'] == null ? null : \Carbon\Carbon::parse($data_ekstra['deleted_at']) : null
                        ]);

                        $output->writeln('info: insert data extra ' . $create_extra);
                        if ($key > 0 && $key % 10 == 0) {
                            sleep(5);
                            $output->writeln('info:  jeda 5 detik ekstra ');
                        }
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

                $check_school_gurumapel = SubjectTeacher::whereNull('sync_date')->get()->count();
                if ($check_school_gurumapel == 0) {
                    foreach ($collection_api_gurumapel['data'] as $key => $data_gurumapel) {
                        $create_gurumapel = SubjectTeacher::withoutGlobalScopes()->updateOrCreate([
                            'key' => $data_gurumapel['uid'],
                            'slug' => $data_gurumapel['uid'] . '-' . $data_gurumapel['id_guru'],
                        ], [
                            'key' => $data_gurumapel['uid'],
                            'id_teacher' => $data_gurumapel['id_guru'] == null ? 0 : $data_gurumapel['id_guru'],
                            'id_course' => $data_gurumapel['id_mapel'] == null ? 0 : $data_gurumapel['id_mapel'],
                            'id_school_year' => $data_gurumapel['id_ta_sm'] == null ? 0 : $data_gurumapel['id_ta_sm'],
                            'id_study_class' => collect($data_gurumapel['id_rombel_values']),
                            'status' => 1,
                            'sync_date' => $timestamp,
                            'slug' => $data_gurumapel['uid'] . '-' . $data_gurumapel['id_guru'],
                            'deleted_at' => isset($data_gurumapel['deleted_at']) ? $data_gurumapel['deleted_at'] == null ? null : \Carbon\Carbon::parse($data_gurumapel['deleted_at']) : null
                        ]);
                        $output->writeln('info: insert data guru mapel ' . $create_gurumapel);
                        if ($key > 0 && $key % 10 == 0) {
                            sleep(5);
                            $output->writeln('info:  jeda 5 detik guru mapel ');
                        }
                    }
                }
            }

            /** sync post delete */
            $this->syncdatepost($output, $timestamp);

        } else {
            $output->writeln('error: API URL BUKU INDUK tidak di ketahui ');
        }

        return Command::SUCCESS;
    }

    /** post if sync date null  */
    public function syncdatepost($output, $timestamp)
    {
        $output->writeln('info: prepared post sync data .... ');

        /** post major  */
        $post_major = Major::whereNull('sync_date')->get();
        $output->writeln('info: prepared post sync data collection major.... ' . $post_major);

        if (!empty($post_major)) {
            $url_post_major = env('API_BUKU_INDUK') . '/api/master/majors';
            foreach ($post_major as $key => $major) {
                $form_major = array(
                    'key' => $major->key,
                    'name' => $major->name,
                    'status' => $major->status,
                );
                $response_major = Http::post($url_post_major, $form_major);
                if ($response_major->ok()) {
                    $post_major = Major::where('id', $major->id)->update(['sync_date' => $timestamp]);
                    $output->writeln('info: post sync data  major ' . $key . ' status' . $post_major);
                }

                if ($key > 0 && $key % 10 == 0) {
                    sleep(5);
                }
            }
        }

        /** delete Major */
        $delete_major = Major::onlyTrashed()->get();
        $output->writeln('info: prepared delete sync data collection major.... ' . $delete_major);
        if (!empty($delete_major)) {
            $url_delete_major = env('API_BUKU_INDUK') . '/api/master/majors';
            foreach ($delete_major as $key => $major) {

                $response_major_delete = Http::delete($url_delete_major . '/' . $major->key);
                if ($response_major_delete->ok()) {
                    $output->writeln('info: post sync data   delete major ' . $key . ' status' . $response_major_delete);
                }

                if ($key > 0 && $key % 10 == 0) {
                    sleep(5);
                }
            }
        }

        /** post level  */
        $post_level = Level::whereNull('sync_date')->get();
        $output->writeln('info: prepared post sync data collection level.... ' . $post_level);
        if (!empty($post_level)) {
            $url_post_levels = env('API_BUKU_INDUK') . '/api/master/levels';
            foreach ($post_level as $key => $level) {
                $form_level = array(
                    'key' => $level->key,
                    'name' => $level->name,
                    'status' => $level->status,
                    'fase' => $level->fase,
                );
                $response_levels = Http::post($url_post_levels, $form_level);
                if ($response_levels->ok()) {
                    $post_levels = Level::where('id', $level->id)->update(['sync_date' => $timestamp]);
                    $output->writeln('info: post sync data  level' . $key . ' status ' . $post_levels);
                }

                if ($key > 0 && $key % 10 == 0) {
                    sleep(5);
                }
            }
        }


        /** delete levels */
        $delete_levels = Level::onlyTrashed()->get();
        $output->writeln('info: prepared delete sync data collection levels.... ' . $delete_levels);
        if (!empty($delete_levels)) {

            $url_delete_levels = env('API_BUKU_INDUK') . '/api/master/level';
            foreach ($delete_levels as $key => $level) {

                $response_level_delete = Http::delete($url_delete_levels . '/' . $level->key);
                if ($response_level_delete->ok()) {
                    $output->writeln('info: post sync data   delete major ' . $key . ' status' . $response_level_delete);
                }

                if ($key > 0 && $key % 10 == 0) {
                    sleep(5);
                }
            }

        }

        /** post mapel */
        $post_cource = Course::whereNull('sync_date')->get();
        $output->writeln('info: prepared post sync data collection mapel.... ' . $post_cource);
        if (!empty($post_cource)) {
            $url_post_cources = env('API_BUKU_INDUK') . '/api/master/mapels';
            foreach ($post_cource as $key => $mapel) {
                $form_mapel = array(
                    'key' => $mapel->key,
                    'nama' => $mapel->name,
                    'kode_mapel' => $mapel->code,
                    'status' => $mapel->status,
                    'kelompok' => $mapel->group
                );
                $response_mapel = Http::post($url_post_cources, $form_mapel);
                if ($response_mapel->ok()) {
                    $post_mapel = Course::where('id', $mapel->id)->update(['sync_date' => $timestamp]);
                    $output->writeln('info: post sync data  mapel' . $key . ' status ' . $post_mapel);
                }

                if ($key > 0 && $key % 10 == 0) {
                    sleep(5);
                }
            }
        }

        /** delete mapel */
        $delete_mapel = Level::onlyTrashed()->get();
        $output->writeln('info: prepared delete sync data collection mapel.... ' . $delete_mapel);
        if (!empty($delete_mapel)) {

            $url_delete_mapel = env('API_BUKU_INDUK') . '/api/master/mapels';
            foreach ($delete_mapel as $key => $mapel) {

                $response_mapel_delete = Http::delete($url_delete_mapel . '/' . $mapel->key);
                if ($response_mapel_delete->ok()) {
                    $output->writeln('info: post sync data   delete mapel ' . $key . ' status' . $response_mapel_delete);
                }

                if ($key > 0 && $key % 10 == 0) {
                    sleep(5);
                }
            }

        }

        /** post studi kelas  */
        $post_studi_kelas = StudyClass::whereNull('sync_date')->get();
        $output->writeln('info: prepared post sync data collection studi kelas.... ' . $post_studi_kelas);
        if (!empty($post_studi_kelas)) {
            $url_post_studi_kelas = env('API_BUKU_INDUK') . '/api/master/study_classes';
            foreach ($post_studi_kelas as $key => $studikelas) {
                $form_studi_kelas = array(
                    'key' => $studikelas->key,
                    'name' => $studikelas->name,
                    'major_id' => $studikelas->id_major,
                    'level_id' => $studikelas->id_level,
                    'status' => $studikelas->status,
                );
                $response_studi_kelas = Http::post($url_post_studi_kelas, $form_studi_kelas);
                if ($response_studi_kelas->ok()) {
                    $post_studikelas = StudyClass::where('id', $studikelas->id)->update(['sync_date' => $timestamp]);
                    $output->writeln('info: post sync data  studi kelas' . $key . ' status ' . $post_studikelas);
                }

                if ($key > 0 && $key % 10 == 0) {
                    sleep(5);
                }
            }
        }


        /** delete studi kelas */
        $delete_studi_kelas = StudyClass::onlyTrashed()->get();
        $output->writeln('info: prepared delete sync data collection studi kelas.... ' . $delete_studi_kelas);
        if (!empty($delete_studi_kelas)) {

            $url_delete_studi = env('API_BUKU_INDUK') . '/api/master/study_classes';
            foreach ($delete_studi_kelas as $key => $studi) {

                $response_studi_delete = Http::delete($url_delete_studi . '/' . $studi->key);
                if ($response_studi_delete->ok()) {
                    $output->writeln('info: post sync data   delete studi kelas ' . $key . ' status' . $response_studi_delete);
                }

                if ($key > 0 && $key % 10 == 0) {
                    sleep(5);
                }
            }
        }

        /** student user  */
        $post_user_siswa = User::whereNull('sync_date')->get();
        $output->writeln('info: prepared post sync data collection user siswa .... ' . $post_user_siswa);
        if (!empty($post_user_siswa)) {
            $url_post_user_siswa = env('API_BUKU_INDUK') . '/api/users/students/updateorcreate';
            foreach ($post_user_siswa as $key => $user_siswa) {
                $form_user_siswa = array(
                    'key' => $user_siswa->key,
                    'name' => $user_siswa->name,
                    'status' => $user_siswa->status,
                    'nis' => $user_siswa->nis,
                    'nisn' => $user_siswa->nisn,
                    'gender' => $user_siswa->gender == 'male' ? 'L' : 'P',
                    'religion' => $user_siswa->religion == 'lainnya' ? 'protestan' : $user_siswa->religion,
                    'email' => $user_siswa->email,
                    'birth_day' => $user_siswa->date_of_birth,
                    'birth_place' => $user_siswa->place_of_birth,
                    'phone' => $user_siswa->phone,
                    'address' => $user_siswa->address,
                    'date_accepted' => $user_siswa->accepted_date,
                    'note' => $user_siswa->note,
                    'class_accepted' => $user_siswa->class_accepted
                );

                $response_user_siswa = Http::post($url_post_user_siswa, $form_user_siswa);
                if ($response_user_siswa->ok()) {
                    $post_usersiswa = User::where('id', $user_siswa->id)->update(['sync_date' => $timestamp]);
                    $output->writeln('info: post sync data  user siswa ' . $key . ' status' . $post_usersiswa);
                }

                if ($key > 0 && $key % 10 == 0) {
                    sleep(5);
                }
            }
        }


        /** delete user student  */
        $delete_user_student = User::onlyTrashed()->get();
        $output->writeln('info: prepared delete sync data collection user student.... ' . $delete_user_student);
        if (!empty($delete_user_student)) {

            $url_delete_user_student = env('API_BUKU_INDUK') . '/api/users/students';
            foreach ($delete_user_student as $key => $user) {

                $response_user_delete = Http::delete($url_delete_user_student . '/' . $user->key);
                if ($response_user_delete->ok()) {
                    $output->writeln('info: post sync data   delete user student ' . $key . ' status' . $response_user_delete);
                }

                if ($key > 0 && $key % 10 == 0) {
                    sleep(5);
                }
            }
        }

        $post_user_teacher = Teacher::whereNull('sync_date')->get();
        $output->writeln('info: prepared post sync data collection user teacher .... ' . $post_user_teacher);
        if (!empty($post_user_teacher)) {
            $url_post_user_teacher = env('API_BUKU_INDUK') . '/api/users/teachers/updateorcreate';
            foreach ($post_user_teacher as $key => $user_teacher) {
                $form_user_teacher = array(
                    'key' => $user_teacher->key,
                    'name' => $user_teacher->name,
                    'status' => $user_teacher->status,
                    'nik' => $user_teacher->nik,
                    'nip' => $user_teacher->nip,
                    'nuptk' => $user_teacher->nuptk,
                    'gender' => $user_teacher->gender == 'male' ? 'L' : 'P',
                    'religion' => $user_teacher->religion == 'lainnya' ? 'protestan' : $user_teacher->religion,
                    'email' => $user_teacher->email,
                    'birth_day' => $user_teacher->date_of_birth,
                    'birth_place' => $user_teacher->place_of_birth,
                    'contact' => $user_teacher->phone,
                    'address' => $user_teacher->address,
                );

                $response_user_teacher = Http::post($url_post_user_teacher, $form_user_teacher);
                if ($response_user_teacher->ok()) {
                    $post_userteacher = Teacher::where('id', $user_siswa->id)->update(['sync_date' => $timestamp]);
                    $output->writeln('info: post sync data  user siswa ' . $key . ' status' . $post_userteacher);
                }

                if ($key > 0 && $key % 10 == 0) {
                    sleep(5);
                }
            }
        }

        /** delete user teacher  */
        $delete_user_teacher = Teacher::onlyTrashed()->get();
        $output->writeln('info: prepared delete sync data collection user teacher.... ' . $delete_user_teacher);
        if (!empty($delete_user_teacher)) {

            $url_delete_user_teacher = env('API_BUKU_INDUK') . '/api/users/teachers';
            foreach ($delete_user_student as $key => $user) {

                $response_user_delete = Http::delete($url_delete_user_teacher . '/' . $user->key);
                if ($response_user_delete->ok()) {
                    $output->writeln('info: post sync data   delete user teacher ' . $key . ' status' . $response_user_delete);
                }

                if ($key > 0 && $key % 10 == 0) {
                    sleep(5);
                }
            }
        }

        /** student class  */

        $post_student_class = StudentClass::whereNull('sync_date')->get();
        $output->writeln('info: prepared post sync data collection student kelas.... ' . $post_student_class);
        if (!empty($post_student_class)) {
            $url_post_student_kelas = env('API_BUKU_INDUK') . '/api/master/student_classes';
            foreach ($post_student_class as $key => $studentkelas) {
                $form_student_kelas = array(
                    'uid' => $studentkelas->key,
                    'student_uid' => User::where('id', $studentkelas->id_student)->first()?->key,
                    'study_class_uid' => StudyClass::where('id', $studentkelas->id_study_class)->first()?->key,
                    'year' => $studentkelas->year,
                    'status' => $studentkelas->status
                );
                $response_student_kelas = Http::post($url_post_student_kelas, $form_student_kelas);
                if ($response_student_kelas->ok()) {
                    $post_studkelas = StudentClass::where('id', $studentkelas->id)->update(['sync_date' => $timestamp]);
                    $output->writeln('info: post sync data  student kelas' . $key . ' status ' . $post_studkelas);
                }

                $output->writeln('info: post student class ' . $response_student_kelas);

                if ($key > 0 && $key % 10 == 0) {
                    sleep(5);
                }
            }
        }

        /** delete student class  */
        $delete_user_student_class = StudentClass::onlyTrashed()->get();
        $output->writeln('info: prepared delete sync data collection user student class.... ' . $delete_user_student_class);
        if (!empty($delete_user_student_class)) {

            $url_delete_user_student_class = env('API_BUKU_INDUK') . '/api/master/student_classes';
            foreach ($delete_user_student_class as $key => $user) {

                $response_user_delete = Http::delete($url_delete_user_student_class . '/' . $user->key);
                if ($response_studi_delete->ok()) {
                    $output->writeln('info: post sync data   delete user student class' . $key . ' status' . $response_user_delete);
                }

                if ($key > 0 && $key % 10 == 0) {
                    sleep(5);
                }
            }
        }

        /** post extrakulikuler  */

        $post_extra_class = Extracurricular::whereNull('sync_date')->get();
        $output->writeln('info: prepared post sync data collection extrakulikuler.... ' . $post_extra_class);
        if (!empty($$post_extra_class)) {
            $url_post_extra = env('API_BUKU_INDUK') . '/api/master/extracurriculars';
            foreach ($post_extra_class as $key => $extra) {
                $form_extra = array(
                    'key' => $extra->key,
                    'name' => $extra->name
                );
                $response_ekstra = Http::post($url_post_extra, $form_extra);
                if ($response_ekstra->ok()) {
                    $post_extrasx = Extracurricular::where('id', $extra->id)->update(['sync_date' => $timestamp]);
                    $output->writeln('info: post sync data extra' . $key . ' status ' . $post_extrasx);
                }

                if ($key > 0 && $key % 10 == 0) {
                    sleep(5);
                }
            }
        }


        /** delete extra  */
        $delete_extra = Extracurricular::onlyTrashed()->get();
        $output->writeln('info: prepared delete sync data collection extra .... ' . $delete_extra);
        if (!empty($delete_extra)) {

            $url_delete_extra = env('API_BUKU_INDUK') . '/api/master/extracurriculars';
            foreach ($delete_user_student_class as $key => $extra) {

                $response_extra_delete = Http::delete($url_delete_extra . '/' . $extra->key);
                if ($response_extra_delete->ok()) {
                    $output->writeln('info: post sync data   delete extra class' . $key . ' status' . $response_extra_delete);
                }

                if ($key > 0 && $key % 10 == 0) {
                    sleep(5);
                }
            }
        }

    }
}