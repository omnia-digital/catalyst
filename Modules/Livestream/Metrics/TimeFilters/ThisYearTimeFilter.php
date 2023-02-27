<?php namespace App\Metrics\TimeFilters;

use Carbon\Carbon;

class ThisYearTimeFilter extends TimeFilter
{
    public function from(): Carbon
    {
        return now()->startOfYear()->startOfDay();
    }

    public function to(): Carbon
    {
        return now()->endOfYear()->endOfDay();
    }

    public function previousFrom(): Carbon
    {
        return $this->from()->subYear()->startOfYear()->startOfDay();
    }

    public function previousTo(): Carbon
    {
        return $this->to()->subYear()->endOfYear()->endOfDay();
    }

    public function step(): string
    {
        return '1 month';
    }
}
