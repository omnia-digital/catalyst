<?php

namespace Modules\Advice\Http\Livewire\Pages;

use Livewire\Component;
use Modules\Jobs\Models\Job;
use Modules\Social\Models\Post;

class Home extends Component
{
    public function render(): \Illuminate\View\View
    {
        $questions = Post::with(['company', 'tags', 'addons'])
                           ->latest()
                           ->get();


        return view('advice::livewire.pages.home',[
                    'questions'         => $questions,
        ]);
    }
}
