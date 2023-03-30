<?php

namespace Modules\Livestream\Metrics\TimeFilters;

use Carbon\Carbon;
use Modules\Livestream\Omnia;

abstract class TimeFilter
{
    public function name(): string
    {
        return trim(str_replace('Time Filter', '', Omnia::humanize($this)));
    }

    abstract public function from(): Carbon;

    abstract public function to(): Carbon;

    abstract public function previousFrom(): Carbon;

    abstract public function previousTo(): Carbon;

    abstract public function step(): string;
}
