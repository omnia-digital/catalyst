<?php

use Modules\Articles\Http\Livewire\Pages\Bookmarks\Index as BookmarkIndex;
use Modules\Articles\Http\Livewire\Pages\Articles\Drafts as ArticlesDrafts;
use Modules\Articles\Http\Livewire\Pages\Articles\Edit;
use Modules\Articles\Http\Livewire\Pages\Articles\Index;
use Modules\Articles\Http\Livewire\Pages\Articles\Published as ArticlesPublished;
use Modules\Articles\Http\Livewire\Pages\Articles\Show;
use Modules\Social\Actions\Posts\CreateNewPostAction;
use Modules\Social\Enums\PostType;
use Modules\Social\Http\Middleware\GuestAccessMiddleware;

Route::name('articles.')->prefix('articles')->middleware([GuestAccessMiddleware::class, 'verified'])->group(function () {
    Route::get('/', Index::class)->name('home');
    Route::get('drafts', ArticlesDrafts::class)->middleware(['auth'])->withoutMiddleware([GuestAccessMiddleware::class])->name('drafts');
    Route::get('published', ArticlesPublished::class)->middleware(['auth'])->withoutMiddleware([GuestAccessMiddleware::class])->name('published');
    Route::get('bookmarks', BookmarkIndex::class)->name('bookmarks');
    Route::get('create', function () {
        $article = (new CreateNewPostAction)->type(PostType::ARTICLE)->execute('', ['title' => '', 'url' => '']);

        return redirect()->route('articles.edit', $article->id);
    })->name('create');
    Route::get('{article}', Show::class)->name('show');
    Route::get('{article}/edit', Edit::class)->name('edit');
});
