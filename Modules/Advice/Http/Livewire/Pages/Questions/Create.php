<?php

namespace Modules\Advice\Http\Livewire\Pages\Questions;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Phuclh\MediaManager\WithMediaManager;

class Create extends Component
{
    use WithMediaManager;

    public ?string $body = null;
}
