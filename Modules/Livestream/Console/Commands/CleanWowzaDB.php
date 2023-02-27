<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CleanWowzaDB extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'clean-wowza-db';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clean Wowza DB';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
	    DB::connection('wowzadb')->table('accesslog')->where([
	    	['xevent',  '!=',   'unpublish'],
		    ['xevent',  '!=',   'stop']
	    ])->delete();
	    DB::connection('wowzadb')->table('accesslog')->where([
		    ['xsname', 'like', '%trans%']
	    ])->delete();
	    Log::info( 'WowzaDB.accesslog table has been cleaned to save space' );
    }
}
