<?php

namespace Modules\Livestream\Console\Commands;

use Modules\Livestream\Jobs\Stats\PostStatsToService;
use Illuminate\Console\Command;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Modules\Livestream\Services\StreamStatService;

class GetLivestreamAccountStorageSize extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'livestream-get-storage-size {livestream_account_id?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get Livestream Storage size';

	/**
	 * Execute the console command.
	 * @return mixed
	 * @throws \Exception
	 */
    public function handle()
    {
	    try {
	        $livestreamAccountId = $this->argument('livestream_account_id');

	        if (empty($livestreamAccountId)) {
	            $command = 'aws s3 ls --summarize --human-readable --recursive s3://' . env('LIVESTREAM_S3_VOD_BUCKET');
            } else {
	            $command = 'aws s3 ls --summarize --human-readable --recursive s3://' . env('LIVESTREAM_S3_VOD_BUCKET') . '/' . $livestreamAccountId . '/';
            }
	        $this->info('Running aws command: ' . 'aws s3 ls --summarize --human-readable --recursive s3://' . env('LIVESTREAM_S3_VOD_BUCKET') . '/' . $livestreamAccountId . '/');
	        $result = exec($command);
            $result = substr($result, strlen('Total Size:') + 3);
            $result = substr($result, 0, strpos($result, 'GiB') - 1);
            echo $result;
            return $result;

	    } catch(\Exception $e) {
		    throw new \Exception('Couldn\'t Post Livestream Stats: ' . $e->getMessage(), $e->getCode(), $e);
	    }
    }
}