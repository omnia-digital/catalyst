<?php

namespace Modules\Livestream\Shortcodes;

class DayOfMonthShortcode implements Shortcode
{
    public function shortcode(): string
    {
        return 'day_of_month';
    }

    public function replace(): string
    {
        return now()->day;
    }
}
