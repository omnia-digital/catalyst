<?php

namespace App\Http\Livewire\Teams;

use App\Models\Team;
use App\Models\User;
use Illuminate\Validation\Rule;
use Laravel\Cashier\Subscription;
use Livewire\Component;
use OmniaDigital\OmniaLibrary\Livewire\WithModal;
use OmniaDigital\OmniaLibrary\Livewire\WithNotification;

/**
 * @property User $billable
 * @property Subscription $currentPlan
 */
class UpdateTeamPlanModal extends Component
{
    use WithNotification, WithModal;

    public Team $team;

    public ?string $plan = null;

    public function mount()
    {
        $this->plan = $this->currentPlan?->stripe_price;
    }

    protected function rules(): array
    {
        return [
            'plan' => ['required', Rule::in(collect($this->teamPlans)->pluck('stripe_id'))]
        ];
    }

    public function getTeamPlansProperty()
    {
        return config('billing.team_member_subscriptions.plans');
    }

    public function updatePlan()
    {
        $this->validate();

        if (!$this->billable->hasDefaultPaymentMethod()) {
            $this->error('You do not have a default payment method. Please add one!');

            return;
        }

        // Avoid swapping same plan.
        if ($this->plan === $this->currentPlan->stripe_price) {
            $this->error('Please select a plan!');

            return;
        }

        $this->billable->subscription("team_{$this->team->id}")->swap($this->plan);

        $this->success('Plan is updated!');
        $this->closeModal('update-team-plan');
    }

    public function cancelSubscription()
    {
        $this->billable->subscription("team_{$this->team->id}")->cancel();

        $this->success('Your subscription was cancelled successfully!');
        $this->closeModal('cancel-subscription');
        $this->closeModal('update-team-plan');
    }

    public function resumeSubscription()
    {
        $this->billable->subscription("team_{$this->team->id}")->resume();

        $this->success('Hooray! Your subscription was resumed successfully!');
        $this->closeModal('update-team-plan');
    }

    public function getBillableProperty()
    {
        return auth()->user();
    }

    public function getCurrentPlanProperty()
    {
        return auth()->user()->subscription("team_{$this->team->id}");
    }

    public function render()
    {
        return view('livewire.teams.update-team-plan-modal', [
            'teamPlans' => $this->teamPlans
        ]);
    }
}
