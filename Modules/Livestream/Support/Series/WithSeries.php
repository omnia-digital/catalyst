<?php

namespace App\Support\Series;

/**
 * This need to be used with WithLivestreamAccount trait.
 */
trait WithSeries
{
    public function getSeriesProperty()
    {
        return $this->livestreamAccount
            ->series()
            ->latest()
            ->pluck('name', 'id')
            ->all();
    }
}
