<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

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

        //handle sync api buku induk 
        if (!empty(env('API_BUKU_INDUK'))) {

            /**
             * Api Levels Buku Induk 
             */

            $url_api_levels = env('API_BUKU_INDUK') . '/api/master/levels';

        }

        return Command::SUCCESS;
    }
}