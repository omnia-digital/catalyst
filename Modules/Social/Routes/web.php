<?php

    use Illuminate\Support\Facades\Route;
    use Modules\Social\Http\Livewire\Home;
use Modules\Social\Http\Livewire\Pages\Bookmarks\Index;

    Route::name('social.')->prefix('social')->middleware(['auth', 'verified'])->group(function () {
//        Route::get('/', 'SocialController@index');

        // the way twitter works is
        // /{handle} for profile
        // /{handle}/status/{post_id} for any type of post, whether it's a post or reply
        // /{messages}/{message_id} for messages

        Route::get('/home', Home::class)->name('home');
        Route::get('bookmarks', Index::class)->name('bookmarks');

//        Route::get('/projects', function () {
//            return "Projects";
//        })->name('projects');

        Route::get('/posts', function () {
            return "Posts";
        })->name('posts');

        Route::get('/posts/{post}', function () {
            return "Show a post";
        })->name('posts.show');

        Route::get('/crm', function () {
            return "CRM";
        })->name('crm');

        Route::get('/learn', function () {
            return "Learn";
        })->name('learn');

        Route::get('/marketplace', function () {
            return "Marketplace";
        })->name('marketplace');
//        Route::get('/', function () {
////            return Inertia::render('Social/Home');
//        })->name('social-home');
//        Route::get('/explore', function () {
//        })->name('explore');
//        Route::get('/profile', [Profile::class, 'show'])->name('profile');
//        Route::get('/bookmarks', function () {
//        })->name('bookmarks');
    });

