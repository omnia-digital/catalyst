@extends('social::livewire.layouts.pages.full-page-layout')

@section('content')
<div>
    <x-teams.partials.header :team="$team"/>
    <div class="p-8">
        <x-library::heading.2>{{ Trans::get('Team Admin Panel: Form Builder') }}</x-library::heading.2>
    </div>

    <form wire:submit.prevent="save({{ $this->team->id }})" class="p-8 space-y-8 ">
        <div>
            {{ $this->form }}
        </div>

        <x-forms::button wire:loading.attr="disabled" wire:target="save" class="bg-black" type="submit">
            <span wire:loading.remove wire:target="save" class="text-white">Save</span>
            <span wire:loading wire:target="save">Saving...</span>
        </x-forms::button>
    </form>
</div>
@endsection
