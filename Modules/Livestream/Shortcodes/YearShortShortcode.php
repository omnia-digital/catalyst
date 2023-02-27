<?php namespace App\Shortcodes;

class YearShortShortcode implements Shortcode
{
    public function shortcode(): string
    {
        return 'year_short';
    }

    public function replace(): string
    {
        return now()->format('y');
    }
}
