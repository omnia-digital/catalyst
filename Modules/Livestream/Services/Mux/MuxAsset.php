<?php namespace Modules\Livestream\Services\Mux;

use GuzzleHttp\Client;
use MuxPhp\Api\AssetsApi;
use MuxPhp\ApiException;
use MuxPhp\Configuration;
use MuxPhp\Models\Asset;
use MuxPhp\Models\AssetResponse;
use MuxPhp\Models\CreateAssetRequest;
use MuxPhp\Models\PlaybackPolicy;
use MuxPhp\Models\UpdateAssetMP4SupportRequest;

class MuxAsset
{
    protected AssetsApi $assetsApi;

    public function __construct(Client $client, Configuration $configuration)
    {
        $this->assetsApi = new AssetsApi($client, $configuration);
    }

    /**
     * @param string $muxAssetId
     * @return AssetResponse
     * @throws \MuxPhp\ApiException
     */
    public function getAsset(string $muxAssetId): AssetResponse
    {
        return $this->assetsApi->getAsset($muxAssetId);
    }

    /**
     * @param string $muxAssetId
     * @return void
     * @throws \MuxPhp\ApiException
     */
    public function deleteAsset(string $muxAssetId): void
    {
        try {
            $this->assetsApi->deleteAsset($muxAssetId);
        } catch (ApiException $e) {
            if ($e->getCode() != 404) {
                throw $e;
            }
        }
    }

    /**
     * Get Mux Asset Api instance.
     *
     * @return AssetsApi
     */
    public function getInstance(): AssetsApi
    {
        return $this->assetsApi;
    }

    /**
     *  Update Mp4 support on an asset.
     *
     * @param string $assetId
     * @param string $supportType
     * @return Asset|null
     * @throws \MuxPhp\ApiException
     */
    public function addAssetMP4Support(string $assetId, string $supportType = 'standard')
    {
        $asset = $this->assetsApi->getAsset($assetId)->getData();
        $mp4Support = $asset->getMp4Support();

        if (!empty($mp4Support) && $mp4Support === 'standard') {
            return null;
        }

        try {
            $updateAssetMp4SupportRequest = new UpdateAssetMP4SupportRequest(['mp4_support' => $supportType]);
            $assetResponse = $this->assetsApi->updateAssetMp4Support($assetId, $updateAssetMp4SupportRequest);
        } catch (\Exception $e) {
            report($e);

            return;
        }

        return $assetResponse->getData();
    }

    public function createFromUrl(string $url, array $options = []): Asset
    {
        $options = array_merge(['mp4_support' => 'standard'], $options);

        $createAssetRequest = new CreateAssetRequest(array_merge($options, [
            'input'           => $url,
            'playback_policy' => [PlaybackPolicy::_PUBLIC],
        ]));

        return $this->getInstance()->createAsset($createAssetRequest)->getData();
    }

    public function __call(string $name, array $arguments)
    {
        return $this->getInstance()->{$name}(...$arguments);
    }
}
