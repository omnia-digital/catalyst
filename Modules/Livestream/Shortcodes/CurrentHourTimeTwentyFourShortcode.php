<?php namespace App\Shortcodes;

class CurrentHourTimeTwentyFourShortcode implements Shortcode
{
    public function shortcode(): string
    {
        return 'current_hour_time_24';
    }

    public function replace(): string
    {
        return now()->format('g:i');
    }
}
