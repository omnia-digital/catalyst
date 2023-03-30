<?php

namespace Modules\Livestream\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class Job implements ShouldQueue
{
    //Symfony\Component\Debug\Exception\FatalErrorException: Illuminate\Queue\Jobs\Job and Illuminate\Bus\Queueable define the same property ($queue) in the composition of App\Jobs\Job. However, the definition differs and is considered incompatible. Class was composed in /home/forge/omniahub.org.deploy.2016-07-19/app/Jobs/Job.php:11
    /*
    |--------------------------------------------------------------------------
    | Queueable Jobs
    |--------------------------------------------------------------------------
    |
    | This job base class provides a central location to place any logic that
    | is shared across all of your jobs. The trait included with the class
    | provides access to the "onQueue" and "delay" queue helper methods.
    |
    */

    use InteractsWithQueue, Queueable;
//        SerializesModels;

    /**
     * Fire the job.
     *
     * @return void
     */
    public function fire()
    {
        return $this->job->fire();
    }

    /**
     * Get the raw body string for the job.
     *
     * @return string
     */
    public function getRawBody()
    {
        return $this->job->getRawBody();
    }

    /**
     * Get the name of the queue the job belongs to.
     *
     * @return string
     */
    public function getQueue()
    {
    }
}
