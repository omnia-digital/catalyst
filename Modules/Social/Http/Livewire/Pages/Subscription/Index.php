<?php

namespace Modules\Social\Http\Livewire\Pages\Subscription;

use App\Models\User;
use Livewire\Component;
use Modules\Subscriptions\Actions\Salesforce\CreateContactObjectAction;
use Modules\Subscriptions\Models\FormAssemblyForm;

class Index extends Component
{
    public $form;

    public function mount()
    {
        $this->form = FormAssemblyForm::findByFormID(config('services.form_assembly.subscription_form_id'));

        if (!$this->user->contact_id) {
            (new CreateContactObjectAction)->execute($this->user);
            $this->user->refresh();
        }
    }

    public function getSubscriptionActiveProperty()
    {
        return $this->subscription?->is_active;
    }

    public function getSubscriptionProperty()
    {
        return $this->user->chargentSubscription;
    }

    public function getUserProperty()
    {
        return auth()->user();
    }

    public function getSubscriptionFormProperty()
    {
        //Set stream options
        $context = stream_context_create(array('http' => array('ignore_errors' => true)));

        if(!isset($_GET['tfa_next'])) {
            $qs = '?';
            $attributes = [];
            $tfaFields = $this->form->fields()->where('enabled', 1)->pluck('name', 'tfa_code');

            foreach ($tfaFields as $code => $attribute) {
                $attributes[$code] = $this->user->$attribute;
            }

            $qs .= http_build_query($attributes);

            return file_get_contents('https://app.formassembly.com/rest/forms/view/'. $this->form->fa_form_id . $qs);
        } else {
            return file_get_contents('https://app.formassembly.com/rest'.$_GET['tfa_next'], false, $context);
        }
    }

    public function render()
    {
        return view('social::livewire.pages.subscription.index');
    }
}
