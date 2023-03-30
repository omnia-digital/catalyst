<?php

namespace Modules\Livestream\Metrics;

use Carbon\Carbon;
use Modules\Livestream\Actions\Episodes\GetTotalNumberOfEpisodesAction;
use Modules\Livestream\Metrics\MetricTypes\Value;

class TotalEpisodeCount extends Value
{
    public function calculate(Carbon $from, Carbon $to): int|float
    {
        return (new GetTotalNumberOfEpisodesAction)->execute($from, $to, false);
    }
}
