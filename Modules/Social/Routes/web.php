<?php

    use Illuminate\Support\Facades\Route;
    use Modules\Social\Http\Livewire\Home;

    Route::name('social.')->prefix('social')->middleware(['auth', 'verified'])->group(function () {
//        Route::get('/', 'SocialController@index');

        // the way twitter works is
        // /{handle} for profile
        // /{handle}/status/{post_id} for any type of post, whether it's a post or reply
        // /{messages}/{message_id} for messages

        Route::get('/home', Home::class)->name('home');

//        Route::get('/', function () {
////            return Inertia::render('Social/Home');
//        })->name('social-home');
//        Route::get('/explore', function () {
//        })->name('explore');
//        Route::get('/profile', [Profile::class, 'show'])->name('profile');
//        Route::get('/bookmarks', function () {
//        })->name('bookmarks');
    });

