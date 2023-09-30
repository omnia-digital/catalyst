<?php

namespace Modules\Articles\Http\Livewire\Pages\Articles;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;
use Modules\Social\Enums\PostType;
use Modules\Social\Models\Post;

class Show extends Component
{
    use AuthorizesRequests;

    public $article;

    public function mount($article)
    {
        $this->article = Post::withoutGlobalScope('parent')->find($article);

        if (is_null($this->article->published_at)) {
            // If it's a draft only the owner can view it
            $this->authorize('update', $this->article);
        }

        if (!empty($this->article) && $this->article->type !== PostType::ARTICLE) {
            $this->redirectRoute('social.posts.show', $this->article);
        }
    }

    public function render()
    {
        return view('articles::livewire.pages.articles.show');
    }
}
