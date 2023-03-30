<?php

namespace Modules\Livestream\Metrics\MetricTypes;

use Carbon\Carbon;

abstract class Value extends Metric
{
    /**
     * Calculate the metric.
     */
    abstract public function calculate(Carbon $from, Carbon $to): int|float;
}
