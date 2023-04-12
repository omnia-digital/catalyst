<?php

namespace Modules\Livestream\DateIntervals;

use Illuminate\Database\Eloquent\Model;

class DailyInterval extends Model
{
    public function checkDate($start_date)
    {
        $start_date = '4 weeks ago today';

        // first off we need to check if its the same day of the week, because if not, then this is false.
        // so here we assume its the same day of the week.
        // now get the diff from start date and current date and see how many days/weeks it has been.
        // if the amount of weeks is divisible by 2 then it is correct?
    }
}
