<?php

namespace App\Services;

use App\Omnia;
use App\Services\Service;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Jenssegers\Agent\Agent;
use App\Episode;
use App\Exceptions\UnsupportedBroswerException;
use App\LivestreamAccount;
use Auth;
use App\Video;

class PlayerService extends Service
{
    /**
     * @param $collection Collection of Episodes, Videos, and/or strings that will be used to get data to create the Player Playlist item
     * @param $streamingProtocol
     * @param $includeTransVideos
     * @return string
     */
    public function getPlayerPlaylistItems($collection, $streamingProtocol, $includeTransVideos = true, $videoName = '')
    {
        $playlistItems = collect();
        foreach($collection as $item) {
            if ($item instanceof Episode) {
                $playlistItem = $this->_getPlayerPlaylistItemsFromEpisode($item, $streamingProtocol, $includeTransVideos);
                if ($playlistItem->isNotEmpty()) {
                    $playlistItems->push($playlistItem);
                }
            } else if ($item instanceof Video) {
                $playlistItems = $this->_getPlayerPlaylistItemsFromVideo($item, null, $streamingProtocol, $includeTransVideos);
                if ($playlistItem->isNotEmpty()) {
                    $playlistItems->push($playlistItem);
                }
            } else if (is_string($item)) {
                $playlistItems = $this->_getPlayerPlaylistItemFromString($item, $streamingProtocol, $includeTransVideos, $videoName);
                if ($playlistItem->isNotEmpty()) {
                    $playlistItems->push($playlistItem);
                }
            }
        }
        return $playlistItems;
    }

	/**
	 * Get Player Playlist Item(s) from one Episode
     * Returns a collection with one or more player playlist items
	 *
	 * @param $episode
	 * @param null $streamingProtocol
	 * @param bool $includeTransVideos
	 *
	 * @return Collection
	 */
    private function _getPlayerPlaylistItemsFromEpisode($episode, $streamingProtocol, $includeTransVideos)
    {
        $videos = $episode->videos;
        $videoCount = $videos->count();
        $title = $episode->title . ' - ' . $this->formatTitleDate($episode->date_recorded);

	    foreach ($videos as $key => $video) {
	        $videoTitle = $title . '(' . ($key + 1) . ' of ' . $videoCount . ')';
            $playlistItem = $this->_getPlayerPlaylistItemsFromVideo($video, $videoTitle, $streamingProtocol, $includeTransVideos);
	    }
        return $playlistItem;
    }

	/**
	 * Get Player Playlist Item(s) from one Video
     * Returns a collection with one or more player playlist items
     *
     * @param $video
	 * @param null $title
	 * @param string $streamingProtocol
	 * @param bool $includeTransVideos
	 *
	 * @return Collection
	 */
    private function _getPlayerPlaylistItemsFromVideo($video, $title = null, $streamingProtocol, $includeTransVideos = true)
    {
        // In the playlist, this is treated as an Episode object
        // this should have 'title', and 'sources'
        $episode = $video->episode;
        $base_url = $video->playback_url;

	    $playlistItems = collect();
        $playlistItems->put('title', (!empty($title) ? $title : $video->title . ((!empty($episode)) ? ' - ' . $this->formatTitleDate($episode->date_recorded) : '')) );

	    // if $streamProtocol is null, assume we want both RTMP and HTTP
	    if (is_null($streamingProtocol)) {
            $streamingProtocol = $this->getStreamingProtocolFromUserAgent();
	    }

        //** Sources **//
        $playlistItemSources = collect();
        $playlistItemSources->push($this->_getSourceFromVideo($base_url, $video, $streamingProtocol));

        // Trans Videos
        if ($includeTransVideos === true & !$video->transVideos->isEmpty()) {
            foreach ($video->transVideos as $transVideo) {
                $transSourceObject = $this->_getSourceFromTransVideo($base_url, $transVideo, $video, $streamingProtocol);
                // push Trans Vid onto Sources
                if ($transSourceObject->isNotEmpty()) {
                    $playlistItemSources->push($transSourceObject);
                }
            }
        }

        if ($playlistItemSources->isNotEmpty()) {
            $playlistItems->put('sources',$playlistItemSources);
        }
        return $playlistItems;
    }

