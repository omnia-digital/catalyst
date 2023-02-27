<?php namespace App\Support\Livewire;

trait WithSlideOver
{
    public function showSlideOver()
    {
        $this->dispatchBrowserEvent('show-slide-over');
    }

    public function hideSlideOver()
    {
        $this->dispatchBrowserEvent('hide-slide-over');
    }
}
