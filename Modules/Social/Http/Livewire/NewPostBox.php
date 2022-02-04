<?php

    namespace Modules\Social\Http\Livewire;

    use Livewire\Component;

    class NewPostBox extends Component
    {
        public $user;
        public $postTypes = [];
        
        public function mount($user) {
            $this->user = $user;
            $this->postTypes = [
                [
                    'label' => 'General',
                    'icon' => 'HeartIcon',
                    'selected' => true
                ],
                [
                    'label' => 'Announcement',
                    'icon' => 'HeartIcon'
                ],
            ];
        }

        public function render()
        {
            return view('social::livewire.new-post-box');
        }

    }
