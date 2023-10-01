<?php

namespace Modules\Livestream\Metrics\TimeFilters;

use Carbon\Carbon;

class LastMonthTimeFilter extends TimeFilter
{
    public function previousFrom(): Carbon
    {
        return $this->from()->subMonth()->startOfMonth()->startOfDay();
    }

    public function from(): Carbon
    {
        return now()->subMonth()->startOfMonth()->startOfDay();
    }

    public function previousTo(): Carbon
    {
        return $this->to()->subMonth()->endOfMonth()->endOfDay();
    }

    public function to(): Carbon
    {
        return now()->subMonth()->endOfMonth()->endOfDay();
    }

    public function step(): string
    {
        return '1 day';
    }
}
