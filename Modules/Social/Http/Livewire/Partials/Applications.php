<?php

namespace Modules\Social\Http\Livewire\Partials;

use Livewire\Component;

class Applications extends Component
{
    public $invitations = [];

    public function mount()
    {
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
    
    public function render()
    {
        return view('social::livewire.partials.applications');
    }
}
