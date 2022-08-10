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
use Modules\Reviews\Models\Review;
use OmniaDigital\OmniaLibrary\Livewire\WithModal;
use Trans;

class CreateReview extends Component implements HasForms
{
    use WithModal, InteractsWithForms;

    public Team $team;

    public Review|null $review = null;

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

    public function mount(Team $team, Review $review)
    {
        $this->team = $team;

        if ($review) {
            $this->review = $review;
    
            $this->form->fill([
                'body' => $this->review->body,
                'visibility' => $this->review->visibility,
                'language_id' => $this->review->language_id,
                'commentable' => $this->review->commentable,
                'received_product_free' => $this->review->received_product_free,
                'recommend' => $this->review->recommend,
            ]);
        }
    }

    protected function getFormModel(): Review 
    {
        return $this->review;
    } 

    public function createReview()
    {
        if ($this->team->reviewedBy(auth()->user())) {
            
            $this->review->update(
                $this->form->getState()
            );
            
            $this->dispatchBrowserEvent('notify', ['message' => Trans::get('Review updated'), 'type' => 'success']);

        } else {
            
            $this->team->reviews()->create(
                array_merge(['user_id' => auth()->id()], $this->form->getState())  
            );
    
            $this->dispatchBrowserEvent('notify', ['message' => Trans::get('Review created'), 'type' => 'success']);
        }

        $this->closeModal('review-modal-' . $this->team->id);
        $this->reset('body', 'visibility', 'language_id', 'commentable', 'received_product_free', 'recommend');
    }

    public function render()
    {
        return view('reviews::livewire.create-review');
    }
}
