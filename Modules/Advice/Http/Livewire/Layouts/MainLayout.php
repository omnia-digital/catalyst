<?php

    namespace Modules\Advice\Http\Livewire\Layouts;

    use Livewire\Component;

    class MainLayout extends Component
    {
        public function render(): \Illuminate\View\View
        {
            return view('advice::livewire.layouts.pages.default-page-layout');
        }
    }
