<?php

namespace Modules\Livestream\Registries\VideoSource;

use Modules\Livestream\Models\Video;
use Modules\Livestream\Registries\VideoSource\Concerns\BaseVideoSource;

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
    }

    public function isProcessing(Video $video): bool
    {
        return false;
    }
}
