<?php

    namespace Modules\Social\Http\Livewire;

    use Livewire\Component;

    class Home extends Component
    {
        public $tabs = [];
        public $questions = [];
        public $whoToFollow = [];
        public $trendingPosts = [];
        public string $orderBy = 'created_at';

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

            $this->questions = [
                [
                    'id' => '81614',
                    'likes' => '29',
                    'replies' => '11',
                    'views' => '2.7k',
                    'author' => [
                        'name' => 'Dries Vincent',
                        'imageUrl' =>
                            'https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80',
                        'href' => '#',
                    ],
                    'date' => 'December 9 at 11:43 AM',
                    'datetime' => '2020-12-09T11:43:00',
                    'href' => '#',
                    'title' => 'What would you have done differently if you ran Jurassic Park?',
                    'body' => `
                        <p>Jurassic Park was an incredible idea and a magnificent feat of engineering, but poor protocols and a disregard for human safety killed what could have otherwise been one of the best businesses of our generation.</p>
                        <p>Ultimately, I think that if you wanted to run the park successfully and keep visitors safe, the most important thing to prioritize would be&hellip;</p>
                        `,
                ],
                [
                    'id' => '81614',
                    'likes' => '29',
                    'replies' => '11',
                    'views' => '2.7k',
                    'author' => [
                        'name' => 'Dries Vincent',
                        'imageUrl' =>
                            'https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80',
                        'href' => '#',
                    ],
                    'date' => 'December 9 at 11:43 AM',
                    'datetime' => '2020-12-09T11:43:00',
                    'href' => '#',
                    'title' => 'What would you have done differently if you ran Jurassic Park?',
                    'body' => `
                        <p>Jurassic Park was an incredible idea and a magnificent feat of engineering, but poor protocols and a disregard for human safety killed what could have otherwise been one of the best businesses of our generation.</p>
                        <p>Ultimately, I think that if you wanted to run the park successfully and keep visitors safe, the most important thing to prioritize would be&hellip;</p>
                    `,
                ],
                [
                    'id' => '81614',
                    'likes' => '29',
                    'replies' => '11',
                    'views' => '2.7k',
                    'author' => [
                        'name' => 'Dries Vincent',
                        'imageUrl' =>
                            'https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80',
                        'href' => '#',
                    ],
                    'date' => 'December 9 at 11:43 AM',
                    'datetime' => '2020-12-09T11:43:00',
                    'href' => '#',
                    'title' => 'What would you have done differently if you ran Jurassic Park?',
                    'body' => `
                        <p>Jurassic Park was an incredible idea and a magnificent feat of engineering, but poor protocols and a disregard for human safety killed what could have otherwise been one of the best businesses of our generation.</p>
                        <p>Ultimately, I think that if you wanted to run the park successfully and keep visitors safe, the most important thing to prioritize would be&hellip;</p>
                    `,
                ],
                [
                    'id' => '81614',
                    'likes' => '29',
                    'replies' => '11',
                    'views' => '2.7k',
                    'author' => [
                        'name' => 'Dries Vincent',
                        'imageUrl' =>
                            'https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80',
                        'href' => '#',
                    ],
                    'date' => 'December 9 at 11:43 AM',
                    'datetime' => '2020-12-09T11:43:00',
                    'href' => '#',
                    'title' => 'What would you have done differently if you ran Jurassic Park?',
                    'body' => `
                        <p>Jurassic Park was an incredible idea and a magnificent feat of engineering, but poor protocols and a disregard for human safety killed what could have otherwise been one of the best businesses of our generation.</p>
                        <p>Ultimately, I think that if you wanted to run the park successfully and keep visitors safe, the most important thing to prioritize would be&hellip;</p>
                    `,
                ],
            ];

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
