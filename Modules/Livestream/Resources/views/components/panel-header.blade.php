@props([
    'title' => '',
    'route' => '',
    'iconClass' => 'w-4 h-4',
    'xdata' => '',
    'click' => '',
    'prevent' => '',
    'icon' => ''
])
<div class="flex items-center py-4 px-4 md:px-6">
    <h1 class="flex-1 text-2xl font-medium text-gray-900">{{ $title }}</h1>
    <div>
        @if (!empty($route))
        <x-form.button-link to="{{ $route }}">
            <span class="flex items-center space-x-2">
                <x-dynamic-component component="{{ $icon }}" :class="$iconClass"/>
                <span>Create {{ $title }}</span>
            </span>
        </x-form.button-link>
        @elseif (!empty($click))
            <x-form.button :wire:click="$click" class="flex items-center space-x-2">
                <x-dynamic-component component="{{ $icon }}" :class="$iconClass"/>
                <span>Create {{ $title }}</span>
            </x-form.button>
        @elseif ($xdata)
            <x-form.button
                :x-data="$xdata"
                :x-on:click.prevent="$prevent"
                class="flex items-center space-x-2"
            >
                <x-heroicon-o-clipboard :class="$iconClass"/>
                <span x-text="text"></span>
            </x-form.button>
        @endif
    </div>
</div>
