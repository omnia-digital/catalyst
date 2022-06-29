<?php

namespace Modules\Social\Http\Livewire\Pages\Teams;

use App\Models\Team;
use App\Traits\WithTeamManagement;
use Livewire\Component;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Show extends Component
{
    use WithTeamManagement;

    public $team;

    public $displayUrl = null;

    public $displayID = null;

    public $additionalInfo = [
        'likes',
        'comments',
        'members'
    ];

    public function getRecentPostsProperty()
    {
        return $this->team->posts()->take(2)->get();
    }

    public function showPost($post) {
        return $this->redirectRoute('social.posts.show', $post['id']);
    }

    public function setImage(Media $media)
    {
        $this->displayUrl = $media->getFullUrl();
        $this->displayID = $media->id;
    }

    public function mount(Team $team)
    {
        $team->owner;
        $this->displayUrl = optional($team->getMedia('team_sample_images')->first())->getFullUrl();
        $this->displayID = optional($team->getMedia('team_sample_images')->first())->id;
    }

    public function render()
    {
        return view('social::livewire.pages.teams.show');
    }
}
