<?php

namespace Modules\Reviews\Http\Livewire;

use Livewire\Component;
use Modules\Reviews\Models\Review;

class ReviewCard extends Component
{
    public $review;

    protected $listeners = ['reviewUpdated' => '$refresh'];

    public function mount(Review $review): void
    {
        $this->review = $review;
    }

    public function render(): \Illuminate\View\View
    {
        return view('reviews::livewire.review-card');
    }
}
