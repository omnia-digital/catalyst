<?php

namespace Modules\Social\Models;

use Illuminate\Database\Eloquent\Model;

class FeedCategories extends Model
{
    use \Sushi\Sushi;

    /**
     * @var (int|string)[][]
     *
     * @psalm-var array{0: array{id: 0, name: 'my-feed', label: 'My Feed'}, 1: array{id: 1, name: 'top-teams', label: 'Top Teams'}, 2: array{id: 2, name: 'newest', label: 'Newest'}, 3: array{id: 3, name: 'favorites', label: 'Favorites'}, 4: array{id: 4, name: 'undiscovered', label: 'Undiscovered'}}
     */
    protected $rows = [
        [
            'id' => 0,
            'name' => 'my-feed',
            'label' => 'My Feed',
        ],
        [
            'id' => 1,
            'name' => 'top-teams',
            'label' => 'Top Teams',
        ],
        [
            'id' => 2,
            'name' => 'newest',
            'label' => 'Newest',
        ],
        [
            'id' => 3,
            'name' => 'favorites',
            'label' => 'Favorites',
        ],
        [
            'id' => 4,
            'name' => 'undiscovered',
            'label' => 'Undiscovered',
        ],
    ];
}
