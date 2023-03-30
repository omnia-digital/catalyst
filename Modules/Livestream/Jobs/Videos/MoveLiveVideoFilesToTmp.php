<?php

namespace Modules\Livestream\Jobs\Videos;

use Illuminate\Support\Facades\Log;
use Modules\Livestream\Events\Video\FinishedMovingLiveVideosToTmp;
use Modules\Livestream\Events\Video\LiveVideosStartedProcessing;
use Modules\Livestream\Jobs\LivestreamJob;
use Modules\Livestream\Services\EpisodeService;

class MoveLiveVideoFilesToTmp extends LivestreamJob
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
        event(new LiveVideosStartedProcessing($this->_episodeService));
        $this->_episodeService->moveLiveVideoFilesToTmp();
        event(new FinishedMovingLiveVideosToTmp($this->_episodeService));
        Log::info(__CLASS__ . 'ENDED');
    }
}
