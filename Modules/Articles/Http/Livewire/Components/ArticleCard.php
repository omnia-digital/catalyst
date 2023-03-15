<?php

namespace Modules\Articles\Http\Livewire\Components;

use Illuminate\Support\Facades\Auth;
use Modules\Social\Http\Livewire\Components\PostCard;
use OmniaDigital\OmniaLibrary\Livewire\WithNotification;
use function view;

class ArticleCard extends PostCard
{
    public function showPost() {
        return $this->redirectRoute('articles.show', $this->post);
    }

    public function render()
    {
        return view('articles::livewire.components.article-card');
    }
}