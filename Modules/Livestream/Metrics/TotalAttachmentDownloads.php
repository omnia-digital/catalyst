<?php namespace App\Metrics;

use App\Actions\Episodes\GetTotalAttachmentDownloadsAction;
use App\Metrics\MetricTypes\Value;
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
