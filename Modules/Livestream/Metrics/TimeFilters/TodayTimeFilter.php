<?php

namespace Modules\Livestream\Metrics\TimeFilters;

use Carbon\Carbon;

class TodayTimeFilter extends TimeFilter
{
    public function previousFrom(): Carbon
    {
        return $this->from()->subDay()->startOfDay();
    }

    public function from(): Carbon
    {
        return now()->startOfDay();
    }

    public function previousTo(): Carbon
    {
        return $this->to()->subDay()->endOfDay();
    }

    public function to(): Carbon
    {
        return now()->endOfDay();
    }

    public function step(): string
    {
        return '1 hour';
    }
}
