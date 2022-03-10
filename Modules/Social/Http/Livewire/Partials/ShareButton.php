<?php

namespace Modules\Social\Http\Livewire\Partials;

use Livewire\Component;

class ShareButton extends Component
{
    public $model;
    public $show;

    public function mount($model, $show = false) {
        $this->model = $model;
        $this->show = $show;

    }

    public function like() {
        $this->model->like();
    }

    public function render()
    {
        return view('social::livewire.partials.share-button');
    }
}
