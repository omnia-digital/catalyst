<?php

namespace Modules\Livestream\Actions\Jetstream;

use Laravel\Jetstream\Contracts\DeletesTeams;
use Modules\Livestream\Support\Livewire\WithNotification;

class DeleteTeam implements DeletesTeams
{
    use WithNotification;

    /**
     * Delete the given team.
     *
     * @param  mixed  $team
     * @return void
     */
    public function delete($team)
    {
        if (
            ($team->subscribed() && ! $team->subscription()->onGracePeriod())
            || $team->hasUnpaidExtraInvoiceItems()
            || $team->livestreamAccount->hasEpisodes()
        ) {
            $this->error('You cannot delete this team unless you cancel the current plan, delete all episodes, and pay off all the open invoices.');

            return;
        }

        $team->purge();
    }
}
