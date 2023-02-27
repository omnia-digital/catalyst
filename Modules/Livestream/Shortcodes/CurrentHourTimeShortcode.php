<?php namespace App\Shortcodes;

class CurrentHourTimeShortcode implements Shortcode
{
    public function shortcode(): string
    {
        return 'current_hour_time';
    }

    public function replace(): string
    {
        return now()->format('g:i A');
    }
}
