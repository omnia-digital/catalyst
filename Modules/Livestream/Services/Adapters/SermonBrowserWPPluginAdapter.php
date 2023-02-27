<?php

namespace App\Services\Adapters;

use Illuminate\Support\Facades\Log;
use App\Events\Episode\ImportRssEpisodeAddedToQueue;
use App\Jobs\Videos\importRemoteMP4FilesToVodAndCreateEpisodes;
use willvincent\Feeds\Facades\FeedsFacade;

/**
 * Class SermonBrowserWPPluginAdapter
 * @package App\Services\Adapters
 */
class SermonBrowserWPPluginAdapter
{

    /**
     * @param $type
     * @param $params
     */
    public function import($type, $params)
    {
        $method = '_importVia' . ucfirst($type);
        return $this->{$method}($params);
    }

    /**
     * @param $type
     * @param $params
     */
    public function export($type, $params)
    {

    }

    /**
     * @param $params
     */
    private function _importViaRss($params)
    {
//        $rss_feed_path = 'http://api.omnia-app.dev/greatbibletruthsfeed.xml';
        $rss_feed_path = $params['import_path'];

        // parse through the rss file
        Log::info('[START - ' . __FUNCTION__ . ' ]');
        $feed = FeedsFacade::make($rss_feed_path);
        $items = $feed->get_items();
        foreach ($items as $item) {
            $episode = new Episode();
            $episode->title = $item->get_title();
            $episode->description = $item->get_description();
            $date = new Carbon($item->get_gmdate());
            $episode->date_recorded = $date->timestamp;
//            $thumbnail = $item->get_thumbnail();
//            $authors = collect();
//            $authors->push($item->get_authors());
//            $authors = $item->get_authors();
            $enclosures = $item->get_enclosures();
            $videoUrls = collect();
            foreach ($enclosures as $enclosure) {
                $videoUrls->push($enclosure->link);
            }
            if (!empty($params['livestream_account_id'])) {
                $episode->livestream_account_id = $params['livestream_account_id'];
            } else {
                throw new Exception(' We do not know which Livestream Account to import into. Please provide a livestream_account_id.');
            }
            $videoProcessorQueueName = config('livestream_queue.queue-names.videoProcessor-low');
            $job = (new importRemoteMP4FilesToVodAndCreateEpisodes( $episode, $videoUrls ))->onQueue($videoProcessorQueueName);
            dispatch($job);
            event(new importRSSEpisodeAddedToQueue($this->episode,$this->_livestreamAccount));
            Log::info('Import Remote Episode from RSS Job added to queue: "' . $videoProcessorQueueName);
        }
        Log::info('[END - ' . __FUNCTION__ . ' ]');
    }
}
