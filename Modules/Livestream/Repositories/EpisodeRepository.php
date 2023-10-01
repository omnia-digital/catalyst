<?php

namespace Modules\Livestream\Repositories;

use Livestream\Livestream;
use Modules\Livestream\Episode;
use Modules\Livestream\Omnia;

class EpisodeRepository
{
    /**
     * @param null $timezone
     * @param null $livestreamAccount
     * @param null $published if true, filter out unpublished episodes
     * @param bool $locked
     * @param int $show
     * @param int $currentPage
     * @param null $query
     * @return array
     */
    public function all(
        $timezone = null,
        $livestreamAccount = null,
        $published = null,
        $locked = true,
        $show = 15,
        $currentPage = 1,
        $query = null
    ) {
        if (empty($livestreamAccount)) {
            $livestreamAccount = Livestream::getLivestreamAccount();
        }

//            $timezone = Omnia::getTimezone($timezone, $livestreamAccount->team);

        $episodes = collect();

        $totalEpisode = $livestreamAccount->episodes()->count();

        $offset = $show >= $totalEpisode ? 0 : ($currentPage - 1) * $show;

        $currentPage = $show >= $totalEpisode ? 1 : $currentPage;

        $sortedEpisodeCollection = $livestreamAccount->limitEpisodes($show, $offset)
            ->with('videos');

        if (!empty($query)) {
            $sortedEpisodeCollection->where('title', 'LIKE', '%' . $query . '%');
        }

        $sortedEpisodeCollection = $sortedEpisodeCollection->get();

        $activePlanId = $livestreamAccount->team->currentActivePlan()->id;
        $user = auth()->user();
        if (!empty($user) && $user->isSystemAdmin()) {
            $activePlanId = 'livestream-growth';
        }
        if ($activePlanId === 'livestream-free') {
            // Only return most recent episode
            $latestEpisode = $sortedEpisodeCollection->shift();

            // Add Unlocked Episodes
            if (!empty($latestEpisode)) {
                if ($published) {
                    $unlocked_episodes = ($latestEpisode->is_published ? collect([$latestEpisode]) : collect());
                } else {
                    $unlocked_episodes = collect([$latestEpisode]);
                }
            } else {
                $unlocked_episodes = collect();
            }

            $episodes->put('unlocked_episodes', $unlocked_episodes->values());

            // Add Locked Episodes
            if ($locked == true) {
                $locked_episodes = $sortedEpisodeCollection;
                $episodes->put('locked_episodes', $locked_episodes->values());
            }
        } else {
            if ($published) {
                $sortedEpisodeCollection = $sortedEpisodeCollection->filter(function ($episode, $key) {
                    return $episode->is_published == true;
                });
            }

            // Add Unlocked Episodes
            $episodes->put('unlocked_episodes', $sortedEpisodeCollection->values());
        }

        return [
            'episodes' => $episodes,
            'current_page' => $currentPage,
            'total_page' => ceil($totalEpisode / $show),
            'total_episodes' => $totalEpisode,
        ];
    }

    /**
     * Get One Episode
     *
     * @param int|Episode $episode
     */
    public function get($episode, $timezone = null, $livestreamAccount = null)
    {
        if (is_int($episode)) {
            $episode = Episode::find($episode);
        }

        if (empty($livestreamAccount)) {
            $livestreamAccount = Livestream::getLivestreamAccount();
        }

        $episode->syncVideos();
        $episode->fresh();
        $episode->load('people');

        foreach ($episode->videos as $video) {
            $video->setAttribute('playback_url', $video->playback_url);
            $video->setAttribute('download_url', $video->download_url);
            unset($video->episode);
        }

        if (!empty($episode->livestreamAccount)) {
            unset($episode->livestreamAccount);
        }

        return $episode;
    }

    /**
     * Check if user has reach episode limit
     *
     * @return bool
     */
    public function hasReachEpisodeLimit($livestreamAccount)
    {
        return Episode::query()
            ->where('livestream_account_id', $livestreamAccount->id)
            ->whereDate('created_at', '>=', now()->subWeek())
            ->exists();
    }
}
