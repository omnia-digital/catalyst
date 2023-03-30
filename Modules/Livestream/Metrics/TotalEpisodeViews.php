<?php

namespace Modules\Livestream\Metrics;

use Carbon\Carbon;
use Modules\Livestream\Actions\Episodes\GetTotalEpisodeViewsAction;
use Modules\Livestream\Metrics\MetricTypes\Value;

class TotalEpisodeViews extends Value
{
    public function calculate(Carbon $from, Carbon $to): int|float
    {
        return (new GetTotalEpisodeViewsAction)->execute($from, $to, false);
    }
}
