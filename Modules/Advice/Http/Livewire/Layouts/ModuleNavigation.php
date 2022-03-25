<?php

    namespace Modules\Advice\Http\Livewire\Layouts;

    use Livewire\Component;

    class ModuleNavigation extends Component
    {
        public array $navigation = [];

        public function mount() {
            $this->navigation = [
                [
                    'label'   => 'Home',
                    'name'    => 'advice.home',
                    'icon'    => 'heroicon-o-home',
                    'current' => false
                ],
            ];
        }

        public function render()
        {
            return view('advice::livewire.layouts.module-navigation');
        }
    }
