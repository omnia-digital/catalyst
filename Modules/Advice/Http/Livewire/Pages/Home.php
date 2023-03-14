<?php

namespace Modules\Advice\Http\Livewire\Pages;

use App\Support\Platform\WithGuestAccess;
use Livewire\Component;
use Livewire\WithPagination;
use Modules\Jobs\Models\JobPosition;
use Modules\Jobs\Traits\WithSortAndFilters;
use Modules\Social\Models\Post;
use OmniaDigital\OmniaLibrary\Livewire\WithCachedRows;

class Home extends Component
{
    use WithPagination, WithCachedRows, WithSortAndFilters, WithGuestAccess;

    public $perPage = 25;
    public $loadMoreCount = 25;

    public array $sortLabels = [
        'title' => 'title',
    ];

    public string $dateColumn = 'created_at';

    public function render()
    {
        $questions = Post::with(['company', 'tags', 'addons'])
                           ->latest()
                           ->get();


        return view('advice::livewire.pages.questions.index',[
                    'questions'         => $questions,
        ]);
    }
}
