<?php

namespace Modules\Social\Http\Livewire;

use App\Models\ContactCategory;
use Illuminate\Support\Arr;
use Livewire\Component;
use Squire\Models\Country;

class Map extends Component
{


    /**
     * @var string[]
     *
     * @psalm-var array{0: 'country'}
     */
    public array $filters = [
        'country'
    ];
}
