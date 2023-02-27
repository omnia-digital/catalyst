<?php

namespace App\Jobs\Episode;

use Illuminate\Support\Facades\Log;
use App\Episode;
use App\Events\Episode\EpisodeVideosFinishedSyncing;
use App\Events\Episode\EpisodeVideosStartedSyncing;
use App\Events\Video\FinishedMovingLiveVideosToTmp;
use App\Events\Video\LiveVideosProcessing;
use App\Events\Video\LiveVideosStartedProcessing;
use App\Jobs\LivestreamJob;
use App\Services\EpisodeService;

/**
 * Class SyncEpisodeVideos
 * @package App\Jobs\Episode
 */
class SyncEpisodeVideos extends LivestreamJob
{
    protected $_episode;

    /**
     * Create a new job instance.
     *
     * @param Episode $episode
     */
    public function __construct(Episode $episode)
    {
        $this->_episode = $episode;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Log::info(__CLASS__ . 'STARTED');
        event(new EpisodeVideosStartedSyncing($this->_episode));
        $this->_episode->syncVideos();
        event(new EpisodeVideosFinishedSyncing($this->_episode));
        Log::info(__CLASS__ . 'ENDED');
    }
}
