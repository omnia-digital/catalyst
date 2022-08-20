<?php

namespace Modules\Social\Http\Livewire\Pages\Posts;

use Livewire\Component;
use Modules\Social\Enums\PostType;
use Modules\Social\Models\Post;

class Show extends Component
{
    /**
     * @var string[]
     *
     * @psalm-var array{postAdded: '$refresh'}
     */
    protected array $listeners = ['postAdded' => '$refresh'];

    /**
     * @var Post&\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Collection&\Illuminate\Database\Eloquent\Builder|null
     *
     * @psalm-var Post&\Illuminate\Database\Eloquent\Builder<Post>|\Illuminate\Database\Eloquent\Collection<Post&\Illuminate\Database\Eloquent\Builder<Post&\Illuminate\Database\Eloquent\Collection<Post&\Illuminate\Database\Eloquent\Builder<Post>>>&\Illuminate\Database\Eloquent\Collection<Post&\Illuminate\Database\Eloquent\Builder<Post>>>&\Illuminate\Database\Eloquent\Builder<Post>|\Illuminate\Database\Eloquent\Collection<Post&\Illuminate\Database\Eloquent\Builder<Post>>&\Illuminate\Database\Eloquent\Builder<Post>|null
     */
    public $post;

    /**
     * @var Post|null
     */
    