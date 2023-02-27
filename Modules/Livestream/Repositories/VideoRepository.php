<?php

    namespace Modules\Livestream\Repositories;

    use Modules\Livestream\Module;
    use Modules\Livestream\Role;
    use Modules\Livestream\SocialAccount;
    use Modules\Livestream\User;
    use Carbon\Carbon;
    use Exception;
    use Facebook\Exceptions\FacebookResponseException;
    use Facebook\Exceptions\FacebookSDKException;
    use Illuminate\Contracts\Auth\Authenticatable;
    use Illuminate\Database\Eloquent\Collection;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\Config;
    use Illuminate\Support\Facades\Log;
    use Illuminate\Support\Facades\Storage;
    use Laravel\Spark\Spark;
    use Modules\Livestream\Episode;
    use Modules\Livestream\PlaybackId;
    use Modules\Livestream\Services\MuxService;
    use Modules\Livestream\Services\SocialAccountService;
    use Modules\Livestream\Services\StreamIntegrationService;
    use Modules\Livestream\Video;
    use Modules\Livestream\VideoSourceType;

    class VideoRepository
    {
        /**
         * Get the current LivestreamAccount of the application.
         *
         * @return Authenticatable|null
         */
        public function current()
        {
        }

        /**
         * Perform a basic LivestreamAccount search by name or e-mail address.
         *
         * @param string               $query
         * @param Authenticatable|null $excludeLivestreamAccount
         *
         * @return Collection
         */
        public function search($query, $excludeLivestreamAccount = null)
        {
        }

        /**
         * {@inheritdoc}
         */
        public function find($id)
        {
            return Spark::LivestreamAccount()->with('owner', 'users')->where('id', $id)->first();
        }

        /**
         * {@inheritdoc}
         */
        public function forUser($user)
        {
            return $user->LivestreamAccounts();
        }

        /**
         * {@inheritdoc}
         */
        public function create(Episode $episode, array $videoData = [])
        {
            // Mux Asset
            if ( ! empty($episode->mux_asset_id)) {
                $mux_asset_id = $episode->mux_asset_id;
            } else if ( ! empty($videoData['mux_asset_id'])) {
                $mux_asset_id = $videoData['mux_asset_id'];
            }

            // Get Asset data from Mux
            $muxService = new MuxService();
            $muxAsset   = $muxService->getAsset($mux_asset_id);

            // Add MP4 support if needed
            $muxService->addAssetMP4Support($mux_asset_id);

            // Create PlaybackIds based on Mux PlaybackIds for this asset/episode
            $muxPlaybackIds = $muxAsset->getPlaybackIds();
            foreach ($muxPlaybackIds as $mux_playback_id) {
                $episodePlaybackId = PlaybackId::create([
                    'playback_id'       => $mux_playback_id->getId(),
                    'policy'            => $mux_playback_id->getPolicy(),
                    'playbackable_type' => Episode::class,
                    'playbackable_id'   => $episode->id,
                ]);
            }

            // get Mux Video Source Type
            $muxVideoSourceType = VideoSourceType::where('slug', '=', 'mux')->first();

            if (empty($muxVideoSourceType)) {
                throw new Exception("Could not find Mux Video Source Type");
            }

            // create video
            $video = Video::create([
                'title'                => $episode->title,
                //                        'video_source_id'      => 'EXh1pEH3in4IXtMc49spGqJLGjJNTvNaYxes8xbZaXw', @note I don't think I need video_source_id right now, I might come back and add later if needed
                'video_source_type_id' => $muxVideoSourceType->id,
                'episode_id'           => $episode->id
            ]);

            $episode->mux_asset_id = $mux_asset_id;
            $episode->save();

            return $video;
        }

        /**
         * @param $ids int|array of Video ids wanting to be destroyed
         *
         * @return bool
         * @throws Exception
         */
        public function destroy($ids)
        {
            if (is_numeric($ids)) {
                $ids = [(int)$ids];
            } else if (is_object($ids)) {
                $ids = $ids->toArray();
            }

            $result = true;

            foreach ($ids as $id) {
                $video = Video::find($id);
                if (empty($video)) {
                    continue;
                }

                if ( ! empty($video->video_source_id)) {
                    try {
                        $facebookResponse = $this->deleteFacebookLiveVideo($video);
                    } catch (Exception $e) {
                        Log::info($e->getMessage());
                        continue;
                    }
                } else {
                    $vodStorage          = Storage::disk(config('livestream.default_vod_disk'));
                    $episode             = $video->episode;
                    $livestreamAccountId = $episode->livestreamAccount->id;
                    $episodePath         = '/' . $livestreamAccountId . '/' . $episode->id . '/';
                    $result              = $vodStorage->deleteDirectory($episodePath);

                    if ($result === false) {
                        throw new Exception('Failed to Delete Episode Directory on Storage');
                    }
                    $transVideos = $video->transVideos()->get();
                    foreach ($transVideos as $transVideo) {
                        $transVideo->delete();
                    }
                }
                $result = Video::destroy($id);
            }

            return (bool)$result;
        }

        /**
         * Delete a Facebook Live Video
         *
         * @param $video
         *
         * @return mixed
         * @throws FacebookResponseException
         * @throws FacebookSDKException
         */
        public function deleteFacebookLiveVideo($video)
        {
            $params = [
                'video_id' => $video->video_source_id
            ];

            $user                  = Auth::user();
            $socialAccounts        = SocialAccount::whereUserId($user->id)->where('provider', '=', 'facebook')->get();
            $facebookSocialAccount = $socialAccounts->first();

            // Grab all facebook pages that the user has admin access to
            $socialAccountService    = new SocialAccountService($facebookSocialAccount);
            $all_user_facebook_pages = collect($socialAccountService->getFacebookPages());

            $fb_page = $video->video_source_account_id;
            // find if fb_page is in user facebook pages
            if ( ! empty($fb_page)) {
                $found_fb_page = $all_user_facebook_pages->first(function ($item, $key) use ($fb_page) {
                    return $item['id'] == $fb_page;
                });

                if ( ! empty($found_fb_page)) {
                    $teamObject = [
                        'id'           => $found_fb_page['id'],
                        'access_token' => $found_fb_page['access_token']
                    ];

                    $streamTargetService = new StreamIntegrationService($video->episode->livestreamAccount);
                    $fbVideoResponse     = $streamTargetService->deleteFacebookLiveVideo($params, $teamObject);

                    return $fbVideoResponse;
                }
            }
        }

        /**
         * @param $video
         *
         * @return mixed
         */
        public function removeFromEpisode($video)
        {
            $video->episode_id = null;
            $video->save();

            // @TODO [Josh] - need to move Videos to a 'Common' folder and delete this episodes directory.
            $s3 = Storage::disk(config('livestream.default_vod_disk'));


            return $video;
        }
    }
