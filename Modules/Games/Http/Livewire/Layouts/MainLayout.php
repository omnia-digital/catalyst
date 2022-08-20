<?php

    namespace Modules\Games\Http\Livewire\Layouts;

    use Livewire\Component;

    class MainLayout extends Component
    {
        public function render(): \Illuminate\View\View
        {
            return view('games::livewire.layouts.main-layout');
        }
    }
