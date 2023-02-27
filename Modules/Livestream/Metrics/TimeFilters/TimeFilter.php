<?php namespace App\Metrics\TimeFilters;

use App\Omnia;
use Carbon\Carbon;

abstract class TimeFilter
{
    public function name(): string
    {
        return trim(str_replace('Time Filter', '', Omnia::humanize($this)));
    }

    public abstract function from(): Carbon;

    public abstract function to(): Carbon;

    public abstract function previousFrom(): Carbon;

    public abstract function previousTo(): Carbon;

    public abstract function step(): string;
}
