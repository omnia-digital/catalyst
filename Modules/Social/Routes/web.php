<?php

    /*
    |--------------------------------------------------------------------------
    | Web Routes
    |--------------------------------------------------------------------------
    |
    | Here is where you can register web routes for your application. These
    | routes are loaded by the RouteServiceProvider within a group which
    | contains the "web" middleware group. Now create something great!
    |
    */

    use Illuminate\Support\Facades\Route;
    use Inertia\Inertia;
    use Modules\Social\Http\Controllers\Pages\Home;
    use Modules\Social\Models\Profile;

    Route::prefix('social')->middleware(['auth:sanctum', 'verified'])->group(function () {
        Route::get('/', 'SocialController@index');

        // the way twitter works is
        // /{handle} for profile
        // /{handle}/status/{post_id} for any type of post, whether it's a post or reply
        // /{messages}/{message_id} for messages

        Route::get('/home', [Home::class, 'show'])->name('home');

        Route::get('/', function () {
            return Inertia::render('Social/Home');
        })->name('social-home');
        Route::get('/explore', function () {
            return Inertia::render('Social/Home');
        })->name('explore');
        Route::get('/profile', [Profile::class, 'show'])->name('profile');
        Route::get('/bookmarks', function () {
            return Inertia::render('Social/Home');
        })->name('bookmarks');
    });

