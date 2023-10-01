<?php

namespace Modules\Livestream\Actions\Episodes;

use Carbon\Carbon;
use Modules\Livestream\Models\Team;

class GetTotalAttachmentDownloadsAction
{
    public function execute(Carbon $from, Carbon $to, bool $expiredOnly = true, ?Team $team = null): int|float
    {
        is_null($team) && $team = auth()->user()->currentTeam;

        // For normal episodes, get all episodes to calculate the attachment downloads count.
        if ($expiredOnly) {
            $downloadCount = $team->livestreamAccount->episodes()->expired()->whereTotalAttachmentDownloadsInDateRange($from,
                $to)->get()->sum('attachment_downloads_sum_count');
        } else {
            $downloadCount = $team->livestreamAccount->episodes()->whereTotalAttachmentDownloadsInDateRange($from,
                $to)->get()->sum('attachment_downloads_sum_count');
        }

        return $downloadCount;
    }
}
