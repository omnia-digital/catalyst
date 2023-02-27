<?php

    namespace App\Traits;

    use Illuminate\Support\Carbon;
    use Livestream\Livestream;
    use Omnia;

    /**
     * Trait HasLocalDates
     * Converts all fields in $dates array to local timezone, if it's able to
     *
     * @package App\Traits
     */
    trait HasLocalDates
    {
        /**
         * Override the models toArray to append the formatted dates fields
         *
         * @return array
         */
        public function toArray()
        {
            $data = parent::toArray();

            if ($this->noFormat) {
                return $data;
            }
            $team = $this->team;

            if (empty($team)) {
                $livestreamAccount = $this->livestreamAccount;
                if (empty($livestreamAccount)) {
                    $livestreamAccount = Livestream::getLivestreamAccount();
                }

                if ( ! empty($livestreamAccount)) {
                    $team = $livestreamAccount->team;
                }
            }

            if ( ! empty($team)) {
                $timezone = Omnia::getTimezone(null, $team);

                foreach ($this->getDates() as $dateField) {
                    $date = new Carbon($this->{$dateField});
                    (! empty($timezone) ? $date->setTimezone($timezone) : null);
                    $data[$dateField] = $date->toDateTimeString();
                }
            }


            return $data;
        }
    }