<?php

    namespace Modules\Jobs\Http\Livewire\Layouts;

    use Livewire\Component;

    class ModuleNavigation extends Component
    {
        public array $navigation = [];

        public function mount() {
            $this->navigation = [
                [
                    'label'   => 'Home',
                    'name'    => 'jobs.home',
                    'icon'    => 'heroicon-o-home',
                    'current' => false
                ],
            ];
        }

        public function render()
        {
            return view('jobs::livewire.layouts.module-navigation');
        }
    }
