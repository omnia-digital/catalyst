<?php

namespace Modules\Social\Http\Livewire\Pages\Teams;

use App\Models\Location;
use App\Models\Team;
use Livewire\Component;
use OmniaDigital\OmniaLibrary\Livewire\WithMap;
use OmniaDigital\OmniaLibrary\Livewire\WithNotification;

class Map extends Component
{
    use WithMap, WithNotification;

    /**
     * @var string[]
     *
     * @psalm-var array{select_event: 'handleEventSelected'}
     */
    protected array $listeners = [
        'select_event' => 'handleEventSelected',
    ];
}
