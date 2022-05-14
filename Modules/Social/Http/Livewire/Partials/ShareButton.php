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
    public ?string $content = null;

    public function mount(Post $model, $url = '')
    {
        $this->model = $model;
        $this->url = $model->getUrl() ?? $url;
    }

    public function showShareModal()
    {
        $this->getLinks();
        $this->openModal('share-modal-' . $this->model->id);
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
