@php use function Filament\Support\prepare_inherited_attributes; @endphp
<x-filament::icon-button
        color="gray"
        icon="heroicon-m-bars-2"
        icon-alias="tables::reorder.button"
        :attributes="prepare_inherited_attributes($attributes)"
/>
