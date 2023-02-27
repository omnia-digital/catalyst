<?php namespace App\Shortcodes;

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
