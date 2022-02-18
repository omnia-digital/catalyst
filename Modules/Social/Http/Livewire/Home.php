<?php

    namespace Modules\Social\Http\Livewire;

use Illuminate\Support\Facades\Date;
use Livewire\Component;
use Modules\Social\Models\Post;

    class Home extends Component
    {
        public $feedCategories;
        public $tabs = [];
        public $activities = [];
        public $questions = [];
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

            $this->activities = [
                [
                    'id' => 0,
                    'title' => 'Your project «Project title» has began',
                    'message' => 'Tincidunt dolor odio vulputate faucibus tempor. Nunc ullamcorper nunc eget eget orci, congue. Imperdie…',
                    'created_at' => now(),
                    'user' => [
                        'avatar' => null,
                    ],
                    'members' => [
                        [
                            'avatar' => 'https://source.unsplash.com/24x24/?face&crop-face&v=1',
                        ],
                        [
                            'avatar' => 'https://source.unsplash.com/24x24/?face&crop-face&v=1',
                        ],
                        [
                            'avatar' => 'https://source.unsplash.com/24x24/?face&crop-face&v=1',
                        ],
                        [
                            'avatar' => 'https://source.unsplash.com/24x24/?face&crop-face&v=1',
                        ],
                        [
                            'avatar' => 'https://source.unsplash.com/24x24/?face&crop-face&v=1',
                        ],
                        [
                            'avatar' => 'https://source.unsplash.com/24x24/?face&crop-face&v=1',
                        ],
                        [
                            'avatar' => 'https://source.unsplash.com/24x24/?face&crop-face&v=1',
                        ],
                        [
                            'avatar' => 'https://source.unsplash.com/24x24/?face&crop-face&v=1',
                        ],
                        [
                            'avatar' => 'https://source.unsplash.com/24x24/?face&crop-face&v=1',
                        ],
                        [
                            'avatar' => 'https://source.unsplash.com/24x24/?face&crop-face&v=1',
                        ],
                        [
                            'avatar' => 'https://source.unsplash.com/24x24/?face&crop-face&v=1',
                        ],
                    ],
                    'project' => [
                        'link' => route('teams.home'),
                    ],
                ],
                [
                    'id' => 1,
                    'title' => 'Robert Fox created a new project «Project title»',
                    'message' => 'Tincidunt dolor odio vulputate faucibus tempor. Nunc ullamcorper nunc eget eget orci, congue. Imperdie…',
                    'created_at' => Date::parse('Dec 02, 2021 at 9:15 AM'),
                    'user' => [
                        'avatar' => 'https://source.unsplash.com/24x24/?face&crop-face&v=1',
                    ],
                    'members' => null,
                    'project' => [
                        'link' => route('teams.home'),
                    ],
                ],
                [
                    'id' => 2,
                    'title' => 'Kate Wills joined to your project «Project title»',
                    'message' => 'Tincidunt dolor odio vulputate faucibus tempor. Nunc ullamcorper nunc eget eget orci, congue. Imperdie…',
                    'created_at' => Date::parse('Dec 02, 2021 at 8:45 AM'),
                    'user' => [
                        'avatar' => 'https://source.unsplash.com/24x24/?face&crop-face&v=1',
                    ],
                    'members' => null,
                    'project' => [
                        'link' => route('teams.home'),
                    ],
                ],
                [
                    'id' => 3,
                    'title' => 'Your request to participate in «Project title» is accepted ',
                    'message' => 'Tincidunt dolor odio vulputate faucibus tempor. Nunc ullamcorper nunc eget eget orci, congue. Imperdie…',
                    'created_at' => Date::parse('Dec 02, 2021 at 8:45 AM'),
                    'user' => [
                        'avatar' => null,
                    ],
                    'members' => null,
                    'project' => [
                        'link' => route('teams.home'),
                    ],
                ],
                [
                    'id' => 4,
                    'title' => 'Jane Cooper attended project «Project title»',
                    'message' => 'Tincidunt dolor odio vulputate faucibus tempor. Nunc ullamcorper nunc eget eget orci, congue. Imperdie…',
                    'created_at' => Date::parse('Dec 01, 2021 at 5:00 PM'),
                    'user' => [
                        'avatar' => '',
                    ],
                    'members' => [
                        [
                            'avatar' => 'https://source.unsplash.com/24x24/?face&crop-face&v=1',
                        ],
                        [
                            'avatar' => 'https://source.unsplash.com/24x24/?face&crop-face&v=1',
                        ],
                        [
                            'avatar' => 'https://source.unsplash.com/24x24/?face&crop-face&v=1',
                        ],
                        [
                            'avatar' => 'https://source.unsplash.com/24x24/?face&crop-face&v=1',
                        ],
                        [
                            'avatar' => 'https://source.unsplash.com/24x24/?face&crop-face&v=1',
                        ],
                        [
                            'avatar' => 'https://source.unsplash.com/24x24/?face&crop-face&v=1',
                        ],
                        [
                            'avatar' => 'https://source.unsplash.com/24x24/?face&crop-face&v=1',
                        ],
                        [
                            'avatar' => 'https://source.unsplash.com/24x24/?face&crop-face&v=1',
                        ],
                        [
                            'avatar' => 'https://source.unsplash.com/24x24/?face&crop-face&v=1',
                        ],
                        [
                            'avatar' => 'https://source.unsplash.com/24x24/?face&crop-face&v=1',
                        ],
                        [
                            'avatar' => 'https://source.unsplash.com/24x24/?face&crop-face&v=1',
                        ],
                    ],
                    'project' => [
                        'link' => route('teams.home'),
                    ],
                ],
                [
                    'id' => 5,
                    'title' => 'Wade Warren raised his level to «Gold member»',
                    'message' => null,
                    'created_at' => Date::parse('Dec 01, 2021 at 2:24 PM'),
                    'user' => [
                        'avatar' => 'https://source.unsplash.com/24x24/?face&crop-face&v=1'
                    ],
                    'memebers' => null,
                    'project' => null,
                ],
                [
                    'id' => 6,
                    'title' => 'Kate Willis attended project «Project title»',
                    'message' => 'Tincidunt dolor odio vulputate faucibus tempor. Nunc ullamcorper nunc eget eget orci, congue. Imperdie…',
                    'created_at' => Date::parse('Dec 01, 2021 at 5:00 PM'),
                    'user' => [
                        'avatar' => '',
                    ],
                    'members' => [
                        [
                            'avatar' => 'https://source.unsplash.com/24x24/?face&crop-face&v=1',
                        ],
                        [
                            'avatar' => 'https://source.unsplash.com/24x24/?face&crop-face&v=1',
                        ],
                        [
                            'avatar' => 'https://source.unsplash.com/24x24/?face&crop-face&v=1',
                        ],
                        [
                            'avatar' => 'https://source.unsplash.com/24x24/?face&crop-face&v=1',
                        ],
                        [
                            'avatar' => 'https://source.unsplash.com/24x24/?face&crop-face&v=1',
                        ],
                        [
                            'avatar' => 'https://source.unsplash.com/24x24/?face&crop-face&v=1',
                        ],
                        [
                            'avatar' => 'https://source.unsplash.com/24x24/?face&crop-face&v=1',
                        ],
                        [
                            'avatar' => 'https://source.unsplash.com/24x24/?face&crop-face&v=1',
                        ],
                        [
                            'avatar' => 'https://source.unsplash.com/24x24/?face&crop-face&v=1',
                        ],
                        [
                            'avatar' => 'https://source.unsplash.com/24x24/?face&crop-face&v=1',
                        ],
                        [
                            'avatar' => 'https://source.unsplash.com/24x24/?face&crop-face&v=1',
                        ],
                    ],
                    'project' => [
                        'link' => route('teams.home'),
                    ],
                ],
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
        }

        public function getPostsProperty() {
            return Post::get();
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
