<?php

namespace Modules\Livestream\Jobs\Stats;

use Illuminate\Support\Facades\Log;
use Modules\Livestream\Jobs\Job;
use Modules\Livestream\Services\StatService;

class PostStatsToService extends Job
{
    protected $_statService;

    /**
     * Create a new job instance.
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
