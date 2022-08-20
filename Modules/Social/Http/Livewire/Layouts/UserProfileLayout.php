<?php

    namespace Modules\Social\Http\Livewire\Layouts;

    use Livewire\Component;

    class UserProfileLayout extends Component
    {
        public function render(): \Illuminate\View\View
        {
            return view('social::livewire.layouts.user-profile-layout');
        }
    }
