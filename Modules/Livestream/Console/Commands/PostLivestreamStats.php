<?php

namespace Modules\Livestream\Console\Commands;

use Exception;
use Illuminate\Console\Command;
use Modules\Livestream\Services\StreamStatService;

class PostLivestreamStats extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'post-livestream-stats';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Post Livestream Stats to Analytics';

    /**
     * Execute the console command.
     *
     * @return mixed
     *
     * @throws Exception
     */
    public function handle()
    {
        try {
            $statService = new StreamStatService;
            $statService->postStandardStats();
            //		    dispatch( new PostStatsToService( $statService ) );
        } catch (Exception $e) {
            throw new Exception('Couldn\'t Post Livestream Stats: ' . $e->getMessage(), $e->getCode(), $e);
        }
        echo "Posted without Errors. :) \n";
    }
}
