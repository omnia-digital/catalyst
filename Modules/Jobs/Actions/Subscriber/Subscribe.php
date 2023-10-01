<?php

namespace Modules\Jobs\Actions\Subscriber;

use Illuminate\Support\Arr;
use Modules\Jobs\Models\Subscriber;

class Subscribe
{
    /**
     * Subscribe an email to the list.
     *
     * @return Subscriber;
     */
    public function execute(string $email, ?array $options = [])
    {
        $subscriber = Subscriber::firstOrCreate(
            ['email' => $email],
            [
                'first_name' => Arr::get($options, 'first_name'),
                'last_name' => Arr::get($options, 'last_name'),
                'options' => collect($options)->except(['first_name', 'last_name'])->all(),
            ]);

        // Update frequency if subscriber change his frequency.
        if (Arr::get($subscriber->options, 'frequency') !== Arr::get($options, 'frequency')) {
            $newOptions = $subscriber->options;
            $newOptions['frequency'] = Arr::get($options, 'frequency');

            $subscriber->update(['options' => $newOptions]);
        }

        return $subscriber;
    }
}
