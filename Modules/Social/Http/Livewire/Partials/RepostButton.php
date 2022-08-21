<?php

namespace Modules\Social\Http\Livewire\Partials;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Modules\Social\Actions\CreateNewPostAction;
use Modules\Social\Models\Post;
use Modules\Social\Notifications\PostWasRepostedNotification;
use Modules\Social\Support\Livewire\WithPostEditor;
use OmniaDigital\OmniaLibrary\Livewire\WithModal;
use OmniaDigital\OmniaLibrary\Livewire\WithNotification;

class RepostButton extends Component
{
    use WithModal, WithNotification, WithPostEditor;

    /**
     * @var string[]
     *
     * @psalm-var array{'post-editor:submitted': 'createRepost'}
     */
    protected $listeners = [
        'post-editor:submitted' => 'createRepost'
    ];
}
