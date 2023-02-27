<?php namespace App\Observers;

use App\Jobs\Billing\CreateExtraInvoiceItemJob;
use App\Models\Episode;
use Illuminate\Support\Facades\Auth;

class EpisodeObserver
{
    /**
     * Handle the episode "creating" event.
     *
     * @param Episode $episode
     */
    public function creating(Episode $episode)
    {
        $plan = $episode->livestreamAccount->team->sparkPlan();

        \Log::info('Creating Episode for team: ' . $episode->livestreamAccount->team->id);
        \Log::info('Plan: ', [$plan]);
        $episode->expires_at = $plan ? now()->addDays($plan->options['episode_expiration']) : $episode->livestreamAccount->team->trial_ends_at->addDay();
    }

    /**
     * Handle the episode "deleting" event.
     *
     * @param Episode $episode
     */
    public function deleting(Episode $episode)
    {
        dispatch(new CreateExtraInvoiceItemJob($episode->livestreamAccount->team, $episode->id));
    }
}
