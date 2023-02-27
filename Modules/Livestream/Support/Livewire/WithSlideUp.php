<?php namespace App\Support\Livewire;

trait WithSlideUp
{
    public function showSlideUp()
    {
        $this->dispatchBrowserEvent('show-slide-up');
    }

    public function hideSlideUp()
    {
        $this->dispatchBrowserEvent('hide-slide-up');
    }
}
