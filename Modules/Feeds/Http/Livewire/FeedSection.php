<?php

namespace Modules\Feeds\Http\Livewire;

use App\Support\Feed\FeedItem;
use App\Support\Feed\PolygonFeedItem;
use Livewire\Component;
use Vedmant\FeedReader\Facades\FeedReader;

class FeedSection extends Component
{
    public bool $loaded = false;
    public string $feedUrl;
    public bool $showTitle = true;
    public bool $showDescription = true;
    public bool $showLinkToNewsPage = false;

    public function ready()
    {
        $this->loaded = true;
    }

    public function getFeedProperty()
    {
        return $this->getFeed($this->feedUrl);
    }

    public function getFeed($url)
    {
        // @TODO [Josh] - add check for class mapping for specific feeds
        $feed = FeedReader::read($url);

        $feed->set_item_class(FeedItem::class);

        return $feed;
    }

    public function sanitize($content)
    {
        $content = strip_tags($content);
        $content = html_entity_decode($content);
//        $content = preg_replace("/&#?[a-z0-9]{2,8};/i","",$content);
        //        $content = preg_replace('/[^A-Za-z0-9 ]+/', '', $content);
        return trim($content, ' ');
    }

    public function render()
    {
        return view('feeds::livewire.feed-section', [
            'feed' => $this->loaded ? $this->feed : null,
        ]);
    }
}
