<?php

namespace App\Jobs\Videos;

use Illuminate\Support\Facades\Log;
use App\Episode;
use App\Events\Video\FinishedMovingLiveTmpVideosToVod;
use App\Events\Video\LiveVideosProcessing;
use App\Jobs\LivestreamJob;
use App\Services\EpisodeService;
use Livestream\Livestream;

/**
 * Class MoveLiveTmpVideosToVod
 * @package App\Jobs\Videos
 */
class MoveLiveTmpVideoFilesToVod extends LivestreamJob
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
        $this->_episodeService->moveTmpVideoFilesToVod();
        Log::info(__CLASS__ . 'ENDED');
    }

    public function tags()
    {
        return ['livestreamAccount: '. Livestream::getLivestreamAccount()];
    }
}
