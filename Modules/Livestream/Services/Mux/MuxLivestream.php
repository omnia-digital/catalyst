<?php namespace App\Services\Mux;

use GuzzleHttp\Client;
use MuxPhp\Api\LiveStreamsApi;
use MuxPhp\Configuration;
use MuxPhp\Models\CreateAssetRequest;
use MuxPhp\Models\CreateLiveStreamRequest;
use MuxPhp\Models\CreateSimulcastTargetRequest;
use MuxPhp\Models\LiveStream;
use MuxPhp\Models\PlaybackPolicy;
use MuxPhp\Models\SimulcastTarget;

class MuxLivestream
{
    protected LiveStreamsApi $livestreamApi;

    public function __construct(Client $client, Configuration $configuration)
    {
        $this->livestreamApi = new LiveStreamsApi($client, $configuration);
    }

    /**
     * Create a livestream.
     *
     * @return LiveStream|null
     * @throws \MuxPhp\ApiException
     */
    public function createLivestreamRequest(): ?LiveStream
    {
        $createAssetRequest = new CreateAssetRequest([
            'playback_policy' => [PlaybackPolicy::_PUBLIC],
            'mp4_support'     => 'standard'
        ]);

        $createLivestreamRequest = new CreateLiveStreamRequest([
            'playback_policy'    => PlaybackPolicy::_PUBLIC,
            'new_asset_settings' => $createAssetRequest,
            'reconnect_window'   => 300,
            'max_continuous_duration' => 21600,
            'reduced_latency'    => true,
            'latency_mode'       => 'reduced',
        ]);

        return $this->livestreamApi->createLiveStream($createLivestreamRequest)->getData();
    }

    /**
     * @param $streamId
     * @param $url
     * @param $streamKey
     * @param null $passthrough
     * @return SimulcastTarget|null
     * @throws \MuxPhp\ApiException
     */
    public function createSimulcastTarget($streamId, $url, $streamKey, $passthrough = null): ?SimulcastTarget
    {
        $createTargetRequest = new CreateSimulcastTargetRequest([
            'url'         => $url,
            'stream_key'  => $streamKey,
            'passthrough' => $passthrough,
        ]);

        return $this->livestreamApi->createLiveStreamSimulcastTarget($streamId, $createTargetRequest)->getData();
    }

    /**
     * @param $streamId
     * @param $simulcastTargetId
     * @throws \MuxPhp\ApiException
     */
    public function deleteSimulcastTargets($streamId, $simulcastTargetId): void
    {
        $this->livestreamApi->deleteLiveStreamSimulcastTarget($streamId, $simulcastTargetId);
    }

    /**
     * Send a signal of live stream is completed.
     *
     * @param $streamId
     * @return object|null
     * @throws \MuxPhp\ApiException
     */
    public function finishLivestreamRequest($streamId)
    {
        return $this->livestreamApi
            ->signalLiveStreamComplete($streamId)
            ->getData();
    }

    /**
     * Return the Livestream API instance.
     *
     * @return LiveStreamsApi
     */
    public function instance(): LiveStreamsApi
    {
        return $this->livestreamApi;
    }
}
