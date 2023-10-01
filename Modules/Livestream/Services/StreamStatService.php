<?php

namespace Modules\Livestream\Services;

use Carbon\Carbon;
use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use KeenIO\Client\KeenIOClient;
use Modules\Livestream\Exceptions\LivestreamAccountIdNotFoundException;
use Modules\Livestream\Omnia;

/**
 * Class StreamStatService
 */
class StreamStatService extends StatService
{
    /**
     * Post Standard Stats to Analytics
     */
    public function postStandardStats($livestream_account_id = null)
    {
        try {
            $this->postStorageStats($livestream_account_id);
            Log::info('Livestream Storage Stats Posted to Analytics Service');
            //			$this->postBandwidthStats();
            //			Log::info( 'Livestream Bandwith Stats Posted to Analytics Service' );
        } catch (Exception $e) {
            $msg = 'Error posting Stats: ' . $e->getMessage();
            Log::info($msg);
            throw new Exception($msg);
        }
    }

    /**
     * @param null $livestream_account_id
     */
    public function postStorageStats($livestream_account_id = null)
    {
        Log::info('Starting to post Livestream Storage Stats to Analytics Service');

        $storage = Storage::disk(config('livestream.default_vod_disk'));
        $livestream_video_storage_events = collect();
        $totalStorageSize = 0;
        if (!is_null($livestream_account_id)) {
            // Get total size for only the given directory/account
            Artisan::call('livestream-get-storage-size', ['livestream_account_id' => $livestream_account_id],
                $totalStorageSize);
            $livestream_video_storage_events->push([
                'livestream_video_storage_events' => (float)$livestream_account_id,
                'total_size' => (float)$totalStorageSize,
            ]);
        } else {
            // Get sizes for all directories/accounts
            $allDirectories = $storage->directories('/');
            foreach ($allDirectories as $accountDirectory) {
                Artisan::call('livestream-get-storage-size', ['livestream_account_id' => $accountDirectory],
                    $totalStorageSize);
                $livestream_video_storage_events->push([
                    'account_id' => (int)$accountDirectory,
                    'total_size' => (float)$totalStorageSize,
                ]);
            }
        }

        $result = $this->postEventsToService(['livestream_video_storage' => $livestream_video_storage_events]);

        Log::info('Finished posting Livestream Storage Stats to Analytics Service');

        return $result;
    }

    /**
     * Post Events to Analytics Service
     */
    public function postEventsToService($eventsData)
    {
        return $this->_analytics_service->addEvents($eventsData);
    }

    /**
     * Get Latest Stats for Livestream Account by Type, or Get all Types by default
     *
     * @param null $livestream_account_id
     * @param string $type storage, playback_live, playback_vod, stream_live
     * @return Collection
     *
     * @throws Exception
     */
    public function getLatestStatByType($livestream_account_id = null, $type = 'all')
    {
        Log::info('Starting to retrieve Latest Stats by type: ' . $type);

        try {
            if (!empty($livestream_account_id) && auth()->user()) {
                $livestream_account_id = auth()->user()->currentTeam()->LivestreamAccount->id;
            }

            if (empty($livestream_account_id)) {
                throw new Exception('Need to have a Livestream Account Id to run stat query');
            }

            $statCollection = collect();

            switch ($type) {
                case 'all':
                    $video_storage = $this->getVideoStorageEvents($livestream_account_id);
                    if ($video_storage->isNotEmpty()) {
                        $statCollection->put('video_storage', $video_storage);
                    }
                    //					$statCollection->put('playback_live', $this->getLivePlaybackBandwidthEvents($livestream_account_id));
                    //					$statCollection->put('stream_live', $this->getLivestreamBandwidthEvents($livestream_account_id));
                    //					$statCollection->put('playback_vod', $this->getVodPlaybackBandwidthEvents($livestream_account_id));
                    break;
                case 'storage':
                    if (!empty($video_storage = $this->getVideoStorageEvents($livestream_account_id))) {
                        $statCollection->put('video_storage', $video_storage);
                    }
                    break;
                case 'playback_live':
                    if (!empty($playback_live = $this->getLivestreamBandwidthEvents($livestream_account_id))) {
                        $statCollection->put('playback_live', $playback_live);
                    }
                    break;
                case 'playback_vod':
                    if (!empty($playback_vod = $this->getLivestreamBandwidthEvents($livestream_account_id))) {
                        $statCollection->put('playback_vod', $playback_vod);
                    }
                    break;
                case 'stream_live':
                    if (!empty($stream_live = $this->getLivestreamBandwidthEvents($livestream_account_id))) {
                        $statCollection->put('stream_live', $stream_live);
                    }
                    break;
            }
            Log::info('Finished retrieving Latest Stats');

            return $statCollection;
        } catch (Exception $e) {
            $msg = 'Error retrieving Latest Stats: ' . $e->getMessage();
            Log::info($msg);
            throw new Exception($msg, $e->getCode(), $e);
        }
    }

