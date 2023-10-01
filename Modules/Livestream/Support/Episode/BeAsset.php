<?php

namespace Modules\Livestream\Support\Episode;

use Modules\Livestream\Services\MuxService;
use Modules\Livestream\Support\EpisodeDownload\Asset;
use MuxPhp\ApiException;

trait BeAsset
{
    /**
     * @return Asset|null
     *
     * @throws ApiException
     */
    public function asMuxAsset()
    {
        $mux = (new MuxService)->getAssetApi();

        if (! $this->mux_asset_id) {
            return null;
        }

        $asset = $mux->getAsset($this->mux_asset_id);

        return $asset ? new Asset($asset->getData()) : null;
    }
}
