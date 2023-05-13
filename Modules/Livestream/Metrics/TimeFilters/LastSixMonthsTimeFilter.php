<?php

namespace Modules\Livestream\Metrics\TimeFilters;

use Carbon\Carbon;

class LastSixMonthsTimeFilter extends TimeFilter
{
    public function name(): string
    {
        return 'Last 6 Months';
    }

    public function from(): Carbon
    {
        return now()->subMonths(6)->startOfMonth()->startOfDay();
    }

    public function to(): Carbon
    {
        return now()->endOfDay();
    }

    public function previousFrom(): Carbon
    {
        return $this->from()->subMonths(6)->startOfMonth()->startOfDay();
    }

    public function previousTo(): Carbon
    {
        return $this->to()->subMonths(6)->endOfMonth()->endOfDay();
    }

    public function step(): string
    {
        return '1 month';
    }
}