    /**
     * Get the Video Storage Event Data for given account
     *
     *
     * @return Collection
     *
     * @throws Exception
     */
    public function getVideoStorageEvents($livestream_account_id = null)
    {
        $cachedId = 'stats_vod_storage-' . $livestream_account_id;
        if ($cache = Cache::get($cachedId)) {
            return $cache;
        }

        if (empty($livestream_account_id)) {
            if (auth()->check()) {
                $livestream_account_id = auth()->user()->currentTeam()->LivestreamAccount->id;
            } else {
                throw new LivestreamAccountIdNotFoundException('Cannot run query: ' . __FUNCTION__);
            }
        }
        $eventCollection = 'livestream_video_storage';
        $parameters = [
            'timeframe' => 'this_1_month',
            'filters' => [
                [
                    'property_name' => 'account_id',
                    'operator' => 'eq',
                    'property_value' => $livestream_account_id,
                ],
            ],
            'property_names' => ['total_size', 'account_id', 'keen.created_at'],
        ];

//        $keen = KeenIOClient::factory([
//            'projectId' => env('KEEN_PROJECT_ID'),
//            'masterKey' => env('KEEN_MASTER_KEY'),
//            'writeKey'  => env('KEEN_WRITE_KEY'),
//            'readKey'   => env('KEEN_READ_KEY')
//        ]);
        //		$queryResponse = collect($keen->extraction($eventCollection,$parameters)['result']);
//
//        $eventsData = $queryResponse->where('account_id','=',$livestream_account_id);
        //		 Get Extraction for this livestream_account_id
        //		$queryResponse = $this->_extraction($eventCollection,$parameters);
        //		$eventsData = collect($queryResponse->result);

        $parameters['event_collection'] = $eventCollection;

        $ch = curl_init();

        $options = [
            CURLOPT_URL => 'https://api.keen.io/3.0/projects/' . env('KEEN_PROJECT_ID') . '/queries/extraction',
            CURLOPT_HEADER => false,
            CURLOPT_POSTFIELDS => json_encode($parameters),
            CURLOPT_HTTPHEADER => ['Content-Type: application/json', 'Authorization:' . env('KEEN_READ_KEY')],
            CURLOPT_RETURNTRANSFER => true,
        ];

        curl_setopt_array($ch, $options);

        $result = curl_exec($ch);
        curl_close($ch);

        $eventsData = collect(json_decode($result)->result);
        $eventsDataCollection = collect();
        //		 Setup EventsData and Sort by Created_At to get the Most Recent Data Last
        if ($eventsData->isNotEmpty()) {
            foreach ($eventsData as $eventData) {
                //				$created_at = new Carbon($eventData->keen->created_at);
                //				$eventData->created_at = $created_at->toDateTimeString();
                $eventData->created_at = $eventData->keen->created_at;
                unset($eventData->keen);
            }
            $eventsDataCollection = $eventsData->sortBy('created_at');
        }
        // Store in Cache 60 Minutes / 1 hour to reduce calls to Analytics Service
        Cache::put($cachedId, $eventsDataCollection, 60);

        return $eventsDataCollection;
    }

    /**
     * Get the Live Playback for given account
     *
     *
     * @return int
     */
    public function getLivestreamBandwidthEvents($livestream_account_id = null)
    {
        $cachedId = 'stats_live_stream_bandwidth';
        if ($cache = Cache::get($cachedId)) {
            return $cache;
        }
        $eventCollection = 'livestream_live_bandwidth_streams';
        $parameters = collect([
            'timeframe' => 'this_1_month',
            'target_property' => 'data_usage',
            'filters' => [
                'property_name' => 'account_id',
                'operator' => 'eq',
                'property_value' => $livestream_account_id,
            ],
        ]);
        // Get Extraction for this livestream_account_id
        $queryResponse = $this->_sum($eventCollection, $parameters);
        $eventsData = collect($queryResponse->result);
        $eventsDataCollection = collect();
        // Setup EventsData and Sort by Created_At to get the Most Recent Data Last
        if ($eventsData->isNotEmpty()) {
            foreach ($eventsData as $eventData) {
                $created_at = new Carbon($eventData->keen->created_at);
                $eventData->created_at = $created_at->toDateTimeString();
                unset($eventData->keen);
            }
            $eventsData = $eventsData->sortBy('created_at');
            $eventsDataCollection = $eventsData->values();
        }

        // Store in Cache 30 Minutes to reduce calls to Analytics Service
        Cache::put($cachedId, $eventsDataCollection, 30);

        return $eventsDataCollection;

        //		if (!empty($livestream_account_id) && Auth::check()) {
        //			$livestream_account_id = Auth::user()->currentTeam()->LivestreamAccount->id;
        //		}
        //		$collection = collect($this->getSavedQuery('livestream-live-bandwidth-streams-total')->result);
        //		// Get all accounts, group by account_id
        //		$accounts = $collection->groupBy('account_id');
        //		// Get data for this livestream_account
        //		$account = $accounts->get($livestream_account_id);
        //		// Sort by Latest Events first
        //		$latestVideoStorageEvent = $account->sortByDesc( function($item) {
        //			return $item->keen->timestamp;
        //		})->first();
//
        //		return Omnia::formatBytes($latestVideoStorageEvent->total_size);
    }

