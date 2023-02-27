<?php namespace Modules\Livestream\Policies;

use Modules\Livestream\Models\EpisodeTemplate;
use Modules\Livestream\Models\User;
use Modules\Livestream\Policies\Traits\HasDefaultPolicy;

class EpisodeTemplatePolicy
{
    use HasDefaultPolicy;

    public function view(User $user, EpisodeTemplate $episodeTemplate)
    {
        return $user->currentTeam->livestreamAccount->id === $episodeTemplate->livestream_account_id;
    }

    public function update(User $user, EpisodeTemplate $episodeTemplate)
    {
        return $this->view($user, $episodeTemplate);
    }

    public function delete(User $user, EpisodeTemplate $episodeTemplate)
    {
        $livestreamAccount = $user->currentTeam->livestreamAccount;

        // Cannot delete default episode template.
        return $livestreamAccount->id === $episodeTemplate->livestream_account_id
            && $livestreamAccount->default_episode_template_id !== $episodeTemplate->id;
    }
}
