<?php

namespace Modules\Articles\Http\Livewire\Pages\Articles;

use App\Models\Tag;
use App\Models\Team;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;
use Modules\Social\Models\Mention;
use Modules\Social\Models\Post;
use Phuclh\MediaManager\WithMediaManager;

class Edit extends Component
{
    use WithMediaManager, AuthorizesRequests;

    public Post $article;

    public function mount(Post $article)
    {
        $this->article = $article;

        if (is_null($this->article->published_at)) {
            // If it's a draft only the owner can view it
            $this->authorize('update', $this->article);
        }
    }

    public function saveAsDraft()
    {
        $validated = $this->validate()['article'];

        $this->saveArticle($validated);

        if (! is_null($this->article->published_at)) {
            $this->article->published_at = null;
            $this->article->save();
        }

        $this->addMentions($validated['body']);

        $this->addTags($validated['body']);

        if (isset($validated['image'])) {
            $this->article->attachMedia([$validated['image']]);
        }

        $this->redirectRoute('articles.show', $this->article);
    }

    public function publishArticle()
    {
        $validated = $this->validate()['article'];

        $this->saveArticle($validated);

        if (is_null($this->article->published_at)) {
            $this->article->published_at = now();
            $this->article->save();
        }

        $this->addMentions($validated['body']);

        $this->addTags($validated['body']);

        if (isset($validated['image'])) {
            $this->article->attachMedia([$validated['image']]);
        }

        $this->redirectRoute('articles.show', $this->article);
    }

    public function addMentions($content)
    {
        [$userMentions, $teamMentions] = Mention::getAllMentions($content);

        Mention::createManyFromHandles($userMentions, User::class, $this->article);
        Mention::createManyFromHandles($teamMentions, Team::class, $this->article);
    }

    public function addTags($content)
    {
        $hashtags = Tag::parseHashTagsFromString($content);

        $tags = Tag::findOrCreateTags($hashtags, 'post');

        $this->article->attachTags($tags, 'post');
    }

    public function saveArticle($attributes)
    {
        $this->article->update([
            'title' => $attributes['title'],
            'body' => Mention::processMentionContent($attributes['body']),
            'url' => $attributes['url'],
            'image' => $attributes['image'],
        ]);

        $this->article->fresh();
    }

    public function setFeaturedImage(array $image)
    {
        $this->article->image = $image['url'];
    }

    public function removeFeaturedImage()
    {
        $this->article->image = null;

        $this->removeFileFromMediaManager();
    }

    public function render()
    {
        return view('articles::livewire.pages.articles.edit');
    }

    protected function rules(): array
    {
        return [
            'article.title' => ['required', 'max:255'],
            'article.url' => ['nullable', 'url', 'max:255'],
            'article.body' => ['required', 'min:50'],
            'article.image' => ['nullable', 'string'],
        ];
    }
}
