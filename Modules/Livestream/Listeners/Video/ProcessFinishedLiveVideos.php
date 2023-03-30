<?php

namespace Modules\Livestream\Listeners\Video;

use Modules\Livestream\Events\Episode\EpisodeFinishedRecording;
use Modules\Livestream\Events\Video\FinishedMovingLiveTmpVideosToVod;
use Modules\Livestream\Events\Video\KickOffLiveVideoProcess;
use Modules\Livestream\Events\Video\LiveVideosFinishedProcessing;
use Modules\Livestream\Events\Video\LiveVideosProcessingAddedToQueue;

class ProcessFinishedLiveVideos
{
    /**
     * Handle the event.
     * @param $event
     * @throws \Exception
     */
    public function handle($event)
    {
        // This class is only used as an abstraction from the current two steps needed to process the video files. This allows for the process to be changed easily if needed.
        // The reason I needed to separate these two steps into separate even listeners is so I could call them from an event, while also being able to queue them separately.
        if ($event instanceof EpisodeFinishedRecording) {
            event(new KickOffLiveVideoProcess($event->episodeService));
            event(new LiveVideosProcessingAddedToQueue($event->episodeService));

        } else if ($event instanceof FinishedMovingLiveTmpVideosToVod) {
            event(new LiveVideosFinishedProcessing($event->episodeService));
        }

    }
}
