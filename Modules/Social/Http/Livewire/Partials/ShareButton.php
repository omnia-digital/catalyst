<?php

namespace Modules\Social\Http\Livewire\Partials;

use Livewire\Component;
use Modules\Social\Models\Post;
use OmniaDigital\OmniaLibrary\Livewire\WithModal;

class ShareButton extends Component
{
    use withModal;
    public ?string $url;
    public array $links = [];

}
