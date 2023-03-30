<?php

namespace Modules\Livestream\Shortcodes;

class MonthNumberShortcode implements Shortcode
{
    public function shortcode(): string
    {
        return 'month_number';
    }

    public function replace(): string
    {
        return now()->month;
    }
}
