<?php

namespace Modules\Games\Http\Livewire;

use Livewire\Component;
use Modules\Games\Models\Game;
use Vedmant\FeedReader\Facades\FeedReader;

class Feeds extends Component
{
    public function getAllFeedsProperty()
    {
        $feeds = collect();
        $feeds->push(FeedReader::read('https://feeds.feedburner.com/ign/all'));
        $feeds->push(FeedReader::read('https://www.gamespot.com/feeds/game-news'));
        $feeds->push(FeedReader::read('https://kotaku.com/rss'));
        $feeds->push(FeedReader::read('http://feeds.feedburner.com/thatvideogameblog'));
        $feeds->push(FeedReader::read('http://www.polygon.com/rss/index.xml'));
        $feeds->push(FeedReader::read('https://www.rockpapershotgun.com/feed/'));
        $feeds->push(FeedReader::read('https://www.gameinformer.com/feeds/thefeedrss.aspx'));
        $feeds->push(FeedReader::read('https://news.xbox.com/en-us/feed/'));
        $feeds->push(FeedReader::read('https://www.pcgamer.com/rss/'));
        $feeds->push(FeedReader::read('https://www.engadget.com/gaming'));
        $feeds->push(FeedReader::read('https://www.giantbomb.com/feeds/reviews/'));
        $feeds->push(FeedReader::read('http://nintendoeverything.com/feed'));
        $feeds->push(FeedReader::read('https://www.gamedeveloper.com/rss.xml'));
        $feeds->push(FeedReader::read('http://rss.indiedb.com/headlines/feed/rss.xml'));
        $feeds->push(FeedReader::read('https://www.playstationlifestyle.net/feed/'));
        $feeds->push(FeedReader::read('https://www.indieretronews.com/feeds/posts/default?alt=rss'));

        $feeds->push(FeedReader::read('http://indiegamesplus.com/feed'));
        $feeds->push(FeedReader::read('https://www.indiegamebundles.com/feed/'));
        $feeds->push(FeedReader::read('https://www.alphabetagamer.com/category/indie/feed'));
        $feeds->push(FeedReader::read('https://itch.io/blog.rss'));
        $feeds->push(FeedReader::read('https://forums.tigsource.com/index.php?PHPSESSID=8f88e3e908823b3ff5a3306b19a423c9&type=rss;action=.xml'));
        $feeds->push(FeedReader::read('https://indiegamereviewer.com/feed/'));
        $feeds->push(FeedReader::read('https://indiecator.org/feed/'));
        $feeds->push(FeedReader::read('https://ind13.com/feed/'));
        $feeds->push(FeedReader::read('https://warpdoor.com/rss/'));
        $feeds->push(FeedReader::read('https://octocurio.com/feed/'));

        return $feeds;
    }

    public function render()
    {
        return view('games::livewire.feeds', [
            'feeds' => $this->allFeeds,
        ]);
    }
}
