<?php

namespace Modules\Reviews\Http\Livewire;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Livewire\Component;
use OmniaDigital\OmniaLibrary\Livewire\WithModal;

class CreateReview extends Component implements HasForms
{
    use WithModal, InteractsWithForms;

    protected function getFormSchema(): array
    {
        return [
            TextInput::make('review.body')->required(),
            Select::make('review.visibility')->options(['Public', 'Friends Only']),
        ];        
    }

    public function render()
    {
        return view('reviews::Resources/views/livewire.create-review');
    }
}
