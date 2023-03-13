<?php

namespace Modules\Jobs\Listeners;

use Modules\Jobs\Events\JobWasCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Modules\Jobs\Google\Client;

class UpdateGoogleJobsWhenJobCreated implements ShouldQueue
{
    use InteractsWithQueue;

    protected $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Handle the event.
     *
     * @param JobWasCreated $event
     * @return void
     */
    public function handle(JobWasCreated $event)
    {   
        // Get a Guzzle HTTP Client
        $httpClient = $this->client->authorize();
        $endpoint = 'https://indexing.googleapis.com/v3/urlNotifications:publish';
        
        // Define contents here. The structure of the content is described in the next step.
        $content = '{
          "url":' . route("jobs.show", ["team" => $event->job->company, "job" => $event->job]) . ',
          "type": "URL_UPDATED"
        }';
        
        $httpClient->request('post', $endpoint, [ 'body' => $content ]);
    }
}