    /**
     * Format date for Video Titles
     *
     * @param Carbon $date
     *
     * @return string
     */
    private function formatTitleDate(Carbon $date)
    {
        return $date->toFormattedDateString();
    }

    /**
     * @param $base_url
     * @param $videoObject
     * @param $streamingProtocol
     * @return Collection
     */
    private function _getSourceFromVideo($videoObject, $streamingProtocol)
    {
        $sourceObject = collect();

        // Label
        $sourceObject->put('label', $videoObject->title . (!empty($videoObject->episode) ? ' - ' . $this->formatTitleDate($videoObject->episode->date_recorded): ''));

        // File
        $file_url = '';
        if ( $streamingProtocol === 'http' ) {
            $file_url .= $videoObject->playback_url . '/jwplayer.m3u8';
        }

        $sourceObject->put('file', $file_url);

        // Image
        $imageUrl = '';
        if (!empty($thumbnail_url)) {
            $imageUrl = 'http';
            $imageUrl = $this->_getUrlProtocolFromStreamingProtocol($imageUrl);
            $imageUrl .= '://' . $thumbnail_url;
        } else {
            $imageUrl .= '//';
        }
        $sourceObject->put('image', $imageUrl);

        return $sourceObject;
	}

    /**
     * @param $base_url
     * @param $transVideo
     * @param $streamingProtocol
     * @return Collection
     */
    private function _getSourceFromTransVideo($transVideo, $videoObject, $streamingProtocol)
    {
        $transSourceObject = collect();
        $transSourceObject->put('label',$transVideo->resolution);
        $url_protocol = $this->_getUrlProtocolFromStreamingProtocol($streamingProtocol);
        $file_url = $url_protocol . $base_url . '_trans_' . $transVideo->resolution . 'p.' . $videoObject->file_type . '",';
        $transSourceObject->put('file', $file_url);
        $transSourceObject->put('image', '//' . config('livestream.default_image_not_streaming_path'));
        return $transSourceObject;
	}

    /**
     * @param $streamingProtocol
     * @return mixed|string
     */
    private function _getUrlProtocolFromStreamingProtocol($streamingProtocol)
    {
        $playback_ssl = env('WOWZA_PLAYBACK_SSL');
        if ($playback_ssl) {
            $streamingProtocol .= 's'; // add the s to the streaming protocol
        }
        return $streamingProtocol;
    }

    /**
     * Format a Collection of string objects for the JWPlayer Playlist
     *
     * @param $stringPath
     * @param null $videoName
     * @param null $streamingProtocol
     * @return Collection
     * @internal param bool $includeTransVideos
     */
    private function _getPlayerPlaylistItemFromString($stringPath, $videoName = null, $streamingProtocol = null)
    {
        $playlistItem = collect();
        if (is_string($stringPath)) {
            if (!is_null($videoName)) {
                $playlistItem->put('title',$videoName);
            }
            $file = collect();
            $file->put('label', "Standard");
            $file->put('file', $stringPath);
            $file->put('image', '//' . config('livestream.default_image_currently_not_streaming_path'));
            $playlistItem->put('file',$file);

        }
    }

	/**
	 * Create a Correctly Formatted Playlist with current Live and Vod streams
	 *
	 * @param LivestreamAccount $LivestreamAccount
	 * @param StreamService $streamService
	 *
	 * @param string $type
	 *
	 * @return string
	 */
	public function getPlayerPlaylist(LivestreamAccount $LivestreamAccount, StreamService $streamService = null, $type = 'all', $streamingProtocol = 'http')
	{
		// @TODO [Josh] - need to add 'default' to livestream items
		$playlist = collect();

		switch ($type) {
			case 'all':
                $this->_addLivePlaylistItemsToPlaylist($playlist, $LivestreamAccount, $streamService, $streamingProtocol);
                $this->_addVodPlaylistItemsToPlaylist($playlist, $LivestreamAccount, $streamingProtocol);
                break;
			case 'live':
                $this->_addLivePlaylistItemsToPlaylist($playlist, $LivestreamAccount, $streamService, $streamingProtocol);
                break;
			case 'vod':
			    $this->_addVodPlaylistItemsToPlaylist($playlist, $LivestreamAccount, $streamingProtocol);
                break;
		}

//		$playlist = $playlist->toJson();
		return $playlist;
	}

