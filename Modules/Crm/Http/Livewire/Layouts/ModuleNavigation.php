<?php

    namespace Modules\Crm\Http\Livewire\Layouts;

    use Livewire\Component;

    class ModuleNavigation extends Component
    {
        public string $class;
        public array $navigation = [];

        public function mount() {
            $this->navigation = [
                [
                    'label'   => 'Home',
                    'name'    => 'crm.home',
                    'icon'    => 'fa-regular fa-house',
//                    'icon'    => 'fa-regular fa-house-chimney',
//                    'icon'    => 'heroicon-o-home',
                    'module'  => 'crm',
                    'current' => false
                ],
                [
                    'label'   => 'Reviews',
                    'name'    => 'crm.reviews',
                    'icon'    => 'fa-regular fa-house',
                    //                    'icon'    => 'fa-regular fa-house-chimney',
                    //                    'icon'    => 'heroicon-o-home',
                    'module'  => 'crm',
                    'current' => false
                ],
            ];
        }

        public function render()
        {
            return view('social::livewire.layouts.module-navigation');
        }
    }
