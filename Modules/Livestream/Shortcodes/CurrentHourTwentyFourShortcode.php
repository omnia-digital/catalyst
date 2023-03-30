<?php

namespace Modules\Livestream\Shortcodes;

class CurrentHourTwentyFourShortcode implements Shortcode
{
    public function shortcode(): string
    {
        return 'current_hour_24';
    }

    public function replace(): string
    {
        return now()->format('g');
    }
}
