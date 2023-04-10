<?php

namespace Modules\Feeds\Http\Livewire;

use App\Support\Feed\FeedItem;
use Livewire\Component;
use Modules\Feeds\Models\FeedSource;

class Feeds extends Component
{
    private array $classes = [
        'ign' => FeedItem::class,
    ];

    public function getAllFeedsProperty()
    {
        return FeedSource::pluck('url');
    }

    public function render()
    {
        return view('feeds::livewire.feeds', [
            'feeds' => $this->allFeeds,
        ]);
    }
}
