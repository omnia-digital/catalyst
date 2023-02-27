<?php
namespace App\Traits;

trait UsesTimezones
{
	/**
	 * Get the Team Timezone, or default to the Omnia Default Timezone
	 *
	 * @param $team
	 *
	 * @return array
	 */
	public static function getTimezone($timezone = null, $team = null)
	{
	    if (!empty($timezone)) {
	        return $timezone;
        } else {
		    return (!empty($team) ? $team->timezone : config('app.timezone'));
        }
	}

}