    /**
     * Post Bandwidth Stats as events to Analytics Service
     */
    public function postBandwidthStats()
    {
        Log::info('Starting to post Livestream Bandwidth Stats to Analytics Service');

        $unPublishEventData = $this->getPublishEvents('unpublish', null, null, true);
        $livePlaybackData = $this->getPlaybackEvents('live', 'stop', null, true);
        $vodPlaybackData = $this->getPlaybackEvents('vod', 'stop', null, true);

        $this->postEventsToService([
            'livestream_live_bandwidth_streams' => $unPublishEventData,
            'livestream_live_bandwidth_playback' => $livePlaybackData,
            'livestream_vod_bandwidth_playback' => $vodPlaybackData,
        ]);

        Log::info('Finished posting Livestream Bandwidth Stats to Analytics Service');
    }

    /**
     * @param string $event_type
     * @param null $app_name
     * @param bool $deleteRecords if true deletes the records that it pulls from the DB
     * @return array
     *
     * @throws Exception
     *
     * @internal param null $app_type live or vod
     * @internal param null $app_name
     */
    public function getPublishEvents(
        $event_type = 'unpublish',
        $livestream_account_id = null,
        $app_name = null,
        $deleteRecords = false
    ) {
        try {
            Log::info('Starting to retrieving Publish Events');
            $unpublishData = $this->getEventsFromWowza($event_type, $livestream_account_id, $app_name, $deleteRecords);
            $publishEvents = [];

            foreach ($unpublishData as $dataRow) {
                $datetime = new Carbon($dataRow->date . ' ' . $dataRow->time, $dataRow->tz);
                $publishEvents[] = [
                    'event_type' => $dataRow->xevent,
                    'account_id' => (int)$dataRow->xappinst,
                    'data_usage' => (int)$dataRow->csstreambytes,
                    'timestamp' => $datetime->timestamp,
                ];
            }
            Log::info('Starting to retrieving Publish Events');

            return $publishEvents;
        } catch (Exception $e) {
            $msg = 'Error retrieving Latest Stats: ' . $e->getMessage();
            Log::info($msg);
            throw new Exception($msg);
        }
    }

    /**
     * @param null $event_type
     * @param null $livestream_account_id
     * @param null $app_name
     * @param bool $deleteRecords if true deletes the records that it pulls from the DB
     *
     * @throws Exception
     *
     * @internal param null $app_type live or vod
     */
    public function getEventsFromWowza(
        $event_type = null,
        $livestream_account_id = null,
        $app_name = null,
        $deleteRecords = false
    ) {
        Log::info('Starting to retrieve Events from Wowza');
        $db = DB::connection(env('WOWZADB_DATABASE'));
        $table = env('WOWZADB_STAT_TABLE');
        $db->beginTransaction();

        try {
            $query = 'select * from ' . $table . " where xcategory = 'stream' and xctx NOT LIKE '%trans%'";

            // Check for event type
            (!is_null($event_type)) ? $query .= " and xevent = '{$event_type}'" : '';

            // Check for livestream account id
            (!is_null($livestream_account_id)) ? $query .= " and xappinst = {$livestream_account_id}" : '';

            // Check for app name
            (!is_null($app_name)) ? $query .= " and xapp like '%{$app_name}%'" : '';

            $eventData = $db->select($query);

            if ($deleteRecords === true) {
                foreach ($eventData as $row) {
                    $db->delete('delete from ' . $table . ' where logid = ' . $row->logid);
                }
            }
        } catch (Exception $e) {
            $db->rollback();
            Log::info('Failed to retrieve Events from Wowza: ' . $e->getMessage());
            throw new Exception($e->getMessage());
        }

        $db->commit();
        Log::info('Finished retrieving Events from Wowza');

        return $eventData;
    }

