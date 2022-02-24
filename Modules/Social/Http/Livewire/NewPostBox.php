<?php

    namespace Modules\Social\Http\Livewire;

    use App\Models\User;
    use Livewire\Component;

    class NewPostBox extends Component
    {
        public $postTypes = [];
        public $moods = [];
        public $selected;
        public $title;
        public $body;

        protected $rules = [
            'title' => 'required|min:6',
            'body' => 'required|min:6',
        ];
        
        public function mount() {
            $this->postTypes = [
                [
                    'label' => 'General',
                    'icon' => 'heroicon-o-heart',
                    'selected' => true
                ],
                [
                    'label' => 'Announcement',
                    'icon' => 'heroicon-o-heart'
                ],
            ];
            $this->moods = [
                [ 
                    'name' => 'Excited', 
                    'value' => 'excited', 
                    'icon' => 'heroicon-o-fire', 
                    'iconColor' => 'text-white', 
                    'bgColor' => 'bg-red-500' ,
                ],
                [ 
                    'name' => 'Loved', 
                    'value' => 'loved', 
                    'icon' => 'heroicon-o-heart', 
                    'iconColor' => 'text-white', 
                    'bgColor' => 'bg-pink-400' ,
                ],
                [ 
                    'name' => 'Happy', 
                    'value' => 'happy', 
                    'icon' => 'heroicon-o-emoji-happy', 
                    'iconColor' => 'text-white', 
                    'bgColor' => 'bg-green-400' ,
                ],
                [ 
                    'name' => 'Sad', 
                    'value' => 'sad', 
                    'icon' => 'heroicon-o-emoji-sad', 
                    'iconColor' => 'text-white', 
                    'bgColor' => 'bg-yellow-400' ,
                ],
                [ 
                    'name' => 'Thumbsy', 
                    'value' => 'thumbsy', 
                    'icon' => 'heroicon-o-thumb-up', 
                    'iconColor' => 'text-white', 
                    'bgColor' => 'bg-blue-500' ,
                ],
                [ 
                    'name' => 'I feel nothing', 
                    'value' => null, 
                    'icon' => 'heroicon-o-x', 
                    'iconColor' => 'text-gray-400', 
                    'bgColor' => 'bg-transparent',
                ],
            ];

            $this->selected = $this->moods[5];
        }

        public function updated($propertyName) 
        {
            $this->validateOnly($propertyName);
        }

        public function savePost()
        {
            $validatedData = $this->validate();

            $post = $this->user->posts()->create($validatedData);
            
            $this->emit('postAdded', $post->id);
            $this->reset(['title', 'body']);
        }

        public function getUserProperty()
        {
            return User::find(auth()->id());
        }

        public function render()
        {
            return view('social::livewire.new-post-box');
        }

    }
