<?php namespace Modules\Livestream\Shortcodes;

class TimezoneShortcode implements Shortcode
{
    public function shortcode(): string
    {
        return 'timezone';
    }

    public function replace(): string
    {
        return now()->timezone;
    }
}
