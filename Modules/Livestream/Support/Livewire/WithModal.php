<?php namespace Modules\Livestream\Support\Livewire;

trait WithModal
{
    /**
     * Close modal in frontend.
     */
    public function closeModal(string $modalId)
    {
        $this->dispatchBrowserEvent($modalId, ['type' => 'hide']);
    }

    /**
     * Show modal in frontend.
     */
    public function showModal(string $modalId)
    {
        $this->dispatchBrowserEvent($modalId, ['type' => 'show']);
    }
}
