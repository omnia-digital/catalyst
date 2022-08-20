<?php

namespace Modules\Reviews\Http\Livewire;

use Livewire\Component;
use Modules\Reviews\Models\Review;

class ReviewList extends Component
{
    public $model = null;

    public $latestReview = null;

    protected $listeners = ['updateReviews' => '$refresh'];

    public function mount($model): void
    {
        $this->model = $model;
    }

    public function updateReviews(Review $review): void
    {
        $this->latestReview = $review;
    }

    public function getRowsQueryProperty()
    {
        return $this->model->reviews()->latest();
    }

    public function getRowsProperty()
    {
        return $this->rowsQuery->get();
    }

    public function render(): \Illuminate\View\View
    {
        return view('reviews::livewire.review-list', [
            'reviews' => $this->rows
        ]);
    }
}
