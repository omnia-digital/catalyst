<?php

namespace Modules\Social\Http\Livewire\Pages\Teams\Admin;

use App\Models\Team;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Laravel\Jetstream\Jetstream;
use Livewire\Component;
use Modules\Forms\Models\Form;
use Modules\Forms\Models\FormNotification;
use Modules\Forms\Traits\Livewire\WithFormManagement;
use OmniaDigital\OmniaLibrary\Livewire\WithModal;
use OmniaDigital\OmniaLibrary\Livewire\WithNotification;
use Spatie\Permission\Models\Role;

class ManageTeamForms extends Component
{
    use WithFormManagement, WithModal, WithNotification;

    public ?Team $team;
    public $formId = null;

    public $platformForms = [];
    public $teamForms = [];

    public $editingNotification = [
        'form_id' => '',
        'role_id' => '',
        'title' => '', 
        'send_date_edit' => '',
        'timezone' => ''
    ];

    protected $listeners = [
        'formRemoved' => '$refresh',
        'formPublished' => '$refresh',
        'formSavedAsDraft' => '$refresh',
        'notificationSaved' => '$refresh',
    ];

    public function mount()
    {
        $this->editingNotification = $this->makeBlankNotification();
    }
    
    public function onLoad()
    {
        $this->loadForms();
    }

    public function getUserProperty()
    {
        return Auth::user();
    }

    public function makeBlankNotification($formId = null)
    {
        return [
            'form_id' => $formId,
            'role_id' => Role::first()?->id,
            'title' => 'New Form Notification', 
            'send_date_edit' => now(),
            'timezone' => 'UTC'
        ];
    }

    public function createFormNotification($formId)
    {
        if (isset($this->editingNotification['id'])) $this->editingNotification = $this->makeBlankNotification($formId);
        else $this->editingNotification['form_id'] = $formId;

        $this->openModal('form-notification-modal');
    }

    public function editFormNotification(FormNotification $formNotification)
    {
        if (!isset($this->editingNotification['id'])) 
            $this->editingNotification = $formNotification->toArray();

        if (isset($this->editingNotification['id']) && ($this->editingNotification['id'] !== $formNotification->id))
            $this->editingNotification = $formNotification->toArray();

        $this->openModal('form-notification-modal');
    }

    public function saveFormNotification()
    {
        $attributes = $this->validate([
            'editingNotification.form_id' => ['required'],
            'editingNotification.role_id' => [
                'required', 
                Rule::exists(config('permission.table_names.roles'), 'id')
                    ->where(fn ($q) => $q->where('team_id', $this->team->id)),
            ],
            'editingNotification.title' => ['required', 'string'],
            'editingNotification.message' => ['nullable', 'string'],
            'editingNotification.send_date_edit' => ['required', 'date'],
            'editingNotification.timezone' => ['required', 'timezone']
        ]);

        if (isset($this->editingNotification['id'])) {
            FormNotification::find($this->editingNotification['id'])->update($attributes['editingNotification']);
        } else {
            FormNotification::create($attributes['editingNotification']);
        }
        
        $this->success('Notification created successfully');

        $this->reset('editingNotification', 'formId');
        $this->editingNotification = $this->makeBlankNotification();
        
        $this->closeModal('form-notification-modal');

        $this->emit('notificationSaved');
    }

    public function getRoleIds()
    {
        return Role::where('team_id', $this->team->id)->pluck('name', 'id');
    }

    public function getRoles()
    {
        return Arr::pluck(Jetstream::$roles, 'name', 'key');
    }

    public function loadForms()
    {
        $platformForms = Form::whereNull('team_id')->get();

        $teamForms = Form::where('team_id', $this->team->id)->get();

        $this->platformForms = $platformForms;
        $this->teamForms = $teamForms;
    }

    public function render()
    {
        return view('social::livewire.pages.teams.admin.manage-team-forms', [
            'platformForms' => $this->platformForms,
            'teamForms' => $this->teamForms,
        ]);
    }
}
