<?php

namespace App\Livewire\Teams;

use App\Models\Team;
use App\Models\User;
use App\Support\Platform\Platform;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Modules\Billing\Events\TeamMemberSubscriptionCreatedEvent;
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

    public function getTeamPlansProperty()
    {
        return config('billing.team_member_subscriptions.plans');
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

        $subscription = $this->billable
            ->newSubscription('team_' . $this->team->id, $this->plan)
            ->teamId($this->team->id)
            ->create(subscriptionOptions: [
                'application_fee_percent' => Platform::getAppFee(),
                'transfer_data' => [
                    'destination' => $this->team->stripe_connect_id,
                ],
            ]);

        event(new TeamMemberSubscriptionCreatedEvent($subscription, $this->billable, $this->team));

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
            'teamPlans' => $this->teamPlans,
        ]);
    }

    protected function rules(): array
    {
        return [
            'plan' => ['required', Rule::in(collect($this->teamPlans)->pluck('stripe_id'))],
        ];
    }
}
