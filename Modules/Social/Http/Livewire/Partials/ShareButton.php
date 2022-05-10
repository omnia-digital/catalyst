<?php

namespace Modules\Social\Http\Livewire\Partials;

use Livewire\Component;

class ShareButton extends Component
{
    public $url;
    public $links = [];
    public $showButton;
    public $showModal = false;

    public function mount($url = '', $showButton = true)
    {
        $this->url  = $url;
        $this->showButton = $showButton;
    }

    public function openModal()
    {
        $this->getLinks();
        $this->showModal = true;
//        $this->dispatchBrowserEvent('openModal');
    }

    public function getLinks()
    {
        $this->links = \Share::page($this->url)->facebook()->twitter()->linkedin()->whatsapp()->telegram()->reddit()->getRawLinks();
        return $this->links;
    }

    public function render()
    {
        return view('social::livewire.partials.share-button');
    }
}
