<?php

namespace Modules\Social\Http\Livewire;

use Livewire\Component;

class Home extends Component
{
    public $tabs = [];

    public $activities = [];

    public $questions = [];

    public function mount()
    {
        $this->tabs = [
            [
                'name'    => 'Recent',
                'href'    => '#',
                'current' => true
            ],
            [
                'name'    => 'Most Liked',
                'href'    => '#',
                'current' => false,
            ],
            [
                'name'    => 'Most Answers',
                'href'    => '#',
                'current' => false
            ]
        ];

        $this->activities = [];

        $this->questions = [];
    }

    public function render()
    {
        return view('social::livewire.home');
    }
}
