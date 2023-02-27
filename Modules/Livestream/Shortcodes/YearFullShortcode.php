<?php namespace App\Shortcodes;

class YearFullShortcode implements Shortcode
{
    public function shortcode(): string
    {
        return 'year_full';
    }

    public function replace(): string
    {
        return now()->year;
    }
}
