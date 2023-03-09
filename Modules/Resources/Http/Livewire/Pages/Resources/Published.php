<?php

namespace Modules\Resources\Http\Livewire\Pages\Resources;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Modules\Social\Enums\PostType;
use Modules\Social\Models\Post;
use OmniaDigital\OmniaLibrary\Livewire\WithCachedRows;

class Published extends Component
{
    use WithPagination, WithCachedRows;
    
    public function getRowsQueryProperty()
    {
        $query = Post::where('type', '=', PostType::RESOURCE)
            ->where('user_id', auth()->id())
            ->whereNotNull('published_at')
            ->withCount(['bookmarks', 'likes', 'media']);

        return $query;
    }

    public function getRowsProperty()
    {
        return $this->cache(function () {
            return $this->rowsQuery->paginate(100);
        });
    }

    public function user()
    {
        return User::find(auth()->id());
    }

    public function render()
    {
        return view('resources::livewire.pages.resources.published', [
            'resources' => $this->rows
        ]);
    }
}
