<?php

namespace Modules\Livestream\Registries\VideoSource\Concerns;

use Modules\Livestream\Models\Video;
use Modules\Livestream\Registries\VideoSource\VideoSourceRegistry;

trait HasSourceVideo
{
    public static function bootHasSourceVideo()
    {
        static::deleted(function ($video) {
            // Delete video source file on 3rd services.
            $video->videoSource()->delete($video);
        });
    }

    /**
     * Get the download url of video source.
     */
    public function getDownloadUrl(): ?string
    {
        /** @var Video $this */
        return $this->videoSource()->downloadUrl($this);
    }

    /**
     * Get playback url.
     *
     * @return ?string
     */
    public function getPlaybackUrl(): ?string
    {
        /** @var Video $this */
        return $this->videoSource()->playbackUrl($this);
    }

    /**
     * Check if the video is processing or ready.
     */
    public function isProcessing(): bool
    {
        /** @var Video $this */
        return $this->videoSource()->isProcessing($this);
    }

    public function videoSource(): BaseVideoSource
    {
        return app(VideoSourceRegistry::class)->get($this->video_source_type_id);
    }
}
