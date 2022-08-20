<?php

namespace Modules\Resources\Http\Livewire\Pages\Resources;

use Livewire\Component;
use Modules\Social\Enums\PostType;
use Modules\Social\Models\Post;

class Show extends Component
{
    /**
     * @var Post&\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Collection|null
     *
     * @psalm-var Post&\Illuminate\Database\Eloquent\Builder<Post>|\Illuminate\Database\Eloquent\Collection<Post&\Illuminate\Database\Eloquent\Builder<Post>>|null
     */
    public $resource;
}
