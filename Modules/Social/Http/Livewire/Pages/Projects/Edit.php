<?php

namespace Modules\Social\Http\Livewire\Pages\Projects;

use App\Models\Team;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Edit extends Component
{
    public $project;

    public ?string $name;

    public ?string $startDate;

    public ?string $summary;
    
    public ?string $targetAudience;
    
    public ?string $content;

    protected function rules(): array
    {
        return [
            'name' => ['required', 'max:254'],
            'startDate' => ['required', 'date'],
            'summary' => ['required', 'max:280'],
            'targetAudience' => ['required', 'max:254'],
            'content' => ['required', 'max:65500'],
        ];
    }

    public function mount(Team $team)
    {
        $this->project = $team->load('owner');
        $this->name = $team->name;
        $this->startDate = $team->start_date;
        $this->summary = $team->summary;
        $this->targetAudience = $team->target_audience;
        $this->content = $team->content;
    }

    public function saveChanges()
    {
        $this->validate();

        /** @var Team $project */
        $this->project->update([
            'name' => $this->name,
            'start_date' => $this->startDate,
            'summary' => $this->summary,
            'target_audience' => $this->targetAudience,
            'content' => $this->content,
        ]);
        
        Auth::user()->switchTeam($this->project);

        $this->emit('changes_saved');
    }

    public function render()
    {
        return view('social::livewire.pages.projects.edit');
    }
}
