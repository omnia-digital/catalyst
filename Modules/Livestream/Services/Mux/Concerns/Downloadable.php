<?php

namespace Modules\Livestream\Services\Mux\Concerns;

use ArrayAccess;
use Illuminate\Support\Arr;
use Modules\Livestream\Services\Mux\MuxAsset;
use MuxPhp\Models\Asset;
use MuxPhp\Models\PlaybackID;

trait Downloadable
{
    public function downloadLink(Asset $asset, ?string $name = null, string $playbackId = 'default'): ?string
    {
        if (! $this->isDownloadable($asset)) {
            app(MuxAsset::class)->addAssetMP4Support($asset->getId());

            return null;
        }

        $name = is_null($name) ? time() : $name;
        $playbackId = $playbackId === 'default' ? $this->defaultPlaybackId($asset) : $playbackId;

        return config('services.mux.playback_prefix') . $playbackId . '/' . $this->downloadQuality($asset) . config('services.mux.download_suffix') . '?download=' . $name;
    }

    /**
     * Check if the asset is downloadable.
     *
     * @return bool
     */
    public function isDownloadable(Asset $asset)
    {
        return $asset->getStaticRenditions()?->getStatus() === 'ready';
    }

    /**
     * @return array|ArrayAccess|mixed
     */
    public function defaultPlaybackId(Asset $asset)
    {
        return Arr::get($this->playbackIds($asset), '0.id');
    }

    /**
     * @return PlaybackID[]|null
     */
    public function playbackIds(Asset $asset)
    {
        return $asset->getPlaybackIds();
    }

    /**
     * Get download quality file.
     *
     * @return string
     */
    public function downloadQuality(Asset $asset)
    {
        $files = collect($asset->getStaticRenditions()->getFiles());

        if ($files->where('name', 'high.mp4')->first()) {
            return 'high';
        }

        if ($files->where('name', 'medium.mp4')->first()) {
            return 'medium';
        }

        return 'low';
    }
}
