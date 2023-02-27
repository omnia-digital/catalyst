<?php namespace App\Metrics\TimeFilters;

use Carbon\Carbon;

class AllTimeFilter extends TimeFilter
{
    public function name(): string
    {
        return 'All Time';
    }

    public function from(): Carbon
    {
        return now()->subYears(5)->startOfYear()->startOfDay();
    }

    public function to(): Carbon
    {
        return now()->endOfDay();
    }

    public function previousFrom(): Carbon
    {
        return $this->from();
    }

    public function previousTo(): Carbon
    {
        return $this->to();
    }

    public function step(): string
    {
        return '1 month';
    }
}
