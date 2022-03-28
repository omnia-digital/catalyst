<?php

    namespace Modules\Social\Http\Livewire;

    use App\Models\User;
    use Livewire\Component;
use Modules\Social\Models\Post;

    class NewPostBox extends Component
    {
        public $postTypes = [];
        public $moods = [];
        public $selected;
        public $body;
        public $attachments = [];
        public $parentPostID;
        public $postSent = false;

        protected $listeners = ['filesAdded'];

        protected $rules = [
            'body' => 'required|min:6',
        ];

        public function filesAdded($files)
        {
            $this->attachments = $files;
        }

        public function mount($parentPostID = null) {
            $this->parentPostID = $parentPostID;
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
                [
                    'label' => 'Resource',
                    'icon' => 'heroicon-o-newspaper'
                ],
            ];
            $this->moods = [
                [
                    'name' => 'Excited',
                    'value' => 'excited',
                    'icon' => 'heroicon-o-fire',
                    'iconColor' => 'text-light-text-color',
                    'bgColor' => 'bg-red-500' ,
                ],
                [
                    'name' => 'Loved',
                    'value' => 'loved',
                    'icon' => 'heroicon-o-heart',
                    'iconColor' => 'text-light-text-color',
                    'bgColor' => 'bg-pink-400' ,
                ],
                [
                    'name' => 'Happy',
                    'value' => 'happy',
                    'icon' => 'heroicon-o-emoji-happy',
                    'iconColor' => 'text-light-text-color',
                    'bgColor' => 'bg-green-400' ,
                ],
                [
                    'name' => 'Sad',
                    'value' => 'sad',
                    'icon' => 'heroicon-o-emoji-sad',
                    'iconColor' => 'text-light-text-color',
                    'bgColor' => 'bg-yellow-400' ,
                ],
                [
                    'name' => 'Thumbsy',
                    'value' => 'thumbsy',
                    'icon' => 'heroicon-o-thumb-up',
                    'iconColor' => 'text-light-text-color',
                    'bgColor' => 'bg-secondary' ,
                ],
                [
                    'name' => 'I feel nothing',
                    'value' => null,
                    'icon' => 'heroicon-o-x',
                    'iconColor' => 'text-light-text-color',
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

            if (is_null($this->parentPostID)) {
                $post = $this->user->posts()->create($validatedData);
            } else {
                $parentPost = Post::withoutGlobalScope('parent')->find($this->parentPostID);
                $post = $parentPost->createComment($validatedData, auth()->id());
            }

            $this->postSent = true;
            $this->emit('postAdded', $post);
            $this->reset(['body']);
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
