<?php

namespace Modules\Advice\Http\Livewire\Pages\Questions;

use Livewire\Component;
use Modules\Social\Models\Post;

use function view;

class Show extends Component
{
    public Post $resource;

    public function mount(Post $question)
    {
        if ($question->type != 'question') {
            return $this->redirectRoute('advice.questions.show', $question);
        }
    }

    public function render()
    {
        return view('advice::livewire.pages.questions.show');
    }
}
