<?php

namespace App\Traits\EventMapCalendar;

trait WithEventManagement
{
    /**
     * Returns the column to be used for the event's date
     * 
     * @return array
     */
    public abstract function getDateColumn();

    /**
     * Return a route to show more details on the specific model
     * 
     * @return string
     */
    public abstract function detailsPage();

    public function getEventDate()
    {
        $dateColumn = $this->getDateColumn()['column'];

        return $this->$dateColumn;
    }

    public function getNameAttribute()
    {
        return $this->name ?? $this->title;
    }
}
