<?php

namespace Modules\Social\Http\Livewire\Pages\Teams;

use App\Models\Team;
use App\Traits\Team\WithTeamManagement;
use Livewire\Component;

class Members extends Component
{
    use WithTeamManagement;

    /**
     * @var Team|null
     */
    public $team;

    /**
     * @var string[]
     *
     * @psalm-var array{member_added: '$refresh'}
     */
    protected array $listeners = [
        'member_added' => '$refresh',
    ];
}
