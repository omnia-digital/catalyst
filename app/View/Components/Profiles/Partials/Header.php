<?php

namespace App\View\Components\Profiles\Partials;

use App\Models\User;
use Closure;
use Illuminate\View\Component;

class Header extends Component
{
    public User $user;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|Closure|string
     */
    public function render()
    {
        return view('components.profiles.partials.header');
    }
}
