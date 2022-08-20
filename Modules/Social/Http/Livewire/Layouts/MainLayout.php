<?php

    namespace Modules\Social\Http\Livewire\Layouts;

    use Livewire\Component;

    class MainLayout extends Component
    {
        public function render(): \Illuminate\View\View
        {
            return view('social::livewire.layouts.main-layout');
        }
    }
