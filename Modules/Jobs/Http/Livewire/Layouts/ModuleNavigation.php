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
                    'icon'    => 'fa-regular fa-house',
                    'module'  => 'jobs',
                ],
                [
                    'label'   => 'Discover',
                    'name'    => 'jobs.home',
                    'icon'    => 'fa-regular fa-house',
                    'module'  => 'jobs',
                ],
                [
                    'label'   => 'My Jobs',
                    'name'    => 'jobs.my-jobs',
                    'icon'    => 'fa-regular fa-briefcase',
                    'module'  => 'jobs',
                ],
            ];
        }

        public function render()
        {
            return view('jobs::livewire.layouts.module-navigation');
        }
    }
