<?php

namespace Modules\Livestream\Metrics;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Modules\Livestream\Actions\Episodes\GetEpisodeWithMostAttachmentDownloadsAction;
use Modules\Livestream\Metrics\MetricTypes\ObjectModel;

class EpisodeWithMostAttachmentDownloads extends ObjectModel
{
    /**
     * @return Model
     */
    public function calculate(Carbon $from, Carbon $to): Model|null
    {
        return (new GetEpisodeWithMostAttachmentDownloadsAction)->execute($from, $to, false);
    }
}
