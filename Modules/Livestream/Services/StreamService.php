<?php

namespace Modules\Livestream\Services;

    use Exception;
    use Illuminate\Http\Request;
    use Illuminate\Support\Collection;
    use Illuminate\Support\Facades\Log;
    use Livestream\Livestream;
    use Modules\Livestream\Exceptions\LivestreamAccountIdNotFoundException;
    use Modules\Livestream\LivestreamAccount;
    use Modules\Livestream\Player;
    use Modules\Livestream\WowzaMediaServer;
    use Modules\Livestream\WowzaVhost;
use SimpleXMLElement;

    class StreamService extends Service
    {
        private $_livestreamAccount;
        private $_player;
        private $_streamType = 'all';

        private $_live_instances;
        private $_lastInstanceGrabTime;

        /**
         * StreamService constructor.
         *
         * @param  null  $streamType
         */
        public function __construct(LivestreamAccount $livestreamAccount, $player = null, $streamType = null)
        {
            $this->_livestreamAccount = $livestreamAccount;
            $this->_player = $player;
            if (! is_null($streamType)) {
                $this->_streamType = $streamType;
            }
        }

        /**
         * Get Live Instances for given Account
         *
         *
         * @return Collection
         *
         * @throws Exception
         */
        public function getAccountLiveInstances($accountId = null)
        {
            try {
                Log::info('[START] - ' . __FUNCTION__);

                $allLiveInstances = $this->getAllLiveInstances();
                if ($allLiveInstances->isEmpty()) {
                    return $allLiveInstances;
                }

                $accountId = $this->getAccountId($accountId);
                Log::info('Attempt to retrieve Live Instances for account: ' . $accountId);

                $accountLiveInstances = collect();

                if ($allLiveInstances->count() > 1) {
                    foreach ($allLiveInstances as $instance) {
                        if ($this->isCorrectAccountForInstance($instance, $accountId) === true) {
                            $accountLiveInstances->push($instance);
                        }
                    }
                } else {
                    if ($this->isCorrectAccountForInstance($allLiveInstances->first(), $accountId) === true) {
                        $accountLiveInstances->push($allLiveInstances->first());
                    }
                }
                Log::info('[END] - ' . __FUNCTION__);

                return $accountLiveInstances;
            } catch (Exception $e) {
                throw new Exception('Could not get Account Live Instances: ' . $e->getMessage());
            }
        }

        /**
         * Get All Live Instances currently being streamed
         *
         * @return Collection
         *
         * @throws Exception
         */
        public function getAllLiveInstances()
        {
            Log::info('[START] - ' . __FUNCTION__);
            $instanceCollection = collect();
            try {
                // only grab live instances every second
                if (! empty($this->_lastInstanceGrabTime)
                    && (now()->diffInSeconds($this->_lastInstanceGrabTime) < 3)
                    && ! empty($this->_live_instances)) {
                    return $this->_live_instances;
                }
                $this->_lastInstanceGrabTime = now();

                // pull up the playlists assigned to this player, so we can check which live streams we care about
                //        $playlists = $this->_player->playlists;

                // Get the Wowza Media Server that this LivestreamApplication is associated with
                //		    $vhost            = WowzaVhost::findOrFail( 1 );
                //		    $wowzaMediaServer = $vhost->mediaServer;
                //		    $wowzaMediaServer = WowzaMediaServer::find( 2 ); // @TODO [Josh] - disable this as soon as I know the vhost media server will be valid

                $url = env('WOWZA_API_PROTOCOL') . '://' . env('WOWZA_API_DOMAIN') . ':' . env('WOWZA_API_PORT') . '/v2/servers/' . env('WOWZA_DEFAULT_SERVER_INSTANCE') . '/vhosts/' . env('WOWZA_DEFAULT_VHOST_INSTANCE') . '/applications/live/instances';
                //        $url = 'http://livestream.omnia-app.org:8087/v2/servers/_defaultServer_/vhosts/_defaultVHost_/applications/live/instances';
                $ch = curl_init($url);
                curl_setopt($ch, CURLOPT_POST, false);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_CONNECTTIMEOUT_MS, env('WOWZA_CURL_TIMEOUT') * 60);
                curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-type: text/xml']);
                $resultXML = curl_exec($ch);
                if ($errno = curl_errno($ch)) {
                    $error_message = curl_strerror($errno);
                    curl_close($ch);
                    throw new Exception('Error: ' . $errno . ': ' . $error_message);
                }
                curl_close($ch);

                if ($resultXML !== false) {
                    $result = simplexml_load_string($resultXML);
                    if (! empty($result->InstanceList)) {
                        foreach ($result->InstanceList as $key => $instance) {
                            $instanceCollection->push($instance);
                        }
                    }
                } else {
                    Log::info('Could not find any Live Instances');
                }
            } catch (Exception $e) {
                Log::error('There was an error when trying to get Live Instances: ' . $e->getMessage());
            }

            Log::info('[END] - ' . __FUNCTION__);
            $this->_live_instances = $instanceCollection;

            return $instanceCollection;
        }

        /**
         * Check if there are any live instances currently streaming for this account
         *
         * @param  LivestreamAccount  $livestreamAccount
         * @return bool
         *
         * @throws Exception
         */
        public function isCurrentlyStreaming($livestreamAccount = null)
        {
            if (empty($livestreamAccount)) {
                if (empty($this->_livestreamAccount)) {
                    throw new LivestreamAccountIdNotFoundException('Need LivestreamAccount to check for current livestreams');
                } else {
                    $livestreamAccount = $this->_livestreamAccount;
                }
            }

            if ($livestreamAccount->mux_livestream_active) {
                // Mux
                $muxService = new MuxService;
                $stream = $livestreamAccount->default_stream;
                if (empty($stream)) {
                    throw new Exception('No Stream Found for this LivestreamAccount: ' . $livestreamAccount->id);
                }
                $muxStream = $muxService->getLivestream($stream->stream_id);

                if (! empty($muxStream)) {
                    $status = $muxStream->getStatus();
                    $stream->status = $status;
                    $stream->save();
                }

                if (! empty($stream) && $stream->status == 'active') {
                    return true;
                } else {
                    return false;
                }
            } else {
                // Wowza
                $instanceCollection = $this->getAccountLiveInstances($livestreamAccount->id);
                if ($instanceCollection->isEmpty()) {
                    return false;
                } else {
                    return true;
                }
            }
        }

        /**
         * Get Livestream Groups for this account
         */
        public function getAccountLivestreamGroups()
        {
            try {
                $accountLivestreamGroups = collect();
                $accountLiveInstances = $this->getAccountLiveInstances();

                if ($accountLiveInstances->isEmpty()) {
                    return $accountLiveInstances;
                }

                if ($accountLiveInstances->count() > 1) {
                    foreach ($accountLiveInstances as $instance) {
                        $accountLivestreamGroups->push($this->getStreamGroupsFromInstance($instance));
                    }
                } else {
                    $instance = $accountLiveInstances->first();
                    $accountLivestreamGroups->push($this->getStreamGroupsFromInstance($instance));
                }
            } catch (Exception $e) {
                throw $e;
            }

            return $accountLivestreamGroups;
        }

        /**
         * Get Stream Groups from Wowza Instance XML
         *
         *
         * @return Collection
         */
        public function getStreamGroupsFromInstance(SimpleXMLElement $instance)
        {
            $LivestreamGroups = collect();
            if (! empty($instance->StreamGroups)) {
                $streamGroups = $instance->StreamGroups;
                foreach ($streamGroups as $streamGroup) {
                    foreach ($streamGroup as $streamGroupName) {
                        $LivestreamGroups->push((string) $streamGroupName->GroupName);
                    }
                }
            }

            return $LivestreamGroups;
        }

        /**
         * Checks if given instance from Wowza Server is for given Account. Defaults to current account if null
         *
         * @param  null|int  $accountId
         * @return bool
         *
         * @throws Exception
         */
        public function isCorrectAccountForInstance(SimpleXMLElement $instance, $accountId = null)
        {
            $accountId = $this->getAccountId($accountId);

            if ((int) $instance->Name === $accountId) {
                $result = true;
            } else {
                $result = false;
            }

            Log::info(__FUNCTION__ . ': ' . $result);

            return $result;
        }

        /**
         * Get Account Id based on if one is passed in. Get current Livestream Account Id if one is not passed in.
         *
         * @param  null  $accountId
         * @return mixed|null
         *
         * @throws Exception
         */
        public function getAccountId($accountId = null)
        {
            Log::info('[START] - ' . __FUNCTION__);
            if (is_null($accountId)) {
                if (! empty($this->_livestreamAccount)) {
                    $accountId = $this->_livestreamAccount->id;
                } else {
                    throw new Exception('Account Id not provided, and unable Current Livestream Account id');
                }
            } elseif ($accountId instanceof LivestreamAccount) {
                $accountId = $accountId->id;
            }
            Log::info('[END] - ' . __FUNCTION__);

            return $accountId;
        }

        /**
         * Gets the Live Playlist with Live streams based on the inserted Player
         *
         * @TODO [Josh] - eventually need to figure out a way to only play streams that are associated with this player/playlist combo
         * for now we are going to play any stream that is live stream for this LivestreamAcount
         *
         * @param  Request  $request
         * @return Collection | bool    Empty Collection if there are no live streams, collection with livestreams, or false on error
         *
         * @throws Exception
         *
         * @internal param Player $player
         */
        public function getLivestreams()
        {
            // each Player will have playlists associated with it
            // need to get the playlists associated with this player

            // then need to get the current streams that are live with the instance of <LivestreamAccount_slug>
            // now we have the Instance and streams

            // @TODO [Josh] - If we are going to use just one Live Application, we should be filtering out only the instances that belong to this account

            $currentLivestreams = collect();
            $accountInstances = $this->getAccountLiveInstances();

            if ($accountInstances === false || $accountInstances->isEmpty()) {
                return $currentLivestreams;
            }

            foreach ($accountInstances as $accountInstance) {
                if (! empty($accountInstance->StreamGroups)) {
                    //			        $incomingStreams = $accountInstance->InstanceList->IncomingStreams;
                    $streamGroups = $accountInstance->StreamGroups;
                    // this separates separate streams coming in
                    foreach ($streamGroups as $streamGroup) {
                        $allVideoSources = collect();
                        $audioSources = collect();
                        $mobileVideoSources = collect();
                        foreach ($streamGroup as $transGroup) {
                            $streamInfo = explode('_', $transGroup->GroupName);
                            $streamName = $streamInfo[0];
                            $groupName = $streamInfo[1];
                            switch ($groupName) {
                                case 'all':
                                    // this group has all the streams
                                    foreach ($transGroup->Members->string as $source) {
                                        $allVideoSources->push((string) $source);
                                    }
                                    break;
                                case 'audio':
                                    foreach ($transGroup->Members->string as $source) {
                                        $audioSources->push((string) $source);
                                    }
                                    break;
                                case 'mobile':
                                    foreach ($transGroup->Members->string as $source) {
                                        $mobileVideoSources->push((string) $source);
                                    }
                                    break;
                            }
                        }

                        $streamCollection = collect();

                        // Add the desired trans streams based on the StreamType
                        if ($this->_streamType === 'all') {
                            if (! $allVideoSources->isEmpty()) {
                                $streamCollection->put('all', $allVideoSources);
                                // Only add these two if they exist
                                (! $audioSources->isEmpty() ? $streamCollection->put('audio', $audioSources) : null);
                                (! $mobileVideoSources->isEmpty() ? $streamCollection->put('mobile', $mobileVideoSources) : null);
                            } else {
                                throw new Exception('Sorry, we couldn\'t find any live streams currently running');
                            }
                        }
                        if ($this->_streamType === 'audio') {
                            if (! $audioSources->isEmpty()) {
                                $streamCollection->put('audio', $audioSources);
                            } else {
                                throw new Exception('Sorry, we couldn\'t find any audio-only live streams currently running');
                            }
                        }
                        if ($this->_streamType === 'mobile') {
                            if (! $mobileVideoSources->isEmpty()) {
                                $streamCollection->put('mobile', $mobileVideoSources);
                            } else {
                                throw new Exception('Sorry, we couldn\'t find any mobile live streams currently running');
                            }
                        }
                    }
                    $currentLivestreams->put($streamName . uniqid('-'), $streamCollection);
                }
            }

            //	        // Format Current Streams for Playlist on JWPlayer
            //	        if ( ($request['formatPlaylist'] === false) ) {
            //	            $formattedPlaylist = null;
            //	        } else {
            //	            $formattedPlaylist = $this->formatForJWPlayerPlaylist($currentLivestreams);
            //	        }
            //
            //	        if (!is_null($formattedPlaylist)) {
            //	            $currentLivestreams = $formattedPlaylist;
            //	        }
            return $currentLivestreams;
        }

        /**
         * Get The URL strings from current Livestreams based on streaming protocol and put in a collection
         * eg. Smil URL(/live/1/ngrp:1/auto_all/jwplayer.smil)
         *
         * @param  null|string  $streamingProtocol rtmp or hls or null. If null, assume we want http/hls.
         * @return Collection
         *
         * @throws Exception
         */
        public function getLivestreamURL($streamingProtocol = 'http')
        {
            $livestreamURL = '';
            $activePlanId = $this->_livestreamAccount->team->currentActivePlan()->id;

            if ($activePlanId !== 'livestream-premium' && $activePlanId !== 'livestream-premium-yr' && $activePlanId !== 'livestream-growth' && $activePlanId !== 'livestream-growth-yr') {
                // check if they are on a plan with auto-transcoding, if not, then we will use the simple type of url
                $accountLiveInstances = $this->getAccountLiveInstances();

                if ($accountLiveInstances->isNotEmpty()) {
                    $livestreamURL = $this->_getHttpSingleUrl();
                }
            } elseif (! empty($this->_livestreamAccount) && ! empty($this->_livestreamAccount->cdn_playback_url)) {
                // Check if this livestreamAccount has a CDN playback URL and use that as the Livestream URL if they do
                $livestreamURL = $this->_livestreamAccount->cdn_playback_url;
            } else {
                // If they aren't a free account and don't have cdn_playback_url, look for regular livestream URLs using livestream Groups
                $livestreamGroups = $this->getAccountLivestreamGroups();

                if ($livestreamGroups->isNotEmpty()) {
                    $livestreamGroups = $livestreamGroups->flatten();
                }

                if ($livestreamGroups->isNotEmpty()) {
                    foreach ($livestreamGroups as $livestreamGroup) {
                        if (strpos($livestreamGroup, 'all') !== false) {
                            if ($streamingProtocol === 'rtmp') {
                                $livestreamURL = $this->_getRtmpGroupUrl($livestreamGroup);
                            } elseif ($streamingProtocol === 'http') {
                                $livestreamURL = $this->_getHttpGroupUrl($livestreamGroup);
                            }
                        }
                    }
                }
            }

            return $livestreamURL;
        }

        //https://597f40af4ba7f.streamlock.net:1940/live/33/ngrp:33/auto_all/jwplayer.m3u8?DVR
        //https://597f40af4ba7f.streamlock.net:1940/live/33/33/auto/jwplayer.m3u8?DVR

        //  if ( $streamingProtocol === 'http' ) {
        //      $sources .= 'file: "' . $streamingProtocol . config( 'livestream.vod_playback_url' ) . $episode->livestreamAccount->id . '/' . $episode->id . '/' . $videoObject->file_name . '.' . $videoObject->file_type . '/jwplayer.m3u8",';
        //
        //} else if ( $streamingProtocol === 'rtmp' ) {
        //	    $sources .= 'file: "' . $streamingProtocol . config( 'livestream.vod_playback_url' ) . $episode->livestreamAccount->id . '/' . $episode->id . '/' . $videoObject->file_name . '.' . $videoObject->file_type . '",';
        //
        //}

        /**
         * Get DVR Manifest Links for Current Live Streams
         *
         * @param  Request  $request
         * @return array|string
         */
        public function getDVRLivestreams()
        {
            // @TODO [Josh] - remove this once I have DVR setup and working
            return $this->getLivestreams();

            //        $InstancesXML = $this->getAccountLiveInstances();
            //        if (!empty($InstancesXML->InstanceList->IncomingStreams)) {
            //
            //            $incomingStreams = $InstancesXML->InstanceList->IncomingStreams;
            //
            //            // this separates separate streams coming in
            //            foreach ($incomingStreams as $streamGroup) {
            //                foreach ($streamGroup as $stream) {
            //                    $streamName = (string)$stream->Name;
            //                    $streamProtocol = substr($stream->SourceIp,0,strpos($stream->SourceIp,'://'));
            //                    if ( strpos($streamName,'trans') === false ) {
            //                        $streamAtts['name'] = $streamName;
            //                        $streamAtts['protocol'] = $streamProtocol;
            //                        $streamsList[] = $streamAtts;
            //                    }
            //                }
            //            }
            //        }
            //
            //        if ( empty($streamsList) ) {
            //            $dvrStreams = "There are no active live streams";
            //        } else {
            //            foreach ($streamsList as $stream) {
            //                if ( $stream['protocol'] === 'rtmp') {
            //                    $stream['url'] = $stream['protocol'] . '://' . $wowzaMediaServer->ip . ':1935/' . $LivestreamAccount_slug . '_live/_definst_/flv:' . $stream['name']. '.flv?DVR';
            //                }
            //                if ( $stream['protocol'] === 'hls') {
            //                    $stream['url'] = $stream['protocol'] . '://' . $wowzaMediaServer->ip . ':1935/' . $LivestreamAccount_slug . '_live/_definst_/' . $stream['name'] . '/playlist.m3u8?DVR';
            //                }
            //                $dvrStreams[] = $stream;
            //            }
            //        }
            //
            //        return $dvrStreams;
        }

        /**
         * @return string
         */
        protected function _getRtmpGroupUrl($livestreamGroup)
        {
            return $this->getBaseWowzaLiveURLFromGroup($livestreamGroup) . '.smil' . $this->_getDVRSuffix();
        }

        /**
         * @return string
         */
        protected function _getHttpGroupUrl($livestreamGroup)
        {
            return $this->_getBaseWowzaLiveURL() . '/ngrp:' . $livestreamGroup . '/' . $this->_getLiveUrlSuffix() . $this->_getDVRSuffix();
        }

        /**
         * Get Live URL for single stream without group
         *
         * @return string
         * example: https://597f40af4ba7f.streamlock.net:1940/live/33/33/auto/jwplayer.m3u8?DVR
         * example: https://d3v4to64un7d7c.cloudfront.net:443/live/4/4/auto/jwplayer.m3u8
         */
        protected function _getHttpSingleUrl()
        {
            return $this->_getBaseWowzaLiveURL() . '/' . $this->_livestreamAccount->id . '/auto/' . $this->_getLiveUrlSuffix();
        }

        /**
         * Get Base Wowza Live URL
         *
         * @return string
         */
        private function _getBaseWowzaLiveURL()
        {
            $url = 'http';

            if (env('WOWZA_PLAYBACK_SSL')) {
                $url .= 's';
            }

            $url .= '://' . env('WOWZA_PLAYBACK_DOMAIN') . ':' . env('WOWZA_PLAYBACK_PORT') . '/live/' . $this->_livestreamAccount->id;

            return $url;
        }

        private function _getLiveUrlSuffix($vendor = 'jwplayer')
        {
            $suffix = '';
            if ($vendor === 'jwplayer') {
                $suffix .= 'jwplayer';
            }

            $suffix .= '.m3u8';

            return $suffix;
        }

        private function _getDVRSuffix()
        {
            // added DVR so these accounts have DVR. This eventually needs to change to not include Free accounts.
            return '?DVR';
        }
        //
        //
        //    /**
        //     * Start Stream Recorder for Episode on Wowza Media Server
        //     */
        //    public function startStreamRecorder($LivestreamAccount, $episode)
        //    {
        //        try {
        //            $vhost = $LivestreamAccount->vhost;
        //            $wowzaMediaServer = $vhost->mediaServer;
        //            $LivestreamApplication = $LivestreamAccount->LivestreamApplication;
        //
        //            // Send POST Request
        //            // $url = 'http://'. $serverIP . ':8087/v2/servers/' . $serverName . '/vhosts/' . $vhostName . '/applications';
        //            // $url = 'http://52.53.215.51:8086/dvrstreamrecord?app=desert_reign_church_live&streamname=myStream&recordingname=' . $episode->id . '&action=start';
        //            $url = 'http://' . $wowzaMediaServer->ip . ':' . $wowzaMediaServer->port . '/v2/servers/' . $wowzaMediaServer->wowza_server_name . '/vhosts/' . $vhost->name . '/applications/' . $LivestreamApplication->app_slug . '/instances/_definst_/streamrecorders/' . $episode->id;
        //
        //            $config = '{
        //                     "restURI": "",
        //                     "recorderName":"myStream",
        //                    "instanceName":"_definst_",
        //                    "recorderState":"Waiting for stream",
        //                    "defaultRecorder":true,
        //                    "segmentationType":"None",
        //                    "outputPath":"/usr/local/wowza/content",
        //                    "baseFile":"12345.mp4",
        //                    "fileFormat":"MP4",
        //                    "fileVersionDelegateName":"com.wowza.wms.livestreamrecord.manager.StreamRecorderFileVersionDelegate",
        //                    "fileTemplate":"${BaseFileName}_${RecordingStartTime}_${SegmentNumber}",
        //                    "segmentDuration":900000,
        //                    "segmentSize":10485760,
        //                    "segmentSchedule":"0 * * * * *",
        //                    "recordData":true,
        //                    "startOnKeyFrame":true,
        //                    "option":"Version existing file",
        //                    "moveFirstVideoFrameToZero":true,
        //                    "currentSize":0,
        //                    "currentDuration":0,
        //                    "recordingStartTime":""
        //                    }';
        //
        //            $config = json_decode($config, true);
        //
        //            $config['restURI'] = $url;
        //            $config['baseFile'] = $episode->id . '.mp4';
        //
        //            $config = json_encode($config);
        //
        //            $ch = curl_init($url);
        //            curl_setopt($ch, CURLOPT_POST, true);
        //            curl_setopt($ch, CURLOPT_POSTFIELDS, $config);
        //            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        //            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        //                    'Content-Type: application/json',
        //                    'Content-Length: ' . strlen($config))
        //            );
        //            $result = curl_exec($ch);
        //            curl_close($ch);
        //
        ////        http://52.53.215.51:8086/dvrstreamrecord?app=[application-name]&streamname=[stream-name]&recordingname=[recording-name]&action=[start|stop]
        //            return true;
        //        } catch(\Exception $e) {
        //            throw new \Exception('Could not start Stream Recorder on Wowza Media Server: ' . $wowzaMediaServer . ' for episode: ' . $episode->id);
        //        }
        //    }
    }
