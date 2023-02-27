<?php namespace App\Support\Episode;

use App\Services\MuxService;
use App\Support\EpisodeDownload\Asset;

trait BeAsset
{
    /**
     * @return Asset|null
     * @throws \MuxPhp\ApiException
     */
    public function asMuxAsset()
    {
        $mux = (new MuxService)->getAssetApi();

        if (!$this->mux_asset_id) {
            return null;
        }

        $asset = $mux->getAsset($this->mux_asset_id);

        return $asset ? new Asset($asset->getData()) : null;
    }
}
