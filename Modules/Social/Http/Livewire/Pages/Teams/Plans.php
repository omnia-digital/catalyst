<?php

namespace Modules\Social\Http\Livewire\Pages\Teams;

use App\Actions\Teams\CreateTeamPlanAction;
use App\Enums\Teams\TeamBillingPeriod;
use App\Models\Team;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Validation\Rule;
use Livewire\Component;
use OmniaDigital\OmniaLibrary\Livewire\WithNotification;

/** @note We are not using this currently. Save for future when we want teams to create custom plans */
class Plans extends Component
{
    use AuthorizesRequests, WithNotification;

    public Team $team;

    public ?string $name = null;

    public ?string $description = null;

    public float|string|null $price = null;

    public string $billingPeriod;

    protected function rules(): array
    {
        return [
            'name' => ['required', 'max:254'],
            'description' => ['nullable'],
            'price' => ['required', 'numeric'],
            'billingPeriod' => ['required', Rule::in(array_keys(TeamBillingPeriod::options()))],
        ];
    }

    public function mount()
    {
        $this->authorize('manageMembership', $this->team);

        $this->billingPeriod = TeamBillingPeriod::MONTHLY->value;
    }

    public function addNewPlan()
    {
        $this->validate();

        (new CreateTeamPlanAction)
            ->price($this->price, $this->billingPeriod)
            ->execute($this->team, $this->name, $this->description);

        $this->reset('name', 'description', 'price');
        $this->success('Plan is created successfully!');
    }

    public function getRowsProperty()
    {
        return $this->team->teamPlans()
            ->latest()
            ->get();
    }

    public function render()
    {
        return view('social::livewire.pages.teams.plans', [
            'plans' => $this->rows
        ]);
    }
}
