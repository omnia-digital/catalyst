<?php

namespace Modules\Social\Http\Livewire\Pages\Teams\Admin;

use App\Actions\Teams\CreateStripeConnectAccountForTeamAction;
use App\Models\Team;
use App\Support\StripeConnect\StripeConnect;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;

class Subscriptions extends Component
{
    use AuthorizesRequests;

    public Team $team;

    public function mount()
    {
        $this->authorize('manageMembership', $this->team);

        $this->updateOnboardingProcessCompleted();
    }

    public function connectStripe()
    {
        if (!$this->team->hasStripeConnectAccount()) {
            (new CreateStripeConnectAccountForTeamAction)->execute($this->team);

            $this->team->refresh();
        }

        $accountLink = app(StripeConnect::class)->createAccountLink(
            accountStripeId: $this->team->stripe_connect_id,
            returnUrl: route('social.teams.subscriptions', $this->team)
        );

        $this->redirect($accountLink->url);
    }

    public function updateOnboardingProcessCompleted()
    {
        if (!$this->team->hasStripeConnectAccount()) {
            return;
        }

        // Complete, nothing to update
        if ($this->team->stripeConnectOnboardingCompleted()) {
            return;
        }

        $account = app(StripeConnect::class)->getAccount($this->team->stripe_connect_id);

        $this->team->update(['stripe_connect_onboarding_completed' => $account->details_submitted]);
    }

    public function render()
    {
        return view('billing::livewire.pages.teams.subscriptions');
    }
}
