<?php

namespace Modules\Social\Http\Livewire\Pages\Teams;

use App\Models\Location;
use App\Models\Team;
use App\Traits\Team\WithTeamManagement;
use Livewire\Component;
use OmniaDigital\OmniaLibrary\Livewire\WithMap;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Show extends Component
{
    use WithTeamManagement, WithMap;

    public $team;
}