    /**
     * @param $playlist
     * @param $LivestreamAccount
     * @param $streamingProtocol
     */
    private function _addVodPlaylistItemsToPlaylist(&$playlist, $LivestreamAccount, $streamingProtocol)
    {
        $vodPlaylistItems = $this->getVodPlaylistItems($LivestreamAccount, $streamingProtocol);
        foreach($vodPlaylistItems as $item) {
            $playlist->push($item);
        }
	}

    /**
     * @param $playlist
     * @param $LivestreamAccount
     * @param $streamingProtocol
     */
    private function _addLivePlaylistItemsToPlaylist(&$playlist, $LivestreamAccount, $streamService, $streamingProtocol)
    {
        $livePlaylistItems = $this->getLivePlaylistItems($LivestreamAccount, $streamService, $streamingProtocol);
        foreach($livePlaylistItems as $item) {
            $playlist->push($item);
        }
    }

    /**
     * @param $livestreamAccount
     * @param $streamService
     * @param null $streamingProtocol
     *
     * @return string
     * @throws \Exception
     */
	public function getLivePlaylistItems( $livestreamAccount, $streamService, $streamingProtocol = null )
	{
	    try {
            Log::info(__FUNCTION__ . '[START]');
            if (is_null($streamService)) {
                $streamService = new StreamService($livestreamAccount);
            }

            if (is_null($streamingProtocol)) {
                $streamingProtocol = $this->getStreamingProtocolFromUserAgent();
            }

            $livestreamURL = $streamService->getLivestreamURL($streamingProtocol);
            $collection = collect([$livestreamURL]);
            $playlistItems = $this->getPlayerPlaylistItems($collection, $streamingProtocol);

            Log::info(__FUNCTION__ . '[END]');
            return $playlistItems;

        } catch(\Exception $e) {
            $msg = 'Could not get Live Playlist' . $e->getMessage();
            Log::error($msg);
            throw $e;
        }
	}

    /**
     * @param $livestream_account
     * @param null $streamingProtocol
     * @return Collection collection of item objects that go in the Player Playlist array
     * @throws \Exception
     */
	public function getVodPlaylistItems($livestream_account, $streamingProtocol = null)
	{
	    try {
            $allEpisodesForAccount = $livestream_account->episodes()->get()->reverse(); // reverse to put most recent episode first

            $activePlanId = $livestream_account->team->currentActivePlan()->id;

            if ($activePlanId === 'livestream-free') {
                $unlocked_episodes = $allEpisodesForAccount->take(1);
                $episodesForPlaylist = $unlocked_episodes;
            } else {
                $episodesForPlaylist = $allEpisodesForAccount;
            }

            return $this->getPlayerPlaylistItems($episodesForPlaylist, $streamingProtocol);

        } catch(\Exception $e) {
	        $msg = 'Could not get VOD Playlist' . $e->getMessage();
            Log::error($msg);
            throw $e;
        }
	}

    /**
     * @return string
     */
    public function getStreamingProtocolFromUserAgent()
    {
        $agent = new Agent();
        // Check to make sure this isn't Firefox on Android, else return an Exception message to the user and bail out
        $this->checkForFirefoxOnAndroidBrowser($agent);
        $browser = $agent->browser();

        if ($agent->isMobile() || $browser === 'Safari' ) {
            $streamingProtocol = 'http';
        } else {
            $streamingProtocol = 'http';
        }

        return $streamingProtocol;
	}

    /**
     * @param $agent
     */
    public function checkForFirefoxOnAndroidBrowser($agent)
    {
        $browser = $agent->browser();
        if ( $agent->isAndroidOS() && $browser === 'Firefox' ) {
            throw new UnsupportedBroswerException('Firefox on Android does not support playing livestream videos. Please try using another browser, such as Google Chrome for Android');
        }
	}
}
