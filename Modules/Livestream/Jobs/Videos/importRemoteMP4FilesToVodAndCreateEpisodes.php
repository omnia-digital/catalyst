<?php

namespace Modules\Livestream\Jobs\Videos;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Modules\Livestream\Episode;
use Modules\Livestream\Jobs\LivestreamJob;
use Modules\Livestream\Services\EpisodeService;

/**
 * Class importRemoteMP4FilesToVodAndCreateEpisodes
 */
class importRemoteMP4FilesToVodAndCreateEpisodes extends LivestreamJob
{
    protected $_episode;
    protected $_videoUrls;
    protected $_vodStorageName;

    /**
     * Create a new job instance.
     *
     * @param  null|string  $vodStorageName
     */
    public function __construct(Episode $episode, Collection $videoUrls, $vodStorageName = null)
    {
        $this->_episode = $episode;
        $this->_videoUrls = $videoUrls;
        if (empty($vodStorageName)) {
            $this->_vodStorageName = config('livestream.default_vod_disk');
        } else {
            $this->_vodStorageName = $vodStorageName;
        }
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Log::info(__CLASS__ . 'STARTED');
        $episodeService = new EpisodeService($this->_episode->livestream_account_id, null, $this->_vodStorageName);
        $episodeService->episode = $this->_episode;
        $episodeService->importRemoteMP4FilesToVodAndCreateEpisodes($this->_videoUrls);
        Log::info(__CLASS__ . 'ENDED');
    }
}
