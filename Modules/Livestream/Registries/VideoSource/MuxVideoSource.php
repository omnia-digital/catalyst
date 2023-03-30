<?php

namespace Modules\Livestream\Registries\VideoSource;

use Modules\Livestream\Models\Video;
use Modules\Livestream\Registries\VideoSource\Concerns\BaseVideoSource;
use Modules\Livestream\Services\Mux\Concerns\Downloadable;
use Modules\Livestream\Services\Mux\MuxAsset;

class MuxVideoSource implements BaseVideoSource
{
    use Downloadable;

    public function name(): string
    {
        return 'Omnia';
    }

    public function asSourceVideo()
    {
        // TODO: Implement asSourceVideo() method.
    }

    public function playbackUrl(Video $video): ?string
    {
        $defaultPlaybackId = $video->getDefaultPlaybackId()?->playback_id;

        return $defaultPlaybackId ? config('services.mux.playback_prefix') . $defaultPlaybackId . config('services.mux.playback_suffix') : null;
    }

    public function downloadUrl(Video $video): ?string
    {
        $asset = app(MuxAsset::class)->getAsset($video->video_source_id);

        return $this->downloadLink($asset->getData(), $video->episode->title . '-' . date('Y-m-d'));
    }

    public function delete(Video $video): void
    {
        app(MuxAsset::class)->deleteAsset($video->video_source_id);
    }

    public function isProcessing(Video $video): bool
    {
        return empty($video->video_source_id);
    }
}
