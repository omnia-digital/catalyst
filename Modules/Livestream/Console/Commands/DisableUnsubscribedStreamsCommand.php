<?php namespace App\Console\Commands;

use App\Jobs\Streams\DisableStreamJob;
use App\Models\Stream;
use App\Models\Team;
use Illuminate\Console\Command;

class DisableUnsubscribedStreamsCommand extends Command
{
    protected $signature = 'stream:disable';

    protected $description = 'Disable stream when trial period is expired or billable is not subscribed';

    public function handle()
    {
        Stream::with('livestreamAccount.team')
            ->active()
            ->get()
            ->each(function (Stream $stream) {
                $billable = $stream->livestreamAccount->team;
                if (!$billable->subscribed() && !$billable->onTrial()) {
                    dispatch(new DisableStreamJob($stream));

                    $this->info('Disabling stream ' . $stream->id);
                }
            });
    }
}
