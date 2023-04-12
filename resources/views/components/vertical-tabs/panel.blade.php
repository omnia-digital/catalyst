<div
    x-show="isSelected($id('tab', whichChild($el, $el.parentElement)))"
    :aria-labelledby="$id('tab', whichChild($el, $el.parentElement))"
    role="tabpanel"
    {{ $attributes->merge(['class' => 'space-y-6 sm:px-6 lg:col-span-9 lg:px-0']) }}
>
    <x-vertical-tabs.panel-section>
        <x-slot:title>{{ $title }}</x-slot>
        @isset($description)
            <x-slot:description>{{ $description }}</x-slot>
        @endisset
        {{ $slot }}
        @isset($footer)
            <x-slot:footer>{{ $footer }}</x-slot>
        @endisset
    </x-vertical-tabs.panel-section>
    @isset($additional)
        {{ $additional }}
    @endisset
</div>