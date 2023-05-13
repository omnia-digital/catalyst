<?php

namespace Modules\Livestream\Metrics;

use Carbon\Carbon;
use Modules\Livestream\Actions\Episodes\GetStorageDurationAction;
use Modules\Livestream\Metrics\MetricTypes\Value;

class TotalStorageDuration extends Value
{
    public function calculate(Carbon $from, Carbon $to): int|float
    {
        return (new GetStorageDurationAction)->execute($from, $to, false);
    }
}
