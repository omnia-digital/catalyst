<?php

namespace Modules\Livestream\Support\EpisodeDownload;

use ArrayAccess;
use Illuminate\Support\Arr;
use MuxPhp\Models\Asset as MuxAsset;

class Asset
{
    private $asset;

    /**
     * Asset constructor.
     */
    public function __construct(MuxAsset $asset)
    {
        $this->asset = $asset;
    }

    /**
     * Check if the asset is downloadable.
     *
     * @return bool
     */
    public function isDownloadable()
    {
        return optional($this->asset->getStaticRenditions())->getStatus() === 'ready';
    }

    /**
     * Get download quality file.
     *
     * @return string
     */
    public function downloadQuality()
    {
        $files = collect($this->asset->getStaticRenditions()->getFiles());

        if ($files->where('name', 'high.mp4')->first()) {
            return 'high';
        }

        if ($files->where('name', 'medium.mp4')->first()) {
            return 'medium';
        }

        return 'low';
    }

    /**
     * @return \MuxPhp\Models\PlaybackID[]|null
     */
    public function playbackIds()
    {
        return $this->asset->getPlaybackIds();
    }

    /**
     * @return array|ArrayAccess|mixed
     */
    public function defaultPlaybackId()
    {
        return Arr::get($this->playbackIds(), '0.id');
    }

    /**
     * @return string
     */
    public function downloadLink(string $playbackId = 'default')
    {
        $playbackId = $playbackId === 'default' ? $this->defaultPlaybackId() : $playbackId;

        return config('services.mux.playback_prefix') . $playbackId . '/' . $this->downloadQuality() . '.mp4';
    }
}
