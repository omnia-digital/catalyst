<?php

namespace Modules\Livestream\Jobs\Videos;

use Illuminate\Support\Facades\Log;
use Modules\Livestream\Episode;
use Modules\Livestream\Events\Video\FinishedMovingLiveTmpVideosToVod;
use Modules\Livestream\Events\Video\LiveVideosProcessing;
use Modules\Livestream\Jobs\LivestreamJob;
use Modules\Livestream\Services\EpisodeService;

/**
 * Class MoveLiveTmpVideosToVod
 * @package App\Jobs\Videos
 */
class MoveLiveTmpTransVideoFilesToVod extends LivestreamJob
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
        $this->_episodeService->moveLiveTransVideosToVod();
        event(new FinishedMovingLiveTmpVideosToVod($this->_episodeService));
        Log::info(__CLASS__ . 'ENDED');
    }
}
