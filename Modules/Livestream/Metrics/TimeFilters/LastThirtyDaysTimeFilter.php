<?php

namespace Modules\Livestream\Metrics\TimeFilters;

use Carbon\Carbon;

class LastThirtyDaysTimeFilter extends TimeFilter
{
    public function name(): string
    {
        return 'Last 30 Days';
    }

    public function from(): Carbon
    {
        return now()->subDays(30)->startOfDay();
    }

    public function to(): Carbon
    {
        return now()->endOfDay();
    }

    public function previousFrom(): Carbon
    {
        return $this->from()->subDays(30)->startOfDay();
    }

    public function previousTo(): Carbon
    {
        return $this->to()->subDays(30)->endOfDay();
    }

    public function step(): string
    {
        return '1 day';
    }
}
