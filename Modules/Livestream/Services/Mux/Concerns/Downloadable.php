<?php namespace App\Services\Mux\Concerns;

use App\Services\Mux\MuxAsset;
use Illuminate\Support\Arr;
use MuxPhp\Models\Asset;

trait Downloadable
{
    /**
     * Check if the asset is downloadable.
     *
     * @param Asset $asset
     * @return bool
     */
    public function isDownloadable(Asset $asset)
    {
        return $asset->getStaticRenditions()?->getStatus() === 'ready';
    }

    /**
     * Get download quality file.
     *
     * @param Asset $asset
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

    /**
     * @param Asset $asset
     * @return \MuxPhp\Models\PlaybackID[]|null
     */
    public function playbackIds(Asset $asset)
    {
        return $asset->getPlaybackIds();
    }

    /**
     * @param Asset $asset
     * @return array|\ArrayAccess|mixed
     */
    public function defaultPlaybackId(Asset $asset)
    {
        return Arr::get($this->playbackIds($asset), '0.id');
    }

    /**
     * @param Asset $asset
     * @param string|null $name
     * @param string $playbackId
     * @return string|null
     */
    public function downloadLink(Asset $asset, ?string $name = null, string $playbackId = 'default'): ?string
    {
        if (!$this->isDownloadable($asset)) {
            app(MuxAsset::class)->addAssetMP4Support($asset->getId());

            return null;
        }

        $name = is_null($name) ? time() : $name;
        $playbackId = $playbackId === 'default' ? $this->defaultPlaybackId($asset) : $playbackId;

        return config('services.mux.playback_prefix') . $playbackId . '/' . $this->downloadQuality($asset) . config('services.mux.download_suffix') .'?download=' . $name;
    }
}
