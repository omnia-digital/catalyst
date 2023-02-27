<?php namespace App\Metrics;

use App\Actions\Episodes\GetEpisodeWithMostAttachmentDownloadsAction;
use App\Metrics\MetricTypes\ObjectModel;
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
