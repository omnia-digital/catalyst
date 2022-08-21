<?php

namespace Modules\Social\Http\Livewire\Components;

use Livewire\Component;
use Modules\Social\Models\Post;
use OmniaDigital\OmniaLibrary\Livewire\WithNotification;
use function view;

class PostCard extends Component
{
    use WithNotification;

    public Post $post;
}
