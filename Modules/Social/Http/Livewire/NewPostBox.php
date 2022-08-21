<?php

    namespace Modules\Social\Http\Livewire;

    use App\Models\User;
    use Livewire\Component;
use Modules\Social\Models\Post;

    class NewPostBox extends Component
    {


        /**
         * @var (null|string)[]|null
         *
         * @psalm-var array{name: 'I feel nothing', value: null, icon: 'heroicon-o-x', iconColor: 'text-light-text-color', bgColor: 'bg-transparent'}|null
         */
         public $body;


        /**
         * @var string[]
         *
         * @psalm-var array{0: 'filesAdded'}
         */
        protected $listeners = ['filesAdded'];

        /**
         * @var string[]
         *
         * @psalm-var array{body: 'required|min:6'}
         */
        protected $rules = [
            'body' => 'required|min:6',
        ];

    }
