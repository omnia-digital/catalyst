<?php

namespace Modules\Livestream\Traits;

trait UsesTimezones
{
    /**
     * Get the Team Timezone, or default to the Omnia Default Timezone
     *
     *
     * @return array
     */
    public static function getTimezone($timezone = null, $team = null)
    {
        if (! empty($timezone)) {
            return $timezone;
        } else {
            return ! empty($team) ? $team->timezone : config('app.timezone');
        }
    }
}