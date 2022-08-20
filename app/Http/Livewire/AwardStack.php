<?php

namespace App\Http\Livewire;

use App\Models\Team;
use Livewire\Component;
use App\Models\User;

class AwardStack extends Component
{
    /**
     * @var array
     */
    public array $awardsToAdd = [];

    /**
     * @var User|null
     */
    public $user;

    /**
     * @var \Illuminate\Database\Eloquent\Collection|null
     *
     * @psalm-var \Illuminate\Database\Eloquent\Collection<\App\Models\Award>|null
     */
    public $awards;

    /**
     * @var string[]
     *
     * @psalm-var array{'modal-closed': 'resetAwardsSelection'}
     */
    protected array $listeners = [
        'modal-closed' => 'resetAwardsSelection'
    ];
}
