<?php namespace App\Metrics\TimeFilters;

use Carbon\Carbon;

class ThisMonthTimeFilter extends TimeFilter
{
    public function from(): Carbon
    {
        return now()->startOfMonth()->startOfDay();
    }

    public function to(): Carbon
    {
        return now()->endOfMonth()->endOfDay();
    }

    public function previousFrom(): Carbon
    {
        return $this->from()->subMonth()->startOfMonth()->startOfDay();
    }

    public function previousTo(): Carbon
    {
        return $this->to()->subMonth()->endOfMonth()->endOfDay();
    }

    public function step(): string
    {
        return '1 day';
    }
}
