<?php

namespace Modules\Social\Http\Livewire\Partials;

use Livewire\Component;
use Modules\Social\Models\Post;
use OmniaDigital\OmniaLibrary\Livewire\WithModal;

class ShareButton extends Component
{
    use withModal;

    public Post $model;
    public ?string $url;
    public array $links = [];


    public function getLinks()
    {
        $this->links = \Share::page($this->url)->facebook()->twitter()->linkedin()->whatsapp()->telegram()->reddit()->getRawLinks();
        return $this->links;
    }
}
