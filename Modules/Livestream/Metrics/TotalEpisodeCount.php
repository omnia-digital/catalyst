<?php namespace Modules\Livestream\Metrics;

use Modules\Livestream\Actions\Episodes\GetTotalNumberOfEpisodesAction;
use Modules\Livestream\Metrics\MetricTypes\Value;
use Carbon\Carbon;

class TotalEpisodeCount extends Value
{
    /**
     * @param Carbon $from
     * @param Carbon $to
     * @return int|float
     */
    public function calculate(Carbon $from, Carbon $to): int|float
    {
        return (new GetTotalNumberOfEpisodesAction)->execute($from, $to, false);
    }
}
