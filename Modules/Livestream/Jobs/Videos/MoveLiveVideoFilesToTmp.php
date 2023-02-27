<?php

namespace App\Jobs\Videos;

use Illuminate\Support\Facades\Log;
use App\Events\Video\FinishedMovingLiveVideosToTmp;
use App\Events\Video\LiveVideosProcessing;
use App\Events\Video\LiveVideosStartedProcessing;
use App\Jobs\LivestreamJob;
use App\Services\EpisodeService;

class MoveLiveVideoFilesToTmp extends LivestreamJob
{
    protected $_episodeService;

    /**
     * Create a new job instance.
     *
     * @param EpisodeService $episodeService
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
        event(new LiveVideosStartedProcessing($this->_episodeService));
        $this->_episodeService->moveLiveVideoFilesToTmp();
        event(new FinishedMovingLiveVideosToTmp($this->_episodeService));
        Log::info(__CLASS__ . 'ENDED');
    }
}
