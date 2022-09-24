<?php

namespace Modules\Social\Http\Livewire\Pages\Teams;

use App\Models\Team;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;
use Modules\Forms\Models\Form;
use OmniaDigital\OmniaLibrary\Livewire\WithPlace;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Forms extends Component
{
    public ?Team $team;

    public $platformForms;
    public $teamForms;

    public function onLoad()
    {
        $this->loadForms();
    }

    public function getUserProperty()
    {
        return Auth::user();
    }

    public function loadForms()
    {
        $platformForms = Form::whereNull('team_id')->get();

        $teamForms = Form::where('team_id', $this->team->id)->get();

        $this->platformForms = $platformForms;
        $this->teamForms = $teamForms;
    }

    public function render()
    {
        return view('social::livewire.pages.teams.forms', [
            'platformForms' => $this->platformForms,
            'teamForms' => $this->teamForms,
        ]);
    }
}
