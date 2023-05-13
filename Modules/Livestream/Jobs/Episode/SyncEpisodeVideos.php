<?php

namespace Modules\Livestream\Jobs\Episode;

use Illuminate\Support\Facades\Log;
use Modules\Livestream\Episode;
use Modules\Livestream\Events\Episode\EpisodeVideosFinishedSyncing;
use Modules\Livestream\Events\Episode\EpisodeVideosStartedSyncing;
use Modules\Livestream\Jobs\LivestreamJob;

/**
 * Class SyncEpisodeVideos
 */
class SyncEpisodeVideos extends LivestreamJob
{
    protected $_episode;

    /**
     * Create a new job instance.
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
