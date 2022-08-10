<?php

namespace Modules\Reviews\Http\Livewire;

use Livewire\Component;
use Modules\Reviews\Models\Review;

class ReviewCard extends Component
{
    public $review;

    public function mount(Review $review)
    {
        $this->review = $review;
    }

    public function render()
    {
        return view('reviews::livewire.review-card');
    }
}
