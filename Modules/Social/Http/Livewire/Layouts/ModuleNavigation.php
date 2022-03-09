<?php

    namespace Modules\Social\Http\Livewire\Layouts;

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
                [
                    'label'   => 'Bookmarks',
                    'name'    => 'social.bookmarks',
                    'icon'    => 'heroicon-o-bookmark',
                    'current' => false
                ],
            ];
        }

        public function render()
        {
            return view('social::livewire.layouts.module-navigation');
        }
    }
