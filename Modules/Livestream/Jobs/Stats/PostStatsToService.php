<?php

namespace Modules\Livestream\Jobs\Stats;

use Modules\Livestream\Jobs\Job;
use Modules\Livestream\Services\StatService;
use Illuminate\Support\Facades\Log;

class PostStatsToService extends Job
{
    protected $_statService;

	/**
	 * Create a new job instance.
	 *
	 * @param StatService $statService
	 *
	 */
    public function __construct(StatService $statService)
    {
        $this->_statService = $statService;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Log::info(__CLASS__ . 'STARTED');
	    $this->_statService->postStandardStats();
        Log::info(__CLASS__ . 'ENDED');
    }
}