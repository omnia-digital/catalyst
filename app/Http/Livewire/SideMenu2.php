<?php

namespace App\Http\Livewire;

use Livewire\Component;

class SideMenu2 extends Component
{
    public $isOpen = false;

    public $navigation = [];
    public $invitations = [];

    public function mount() {
        $this->navigation = [
            [
                'label'   => 'Home',
                'name'    => 'social.home',
                'icon'    => 'heroicon-o-home',
                'current' => false
            ],
            [
                'label'   => 'My Projects',
                'name'    => 'projects',
                'icon'    => 'heroicon-o-globe',
                'current' => false
            ],
            [
                'label'   => 'Contacts',
                'name'    => 'contacts',
                'icon'    => 'heroicon-o-users',
                'current' => false
            ],
            [
                'label'   => 'Favorites',
                'name'    => 'favorites',
                'icon'    => 'heroicon-o-star',
                'current' => false
            ],
        ];

        $this->invitations = [
            [
                'from' => 'Robert Fox',
                'subject' => 'The Great Project',
                'message' => 'Tincidunt dolor odio vulputate faucibus tempor. Nunc ullamcorper nunc eget…',
                'accepted_at' => null,
                'declined_at' => null,
                'user' => [
                    'avatar' => 'https://tuk-cdn.s3.amazonaws.com/assets/components/popovers/p_1_0.png',
                ],
            ],
            [
                'from' => 'Kate Wills',
                'subject' => 'The Other Great Project',
                'message' => 'Tincidunt dolor odio vulputate faucibus tempor. Nunc ullamcorper nunc eget…',
                'accepted_at' => null,
                'declined_at' => null,
                'user' => [
                    'avatar' => 'https://tuk-cdn.s3.amazonaws.com/assets/components/popovers/p_1_0.png',
                ],
            ],
        ];
    }

    public function openMobileMenu()
    {
        $this->isOpen = true;
    }

    public function closeMobileMenu()
    {
        $this->isOpen = false;
    }

    public function render()
    {
        return view('livewire.side-menu2');
    }
}
