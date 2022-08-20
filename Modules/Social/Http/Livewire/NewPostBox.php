<?php

    namespace Modules\Social\Http\Livewire;

    use App\Models\User;
    use Livewire\Component;
use Modules\Social\Models\Post;

    class NewPostBox extends Component
    {


        /**
         * @var (null|string)[][]
         *
         * @psalm-var array{0?: array{name: 'Excited', value: 'excited', icon: 'heroicon-o-fire', iconColor: 'text-light-text-color', bgColor: 'bg-red-500'}, 1?: array{name: 'Loved', value: 'loved', icon: 'heroicon-o-heart', iconColor: 'text-light-text-color', bgColor: 'bg-pink-400'}, 2?: array{name: 'Happy', value: 'happy', icon: 'heroicon-o-emoji-happy', iconColor: 'text-light-text-color', bgColor: 'bg-green-400'}, 3?: array{name: 'Sad', value: 'sad', icon: 'heroicon-o-emoji-sad', iconColor: 'text-light-text-color', bgColor: 'bg-yellow-400'}, 4?: array{name: 'Thumbsy', value: 'thumbsy', icon: 'heroicon-o-thumb-up', iconColor: 'text-light-text-color', bgColor: 'bg-secondary'}, 5?: array{name: 'I feel nothing', value: null, icon: 'heroicon-o-x', iconColor: 'text-light-text-color', bgColor: 'bg-transparent'}}
         */
        public array $moods = [];

        /**
         * @var (null|string)[]|null
         *
         * @psalm-var array{name: 'I feel nothing', value: null, icon: 'heroicon-o-x', iconColor: 'text-light-text-color', bgColor: 'bg-transparent'}|null
         */
         public $body;

        public $parentPostID;


        /**
         * @var string[]
         *
         * @psalm-var array{0: 'filesAdded'}
         */
        protected array $listeners = ['filesAdded'];

        /**
         * @var string[]
         *
         * @psalm-var array{body: 'required|min:6'}
         */
        protected array $rules = [
            'body' => 'required|min:6',
        ];

    }
