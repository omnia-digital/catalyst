<?php namespace Laravel\Spark\Listeners\Tutorials;

class FirstTimeLoginTutorial
{

    /**
     * Handle the event.
     *
     * @return void
     */
    public function handle($event)
    {
        flash()->overlay('Tutorial', 'Would you like to show you the basics of Omnia?');
    }
}
