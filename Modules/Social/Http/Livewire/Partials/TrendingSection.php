<?php

namespace Modules\Social\Http\Livewire\Partials;

use Livewire\Component;

class TrendingSection extends Component
{
    public $trendingPosts = [];

    public function mount($trendingPosts = null)
    {
        $this->trendingPosts = [
            [
                'id' => 1,
                'user' => [
                    'name' => 'Floyd Miles',
                    'imageUrl' =>
                        'https://images.unsplash.com/photo-1463453091185-61582044d556?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80',
                ],
                'body' => 'What books do you have on your bookshelf just to look smarter than you actually are?',
                'comments' => 291,
            ],
            [
                'id' => 1,
                'user' => [
                    'name' => 'Floyd Miles',
                    'imageUrl' =>
                        'https://images.unsplash.com/photo-1463453091185-61582044d556?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80',
                ],
                'body' => 'What books do you have on your bookshelf just to look smarter than you actually are?',
                'comments' => 291,
            ],
            [
                'id' => 1,
                'user' => [
                    'name' => 'Floyd Miles',
                    'imageUrl' =>
                        'https://images.unsplash.com/photo-1463453091185-61582044d556?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80',
                ],
                'body' => 'What books do you have on your bookshelf just to look smarter than you actually are?',
                'comments' => 291,
            ],
        ];
    }

    public function render()
    {
        return view('social::livewire.partials.trending-section');
    }
}
