<?php namespace App\Metrics;

use App\Actions\Episodes\GetStorageDurationAction;
use App\Metrics\MetricTypes\Value;
use Carbon\Carbon;

class BillableStorageDuration extends Value
{
    /**
     * @param Carbon $from
     * @param Carbon $to
     * @return int|float
     */
    public function calculate(Carbon $from, Carbon $to): int|float
    {
        return (new GetStorageDurationAction)->execute($from, $to);
    }
}
