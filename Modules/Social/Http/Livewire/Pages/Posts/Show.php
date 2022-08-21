<?php

namespace Modules\Social\Http\Livewire\Pages\Posts;

use Livewire\Component;
use Modules\Social\Enums\PostType;
use Modules\Social\Models\Post;

class Show extends Component
{
    /**
     * @var string[]
     * @psalm-var array{postAdded: '$refresh'}
     */
    protected $listeners = ['postAdded' => '$refresh'];
}
