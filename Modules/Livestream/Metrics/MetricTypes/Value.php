<?php namespace App\Metrics\MetricTypes;

use Carbon\Carbon;

abstract class Value extends Metric
{
    /**
     * Calculate the metric.
     *
     * @param Carbon $from
     * @param Carbon $to
     * @return int|float
     */
    public abstract function calculate(Carbon $from, Carbon $to): int|float;
}
