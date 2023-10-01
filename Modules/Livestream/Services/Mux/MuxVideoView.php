<?php

namespace Modules\Livestream\Services\Mux;

use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Support\Collection;
use Modules\Livestream\Models\Episode;
use Modules\Livestream\Models\LivestreamAccount;
use Modules\Livestream\Models\VideoView;
use MuxPhp\Api\VideoViewsApi;
use MuxPhp\Configuration;
use MuxPhp\Models\AbridgedVideoView;

class MuxVideoView
{
    protected VideoViewsApi $videoViewsApi;

    public function __construct(Client $client, Configuration $configuration)
    {
        $this->videoViewsApi = new VideoViewsApi($client, $configuration);
    }

    public function getTotalViews(
        LivestreamAccount|int|null $livestreamAccount = null,
        Episode|string|null $episodeOrMuxAssetId = null,
        ?Carbon $from = null,
        ?Carbon $to = null
    ): int {
        return $this->getViews($livestreamAccount, $episodeOrMuxAssetId, $from, $to)->count();
    }

    public function getViews(
        LivestreamAccount|int|null $livestreamAccount = null,
        Episode|string|null $episodeOrMuxAssetId = null,
        ?Carbon $from = null,
        ?Carbon $to = null
    ): Collection {
        $livestreamAccountId = $livestreamAccount instanceof LivestreamAccount ? $livestreamAccount->id : $livestreamAccount;
        $muxAssetId = $episodeOrMuxAssetId instanceof Episode ? $episodeOrMuxAssetId->video?->video_source_id : $episodeOrMuxAssetId;
        $page = 1;
        $videoViews = [];
        $filters = [];

        if (! is_null($livestreamAccountId)) {
            array_push($filters, 'sub_property_id:' . $livestreamAccountId);
        }

        if (! is_null($muxAssetId)) {
            array_push($filters, 'asset_id:' . $muxAssetId);
        }

        do {
            $result = $this->videoViewsApi->listVideoViews(
                limit: 100,
                page: $page,
                filters: [
                    'filters' => $filters,
                ],
                timeframe: [
                    'timeframe' => [
                        $from ? $from->timestamp : now()->subDays(30)->timestamp,
                        $to ? $to->timestamp : now()->timestamp,
                    ],
                ]
            );

            $videoViews = array_merge($videoViews, $result['data']);
            $page = $page + 1;
        } while (! empty($result['data']));

        return collect(array_map(function (AbridgedVideoView $item) {
            $videoView = new VideoView;

            $videoView->viewer_id = $item['id'];
            $videoView->os = $item['viewer_os_family'];
            $videoView->browser = $item['viewer_application_name'];
            $videoView->country_code = $item['country_code'];
            $videoView->video_title = $item['video_title'];
            $videoView->view_start = $item['view_start'];
            $videoView->view_end = $item['view_end'];

            return $videoView;
        }, $videoViews));
    }
}
