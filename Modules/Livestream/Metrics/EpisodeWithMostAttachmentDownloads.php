<?php namespace Modules\Livestream\Metrics;

use Modules\Livestream\Actions\Episodes\GetEpisodeWithMostAttachmentDownloadsAction;
use Modules\Livestream\Metrics\MetricTypes\ObjectModel;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class EpisodeWithMostAttachmentDownloads extends ObjectModel
{
    /**
     * @param Carbon $from
     * @param Carbon $to
     * @return Model
     */
    public function calculate(Carbon $from, Carbon $to): Model|null
    {
        return (new GetEpisodeWithMostAttachmentDownloadsAction)->execute($from, $to, false);
    }
}