<?php

namespace Modules\Livestream\Support\Livestream\Concerns;

use Modules\Livestream\Models\PlaybackId;

trait HasPlayback
{
    public function playbackIds()
    {
        return $this->morphMany(PlaybackId::class, 'playbackable');
    }

    public function getDefaultPlaybackId(): ?PlaybackId
    {
        return $this->playbackIds->first();
    }
}
