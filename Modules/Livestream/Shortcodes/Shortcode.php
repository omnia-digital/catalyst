<?php

namespace Modules\Livestream\Shortcodes;

interface Shortcode
{
    public function shortcode(): string;

    public function replace(): string;
}
