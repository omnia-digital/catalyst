<?php

namespace Modules\Social\Http\Livewire;

use Illuminate\Validation\Validator;
use Livewire\Component;
use Modules\Social\Actions\CreateNewPostAction;
use Modules\Social\Models\Post;
use Modules\Social\Support\Livewire\WithPostEditor;
use OmniaDigital\OmniaLibrary\Livewire\WithValidationFails;

class Home extends Component
{
    use WithValidationFails, WithPostEditor;

    public $recentlyAddedPost;

    public $tabs = [];

    public $activities = [];

    public $questions = [];

    public ?string $content = null;

    public string $orderBy = 'created_at';

    protected $listeners = [
        'postAdded'             => '$refresh',
        'post-editor:submitted' => 'createPost'
    ];

    public function postAdded(Post $post)
    {
        $this->recentlyAddedPost = $post;
    }

    public function mount()
    {
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

    public function createPost($data)
    {
        $this->content = strip_tags($data['content']);

        $this->whenFails(fn(Validator $validator) => $this->emitPostValidated($validator))
            ->validate(['content' => ['required']]);

        (new CreateNewPostAction)->execute($data['content']);

        $this->emitPostSaved();
    }

    public function getPostsProperty()
    {
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
