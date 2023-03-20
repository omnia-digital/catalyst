<?php

namespace Modules\Resources\Http\Livewire\Components;

use Illuminate\Support\Facades\Auth;
use Modules\Social\Http\Livewire\Components\PostCard;
use OmniaDigital\OmniaLibrary\Livewire\WithNotification;
use function view;

class ResourceMediaCard extends PostCard
{
    public $showDetails = false;
    public $showTeamDetails = false;
    public function showPost() {
        return $this->redirectRoute('resources.show', $this->post);
    }

    public function render()
    {
        return view('resources::livewire.components.resource-media-card');
    }
}
