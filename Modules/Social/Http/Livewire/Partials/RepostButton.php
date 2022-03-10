<?php

namespace Modules\Social\Http\Livewire\Partials;

use Livewire\Component;

class RepostButton extends Component
{
    public $model;
    public $show;

    public function mount($model, $show = false) {
        $this->model = $model;
        $this->show = $show;
    }

    public function render()
    {
        return view('social::livewire.partials.repost-button');
    }
}
