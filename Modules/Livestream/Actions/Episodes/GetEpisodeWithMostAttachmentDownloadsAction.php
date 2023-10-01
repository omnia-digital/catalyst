<?php

namespace Modules\Livestream\Actions\Episodes;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Modules\Livestream\Models\Team;

class GetEpisodeWithMostAttachmentDownloadsAction
{
    /**
     * @return Model
     */
    public function execute(Carbon $from, Carbon $to, bool $expiredOnly = true, ?Team $team = null): Model|null
    {
        is_null($team) && $team = auth()->user()->currentTeam;

        // For normal episodes, get all episodes to calculate the attachment downloads count.
        if ($expiredOnly) {
            $episode = $team->livestreamAccount->episodes()->expired()->whereTotalAttachmentDownloadsInDateRange($from,
                $to)->orderBy('attachment_downloads_sum_count', 'desc')->first();
        } else {
            $episode = $team->livestreamAccount->episodes()->whereTotalAttachmentDownloadsInDateRange($from,
                $to)->orderBy('attachment_downloads_sum_count', 'desc')->first();
        }

        return $episode;
    }
}
