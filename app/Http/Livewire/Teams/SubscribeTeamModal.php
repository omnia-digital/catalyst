<?php

namespace App\Http\Livewire\Teams;

use App\Models\Team;
use App\Models\User;
use Illuminate\Validation\Rule;
use Livewire\Component;
use OmniaDigital\OmniaLibrary\Livewire\WithModal;
use OmniaDigital\OmniaLibrary\Livewire\WithNotification;

/**
 * @property User $billable
 */
class SubscribeTeamModal extends Component
{
    use WithNotification, WithModal;

    public Team $team;

    public ?string $plan = null;

    protected function rules(): array
    {
        return [
            'plan' => ['required', Rule::in(collect($this->teamPlans)->pluck('stripe_id'))]
        ];
    }

    public function getTeamPlansProperty()
    {
        return config('payments.team_member_subscriptionsplans');
    }

    public function subscribeTeam()
    {
        if (!$this->team?->hasStripeConnectAccount()) {
            $this->error('This team is not ready to receive subscriptions yet!');

            return;
        }

        $this->validate();

        $this->billable->createOrGetStripeCustomer();

        if (!$this->billable->hasDefaultPaymentMethod()) {
            $this->error('You do not have a default payment method. Please add one!');

            return;
        }

        if ($this->billable->subscribed('team_' . $this->team->id)) {
            $this->error('You have already subscribed this team!');

            return;
        }

        $this->billable
            ->newSubscription('team_' . $this->team->id, $this->plan)
            ->create(subscriptionOptions: [
                'application_fee_percent' => config('payments.team_member_subscriptionsapplication_fee_percent'),
                'transfer_data' => [
                    'destination' => $this->team->stripe_connect_id,
                ],
            ]);

        $this->success('Subscribed!');
        $this->closeModal('subscribe-team');
    }

    public function getBillableProperty()
    {
        return auth()->user();
    }

    public function render()
    {
        return view('livewire.teams.subscribe-team-modal', [
            'teamPlans' => $this->teamPlans
        ]);
    }
}
