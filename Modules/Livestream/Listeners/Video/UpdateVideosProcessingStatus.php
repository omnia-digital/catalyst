<?php

namespace Modules\Livestream\Listeners\Video;

use Modules\Livestream\Episode;

/**
 * Class UpdateVideosProcessingStatus
 */
class UpdateVideosProcessingStatus
{
    /**
     * Handle the event.
     */
    public function handle($event)
    {
        // @TODO [Josh] - update the "Processing status" on the video/episode so the user can see that the video is processing (maybe even have a percentage)
    }
}
