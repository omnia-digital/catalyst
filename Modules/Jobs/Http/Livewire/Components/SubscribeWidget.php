<?php

namespace Modules\Jobs\Http\Livewire\Components;

use Illuminate\Support\Facades\Http;
use Livewire\Component;
use Modules\Jobs\Actions\Subscriber\Subscribe;
use Modules\Jobs\Support\Livewire\WithNotification;

class SubscribeWidget extends Component
{
    use WithNotification;

    public $frequency = 'instant';

    public $email;

    protected $rules = [
        'email' => ['required', 'email', 'max:254'],
    ];

    public function subscribe(Subscribe $subscribe)
    {
        $this->validate();

        $json_data = '{
              "list_ids": ["' . config('app.sendgrid_subscriber_list_id') . '"],
              "contacts": [
                {

                  "email": "' . $this->email . '"
                }
              ]
            }';

        $response = Http::withToken(config('app.sendgrid_key'))->withBody($json_data,
            'application/json')->put(config('app.sendgrid_url'));
        //202 Accepted
        if ($response->status() == 202) {
            $subscribe->execute($this->email, [
                'frequency' => $this->frequency,
            ]);
            $this->reset('email');
            $this->success('Your email is added to our list.');
        }
    }

    public function render()
    {
        return view('jobs::livewire.components.subscribe-widget', [
            'frequencies' => [
                'instant' => 'Instant',
                'weekly' => 'Weekly',
            ],
        ]);
    }
}
