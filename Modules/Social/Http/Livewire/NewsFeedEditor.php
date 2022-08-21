<?php

namespace Modules\Social\Http\Livewire;

use App\Models\Team;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Modules\Social\Actions\CreateNewPostAction;
use Modules\Social\Support\Livewire\WithPostEditor;
use OmniaDigital\OmniaLibrary\Livewire\WithNotification;

class NewsFeedEditor extends Component
{
    use WithPostEditor, WithNotification;

    /**
     * @var string[]
     *
     * @psalm-var array{'post-editor:submitted': 'createPost'}
     */
    protected $listeners = [
        'post-editor:submitted' => 'createPost'
    ];
}
