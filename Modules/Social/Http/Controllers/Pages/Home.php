<?php

namespace Modules\Social\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class Home extends Controller
{
    public function show()
    {
        return Inertia::render('Social::Home', [
        ]);
    }
}
