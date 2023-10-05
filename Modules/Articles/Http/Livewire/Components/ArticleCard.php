<?php

namespace Modules\Articles\Http\Livewire\Components;

use OmniaDigital\CatalystCore\Http\Livewire\Components\PostCard;
use function view;

class ArticleCard extends PostCard
{
    public function showPost()
    {
        return $this->redirectRoute('articles.show', $this->post);
    }

    public function render()
    {
        return view('articles::livewire.components.article-card');
    }
}
