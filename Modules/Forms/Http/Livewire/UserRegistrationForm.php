<?php

namespace Modules\Forms\Http\Livewire;

use App\Actions\Fortify\CreateNewUser;
use Auth;
use Illuminate\Auth\Events\Registered;
use Modules\Forms\Http\Livewire\Form as LivewireForm;
use Modules\Forms\Models\FormSubmission;

class UserRegistrationForm extends LivewireForm
{
    public function processFormSubmission($formData)
    {
        $registrationData = array_map(fn ($item): string => $item['data'], $formData );

        event(new Registered($user = (new CreateNewUser)->create($registrationData)));
        Auth::login($user);

        unset($formData['password']);
        unset($formData['password_confirmation']);

        FormSubmission::create([
            'form_id' => $this->formModel->id,
            'user_id' => $user->id,
            'team_id' => $this->team_id ?? null,
            'data' => $formData,
        ]);
    }
}
