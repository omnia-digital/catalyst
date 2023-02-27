<?php namespace Modules\Livestream\Shortcodes;

class CurrentHourShortcode implements Shortcode
{
    public function shortcode(): string
    {
        return 'current_hour';
    }

    public function replace(): string
    {
        return now()->format('g A');
    }
}
