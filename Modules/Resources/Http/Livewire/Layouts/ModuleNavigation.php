<?php

    namespace Modules\Resources\Http\Livewire\Layouts;

    use Livewire\Component;

    class ModuleNavigation extends Component
    {
        public array $navigation = [];

        public function mount() {
            $this->navigation = [
                [
                    'label'   => 'Home',
                    'name'    => 'social.home',
                    'icon'    => 'heroicon-o-home',
                    'current' => false
                ],
            ];
        }

        public function render()
        {
            return view('resources::livewire.layouts.module-navigation');
        }
    }
