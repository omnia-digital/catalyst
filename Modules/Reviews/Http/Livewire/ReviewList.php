<?php

namespace Modules\Reviews\Http\Livewire;

use Livewire\Component;
use Modules\Reviews\Models\Review;

class ReviewList extends Component
{
    public $model = null;

    /**
     * @var string[]
     *
     * @psalm-var array{updateReviews: '$refresh'}
     */
    protected array $listeners = ['updateReviews' => '$refresh'];
}
