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

    protected $listeners = ['openReviewModal'];

    public function mount($model)
    {
        $this->model = $model;
    }

    public function openReviewModal()
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
        } else {
            $this->form->fill();
        }

        $this->dispatch('review-modal-' . $this->model->id, type: 'open');
    }

    public function createReview()
    {
        if ($this->model->reviewedBy(auth()->user())) {
            $this->review->update(
                $this->form->getState()
            );

            $this->dispatch('reviewUpdated')->to('reviews::review-card');
            $this->dispatch('notify', message: Trans::get('Review updated'), type: 'success');
        } else {
            $this->review = $this->model->reviews()->create(
                array_merge(['user_id' => auth()->id()], $this->form->getState())
            );

            $this->dispatch('notify', message: Trans::get('Review created'), type: 'success');
        }

        $this->dispatch('updateReviews', review: $this->review);
        $this->closeModal('review-modal-' . $this->model->id);
        $this->reset('body', 'visibility', 'language_id', 'commentable', 'received_product_free', 'recommend');
    }

    public function removeReview()
    {
        if ($this->model->reviewedBy(auth()->user())) {
            $this->review->delete();

            $this->dispatch('notify', message: Trans::get('Review removed'), type: 'success');

            $this->dispatch('updateReviews');
            $this->closeModal('review-modal-' . $this->model->id);
            $this->reset('body', 'visibility', 'language_id', 'commentable', 'received_product_free', 'recommend');
        }
    }

    public function render()
    {
        return view('reviews::livewire.create-review-modal');
    }

    protected function getFormSchema(): array
    {
        return [
            Textarea::make('body')->required(),
            Select::make('visibility')
                ->options([
                    0 => 'Public',
                    1 => 'Friends Only',
                ])
                ->default(0)
                ->disablePlaceholderSelection()
                ->required(),
            Select::make('language_id')
                ->label('Language')
                ->options(Language::pluck('name', 'id'))
                ->default(1)
                ->disablePlaceholderSelection()
                ->required(),
            Checkbox::make('commentable')
                ->default(1)
                ->label('Allow Comments'),
            Checkbox::make('received_product_free')
                ->default(0)
                ->label('Check this box if you joined for free'),
            Radio::make('recommend')
                ->label(Trans::get('Do you recommend this Team?'))
                ->boolean()
                ->required(),
        ];
    }
}
