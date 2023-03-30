<?php

namespace Modules\Livestream\Metrics;

use Carbon\Carbon;
use Modules\Livestream\Actions\Episodes\GetStorageDurationAction;
use Modules\Livestream\Metrics\MetricTypes\Value;

class CurrentStorageCost extends Value
{
    public function calculate(Carbon $from, Carbon $to): int|float
    {
        $duration = (new GetStorageDurationAction)->execute($from, $to);

        return round($duration * auth()->user()->currentTeam->meteredPrice('storage'), 2);
    }
}
