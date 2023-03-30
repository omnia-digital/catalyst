<?php

namespace Modules\Livestream\Shortcodes;

class MonthFullShortcode implements Shortcode
{
    public function shortcode(): string
    {
        return 'month_full';
    }

    public function replace(): string
    {
        return now()->monthName;
    }
}
