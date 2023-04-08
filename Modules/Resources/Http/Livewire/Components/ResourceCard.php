<?php

namespace Modules\Resources\Http\Livewire\Components;

use Modules\Social\Http\Livewire\Components\PostCard;

use function view;

class ResourceCard extends PostCard
{
    public function showPost()
    {
        return $this->redirectRoute('resources.show', $this->post);
    }

    public function render()
    {
        return view('resources::livewire.components.resource-card');
    }
}
