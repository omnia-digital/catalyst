<div wire:init="onLoad">

    <x-library::heading.2>{{ Trans::get('Forms') }}</x-library::heading.2>
    <p>{{ Trans::get('These are forms that will be sent to members of your Team. You can choose which date these forms are sent out.') }}</p>
    @if($teamForms)
        @foreach($teamForms as $form)
            <livewire:forms::form :form="$form" :key="$form->id" />
        @endforeach
    @endif

    @if($platformForms)
        @foreach($platformForms as $form)
            <livewire:forms::form :form="$form" :key="$form->id" />
        @endforeach
    @endif
</div>
