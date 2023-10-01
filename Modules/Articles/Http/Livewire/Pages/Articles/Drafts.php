<?php

namespace Modules\Articles\Http\Livewire\Pages\Articles;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Modules\Social\Enums\PostType;
use Modules\Social\Models\Post;
use OmniaDigital\OmniaLibrary\Livewire\WithCachedRows;

class Drafts extends Component
{
    use WithPagination, WithCachedRows;

    public function getRowsQueryProperty()
    {
        $query = Post::where('type', '=', PostType::ARTICLE)
            ->where('user_id', auth()->id())
            ->whereNull('published_at')
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
        return view('articles::livewire.pages.articles.drafts', [
            'articles' => $this->rows,
        ]);
    }
}
