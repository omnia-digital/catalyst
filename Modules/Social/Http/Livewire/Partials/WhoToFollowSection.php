<?php

namespace Modules\Social\Http\Livewire\Partials;

use Livewire\Component;

class WhoToFollowSection extends Component
{
    public $whoToFollow = [];

    public function mount($whoToFollow = null)
    {
        $this->whoToFollow = [
            [
                'name' => 'Leonard Krasner',
                'profile' => [
                    'handle' => 'leonardkrasner',
                ],
                'href' => '#',
                'imageUrl' =>
                    'https://images.unsplash.com/photo-1519345182560-3f2917c472ef?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80',
            ],
            [
                'name' => 'Leonard Krasner',
                'profile' => [
                    'handle' => 'leonardkrasner',
                ],
                'href' => '#',
                'imageUrl' =>
                    'https://images.unsplash.com/photo-1519345182560-3f2917c472ef?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80',
            ],
            [
                'name' => 'Leonard Krasner',
                'profile' => [
                    'handle' => 'leonardkrasner',
                ],
                'href' => '#',
                'imageUrl' =>
                    'https://images.unsplash.com/photo-1519345182560-3f2917c472ef?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80',
            ],
        ];
    }

    public function render()
    {
        return view('social::livewire.partials.who-to-follow-section');
    }
}
