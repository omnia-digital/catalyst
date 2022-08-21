<?php

namespace Modules\Reviews\Http\Livewire;

use Livewire\Component;
use Modules\Reviews\Models\Review;

class ReviewList extends Component
{


    /**
     * @var string[]
     *
     * @psalm-var array{updateReviews: '$refresh'}
     */
    protected $listeners = ['updateReviews' => '$refresh'];
}
