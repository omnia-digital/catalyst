<?php

namespace App\Http\Livewire;

use App\Models\Team;
use Livewire\Component;
use App\Models\User;

class AwardStack extends Component
{


    /**
     * @var string[]
     *
     * @psalm-var array{'modal-closed': 'resetAwardsSelection'}
     */
    protected $listeners = [
        'modal-closed' => 'resetAwardsSelection'
    ];
}
