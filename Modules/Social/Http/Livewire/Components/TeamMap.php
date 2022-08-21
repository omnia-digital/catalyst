<?php

namespace Modules\Social\Http\Livewire\Components;

use App\Models\Location;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Livewire\Component;
use OmniaDigital\OmniaLibrary\Livewire\WithMap;

/**
 * @property array $places
 */
class TeamMap extends Component
{
    use WithMap;

    /**
     * @var string[]
     *
     * @psalm-var array{startDateUpdated: 'handleStartDateUpdated'}
     */
    protected $listeners = [
        'startDateUpdated' => 'handleStartDateUpdated'
    ];
}
