<?php

namespace Modules\Social\Http\Livewire\Pages\Teams;

use App\Models\Location;
use App\Models\Team;
use App\Traits\Team\WithTeamManagement;
use Livewire\Component;
use OmniaDigital\OmniaLibrary\Livewire\WithMap;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Show extends Component
{
    use WithTeamManagement, WithMap;

    public $team;

    public $displayUrl = null;

    public $displayID = null;

    public $additionalInfo = [
        'likes',
        'comments',
        'members'
    ];

    public $activity = [
        'user' => [
            'avatar' => 'https://via.placeholder.com/150',
        ],
        'title' => 'Activity Title',
        'created_at' => 'June 1, 2022',
        'id' => 1,
        'message' => 'Activity Message',
        'team' => [
            'link' => '#',
        ],
        'members' => [
            [
                'avatar' => 'https://via.placeholder.com/150',
                'name' => 'Member Name',
                'link' => '#',
            ],
        ],
    ];

    public function getPlacesProperty()
    {
        $places = Location::select(['lat', 'lng', 'model_id', 'model_type'])
            ->where('model_id', $this->team->id)
            ->where('model_type', Team::class)
            ->hasCoordinates()
            ->with('model')
            ->get()
            ->map(function (Location $location) {
                return [
                    'id' => $location->id,
                    'name' => $location->model->name,
                    'lat' => $location->lat,
                    'lng' => $location->lng,
                ];
            });

        return $places->all();
    }

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
        $this->displayUrl = $team->sampleImages()->first()->getFullUrl();
        $this->displayID = $team->sampleImages()->first()->id;
    }

    public function render()
    {
        return view('social::livewire.pages.teams.show');
    }
}
