<?php

namespace Modules\Reviews\Http\Livewire;

use App\Models\Language;
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

class CreateReviewModal extends Component implements HasForms
{
    use WithModal, InteractsWithForms;

    public $model;

    public Review|null $review = null;

    public $body;
    public $visibility;
    public $language_id;
    public $commentable;
    public $received_product_free;
    public $recommend;

    /**
     * @var string[]
     *
     * @psalm-var array{0: 'openReviewModal'}
     */
    protected array $listeners = ['openReviewModal'];

    /**
     * @return (Checkbox|Radio|Select|Textarea)[]
     *
     * @psalm-return array{0: Textarea, 1: Select, 2: Select, 3: Checkbox, 4: Checkbox, 5: Radio}
     */
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
                ->required(),
            Select::make('language_id')
                ->label('Language')
                ->options(Language::pluck('name', 'id'))
                ->default(1)
                ->required(),
            Checkbox::make('commentable')
                ->default(false)
                ->label('Allow Comments'),
            Checkbox::make('received_product_free')
                ->default(false)
                ->label('Check this box if you joined for free'),
            Radio::make('recommend')
                ->label(Trans::get('Do you recommend this Team?'))
                ->boolean()
                ->required()
        ];        
    }

    public function mount($model): void
    {
        $this->model = $model;
    }

    public function openReviewModal(): void
    {
        if ($this->model->reviewedBy(auth()->user())) {
            $this->review = $this->model->getCurrentUserReview();
    
            $this->form->fill([
                'body' => $this->review->body,
                'visibility' => $this->review->visibility,
                'language_id' => $this->review->language_id,
                'commentable' => $this->review->commentable,
                'received_product_free' => $this->review->received_product_free,
                'recommend' => $this->review->recommend,
            ]);
        }

        $this->dispatchBrowserEvent('review-modal-' . $this->model->id, ['type' => 'open']);
    }

    public function createReview(): void
    {
        if ($this->model->reviewedBy(auth()->user())) {
            
            $this->review->update(
                $this->form->getState()
            );
            
            $this->emitTo('reviews::review-card', 'reviewUpdated');
            $this->dispatchBrowserEvent('notify', ['message' => Trans::get('Review updated'), 'type' => 'success']);

        } else {
            
            $this->review = $this->model->reviews()->create(
                array_merge(['user_id' => auth()->id()], $this->form->getState())  
            );
    
            $this->dispatchBrowserEvent('notify', ['message' => Trans::get('Review created'), 'type' => 'success']);
        }

        $this->emit('updateReviews', $this->review);
        $this->closeModal('review-modal-' . $this->model->id);
        $this->reset('body', 'visibility', 'language_id', 'commentable', 'received_product_free', 'recommend');
    }

    public function removeReview(): void
    {
        if ($this->model->reviewedBy(auth()->user())) {
            $this->review->delete();

            $this->dispatchBrowserEvent('notify', ['message' => Trans::get('Review removed'), 'type' => 'success']);

            $this->emit('updateReviews');
            $this->closeModal('review-modal-' . $this->model->id);
            $this->reset('body', 'visibility', 'language_id', 'commentable', 'received_product_free', 'recommend');
        }
    }

    public function render(): \Illuminate\View\View
    {
        return view('reviews::livewire.create-review-modal');
    }
}
