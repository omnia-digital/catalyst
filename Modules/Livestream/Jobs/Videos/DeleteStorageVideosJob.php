<?php

namespace Modules\Livestream\Jobs\Videos;

use Exception;
use Facebook\Exceptions\FacebookResponseException;
use Facebook\Exceptions\FacebookSDKException;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Modules\Livestream\Models\SocialAccount;
use Modules\Livestream\Models\Video;
use Modules\Livestream\Services\SocialAccount\SocialAccountService;
use Modules\Livestream\Services\SocialAccount\StreamIntegrationService;

class DeleteStorageVideosJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        private array $ids
    ) {
    }

    public function handle()
    {
        foreach ($this->ids as $id) {
            $video = Video::find($id);

            if (empty($video)) {
                continue;
            }

            if (! empty($video->video_source_id)) {
                try {
                    $this->deleteFacebookLiveVideo($video);
                } catch (Exception $e) {
                    Log::info($e->getMessage());

                    continue;
                }
            } else {
                $vodStorage = Storage::disk(config('livestream.default_vod_disk'));
                $episode = $video->episode;
                $livestreamAccountId = $episode->livestreamAccount->id;
                $episodePath = '/' . $livestreamAccountId . '/' . $episode->id . '/';
                $result = $vodStorage->deleteDirectory($episodePath);

                if ($result === false) {
                    throw new Exception('Failed to Delete Episode Directory on Storage');
                }

                $transVideos = $video->transVideos()->get();

                foreach ($transVideos as $transVideo) {
                    $transVideo->delete();
                }
            }

            Video::destroy($id);
        }
    }

    /**
     * Delete a Facebook Live Video
     *
     *
     * @return mixed
     *
     * @throws FacebookResponseException
     * @throws FacebookSDKException
     */
    public function deleteFacebookLiveVideo($video)
    {
        $params = [
            'video_id' => $video->video_source_id,
        ];

        $user = auth()->user();
        $socialAccounts = SocialAccount::whereUserId($user->id)->where('provider', '=', 'facebook')->get();
        $facebookSocialAccount = $socialAccounts->first();

        // Grab all facebook pages that the user has admin access to
        $socialAccountService = new SocialAccountService($facebookSocialAccount);
        $all_user_facebook_pages = collect($socialAccountService->getFacebookPages());

        $fb_page = $video->video_source_account_id;
        // find if fb_page is in user facebook pages
        if (! empty($fb_page)) {
            $found_fb_page = $all_user_facebook_pages->first(function ($item, $key) use ($fb_page) {
                return $item['id'] == $fb_page;
            });

            if (! empty($found_fb_page)) {
                $teamObject = [
                    'id' => $found_fb_page['id'],
                    'access_token' => $found_fb_page['access_token'],
                ];

                return (new StreamIntegrationService)->deleteFacebookLiveVideo($params, $teamObject);
            }
        }
    }
}
