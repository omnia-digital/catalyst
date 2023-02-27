<?php namespace App\Shortcodes;

interface Shortcode
{
    public function shortcode(): string;

    public function replace(): string;
}
