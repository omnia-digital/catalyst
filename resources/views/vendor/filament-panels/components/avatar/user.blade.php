@php use function Filament\Support\prepare_inherited_attributes; @endphp
@props([
    'user' => filament()->auth()->user(),
])

<x-filament::avatar
        :src="filament()->getUserAvatarUrl($user)"
        :attributes="
        prepare_inherited_attributes($attributes)
            ->class(['fi-user-avatar rounded-full'])
    "
/>
