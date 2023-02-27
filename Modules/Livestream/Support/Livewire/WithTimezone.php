<?php namespace App\Support\Livewire;

trait WithTimezone
{
    public function getTimezonesProperty()
    {
        foreach (timezone_identifiers_list() as $timezone) {
            $timezones[$timezone] = $timezone;
        }

        return $timezones ?? [];
    }
}
