<?php

namespace Modules\Social\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class Profile extends Controller
{
    public function show()
    {
        Auth::user();

        return Inertia::render('Social/Profile', [
            'profile' => [
                'name' => $profile->name,
                'email' => $user->email,
                'avatar' => 'https://images.unsplash.com/photo-1463453091185-61582044d556?ixlib=rb-=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=8&w=1024&h=1024&q=80',
                'field' => $profile->fields(),
                'backgroundImage' => 'https://images.unsplash.com/photo-1444628838545-ac4016a5418a?ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&ixlib=rb-1.2.1&auto=format&fit=crop&w=1950&q=80',
            ],

        ]);
    }
}
