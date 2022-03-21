<?php

    namespace Modules\Social\Http\Livewire;

use Illuminate\Support\Facades\Date;
use Livewire\Component;
use Modules\Social\Models\Post;

    class Home extends Component
    {
        public $recentlyAddedPost;
        public $tabs = [];
        public $activities = [];
        public $questions = [];
        public string $orderBy = 'created_at';
        protected $listeners = ['postAdded' => '$refresh'];

        public function postAdded(Post $post) {
            $this->recentlyAddedPost = $post;
        }

        public function mount() {
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

        public function getPostsProperty() {
            return Post::latest()->get();
        }

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
