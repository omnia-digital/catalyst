<?php

namespace Modules\Livestream\Metrics;

use Carbon\Carbon;
use Modules\Livestream\Actions\Episodes\GetTotalAttachmentDownloadsAction;
use Modules\Livestream\Metrics\MetricTypes\Value;

class TotalAttachmentDownloads extends Value
{
    public function calculate(Carbon $from, Carbon $to): int|float
    {
        return (new GetTotalAttachmentDownloadsAction)->execute($from, $to, false);
    }
}
