<?php

namespace Modules\Forms\Http\Livewire;

use App\Models\Team;
use App\Models\TeamApplication;
use App\Traits\Team\WithTeamManagement;
use Modules\Forms\Http\Livewire\Form as LivewireForm;
use Modules\Forms\Models\Form;
use Modules\Forms\Models\FormSubmission;

class TeamApplicationForm extends LivewireForm
{
    use WithTeamManagement;

    public Team $team;

    public ?Form $applicationForm;

    public function mount(Form $form, int $team_id = null, $submitText = 'Submit')
    {
        $this->team = Team::find($team_id);

        parent::mount($form, $team_id, $submitText);

        $this->applicationForm = $form;
    }

    public function processFormSubmission($formData)
    {
        $this->applyToTeam();

        $application = TeamApplication::query()
                            ->where('user_id', $this->user->id)
                            ->where('team_id', $this->team_id)
                            ->first();

        $formSubmission = FormSubmission::create([
            'form_id' => $this->formModel->id,
            'user_id' => $this->user->id,
            'team_id' => $this->team_id ?? null,
            'data' => $formData,
        ]);

        $application->update(['form_submission_id' => $formSubmission->id]);
    }

    public function afterSubmission()
    {
        $this->redirectRoute('social.teams.show', $this->team);
    }
}
