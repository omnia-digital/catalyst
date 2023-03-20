<?php

namespace Modules\Articles\Http\Livewire\Pages\Articles;

use App\Models\Tag;
use Livewire\Component;
use Modules\Social\Actions\Posts\CreateNewPostAction;
use Modules\Social\Enums\PostType;
use Phuclh\MediaManager\WithMediaManager;

class Create extends Component
{
    use WithMediaManager;

    public ?string $title = null;

    public ?string $body = null;

    public ?string $url = null;

    public ?string $image = null;

    protected function rules(): array
    {
        return [
            'title' => ['required', 'max:255'],
            'url'   => ['nullable', 'url', 'max:255'],
            'body'  => ['required', 'min:50'],
            'image' => ['nullable','string'],
        ];
    }

    public function addArticle()
    {
        $validated = $this->validate();

        $hashtags = Tag::parseHashTagsFromString($validated['body']);

        $article = (new CreateNewPostAction)
            ->type(PostType::ARTICLE)
            ->execute($validated['body'], [
                'title' => $validated['title'],
                'body' => $validated['body'],
                'url'   => $validated['url'],
            ]);

        $tags = Tag::findOrCreateTags($hashtags, 'post');
        $article->attachTags($tags,'post');

        if (isset($validated['image'])) {
            $article->attachMedia([$validated['image']]);
        }

        $this->reset('title', 'url', 'body', 'image');
        $this->redirectRoute('articles.home', $article);
    }


    public function setFeaturedImage(array $image)
    {
        $this->image = $image['url'];
    }

    public function removeFeaturedImage()
    {
        $this->image = null;

        $this->removeFileFromMediaManager();
    }

    public function render()
    {
        return view('articles::livewire.pages.articles.create');
    }
}
