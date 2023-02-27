<?php

namespace App\DateIntervals;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class DayOfTheMonthInterval extends Model
{
    
    public function checkDate($start_date)
    {
        $start_date = '4th of june';
        // check if its the right time
        // we need to get the current day of the month,
        // then compare to see if they are the same day of the month
    }
}
