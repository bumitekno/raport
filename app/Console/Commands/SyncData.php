<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Symfony\Component\Console\Output\ConsoleOutput;
use DateTime;
use App\Models\Level;
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


        } else {
            $output->writeln('error: API URL BUKU INDUK tidak di ketahui ');
        }

        return Command::SUCCESS;
    }
}