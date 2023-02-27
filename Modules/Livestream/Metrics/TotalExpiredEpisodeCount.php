<?php namespace App\Metrics;

use App\Actions\Episodes\GetTotalNumberOfEpisodesAction;
use App\Metrics\MetricTypes\Value;
use Carbon\Carbon;

class TotalExpiredEpisodeCount extends Value
{
    /**
     * @param Carbon $from
     * @param Carbon $to
     * @return int|float
     */
    public function calculate(Carbon $from, Carbon $to): int|float
    {
        return (new GetTotalNumberOfEpisodesAction)->execute($from, $to, true);
    }
}
