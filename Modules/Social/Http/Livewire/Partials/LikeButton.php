<?php

namespace Modules\Social\Http\Livewire\Partials;

use Livewire\Component;

class LikeButton extends Component
{
    public $model;

    public function mount($model) {
        $this->model = $model;
    }
    
    public function like() {
        $this->model->like();
    }

    public function render()
    {
        return view('social::livewire.partials.like-button');
    }
}
