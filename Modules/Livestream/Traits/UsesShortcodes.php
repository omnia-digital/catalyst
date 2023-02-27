<?php namespace App\Traits;

use Illuminate\Support\Facades\Auth;

trait UsesShortcodes
{
    /**
     * Replace Shortcode in a string with the shortcodes value
     *
     * @param $string
     * @param null $team
     * @return mixed
     */
    public static function replaceShortcodesInString(&$string, $team = null)
    {
        if (!str_contains($string, '[')) {
            return $string;
        }

        if (!$team && $user = Auth::user()) {
            $team = $user->currentTeam;
        }

        $time = now($team ? $team->timezone : config('app.timezone'));

        // Find all shortcodes in string
        $matches = [];
        preg_match_all('@\[([^<>&/\[\]\x00-\x20=]++)@', $string, $matches);
        $stringShortcodes = collect($matches[1]);

        $shortcodesToReplace = self::getTimeShortcodesAndValues($time)->filter(function ($value, $key) use ($stringShortcodes) {
            return $stringShortcodes->contains($key);
        });

        if ($shortcodesToReplace->isNotEmpty()) {
            foreach ($shortcodesToReplace as $shortcode => $value) {
                $string = str_replace('[' . $shortcode . ']', $value, $string);
            }
        }

        return $string;
    }

    /**
     * Replace Shortcode in a string with the shortcodes value
     *
     * @param $string
     * @param null $team
     * @return mixed
     */
    public static function replaceShortcodesInStringUsingGivenTimestamp(&$string, $time, $team = null)
    {
        if (!str_contains($string, '[')) {
            return $string;
        }

        if (!$team && $user = Auth::user()) {
            $team = $user->currentTeam;
        }

        // Find all shortcodes in string
        $matches = [];
        preg_match_all('@\[([^<>&/\[\]\x00-\x20=]++)@', $string, $matches);
        $stringShortcodes = collect($matches[1]);

        $shortcodesToReplace = self::getTimeShortcodesAndValues($time)->filter(function ($value, $key) use ($stringShortcodes) {
            return $stringShortcodes->contains($key);
        });

        if ($shortcodesToReplace->isNotEmpty()) {
            foreach ($shortcodesToReplace as $shortcode => $value) {
                $string = str_replace('[' . $shortcode . ']', $value, $string);
            }
        }

        return $string;
    }

    /**
     * Get List of Shortcodes and their values
     *
     * @return \Illuminate\Support\Collection
     */
    public static function getTimeShortcodesAndValues($time = null)
    {
        if (is_null($time)) {
            $time = now();
        }

        return collect([
            'current_hour'         => date('g a', $time->timestamp),
            'current_hour_24'      => date('G', $time->timestamp),
            'current_hour_time'    => date('g:i a', $time->timestamp),
            'current_hour_time_24' => date('G:i', $time->timestamp),
            'day_of_week'          => date('l', $time->timestamp),
            'day_of_month'         => date('d', $time->timestamp),
            'month_full'           => date('F', $time->timestamp),
            'month_short'          => date('M', $time->timestamp),
            'month_number'         => date('m', $time->timestamp),
            'year_full'            => date('Y', $time->timestamp),
            'year_short'           => date('y', $time->timestamp),
            'timezone'             => date('T', $time->timestamp),
        ]);
    }
}
