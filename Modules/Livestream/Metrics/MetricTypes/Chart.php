<?php

namespace Modules\Livestream\Metrics\MetricTypes;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Support\Collection;

abstract class Chart extends Metric
{
    /**
     * Calculate the metric.
     */
    abstract public function calculate(Carbon $from, Carbon $to): Collection|EloquentCollection;
}
