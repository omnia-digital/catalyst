<?php

namespace Modules\Games\Http\Livewire\Components;

use App\Support\Feed\FeedItem;
use App\Support\Feed\PolygonFeedItem;
use Illuminate\Support\Collection;
use Livewire\Component;
use Modules\Games\Models\Game;
use SimplePie\SimplePie;
use Vedmant\FeedReader\Facades\FeedReader;

class FeedSection extends Component
{
    private array $typeClasses = [
        'ign'   => FeedItem::class,
    ];

    public bool $loaded = false;
    public string $feedUrl;
    public string $type;

    public function ready()
    {
        $this->loaded = true;
    }

    public function getFeedProperty()
    {
        return $this->getFeed($this->feedUrl);
    }

    public function getFeed($url, $id = null)
    {
        // @TODO [Josh] - add check for class mapping for specific feeds
        $feed = FeedReader::read($url);
        if ($id === 'polygon') {
            $feed->set_item_class(PolygonFeedItem::class);
        } else {
            $feed->set_item_class(FeedItem::class);
        }
        return $feed;
    }

    public function render()
    {
        return view('games::livewire.components.feed-section', [
            'feed' => $this->loaded ? $this->feed : null,
        ]);
    }
}
