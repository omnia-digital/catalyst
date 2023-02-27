<?php

namespace App\Registries\VideoSource;

use App\Models\Video;
use App\Registries\VideoSource\Concerns\BaseVideoSource;

class FromUrlSource implements BaseVideoSource
{
    public function name(): string
    {
        return 'From URL';
    }

    public function asSourceVideo()
    {
        // TODO: Implement asSourceVideo() method.
    }

    public function playbackUrl(Video $video): ?string
    {
        return $video->playback_url;
    }

    public function downloadUrl(Video $video): ?string
    {
        return $video->playback_url;
    }

    public function delete(Video $video): void
    {
        return;
    }

    public function isProcessing(Video $video): bool
    {
        return false;
    }
}
