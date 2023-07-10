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

        } else {
            $output->writeln('error: API URL BUKU INDUK tidak di ketahui ');
        }

        return Command::SUCCESS;
    }
}