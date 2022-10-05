<?php

namespace Modules\Games\Http\Livewire;

use App\Support\Feed\FeedItem;
use App\Support\Feed\PolygonFeedItem;
use Livewire\Component;
use Modules\Games\Models\Game;
use Vedmant\FeedReader\Facades\FeedReader;

class Feeds extends Component
{
    private array $classes = [
        'ign'   => FeedItem::class,
    ];

    public function getAllFeedsProperty()
    {
        $feeds = collect();
        // with images
        $feeds->push(['','https://feeds.feedburner.com/ign/all']);
        $feeds->push(['','https://www.gamedeveloper.com/rss.xml']);
        $feeds->push(['','https://www.gamespot.com/feeds/game-news']);
        $feeds->push(['','https://news.xbox.com/en-us/feed/']);
        $feeds->push(['','https://www.engadget.com/gaming']);
        $feeds->push(['','https://www.giantbomb.com/feeds/reviews/']);
        $feeds->push(['','http://nintendoeverything.com/feed']);
        $feeds->push(['','http://rss.indiedb.com/news/feed/rss.xml']);
        $feeds->push(['','https://www.indieretronews.com/feeds/posts/default?alt=rss']);
        $feeds->push(['','https://indiecator.org/feed/']);
        $feeds->push(['','https://warpdoor.com/rss/']);
        $feeds->push(['','https://www.rockpapershotgun.com/feed/']);

        // image not working yet
        $feeds->push(['','http://www.polygon.com/rss/index.xml', 'polygon']);
        $feeds->push(['','https://superjoost.substack.com/feed']);
        $feeds->push(['','https://kotaku.com/rss']);
//        $feeds->push(['','http://feeds.feedburner.com/thatvideogameblog']);
        $feeds->push(['','https://www.gameinformer.com/feeds/thefeedrss.aspx']);
        $feeds->push(['','https://www.pcgamer.com/rss/']);
        $feeds->push(['','https://www.playstationlifestyle.net/feed/']);

        $feeds->push(['','http://indiegamesplus.com/feed']);
        $feeds->push(['','https://www.indiegamebundles.com/feed/']);
        $feeds->push(['','https://www.alphabetagamer.com/category/indie/feed']);
        $feeds->push(['','https://itch.io/blog.rss']);
        $feeds->push(['','https://forums.tigsource.com/index.php?PHPSESSID=8f88e3e908823b3ff5a3306b19a423c9&type=rss;action=.xml']);
        $feeds->push(['','https://indiegamereviewer.com/feed/']);
        $feeds->push(['','https://ind13.com/feed/']);
        $feeds->push(['','https://octocurio.com/feed/']);

        return $feeds;
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
        return view('games::livewire.feeds', [
            'feeds' => $this->allFeeds,
        ]);
    }
}
