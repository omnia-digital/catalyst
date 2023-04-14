<?php

namespace App\Http\Livewire\Companies;

use App\Actions\Companies\CreateCompany;
use App\Models\Tag;
use Livewire\Component;
use Livewire\WithFileUploads;
use OmniaDigital\OmniaLibrary\Livewire\WithModal;

class CreateCompanyModal extends Component
{
    use WithModal, WithFileUploads;

    public ?string $name = null;

    public ?string $startDate = null;

    public ?string $summary = null;

    public $bannerImage;
    public $bannerImageName;

    public $mainImage;
    public $mainImageName;

    public $profilePhoto;
    public $profilePhotoName;

    public $sampleMedia = [];
    public $sampleMediaNames = [];

    public $companyTypes = [];

    public function updatedBannerImage()
    {
        $this->validate([
            'bannerImage' => 'image',
        ]);

        $this->bannerImageName = $this->bannerImage->getClientOriginalName();
    }

    public function updatedMainImage()
    {
        $this->validate([
            'mainImage' => 'image',
        ]);

        $this->mainImageName = $this->mainImage->getClientOriginalName();
    }

    public function updatedProfilePhoto()
    {
        $this->validate([
            'profilePhoto' => 'image',
        ]);

        $this->profilePhotoName = $this->profilePhoto->getClientOriginalName();
    }

    public function updatedSampleMedia()
    {
        $this->validate([
            'sampleMedia.*' => 'image',
        ]);

        foreach ($this->sampleMedia as $key => $media) {
            $this->sampleMediaNames[$key] = $media->getClientOriginalName();
        }
    }

    public function getCompanyTagsProperty()
    {
        return Tag::withType('company_type')->get()->mapWithKeys(fn (Tag $tag) => [$tag->name => ucwords($tag->name)])->all();
    }

    public function create()
    {
        $this->validate();

        $company = (new CreateCompany)->create(auth()->user(), [
            'name' => $this->name,
            'companyTypes' => $this->companyTypes,
            //            'start_date' => $this->startDate,
            //            'summary' => $this->summary,
            //            'bannerImage' => $this->bannerImage,
            //            'mainImage' => $this->mainImage,
            //            'profilePhoto' => $this->profilePhoto,
            //            'sampleMedia' => $this->sampleMedia,
        ]);

        $this->closeModal('create-company');
        $this->reset();

        $this->redirectRoute('social.companies.show', $company);
    }

    public function render()
    {
        return view('livewire.create-company-modal', [
            'companyTags' => $this->companyTags,
        ]);
    }

    protected function rules(): array
    {
        return [
            'name' => ['required', 'max:254'],
            'companyTypes' => ['required', 'array'],
        ];
    }
}
