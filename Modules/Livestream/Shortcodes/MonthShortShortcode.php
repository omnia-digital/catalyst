<?php

namespace Modules\Livestream\Shortcodes;

class MonthShortShortcode implements Shortcode
{
    public function shortcode(): string
    {
        return 'month_short';
    }

    public function replace(): string
    {
        return now()->shortMonthName;
    }
}
