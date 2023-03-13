<?php

namespace Modules\Jobs\Listeners;

use Modules\Jobs\Events\JobWasCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Thujohn\Twitter\Facades\Twitter;

class TweetJob implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Handle the event.
     *
     * @param JobWasCreated $event
     * @return void
     */
    public function handle(JobWasCreated $event)
    {
        $status = $event->job->company->name . ' is hiring ' . $event->job->title . ' in ' . $event->job->location . "\n";
        $status .= route('jobs.show', ['team' => $event->job->company, 'job'  => $event->job]) . "\n";
        $status .= implode(' ', $event->job->tags->pluck('name')->map(fn($tag) => '#' . $tag)->all());

        Twitter::postTweet(['status' => $status]);
    }
}
