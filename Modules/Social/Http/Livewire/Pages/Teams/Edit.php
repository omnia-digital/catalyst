<?php

namespace Modules\Social\Http\Livewire\Pages\Teams;

use App\Models\Team;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;
use OmniaDigital\OmniaLibrary\Livewire\WithPlace;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Edit extends Component/*  implements HasForms */
{
    use WithPlace, AuthorizesRequests, WithFileUploads/* , InteractsWithForms */;

    public Team $team;

    public array $newAddress = [];

    public bool $removeAddress = false;

    public $bannerImage;


    public $mainImage;


    public $profilePhoto;


    /**
     * @var array
     */
    public array $sampleMedia = [];
    public $sampleMediaNames = [];

    /**
     * @var Media|null
     */
    public $mediaToRemove;

/*     protected function getFormSchema(): array
    {
        return [
            TextInput::make('team.name')->required(),
            DatePicker::make('team.start_date')->required(),
            Textarea::make('team.summary')->required(),
            MarkdownEditor::make('team.content')->required(),
        ];        
    } */

}
