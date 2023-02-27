<?php namespace App\Support\Livewire;

trait WithLayoutSwitcher
{
    public string $layoutSwitcher = 'grid';

    public function initializeWithLayoutSwitcher()
    {
        $this->layoutSwitcher = session()->get($this->layoutSwitcherSessionKey(), $this->layoutSwitcher);
    }

    public function switchLayout(string $value)
    {
        session()->put($this->layoutSwitcherSessionKey(), $value);

        $this->layoutSwitcher = $value;
    }

    public function isUsingGridLayout(): bool
    {
        return $this->layoutSwitcher === 'grid';
    }

    public function isUsingListLayout(): bool
    {
        return $this->layoutSwitcher === 'list';
    }

    protected function layoutSwitcherSessionKey(): string
    {
        return 'layout-switcher';
    }
}
