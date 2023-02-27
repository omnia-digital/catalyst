<?php namespace Modules\Livestream\Metrics;

use Modules\Livestream\Actions\Episodes\GetTotalAttachmentDownloadsAction;
use Modules\Livestream\Metrics\MetricTypes\Value;
use Carbon\Carbon;

class TotalAttachmentDownloads extends Value
{
    /**
     * @param Carbon $from
     * @param Carbon $to
     * @return int|float
     */
    public function calculate(Carbon $from, Carbon $to): int|float
    {
        return (new GetTotalAttachmentDownloadsAction)->execute($from, $to, false);
    }
}
