<?php

namespace Modules\Livestream\Jobs\Videos;

use Illuminate\Support\Facades\Log;
use Modules\Livestream\Jobs\LivestreamJob;
use Modules\Livestream\Services\EpisodeService;

/**
 * Class MoveLiveTmpVideosToVod
 */
class CleanUpTmpVideoFiles extends LivestreamJob
{
    protected $_episodeService;

    /**
     * Create a new job instance.
     */
    public function __construct(EpisodeService $episodeService)
    {
        $this->_episodeService = $episodeService;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Log::info(__CLASS__ . 'STARTED');
        $this->_episodeService->cleanUpTmpVideoFiles();
        Log::info(__CLASS__ . 'ENDED');
    }
}
