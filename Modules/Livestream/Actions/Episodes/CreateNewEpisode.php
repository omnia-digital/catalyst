<?php namespace App\Actions\Episodes;

use App\Models\Episode;
use App\Models\LivestreamAccount;
use Illuminate\Support\Facades\Auth;

class CreateNewEpisode
{
    public function execute(array $data, ?LivestreamAccount $livestreamAccount = null): Episode
    {
        is_null($livestreamAccount) && $livestreamAccount = Auth::user()->currentTeam->livestreamAccount;

        $episodeTemplate = $livestreamAccount->episodeTemplate?->template ?? [];

        // Validate data since the old version's database has invalid data in episode template
        if (!($episodeTemplate['main_speaker_id'] ?? null)) {
            unset($episodeTemplate['main_speaker_id']);
        }

        return $livestreamAccount->episodes()->create(
            array_merge($episodeTemplate, $data)
        );
    }
}
