<?php

namespace Modules\Social\Http\Livewire\Pages\Subscription;

use Livewire\Component;
use Modules\Subscriptions\Actions\Salesforce\CreateContactObjectAction;
use Modules\Subscriptions\Actions\Salesforce\GetChargentOrderInfoAction;
use Modules\Subscriptions\Actions\Salesforce\StopRecurringPaymentsOnChargentOrderAction;
use Modules\Subscriptions\Models\FormAssemblyForm;

class Index extends Component
{
    public $form;

    /**
     * Indicates if the application is confirming to cancel a subscription.
     *
     * @var bool
     */
    public $confirmingSubscriptionCancellation = false;

    public function mount()
    {
        $this->form = FormAssemblyForm::findBySlug('user-subscriptions');

        (new CreateContactObjectAction)->execute($this->user);
        $this->user->refresh();

        (new GetChargentOrderInfoAction)->execute($this->subscription);
        $this->subscription->refresh();
    }

    /**
     * Confirm that the user wants to cancel their subscription.
     *
     * @return void
     */
    public function confirmSubscriptionCancellation()
    {
        $this->confirmingSubscriptionCancellation = true;
    }

    public function cancelSubscription()
    {
        (new StopRecurringPaymentsOnChargentOrderAction)->execute($this->subscription);
        $this->subscription->refresh();

        $this->confirmingSubscriptionCancellation = false;
    }

    public function getSubscriptionActiveProperty()
    {
        return $this->subscription?->is_active;
    }

    public function getSubscriptionProperty()
    {
        return $this->user->chargentSubscription()->latest()->first();
    }

    public function getUserProperty()
    {
        return auth()->user();
    }

    public function iFrameURL()
    {
        $qs = '?';
        $attributes = [];
        $tfaFields = $this->form->fields()->where('enabled', 1)->pluck('name', 'tfa_code');

        foreach ($tfaFields as $code => $attribute) {
            if ($attribute === 'chargent_order_id') {
                $attributes[$code] = $this->subscription->$attribute;
                continue;
            }
            $attributes[$code] = $this->user->$attribute;
        }

        $qs .= http_build_query($attributes);

        return 'https://tfaforms.com/' . $this->form->fa_form_id . $qs;
    }

    public function render()
    {
        return view('social::livewire.pages.subscription.index');
    }
}
