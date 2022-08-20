<?php

    namespace Modules\Jobs\Http\Livewire\Layouts;

    use Livewire\Component;

    class ModuleNavigation extends Component
    {
        public string $class;
        public array $navigation = [];

        public function mount(): void {
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

        public function render(): \Illuminate\View\View
        {
            return view('jobs::livewire.layouts.module-navigation');
        }
    }