    /**
     * @param string $event_type
     * @param null $app_type either live or vod
     * @param bool $deleteRecords if true deletes the records that it pulls from the DB
     * @return array
     *
     * @internal param null $app_name usually either live or vods3
     */
    public function getPlaybackEvents(
        $app_type = null,
        $event_type = 'stop',
        $livestream_account_id = null,
        $deleteRecords = false
    ) {
        Log::info('Starting to retrieving Playback Events');
        $playbackData = $this->getEventsFromWowza($event_type, $livestream_account_id, $app_type, $deleteRecords);
        $playbackEvents = [];

        foreach ($playbackData as $dataRow) {
            $datetime = new Carbon($dataRow->date . ' ' . $dataRow->time, $dataRow->tz);
            $playbackEvents[] = [
                'event_type' => $dataRow->xevent,
                'account_id' => (int)$dataRow->xappinst,
                'data_usage' => (int)$dataRow->scstreambytes,
                'timestamp' => $datetime->timestamp,
                'view_type' => $app_type,
            ];
        }
        Log::info('Finished retrieving Playback Events');

        return $playbackEvents;
    }

    /**
     * Get Total Size of given files from Storage
     *
     *
     * @return int
     */
    public function getTotalSizeOfFiles($storage, $files)
    {
        $totalStorageSize = 0;
        foreach ($files as $file) {
            $totalStorageSize = $totalStorageSize + $storage->size($file);
        }

        return $totalStorageSize;
    }

    /**
     * Get Named Saved Query from Analytics Service
     */
    public function getSavedQuery($saved_query_name)
    {
        return $this->_analytics_service->getSavedQueryResults(['query_name' => $saved_query_name]);
    }

    /**
     * Get the Live Playback for given account
     *
     *
     * @return int
     */
    public function getLivePlaybackBandwidthEvents($livestream_account_id = null)
    {
        $cachedId = 'stats_live_playback_bandwidth';
        if ($cache = Cache::get($cachedId)) {
            return $cache;
        }
        $eventCollection = 'livestream_live_bandwidth_playback';
        $parameters = collect([
            'timeframe' => 'this_1_month',
            'target_property' => 'data_usage',
            'filters' => [
                'property_name' => 'account_id',
                'operator' => 'eq',
                'property_value' => $livestream_account_id,
            ],
            'property_names',
        ]);
        // Get Extraction for this livestream_account_id
        $queryResponse = $this->_extraction($eventCollection, $parameters);
        $eventsData = collect($queryResponse->result);
        $eventsDataCollection = collect();
        // Setup EventsData and Sort by Created_At to get the Most Recent Data Last
        if ($eventsData->isNotEmpty()) {
            foreach ($eventsData as $eventData) {
                $created_at = new Carbon($eventData->keen->created_at);
                $eventData->created_at = $created_at->toDateTimeString();
                unset($eventData->keen);
            }
            $eventsData = $eventsData->sortBy('created_at');
            $eventsDataCollection = $eventsData->values();
        }

        // Store in Cache 30 Minutes to reduce calls to Analytics Service
        Cache::put($cachedId, $eventsDataCollection, 30);

        return $eventsDataCollection;

        //		if (!empty($livestream_account_id) && Auth::check()) {
        //			$livestream_account_id = Auth::user()->currentTeam()->LivestreamAccount->id;
        //		}
        //		$collection = collect($this->getSavedQuery('livestream-live-bandwidth-playback-total')->result);
        //		// Get all accounts, group by account_id
        //		$accounts = $collection->groupBy('account_id');
        //		// Get data for this livestream_account
        //		$account = $accounts->get($livestream_account_id);
        //		// Sort by Latest Events first
        //		$latestVideoStorageEvent = $account->sortByDesc( function($item) {
        //			return $item->keen->timestamp;
        //		})->first();
//
        //		return Omnia::formatBytes($latestVideoStorageEvent->total_size);
    }

    /**
     * Get the Live Playback for given account
     *
     *
     * @return int
     */
    public function getVodPlaybackBandwidthEvents($livestream_account_id = null)
    {
        $cachedId = 'stats_live_playback_bandwidth';
        if ($cache = Cache::get($cachedId)) {
            return $cache;
        }

        $eventsDataCollection = collect();

        Cache::put($cachedId, $eventsDataCollection, 30);

        //		if (!empty($livestream_account_id) && Auth::check()) {
        //			$livestream_account_id = Auth::user()->currentTeam()->LivestreamAccount->id;
        //		}
        //		$collection = collect($this->getSavedQuery('livestream-vod-bandwidth-playback-total')->result);
        //		// Get all accounts, group by account_id
        //		$accounts = $collection->groupBy('account_id');
        //		// Get data for this livestream_account
        //		$account = $accounts->get($livestream_account_id);
        //		// Sort by Latest Events first
        //		$latestVideoStorageEvent = $account->sortByDesc( function($item) {
        //			return $item->keen->timestamp;
        //		})->first();
//
        //		return Omnia::formatBytes($latestVideoStorageEvent->total_size);
    }
}
