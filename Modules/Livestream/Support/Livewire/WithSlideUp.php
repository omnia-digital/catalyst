<?php

namespace Modules\Livestream\Support\Livewire;

trait WithSlideUp
{
    public function showSlideUp()
    {
        $this->dispatch('show-slide-up');
    }

    public function hideSlideUp()
    {
        $this->dispatch('hide-slide-up');
    }
}
