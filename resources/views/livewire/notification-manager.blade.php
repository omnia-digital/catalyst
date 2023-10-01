<div>
    <div>
        <x-library::accordion default="1">
            @foreach ($this->allNotifications as $notification)
                @if (!empty($notification::getLabel()))
                    <x-library::accordion.item id="1">
                        <x-slot name="title">
                            {{ $notification::getLabel() }}
                        </x-slot>
                        <x-slot name="content">
                            <p>{{ $notification::getDescription() }}</p>
                            <div>
                                @foreach ($notification::getChannels() as $channel)
                                    <div class="flex justify-between">
                                        <x-library::input.label value="{{ $this->getChannelLabel($channel) }}"
                                                                for="{{ $channel }}"/>
                                        <x-library::input.toggle
                                                id="{{ $channel }}"
                                                wire:model.live="subscriptions.{{ $notification }}.{{ $channel }}"
                                                trueBackgroundColor="bg-primary"
                                        />
                                    </div>
                                @endforeach
                            </div>

                        </x-slot>
                    </x-library::accordion.item>
                @endif
            @endforeach
        </x-library::accordion>
    </div>

    @foreach ($this->subscriptions as $subscription)
        {{ $subscription }}
    @endforeach
</div>
