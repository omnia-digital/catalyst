<?php

    namespace Modules\Jobs\Http\Livewire\Layouts;

    use Livewire\Component;

    class ModuleNavigation extends Component
    {
        public string $class;
        public array $navigation = [];
        protected $listeners = [
            'LoggedIn' => '$refresh'
        ];
        
        public function mount() {
            $this->navigation = [
                [
                    'label'   => 'Home',
                    'name'    => 'jobs.home',
                    'icon'    => 'heroicon-o-home',
                    'current' => false
                ],
                [
                    'label'   => 'Notification',
                    'name'    => 'notifications',
                    'icon'    => 'heroicon-o-bell',
                    'current' => false
                ],
            ];
        }

        public function render()
        {
            return view('jobs::livewire.layouts.module-navigation');
        }
    }
