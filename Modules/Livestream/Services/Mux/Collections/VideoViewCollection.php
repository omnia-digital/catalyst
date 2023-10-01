<?php

namespace Modules\Livestream\Services\Mux\Collections;

use Illuminate\Support\Collection;
use Modules\Livestream\Services\Mux\DataTransferObjects\VideoView;
use MuxPhp\Models\AbridgedVideoView;

class VideoViewCollection extends Collection
{
    public function __construct(array $items = [])
    {
        $this->items = array_map(fn (AbridgedVideoView $item) => new VideoView(
            os: $item['viewer_os_family'],
            browser: $item['viewer_application_name'],
            countryCode: $item['country_code'],
            videoTitle: $item['video_title'],
            viewStart: $item['view_start'],
            viewEnd: $item['view_end']
        ), $items);
    }
}
