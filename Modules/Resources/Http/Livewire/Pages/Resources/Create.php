<?php

namespace Modules\Resources\Http\Livewire\Pages\Resources;

use Livewire\Component;
use Modules\Social\Actions\CreateNewPostAction;
use Modules\Social\Enums\PostType;
use Phuclh\MediaManager\WithMediaManager;
use Spatie\Tags\Tag;

class Create extends Component
{
    use WithMediaManager;

    public ?string $body = null;

    // Add Resource tag to all resources

}
