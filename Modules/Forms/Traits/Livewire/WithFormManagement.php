<?php

namespace Modules\Forms\Traits\Livewire;

use Modules\Forms\Models\Form;
use Modules\Forms\Models\FormNotification;

/**
 * Add form management functions to livewire component
 */
trait WithFormManagement
{
    public $confirmingFormRemoval = false;
    public $formIdBeingRemoved = null;

    public $confirmingFormNotificationRemoval = false;
    public $formNotificationIdBeingRemoved = null;

    public $confirmingPublishform = false;
    public $formIdBeingPublished = null;
    public $newStatus = '';

    public function confirmPublishForm($formId, $status)
    {
        $this->confirmingPublishform = true;

        $this->formIdBeingPublished = $formId;

        $this->newStatus = $status;
    }

    public function changeFormStatus()
    {
        $form = Form::find($this->formIdBeingPublished);

        if ($form->isActive) {
            $form->update(['published_at' => null]);

            $this->emit('formSavedAsDraft');
        } else {
            $form->update(['published_at' => now()]);

            $this->emit('formPublished');
        }

        $this->confirmingPublishform = false;

        $this->formIdBeingPublished = null;

        $this->newStatus = '';
    }

    public function confirmFormRemoval($formId)
    {
        $this->confirmingFormRemoval = true;

        $this->formIdBeingRemoved = $formId;
    }

    public function removeForm()
    {
        Form::find($this->formIdBeingRemoved)->delete();

        $this->confirmingFormRemoval = false;

        $this->formIdBeingRemoved = null;

        $this->emit('formRemoved');
    }

    public function confirmFormNotificationRemoval($formNotificationId)
    {
        $this->confirmingFormNotificationRemoval = true;

        $this->formNotificationIdBeingRemoved = $formNotificationId;
    }

    public function removeFormNotification()
    {
        FormNotification::find($this->formNotificationIdBeingRemoved)->delete();

        $this->confirmingFormNotificationRemoval = false;

        $this->formNotificationIdBeingRemoved = null;

        $this->emit('formNotificationRemoved');
    }
}
