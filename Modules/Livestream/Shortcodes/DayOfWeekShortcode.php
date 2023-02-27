<?php namespace App\Shortcodes;

class DayOfWeekShortcode implements Shortcode
{
    public function shortcode(): string
    {
        return 'day_of_week';
    }

    public function replace(): string
    {
        return now()->dayName;
    }
}
