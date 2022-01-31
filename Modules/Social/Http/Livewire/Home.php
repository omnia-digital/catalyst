<?php

    namespace Modules\Social\Http\Livewire;

    use Livewire\Component;

    class Home extends Component
    {
        public $tabs = [
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

        public string $orderBy = 'created_at';

        public function render()
        {
            return view('social::livewire.home');
        }

        public function sortBy(string $orderBy)
        {
            if ($orderBy === $this->orderBy) {
                return;
            }

            $this->orderBy = $orderBy;
        }
    }
