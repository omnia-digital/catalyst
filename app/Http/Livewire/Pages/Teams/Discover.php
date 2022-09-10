<?php

namespace App\Http\Livewire\Pages\Teams;

use App\Actions\Teams\GetCuratedTeamsAction;
use App\Actions\Teams\GetFeaturedTeamsAction;
use App\Actions\Teams\GetPopularIndiesTeamsAction;
use App\Actions\Teams\GetPopularUpcomingTeamsAction;
use App\Actions\Teams\GetTeamCategoriesAction;
use App\Actions\Teams\GetTrendingTeamsAction;
use App\Lenses\Teams\NewReleaseTeamsLens;
use App\Support\Feed\FeedItem;
use App\Support\Feed\PolygonFeedItem;
use Livewire\Component;
use Vedmant\FeedReader\Facades\FeedReader;

class Discover extends Component
{
    private array $feedClasses = [
        'ign'   => FeedItem::class,
    ];

    public function getNewsFeedsProperty()
    {
        $feeds = collect();
        $feeds->push($this->getFeed('https://feeds.feedburner.com/ign/all'));
        $feeds->push($this->getFeed('https://www.gamespot.com/feeds/game-news'));
        $feeds->push($this->getFeed('https://kotaku.com/rss'));
        $feeds->push($this->getFeed('http://feeds.feedburner.com/thatvideogameblog'));
        $feeds->push($this->getFeed('http://www.polygon.com/rss/index.xml', 'polygon'));
        $feeds->push($this->getFeed('https://www.rockpapershotgun.com/feed/'));
        $feeds->push($this->getFeed('https://www.gameinformer.com/feeds/thefeedrss.aspx'));
        $feeds->push($this->getFeed('https://news.xbox.com/en-us/feed/'));
        $feeds->push($this->getFeed('https://www.pcgamer.com/rss/'));
        $feeds->push($this->getFeed('https://www.engadget.com/gaming'));
        $feeds->push($this->getFeed('https://www.giantbomb.com/feeds/reviews/'));
        $feeds->push($this->getFeed('http://nintendoeverything.com/feed'));
        $feeds->push($this->getFeed('https://www.gamedeveloper.com/rss.xml'));
        $feeds->push($this->getFeed('http://rss.indiedb.com/headlines/feed/rss.xml'));
        $feeds->push($this->getFeed('https://www.playstationlifestyle.net/feed/'));
        $feeds->push($this->getFeed('https://www.indieretronews.com/feeds/posts/default?alt=rss'));

        $feeds->push($this->getFeed('http://indiegamesplus.com/feed'));
        $feeds->push($this->getFeed('https://www.indiegamebundles.com/feed/'));
        $feeds->push($this->getFeed('https://www.alphabetagamer.com/category/indie/feed'));
        $feeds->push($this->getFeed('https://itch.io/blog.rss'));
        $feeds->push($this->getFeed('https://forums.tigsource.com/index.php?PHPSESSID=8f88e3e908823b3ff5a3306b19a423c9&type=rss;action=.xml'));
        $feeds->push($this->getFeed('https://indiegamereviewer.com/feed/'));
        $feeds->push($this->getFeed('https://indiecator.org/feed/'));
        $feeds->push($this->getFeed('https://ind13.com/feed/'));
        $feeds->push($this->getFeed('https://warpdoor.com/rss/'));
        $feeds->push($this->getFeed('https://octocurio.com/feed/'));

        return $feeds;
    }

    public function getYoutubeFeedsProperty()
    {
        $feeds = collect();
        $feeds->push($this->getFeed('https://www.youtube.com/c/gameedged'));
        return $feeds;
    }

    public function getTwitchFeedsProperty()
    {
        $feeds = collect();
        $feeds->push($this->getFeed('https://twitchrss.appspot.com/vod/cohhcarnage'));
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

    public function getCategoriesProperty()
    {
        return (new GetTeamCategoriesAction)->execute();
    }

    public function getCuratedTeamsProperty()
    {
        return (new GetCuratedTeamsAction)->execute();
    }

    public function getPopularIndiesTeamsProperty()
    {
        return (new GetPopularIndiesTeamsAction)->execute();
    }

    public function getPopularUpcomingTeamsProperty()
    {
        return (new GetPopularUpcomingTeamsAction)->execute();
    }

    public function getFeaturedTeamsProperty()
    {
        return (new GetFeaturedTeamsAction)->execute();
    }

    public function getTrendingTeamsProperty()
    {
        return (new GetTrendingTeamsAction)->execute();
    }

    public function render()
    {
        return view('livewire.pages.teams.discover', [
            'featuredTeams' => $this->featuredTeams,
            'trendingTeams' => $this->trendingTeams,
            'categories' => $this->categories,
            'curatedTeams' => $this->curatedTeams,
            'popularIndiesTeams' => $this->popularIndiesTeams,
            'popularUpcomingTeams' => $this->popularUpcomingTeams,
//            'newsFeeds' => $this->newsFeeds,
//            'youtubeFeeds' => $this->youtubeFeeds,
//            'twitchFeeds' => $this->twitchFeeds,
        ]);
    }
}
