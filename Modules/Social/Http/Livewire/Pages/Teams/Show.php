<?php

namespace Modules\Social\Http\Livewire\Pages\Teams;

use App\Models\Award;
use App\Models\Location;
use App\Models\Team;
use App\Models\User;
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

    public ?User $userToAddAwardsTo;

    public $awardsToAdd = [];

    public $additionalInfo = [
        'likes',
        'comments',
        'members',
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

    protected $listeners = ['addUserAwards', 'modal-closed' => 'resetAwardsSelection'];

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

    
    public function resetAwardsSelection()
    {
        $this->reset('awardsToAdd');
    }

    public function addUserAwards($userID)
    {
        $this->dispatchBrowserEvent('add-awards-modal', ['type' => 'open']);
        $this->userToAddAwardsTo = User::find($userID);
    }

    public function addAward(User $user)
    {
        $user->awards()->attach($this->awardsToAdd);
        
        $this->dispatchBrowserEvent('notify', ['message' => 'Awards Added', 'type' => 'success']);
        $this->dispatchBrowserEvent('add-awards-modal',  ['type' => 'close']);
    }

    public function getRemainingAwards(User $user)
    {
        return Award::whereNotIn('id', $user->awards()->pluck('awards.id')->toArray())->get();
    }

    /**
     * If we decide to allow the team owners to decide if their team is public
     * or private then we can edit this method to account for that.
     */
    public function getIsPublicProperty()
    {
        return false;
    }

    public function getIsMemberProperty()
    {
        return $this->team->hasUser(auth()->user());
    }

    public function getCanViewTeamContentProperty()
    {
        return $this->isPublic || $this->isMember;
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
