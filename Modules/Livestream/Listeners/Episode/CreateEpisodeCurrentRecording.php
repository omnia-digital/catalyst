<?php

namespace Modules\Livestream\Listeners\Episode;

use Modules\Livestream\Events\Stream\EpisodeStartedRecording;

/**
 * Class CreateEpisodeCurrentRecording
 */
class CreateEpisodeCurrentRecording
{
    /**
     * Handle the event.
     *
     * @return bool
     */
    public function handle(EpisodeStartedRecording $event)
    {
        // Save Episode as a current Recording (until we receive an END Notification )
        $episodeCurrentRecording = EpisodeCurrentRecording::create([
            'episode_id' => $event->episode->id,
            'account_id' => $event->LivestreamAccount->id,
            'stream_name' => $event->realStreamName,
        ]);
        Log::info('Episode Recording: ' . $episodeCurrentRecording->id . ' with Stream Name: ' . $episodeCurrentRecording->stream_name);
    }
}
