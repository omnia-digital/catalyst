<?php

namespace App\Listeners\Video;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Episode;
use App\Events\Stream\StreamStarted;
use App\Events\Stream\StreamEnded;

/**
 * Class UpdateVideosProcessingStatus
 * @package App\Listeners\Episode
 */
class UpdateVideosProcessingStatus
{

    /**
     * Handle the event.
     * @param $event
     */
    public function handle($event)
    {
        // @TODO [Josh] - update the "Processing status" on the video/episode so the user can see that the video is processing (maybe even have a percentage)
    }
}
