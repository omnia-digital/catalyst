<?php

namespace Modules\Livestream\Jobs\Episode;

use Illuminate\Support\Facades\Log;
use Modules\Livestream\Episode;
use Modules\Livestream\Events\Episode\EpisodeVideosFinishedSyncing;
use Modules\Livestream\Events\Episode\EpisodeVideosStartedSyncing;
use Modules\Livestream\Events\Video\FinishedMovingLiveVideosToTmp;
use Modules\Livestream\Events\Video\LiveVideosProcessing;
use Modules\Livestream\Events\Video\LiveVideosStartedProcessing;
use Modules\Livestream\Jobs\LivestreamJob;
use Modules\Livestream\Services\EpisodeService;

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
