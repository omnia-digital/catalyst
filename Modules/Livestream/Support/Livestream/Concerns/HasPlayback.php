<?php namespace App\Support\Livestream\Concerns;

use App\Models\PlaybackId;

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
