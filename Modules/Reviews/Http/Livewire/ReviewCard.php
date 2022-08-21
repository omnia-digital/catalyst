<?php

namespace Modules\Reviews\Http\Livewire;

use Livewire\Component;
use Modules\Reviews\Models\Review;

class ReviewCard extends Component
{


    /**
     * @var string[]
     *
     * @psalm-var array{reviewUpdated: '$refresh'}
     */
    protected $listeners = ['reviewUpdated' => '$refresh'];
}
