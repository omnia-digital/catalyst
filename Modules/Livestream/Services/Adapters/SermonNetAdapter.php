<?php

namespace Modules\Livestream\Services\Adapters;

use Modules\Livestream\Http\Requests\ImportRequest;

/**
 * Class SermonNetAdapter
 */
class SermonNetAdapter
{
    /**
     * @return mixed|void
     */
    public function handleImport(ImportRequest $importRequest)
    {
        $importRssRequest = new SermonBrowserWPPluginImportRssRequest;
        $importRssRequest->rss_feed_path = $rss_feed_path;

        // if $import_type is episodes, call the import Episodes method
        // This will allow other functionality in the future in case we want to import other types of information

        $result = $hostingProviderRssImportAdapter->handle($importRssRequest);

        $this->_importEpisodesViaRss($feed_path);
    }

    private function _importViaRss()
    {
        // parse through the rss file
        Log::info('[START - ' . __FUNCTION__ . ' ]');
        $rss_feed_path = $rssImportRequest->rss_feed_path;
        $feed = FeedsFacade::make($rss_feed_path);
        $items = $feed->get_items();
        foreach ($items as $item) {
            $episode = new Episode;
            $episode->title = $item->get_title();
            $episode->description = $item->get_description();
            $date = new Carbon($item->get_gmdate());
            $episode->date_recorded = $date->timestamp;
//            $thumbnail = $item->get_thumbnail();
//            $authors = collect();
//            $authors->push($item->get_authors());
//            $authors = $item->get_authors();
            $enclosures = $item->get_enclosures();
            foreach ($enclosures as $enclosure) {
                $videoUrls = collect($enclosure->link);
            }
            if (!empty($this->_livestreamAccount)) {
                $episode->livestream_account_id = $this->_livestreamAccount->id;
            }
            $this->episode = $episode;
            $this->_vodStorageName = config('livestream.default_vod_disk');
            $videoProcessorQueueName = config('livestream_queue.queue-names.videoProcessor-low');
            $job = (new importRemoteMP4FilesToVodAndCreateEpisodes($this))->onQueue($videoProcessorQueueName);
            $job->videoUrls = $videoUrls;
            dispatch($job);
            event(new importRSSEpisodeAddedToQueue($this->episode, $this->_livestreamAccount));
            Log::info('Import Remote Episode from RSS Job added to queue: "' . $videoProcessorQueueName);
        }
        Log::info('[END - ' . __FUNCTION__ . ' ]');
    }
}
