<?php

namespace Modules\Reviews\Http\Livewire;

use App\Models\Language;
use App\Models\Team;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Livewire\Component;
use OmniaDigital\OmniaLibrary\Livewire\WithModal;
use Trans;

class CreateReview extends Component implements HasForms
{
    use WithModal, InteractsWithForms;

    public Team $team;

    public $body;
    public $visibility;
    public $language_id;
    public $commentable;
    public $received_product_free;
    public $recommend;

    protected function getFormSchema(): array
    {
        return [
            Textarea::make('body')->required(),
            Select::make('visibility')
                ->options([
                    0 => 'Public', 
                    1 => 'Friends Only'
                ])
                ->default(0)
                ->disablePlaceholderSelection(),
            Select::make('language_id')
                ->label('Language')
                ->options(Language::pluck('name', 'id'))
                ->default('en')
                ->disablePlaceholderSelection(),
            Checkbox::make('commentable')
                ->label('Allow Comments'),
            Checkbox::make('received_product_free')
                ->label('Check this box if you joined for free'),
            Radio::make('recommend')
                ->label(Trans::get('Do you recommend this Team?'))
                ->boolean()
        ];        
    }

    public function mount(Team $team)
    {
        $this->team = $team;
    }

    public function createReview()
    {
        $this->team->reviews()->create(
            array_merge(['user_id' => auth()->id()], $this->form->getState())  
        );

        $this->closeModal('review-modal-' . $this->team->id);
        $this->reset('body', 'visibility', 'language_id', 'commentable', 'received_product_free', 'recommend');
    }

    public function render()
    {
        return view('reviews::livewire.create-review');
    }
}
