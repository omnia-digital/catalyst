<?php

    use Illuminate\Foundation\Application;
    use Illuminate\Support\Facades\Route;
    use Inertia\Inertia;
    use App\Http\Controllers\Pages\Social\Profile;

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

    Route::get('/', function () {
        return Inertia::render('Welcome', [
            'canLogin'       => Route::has('login'),
            'canRegister'    => Route::has('register'),
            'laravelVersion' => Application::VERSION,
            'phpVersion'     => PHP_VERSION,
        ]);
    });

    Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    Route::middleware(['auth:sanctum', 'verified'])->group(function() {

        // This home route we could make configurable to point to different pages
        // For now, let's point it to use the social/home
        Route::get('/home', function () {
            return Inertia::render('Social/Home');
        })->name('home');

        Route::get('/messages', function () {
            return Inertia::render('Social/Home');
        })->name('messages');
        Route::get('/notifications', function () {
            return Inertia::render('Social/Home');
        })->name('notifications');
        Route::get('/projects', function () {
            return Inertia::render('Social/Home');
        })->name('projects');
        Route::get('/groups', function () {
            return Inertia::render('Social/Home');
        })->name('groups');
        Route::get('/learn', function () {
            return Inertia::render('Social/Home');
        })->name('learn');
        Route::get('/marketplace', function () {
            return Inertia::render('Social/Home');
        })->name('marketplace');

        Route::prefix('social')->group(function() {

            // the way twitter works is
            // /{handle} for profile
            // /{handle}/status/{post_id} for any type of post, whether it's a post or reply
            // /{messages}/{message_id} for messages


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
    });

