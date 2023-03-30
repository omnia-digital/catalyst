<?php namespace Modules\Livestream\Actions\Episodes;

use Modules\Livestream\Models\Team;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class GetTotalAttachmentDownloadsAction
{
    /**
     * @param Carbon $from
     * @param Carbon $to
     * @param Team|null $team
     * @return int|float
     */
    public function execute(Carbon $from, Carbon $to, bool $expiredOnly = true, ?Team $team = null): int|float
    {
        is_null($team) && $team = Auth::user()->currentTeam;

        // For normal episodes, get all episodes to calculate the attachment downloads count.
        if ($expiredOnly) {
            $downloadCount = $team->livestreamAccount->episodes()->expired()->whereTotalAttachmentDownloadsInDateRange($from, $to)->get()->sum('attachment_downloads_sum_count');
        } else {
            $downloadCount = $team->livestreamAccount->episodes()->whereTotalAttachmentDownloadsInDateRange($from, $to)->get()->sum('attachment_downloads_sum_count');
        }

        return $downloadCount;
    }
}
