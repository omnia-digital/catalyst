<?php

namespace Modules\Social\Http\Livewire\Pages\Settings;

use App\Models\User;
use Livewire\Component;

class Index extends Component
{
    public function mount()
    {
        # code...
    }

    public function getSubscriptionActiveProperty()
    {
        return $this->subscription?->is_active;
    }

    public function getSubscriptionProperty()
    {
        return $this->user->subscription;
    }

    public function getUserProperty()
    {
        return User::find(auth()->id());
    }

    public function getSubscriptionFormProperty()
    {
        //Set stream options
        $context = stream_context_create(array('http' => array('ignore_errors' => true)));

        if(!isset($_GET['tfa_next'])) {
            $qs = ' ';
            if(isset($_SERVER['QUERY_STRING']) && !empty($_SERVER['QUERY_STRING'])){
                $qs='?'.$_SERVER['QUERY_STRING'];
            };
            return file_get_contents('https://app.formassembly.com/rest/forms/view/5011856'.$qs);
        } else {
            return file_get_contents('https://app.formassembly.com/rest'.$_GET['tfa_next'], false, $context);
        }
    }

    public function render()
    {
        return view('social::livewire.pages.settings.index');
    }
}
